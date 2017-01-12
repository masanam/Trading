<?php

namespace App\Http\Controllers;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Password;

use App\Mail\ForgotPassword;

use Illuminate\Support\Facades\Config;

use App\Model\User;

use Auth;

use App\Http\Requests;

class AuthenticateController extends Controller
{
    public function __construct()
   {
       $this->middleware('jwt.auth', ['except' => ['authenticate', 'signup', 'forgotPassword']]);
   }
 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return "Auth index";
    }
 
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
 
        try {
            // verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        $user = Auth::user();

        $status = 200; $error = 'ok';

        event(new Login($user, false));
        // if no errors are encountered we can return a JWT
        return response()->json(compact('token', 'user', 'status', 'error'), 200);
    }

    public function signup(Request $request)
    {
      $user = User::where(['email' => $request->email])->count();
      if(!$request) {
          return response()->json([
              'message' => 'Bad Request'
          ], 400);
      }
      else if($user > 0){
          return response()->json([
              'message' => 'Your email is already registered. If you forgot your password, please send an enquiry to info@volantech.io'
          ], 400);
      }
        $user = new User;
        $user->name = trim($request->name);
        $user->title = trim($request->title);
        $user->image = trim($request->image);
        $user->status = 'a';
        $user->email = trim(strtolower($request->email));
        $user->phone = trim($request->phone);
        $user->password = bcrypt($request->password);
        $user->save();

        $user->roles()->attach(2);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('token', 'user'), 200);
    }
 
    public function getAuthenticatedUser()
    {
        try {
 
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
 
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
 
            return response()->json(['token_expired'], $e->getStatusCode());
 
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
 
            return response()->json(['token_invalid'], $e->getStatusCode());
 
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
 
            return response()->json(['token_absent'], $e->getStatusCode());
 
        }
        
        $roles=[];

        $user = User::with('roles')->where('status', 'a')->find(Auth::user()->id);
        if($user) {
            foreach($user->roles as $r) {
                // dd($r->role);
                $roles[] = $r->role;
            }
            $user->role = $roles;

            // dd($user->roles);
            $subordinates = $user->subordinates();
            $managers = $user->managers();
     
            // the token is valid and we have found the user via the sub claim
            return response()->json(compact('user', 'subordinates', 'managers'), 200);
        }
        else {
            return response()->json(['message' => 'User is deactivated or not found'], 400);
        }
    }

    private function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^&*():?><,./;';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    public function forgotPassword(Request $request) {
        $user = User::where('email', $request->email)->first();
        if($user) {
            $randPass = $this->randomPassword();
            $user->password = bcrypt($randPass);
            $user->save();

            $mail = new ForgotPassword($request->email, $randPass);
            Mail::to($request->email)
                ->send($mail);

            return response()->json(['message' => 'Email Sent'], 200);
        }
        else {
            return response()->json(['message' => 'Not Found'], 404);
        }

    }

    public function signing(Request $request)
    {
        $aws = config('filesystems.disks.s3');
        $s3 = Storage::disk('s3');

        $s3Url = 'https://' . $aws['bucket'] . '.s3-' . $aws['region'] . '.amazonaws.com';
        $filename = $request->filename;
        $path = $request->folder . '/' . $filename;
        $readType = 'public-read';
        $expiration = date('Y-m-d\TH:i:s\Z', strtotime('+5 minutes'));

        $s3Policy = [
            'expiration' => $expiration,
            'conditions' => [
                [ 'bucket' => $aws['bucket'] ],
                [ 'starts-with', '$key', $path ],
                [ 'acl' => $readType ],
                [ 'success_action_status' => '201' ],
                //[ 'starts-with', '$Content-Type', $request->type ],
                [ 'content-length-range', 2048, 10485760 ], //min and max
            ]
        ];
        $base64Policy = base64_encode(json_encode($s3Policy));
        $signature = base64_encode(hash_hmac( 'sha1', utf8_encode($base64Policy), $aws['secret'], true));

        $credentials = [
            'url' => $s3Url,
            'fields' => [
                'key' => $path,
                'AWSAccessKeyId' => $aws['key'],
                'acl' => $readType,
                'policy' => $base64Policy,
                'signature' => $signature,
                //'Content-Type' => $request->type,
                'success_action_status' => '201'
            ]
        ];

        return response()->json($credentials);
    }
}

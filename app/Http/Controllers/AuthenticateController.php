<?php

namespace App\Http\Controllers;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;

use App\Model\User;

use Auth;

use App\Http\Requests;

class AuthenticateController extends Controller
{
    public function __construct()
   {
       $this->middleware('jwt.auth', ['except' => ['authenticate', 'signup']]);
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

        // if no errors are encountered we can return a JWT
        return response()->json(compact('token', 'user', $user), 200);
    }

    public function signup(Request $request)
    {   
        $user = new User;
        $user->name = trim($request->name);
        $user->title = trim($request->title);
        $user->image = trim($request->image);
        $user->role = $request->role  ? $request->role : 'user';
        $user->status = 'a';
        $user->email = trim(strtolower($request->email));
        $user->phone = trim($request->phone);
        $user->password = bcrypt($request->password);
        $user->save();

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
 
        // the token is valid and we have found the user via the sub claim
        return response()->json(compact('user'), 200);
    }

    public function signing(Request $request)
    {
        $disk = Storage::disk('s3');
        $bucket = Config::get('filesystems.disks.s3.bucket');
        $key = $request->file->filename;

        if ($disk->exists($key)) {
            $command = $disk->getDriver()->getAdapter()->getClient()->getCommand('GetObject', [
                'Bucket'                     => $bucket,
                'Key'                        => $key,
                'ResponseContentDisposition' => 'attachment;'
            ]);
            $request = $disk->getDriver()->getAdapter()->getClient()->createPresignedRequest($command, '+5 minutes');
            return response()->json([ 'url' => (string) $request->getUri() ]);
        }
    }
}

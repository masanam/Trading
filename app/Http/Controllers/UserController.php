<?php

namespace App\Http\Controllers;

use App\Model\User;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Password;

use App\Events\EditUserProfile;

use App\Http\Requests;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('jwt.auth', ['except' => ['store', 'sendResetLinkEmail']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::where('status', 'a')->get();

        return response()->json($user, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::where(['email' => $request->email])->get();
        
        if(!$request) {
            return response()->json([
                'message' => 'Bad Request'
            ], 400);
        }
        else if(!empty($user)){
            return response()->json([
                'message' => 'Your email is already registered. If you forgot your password, please send an enquiry to info@volantech.io'
            ], 400);
        }

        $user = new User();
        $user->name = $request->name;
        $user->image = $request->image;
        $user->title = $request->title;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = bcrypt($request->password);

        $user->employee_id = $request->employee_id;
        $user->role = 'user';

        $user->status = 'a';

        $user->save();

        return response()->json($user, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user)
    {
        $user = User::find($user);

        if($user->status == 'a') {
            return response()->json($user, 200);
        } else {
            return response()->json(['message' => 'deactivated record'], 404);
        }    
    }

    public function currentUser() {
        return response()->json(Auth::user(), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user)
    {
        $user = User::find($user);

        if (!$request) {
            return response()->json([
                'message' => 'Bad Request'
            ], 400);
        }

        if (!$user) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $lastImage = $user->image;

        $user->name = $request->name;
        $user->image = $request->image;
        $user->title = $request->title;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = bcrypt($request->password);
        $user->employee_id = $request->employee_id;

        $user->role = $request->role ? $request->role : 'user';

        $user->status = 'a';

        $user->save();

        // if the new photo url is not the same with the old one, they've changed their photo
        if($lastImage != $user->image) {
            event(new EditUserProfile($user, 'photo'));
        }

        // regardless of whether they change the photo or not, they still change the profile
        event(new EditUserProfile($user, 'edit'));

        return response()->json($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user)
    {
        $user = User::find($user);
        
        if (!$user) {
            return response()->json([
                'message' => 'Not found'
            ] ,404);
        }

        $user->status = 'x';
        $user->save();

        return response()->json($user, 200);
    }

    public function broker()
    {
        return Password::broker();
    }

    public function sendResetLinkEmail(Request $request)
    {
        // $this->validate($request, ['email' => 'required|email']);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $request->only('email'), function (Message $message) {
                dd($message);
                $message->subject('Forgot Coaltrade Password');
                $message->from('noreply-coaltrade@volantech.io', 'Coaltrade');

                $message->to($request->email);
            }
        );

        if ($response === Password::RESET_LINK_SENT) {
            return back()->with('status', trans($response));
        }

        // If an error was returned by the password broker, we will get this message
        // translated so we can notify a user of the problem. We'll redirect back
        // to where the users came from so they can attempt this process again.
        return back()->withErrors(
            ['email' => trans($response)]
        );
    }
}

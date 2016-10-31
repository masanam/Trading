<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Carbon\Carbon;

use App\Model\User;
use App\Model\Activity;
use App\Model\LoginUser;

class UserLoginListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $user = User::find($event->user->id);

        $user->last_login = Carbon::now();

        $user->save();

        $login_user = LoginUser::where('user_id', $user->id)->first();
        if($login_user) {
            $login_user->num_login = $login_user->num_login + 1;

            $login_user->save();
        } else {
            $login_user = new LoginUser();

            $login_user->user_id = $user->id;
            $login_user->num_login = 1;

            $login_user->save();
        }

        $activity = new Activity();
        $activity->user_id = $user->id;
        $activity->action = $user->name.' is logged in now.';

        $activity->save();
    }
}

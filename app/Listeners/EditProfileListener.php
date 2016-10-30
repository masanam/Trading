<?php

namespace App\Listeners;

use App\Events\EditUserProfile;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EditProfileListener
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
     * @param  EditUserProfile  $event
     * @return void
     */
    public function handle(EditUserProfile $event)
    {
        $user = User::find($event->user->id);

        $activity = new Activity();

        if($event->action == 'photo') {
            $activity->user_id = $event->user->id;
            $activity->action = $event->user->name.' has uploaded new photo.';
            $activity->table = 'users';
        } else if($event->action == 'edit') {
            $activity->user_id = $event->user->id;
            $activity->action = $event->user->name.' has edited their profile.';
            $activity->table = 'users';
        }

        $activity->save();
    }
}

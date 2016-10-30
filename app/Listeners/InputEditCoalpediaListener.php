<?php

namespace App\Listeners;

use App\Events\InputEditCoalpedia;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Model\Activity;

class InputEditCoalpediaListener
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
     * @param  InputEditCoalpedia  $event
     * @return void
     */
    public function handle(InputEditCoalpedia $event)
    {
        $activity = new Activity();

        $activity->user_id = $event->user->id;
        if($event->action == 'create') {
            $activity->action = $event->user->name.' has created a new entry of '.$event->table;
        } else if($event->action == 'update') {
            $activity->action = $event->user->name.' has updated an entry of '.$event->table;
        }
        $activity->table = $event->table;
        $activity->entity_id = $event->entity_id;

        $activity->save();
    }
}

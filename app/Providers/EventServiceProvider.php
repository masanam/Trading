<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        // 'App\Events\MessageReceived' => [
        //     'App\Listeners\EventListener',
        // ],

        'Illuminate\Auth\Events\Login' => [
            'App\Listeners\UserLoginListener'
        ],

        'App\Events\EditUserProfile' => [
            'App\Listeners\EditProfileListener'
        ],

        'App\Events\InputEditCoalpedia' => [
            'App\Listeners\InputEditCoalpediaListener'
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}

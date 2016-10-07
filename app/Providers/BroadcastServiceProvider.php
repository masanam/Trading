<?php

namespace App\Providers;

use App\Model\BuyDeal;
use App\Model\SellDeal;
use App\Model\Chat;


use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Broadcast::routes();

        /*
         * Authenticate the user's personal channel...
         */
        Broadcast::channel('chat.*', function ($chat, $chatId) {
            return (int) $chat->id === (int) $chatId;
        });
    }
}

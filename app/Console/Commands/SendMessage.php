<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

// FOR TESTING PURPOSE ONLY

class SendMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chat:message {message}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send chat(testing)';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $user = \App\Model\User::first();
        $buy_deal = \App\Model\BuyDeal::first();
        $message = \App\Model\BuyDealChat::create([
            'user_id' => $user->id,
            'buy_deal_id' => $buy_deal->id,
            'message' => $this->argument('message')
        ]);

        event(new \App\Events\ChatReceived($message, $user));
    }
}

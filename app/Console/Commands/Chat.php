<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

// FOR TESTING PURPOSE ONLY

class Chat extends Command
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
    // public function __construct()
    // {
    //     parent::__construct();
    // }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $chat = \App\Model\Chat::first();
        $user = \App\Model\User::first();
        $message = \App\Model\Message::create([
            'chat_id' => $chat->id,
            'user_id' => $user->id,
            'message' => $this->argument('message')
        ]);

        event(new \App\Events\MessageReceived($message));
    }
}

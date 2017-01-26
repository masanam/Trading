<?php

namespace App\Console\Commands;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

use Illuminate\Console\Command;

class shp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shp:populate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is a command to upload SHP file to the database';

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
      $result = shell_exec("python ./app/Console/Commands/python/shp_parser.py ");
      echo $result;
    }
}

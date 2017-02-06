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
    protected $signature = 'shp:populate {--path=}';

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
      $path = $this->option('path');
      // $result = exec("python ./app/Console/Commands/python/shp_parser.py $path");
      // echo $result;
      $handle = popen("python ./app/Console/Commands/python/shp_parser.py $path", 'r');
      while(!feof($handle)) {
          $buffer = fgets($handle);
      }
      pclose($handle);
      // pclose($result);
      $csvs = scandir($path."csv/");
      foreach($csvs as $csv) {
        $query = sprintf("LOAD DATA 
        INFILE '%s' INTO TABLE spatial_data
        FIELDS TERMINATED BY ','
        OPTIONALLY ENCLOSED BY '\"'
        ESCAPED BY '\"'
        LINES TERMINATED BY '\\n'
        IGNORE 0 LINES (`firstname`, `lastname`, `username`, `gender`, `email`, `country`, `ethnicity`, `education`  )",
        $csv);
      }
      return DB::connection()->getpdo()->exec($query);
    }
}

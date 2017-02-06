<?php

namespace App\Console\Commands;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

use Illuminate\Console\Command;
use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\LexerConfig;

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
      // $handle = popen("python ./app/Console/Commands/python/shp_parser.py $path", 'r');
      // while(!feof($handle)) {
      //     $buffer = fgets($handle);
      // }
      // pclose($handle);
      // pclose($result);
      $csvs = scandir($path."csv/");
      for ($i=2; $i < count($csvs) ; $i++) {
        echo $csvs[$i];
        // echo "\nRestricted Area? ";
        // $handle = fopen ("php://stdin","r");
        // $area = fgets($handle);
        // echo "\nType : ";
        // $handle = fopen ("php://stdin","r");
        // $type = fgets($handle);
        // echo "\nReference for Name : ";
        // $handle = fopen ("php://stdin","r");
        // $ref = fgets($handle);

        // $query = sprintf("LOAD DATA LOCAL
        // INFILE '%s' INTO TABLE spatial_data
        // FIELDS TERMINATED BY ','
        // OPTIONALLY ENCLOSED BY '\"'
        // ESCAPED BY '\"'
        // LINES TERMINATED BY '\\n'
        // IGNORE 0 LINES (`firstname`, `lastname`, `username`, `gender`, `email`, `country`, `ethnicity`, `education`  )",
        // $csv);

        $temperature = [];
        $interpreter = new Interpreter();
        $interpreter->addObserver(function(array $row) use (&$temperature) {
            $temperature[] = array(
                'temperature' => $row[0],
                'city'        => $row[1],
            );
        }); // Ignore row column count consistency

        $lexer = new Lexer(new LexerConfig());
        $lexer->parse($path . "csv/" . $csvs[$i], $interpreter);

        print_r($temperature);
      }
      return DB::connection()->getpdo()->exec($query);
    }
}

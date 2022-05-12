<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;

class Database extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Database migrate';

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
     * @return int
     */
    public function handle()
    {

        if(file_exists(database_path(env('DB_DATABASE')))) {
            system('del "'.database_path(env('DB_DATABASE')) .'"');
            sleep(1);
        }

        new \SQLite3(database_path(env('DB_DATABASE')));


        Artisan::call('migrate');

        $this->info("Migration Complete");

        return 0;
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;

class Setup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Starts the installation.';

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

        if(!file_exists(base_path() . '/.env')){
            copy(base_path() . '/.env.example', base_path() . '/.env');
            Artisan::call('key:generate');
            Artisan::call('storage:link');
        }   else {
            $this->error("The installation is already completed.");
            exit();
        }

        // ENV Düzenleme
        $domain = $this->askValid('What is your domain name?', 'domain' , [
            'required', 'url', 'string'
        ]);

        $connection = $this->ask('Your database connection type?', 'mysql');
        $host = $this->ask('Database host address?', '127.0.0.1');
        $port = $this->ask('Database host port?', '3306');
        $database = $this->askValid('What is your database name?', 'database', [
            'required'
        ]);

        $dbUser = $this->ask('What is your database user?', 'dbuser');

        $dbPassword = $this->ask('What is your database password?', 'dbpassword');

        $this->updateEnv([
            'APP_URL' => $domain,
            'DB_CONNECTION' => $connection,
            'DB_HOST' => $host,
            'DB_PORT' => $port,
            'DB_DATABASE' => $database,
            'DB_USERNAME' => $dbUser,
            'DB_PASSWORD' => $dbPassword
        ]);

        Artisan::call('migrate');

        $this->info("System settings updated.");

        return 0;
    }

    public function updateEnv($data = array())
    {
        if (!count($data)) {
            return;
        }

        $pattern = '/([^\=]*)\=[^\n]*/';

        $envFile = base_path() . '/.env';
        $lines = file($envFile);
        $newLines = [];
        foreach ($lines as $line) {
            preg_match($pattern, $line, $matches);

            if (!count($matches)) {
                $newLines[] = $line;
                continue;
            }

            if (!key_exists(trim($matches[1]), $data)) {
                $newLines[] = $line;
                continue;
            }

            $line = trim($matches[1]) . "={$data[trim($matches[1])]}\n";
            $newLines[] = $line;
        }

        $newContent = implode('', $newLines);
        file_put_contents($envFile, $newContent);
    }

    protected function askValid($question, $field, $rules)
    {
        $value = $this->ask($question);

        if($message = $this->validateInput($rules, $field, $value)) {
            $this->error($message);

            return $this->askValid($question, $field, $rules);
        }

        return $value;
    }

    protected function askSecret($question, $field, $rules)
    {
        $value = $this->secret($question);

        if($message = $this->validateInput($rules, $field, $value)) {
            $this->error($message);

            return $this->askSecret($question, $field, $rules);
        }

        return $value;
    }


    protected function validateInput($rules, $fieldName, $value)
    {
        $validator = Validator::make([
            $fieldName => $value
        ], [
            $fieldName => $rules
        ]);

        return $validator->fails()
            ? $validator->errors()->first($fieldName)
            : null;
    }
}

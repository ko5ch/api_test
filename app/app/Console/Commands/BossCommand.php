<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BossCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'boss';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Like a boss.';
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
        $this->alert('Like a boss');
        $this->info('call migrate:fresh');
        $this->call('migrate:fresh');
        $this->info('call migrate');
        $this->call('migrate');
        $this->info('call db:seed');
        $this->call('db:seed');

        $this->alert('Command complete. Thank you boss. Love you so much.');
    }

    protected function setEnvValue($envKey, $envValue)
    {
        $envFile = app()->environmentFilePath();
        $str     = file_get_contents($envFile);
        $re = "({$envKey}=)((.*))(\\n)?";
        if (is_bool($envValue)) {
            $envValue = $envValue ? 'true' : 'false';
        }
        if ($c = preg_match_all("/".$re."/m", $str, $matches)) {
            $oldValue = $matches[2][0];
            $str      = str_replace("{$envKey}={$oldValue}", "{$envKey}={$envValue}", $str);
        } else {
            $str .= "\n{$envKey}={$envValue}";
        }
        $fp = fopen($envFile, 'w');
        fwrite($fp, $str);
        fclose($fp);
    }
}
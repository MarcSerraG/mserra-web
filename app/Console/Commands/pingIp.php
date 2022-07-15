<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Ping;

class pingIp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:pingIp {ip}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $ip = $this->argument('ip');
        #$ip = $this->argument('port');
        $this->comment('Petición status a '.$ip);
        $ch = curl_init($ip);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        $health = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($health) {
            $json = json_encode(['health' => $health, 'status' => '1']);
        } else {
            $json = json_encode(['health' => $health, 'status' => '0']);
        }
        $this->comment($json);
        return 0;
    }
}

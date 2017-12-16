<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;

class BotSetup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @param Client $client
     * @return mixed
     */
    public function handle(Client $client)
    {
        $result = $client->post(
            'https://api.telegram.org/bot'
            .env('TELEGRAM_TOKEN')
            .'/setWebhook?url='
            .$this->ask('Inset application url'));

        $this->info($result->getBody()->getContents());
    }
}

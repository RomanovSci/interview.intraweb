<?php

namespace App\Providers\Botman;

use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Telegram\TelegramDriver;
use BotMan\Drivers\Web\WebDriver;
use Illuminate\Support\ServiceProvider;

class DriverManagerProvider extends ServiceProvider
{
    protected $drivers = [TelegramDriver::class];

    public function boot()
    {
        foreach ($this->drivers as $driver) {
            DriverManager::loadDriver($driver);
        }
    }
}

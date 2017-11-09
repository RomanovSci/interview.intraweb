<?php

namespace App\Http\Controllers;

use App\Subscriber;
use BotMan\Drivers\Telegram\TelegramDriver;
use Illuminate\Http\Request;
use App\Services\TelegramBotService;

class BotController extends Controller
{
    /**
     * Handle request to bot
     *
     * @param Request    $request
     * @param TelegramBotService $telegramBotService
     * @return void
     */
    public function handle(Request $request, TelegramBotService $telegramBotService)
    {
        $botman = app('botman');

        $botman->hears('/start', $telegramBotService->getStartRequestHandler());
        $botman->hears('/subscribe', $telegramBotService->getSubscribeRequestHandler($request));
        $botman->hears('/unsubscribe', $telegramBotService->getUnsubscribeRequestHandler($request));
        $botman->hears('ssl-info {domain}', $telegramBotService->getCertificateInfoRequestHandler());

        $botman->fallback($telegramBotService->getFallbackHandler());
        $botman->listen();
    }

    /**
     * Send notification to all subscribers
     *
     * @param Request $request
     */
    public function broadcast(Request $request)
    {
        $userIds = $request->input('ids');
        $subscribers = Subscriber::all();

        if (is_array($userIds) && !empty($userIds)) {
            $subscribers = Subscriber::find($userIds);
        }

        $subscribers->each(function($subscriber) use ($request)
        {
            app('botman')->say(
                $request->input('message'),
                $subscriber->telegram_id,
                TelegramDriver::class
            );
        });
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\BroadcastRequest;
use App\Subscriber;
use BotMan\Drivers\Telegram\TelegramDriver;
use App\Services\TelegramBotService;

class BotController extends Controller
{
    /**
     * Handle request to bot
     *
     * @param TelegramBotService $telegramBotService
     * @return void
     */
    public function handle(TelegramBotService $telegramBotService)
    {
        $botman = app('botman');

        $botman->hears('/start', $telegramBotService->getStartRequestHandler());
        $botman->hears('/subscribe', $telegramBotService->getSubscribeRequestHandler());
        $botman->hears('/unsubscribe', $telegramBotService->getUnsubscribeRequestHandler());
        $botman->hears('ssl-info {domain}', $telegramBotService->getCertificateInfoRequestHandler());

        $botman->fallback($telegramBotService->getFallbackHandler());
        $botman->listen();
    }

    /**
     * Send notification to all subscribers
     *
     * @param BroadcastRequest $request
     */
    public function broadcast(BroadcastRequest $request)
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

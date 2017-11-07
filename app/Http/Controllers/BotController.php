<?php

namespace App\Http\Controllers;

use App\Subscriber;
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

        $botman->hears('ssl-info {domain}', $telegramBotService->getCertificateInfoRequestHandler());
        $botman->hears('/start', function($bot) {$bot->reply('Hi there!');});
        $botman->hears('/subscribe', $telegramBotService->getSubscribeRequestHandler($request));
        $botman->hears('/unsubscribe', $telegramBotService->getUnsubscribeRequestHandler($request));

        $botman->fallback($telegramBotService->getFallbackHandler());
        $botman->listen();
    }

    /**
     * Send notification to all subscribers
     *
     * @param TelegramBotService $telegramBotService
     * @param Request            $request
     */
    public function broadcast(TelegramBotService $telegramBotService, Request $request)
    {
        $userIds = $request->input('ids');
        $subscribers = Subscriber::all();

        if (is_array($userIds) && !empty($userIds)) {
            $subscribers = Subscriber::find($userIds);
        }

        $subscribers->each(function($subscriber) use ($telegramBotService, $request)
        {
            $telegramBotService->sendMessage(
                $subscriber->telegram_id,
                $request->input('message')
            );
        });
    }
}

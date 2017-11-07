<?php

namespace App\Services;

use App\Subscriber;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class TelegramBotService
{
    /** @var DomainService */
    protected $domainService;

    /** @var Client  */
    protected $client;

    /**
     * BotService constructor.
     *
     * @param DomainService $domainService
     * @param Client $client
     */
    public function __construct(DomainService $domainService, Client $client)
    {
        $this->domainService = $domainService;
        $this->client = $client;
    }

    /**
     * Get DomainService
     *
     * @return DomainService
     */
    protected function getDomainService()
    {
        return $this->domainService;
    }

    /**
     * Get Client
     *
     * @return Client
     */
    protected function getClient()
    {
        return $this->client;
    }

    /**
     * Send message to user
     *
     * @param $id
     * @param $text
     * @return bool
     */
    public function sendMessage($id, $text): bool
    {
        try {
            $requestURL = env('TELEGRAM_BOT_URL').env('TELEGRAM_TOKEN').'/sendMessage?'.http_build_query([
                    'chat_id' => $id,
                    'text' => $text,
                ]);

            return $this
                    ->getClient()
                    ->request('GET', $requestURL)
                    ->getStatusCode() == 200;
        } catch(\Exception $e) {
            return false;
        }
    }

    /**
     * Get certificate info request handler
     *
     * @return \Closure
     */
    public function getCertificateInfoRequestHandler(): \Closure
    {
        return function($bot, $domain)
        {
            $isValidDomain = $this->getDomainService()->validate($domain);
            $certInfo = $this->getDomainService()->getCertificateInfo($domain);

            if (!$isValidDomain || empty($certInfo)) {
                $bot->reply('Error! Check domain again');
                return null;
            }

            foreach ($certInfo as $param => $value) {
                $bot->reply($param.': '.$value);
            }
        };
    }

    /**
     * Get subscribe handler
     *
     * @param  Request $request
     * @return \Closure
     */
    public function getSubscribeRequestHandler(Request $request): \Closure
    {
        return function($bot) use ($request)
        {
            try {
                $subscriber = new Subscriber();

                $subscriber->telegram_id = $request->input('message.from.id');
                $subscriber->telegram_username = $request->input('message.from.first_name');

                if ($subscriber->save()) {
                    $bot->reply('Done ^_^');
                }
            } catch (\Exception $e) {
                $bot->reply('Sorry...Not now :c');
            }
        };
    }

    /**
     * Get unsubscribe request handler
     *
     * @param Request $request
     * @return \Closure
     */
    public function getUnsubscribeRequestHandler(Request $request): \Closure
    {
        return function($bot) use ($request)
        {
            Subscriber::where(
                'telegram_id',
                $request->input('message.from.id')
            )->delete();

            $bot->reply('Done ^_^');
        };
    }

    /**
     * Get fallback handler
     *
     * @return \Closure
     */
    public function getFallbackHandler(): \Closure
    {
        return function($bot)
        {
            $bot->reply('Error! Check domain again');
        };
    }
}
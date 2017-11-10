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
     * Get start request handler
     *
     * @return \Closure
     */
    public function getStartRequestHandler(): \Closure
    {
        return function($bot)
        {
            $bot->reply('Hi there!');
        };
    }

    /**
     * Get subscribe request handler
     *
     * @return \Closure
     */
    public function getSubscribeRequestHandler(): \Closure
    {
        return function($bot)
        {
            try {
                $telegramUser = $bot->getUser();
                $subscriber = new Subscriber();

                $subscriber->telegram_id = $telegramUser->getId();
                $subscriber->telegram_username = $telegramUser->getFirstName();

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
     * @return \Closure
     */
    public function getUnsubscribeRequestHandler(): \Closure
    {
        return function($bot)
        {
            Subscriber::where('telegram_id', $bot->getUser()->getId())->delete();
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
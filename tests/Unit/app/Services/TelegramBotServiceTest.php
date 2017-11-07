<?php

namespace Tests\app\Services;

use App\Services\DomainService;
use App\Services\TelegramBotService;
use GuzzleHttp\Client;
use Tests\TestCase;

class TelegramBotServiceTest extends TestCase
{
    public function testConstruct()
    {
        /** @var Client $client */
        $client = $this->getMockBuilder(Client::class)
            ->setMethods()
            ->getMock();

        /** @var DomainService $domainService */
        $domainService = $this->getMockBuilder(DomainService::class)
            ->disableOriginalConstructor()
            ->setMethods()
            ->getMock();

        $telegramBotServiceMock = new TelegramBotServiceMock($domainService, $client);
        $this->assertInstanceOf(Client::class, $telegramBotServiceMock->client);
        $this->assertInstanceOf(DomainService::class, $telegramBotServiceMock->domainService);
    }
}

class TelegramBotServiceMock extends TelegramBotService
{
    public $domainService;
    public $client;
}
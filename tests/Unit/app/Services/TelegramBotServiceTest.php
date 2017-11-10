<?php

namespace Tests\app\Services;

use App\Services\DomainService;
use App\Services\TelegramBotService;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
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

    public function testGetDomainService()
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

        /** @var TelegramBotServiceMock $telegramBotServiceMock */
        $telegramBotServiceMock = new TelegramBotServiceMock($domainService, $client);
        $this->assertInstanceOf(DomainService::class, $telegramBotServiceMock->getDomainService());
    }

    public function testGetClient()
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

        /** @var TelegramBotServiceMock $telegramBotServiceMock */
        $telegramBotServiceMock = new TelegramBotServiceMock($domainService, $client);
        $this->assertInstanceOf(Client::class, $telegramBotServiceMock->getClient());
    }

    public function testGetCertificateInfoRequestHandler()
    {
        /** @var TelegramBotServiceMock $telegramBotServiceMock */
        $telegramBotServiceMock = $this->getMockBuilder(TelegramBotServiceMock::class)
            ->disableOriginalConstructor()
            ->setMethods()
            ->getMock();

        $this->assertInstanceOf(
            \Closure::class,
            $telegramBotServiceMock->getCertificateInfoRequestHandler()
        );
    }

    public function testGetSubscribeRequestHandler()
    {
        /** @var TelegramBotServiceMock $telegramBotServiceMock */
        $telegramBotServiceMock = $this->getMockBuilder(TelegramBotServiceMock::class)
            ->disableOriginalConstructor()
            ->setMethods()
            ->getMock();

        $this->assertInstanceOf(
            \Closure::class,
            $telegramBotServiceMock->getSubscribeRequestHandler()
        );
    }

    public function testGetUnsubscribeRequestHandler()
    {
        /** @var TelegramBotServiceMock $telegramBotServiceMock */
        $telegramBotServiceMock = $this->getMockBuilder(TelegramBotServiceMock::class)
            ->disableOriginalConstructor()
            ->setMethods()
            ->getMock();

        $this->assertInstanceOf(
            \Closure::class,
            $telegramBotServiceMock->getUnsubscribeRequestHandler()
        );
    }

    public function testGetFallbackHandler()
    {
        /** @var TelegramBotServiceMock $telegramBotServiceMock */
        $telegramBotServiceMock = $this->getMockBuilder(TelegramBotServiceMock::class)
            ->disableOriginalConstructor()
            ->setMethods()
            ->getMock();

        $this->assertInstanceOf(
            \Closure::class,
            $telegramBotServiceMock->getFallbackHandler()
        );
    }
}

class TelegramBotServiceMock extends TelegramBotService
{
    public $domainService;
    public $client;

    public function getDomainService()
    {
        return parent::getDomainService();
    }

    public function getClient()
    {
        return parent::getClient();
    }
}
<?php

namespace Tests\app\Http\Controllers;

use App\Http\Controllers\SubscribersController;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class SubscribersControllerTest extends TestCase
{
    const NOT_EXISTS_USER_ID = -1;

    public function testAll()
    {
        /** @var SubscribersController $controller */
        $controller = $this->getMockBuilder(SubscribersController::class)
            ->setMethods()
            ->getMock();

        $actualResult = $controller->all();
        $this->assertInstanceOf(JsonResponse::class, $actualResult);
    }

    public function testDelete()
    {
        /** @var SubscribersController $controller */
        $controller = $this->getMockBuilder(SubscribersController::class)
            ->setMethods()
            ->getMock();

        $actualResult = $controller->delete(self::NOT_EXISTS_USER_ID);
        $this->assertInstanceOf(JsonResponse::class, $actualResult);
    }
}
<?php

namespace Tests\Feature;

use Tests\TestCase;

class StaticPagesTest extends TestCase
{
    public function testMain()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function testBroadcast()
    {
        $response = $this->get('/broadcast');
        $response->assertStatus(200);
    }
}
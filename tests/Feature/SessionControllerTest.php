<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SessionControllerTest extends TestCase
{
    public function testCreateSession()
    {
        $this->get('/session/create')
            ->assertSessionHas("userId", "jabal")
            ->assertSessionHas("isMember", true);
    }

    public function testGetSession()
    {
        $this->withSession([
            'userId' => 'jabal',
            'isMember' => 'true'
        ])->get('/session/get')
            ->assertSeeText('jabal')->assertSeeText('true');
    }

    public function testGetSessionFailed()
    {
        $this->withSession([])->get('/session/get')
            ->assertSeeText('User ID : guest, Is Member : false');
    }
}

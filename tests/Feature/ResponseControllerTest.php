<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ResponseControllerTest extends TestCase
{
    public function testResponse()
    {
        $this->get('/response/hello')
            ->assertStatus(200)
            ->assertSeeText('Hello Response');
    }

    public function testHeader()
    {
        $this->get('/response/header')
            ->assertStatus(200)
            ->assertSeeText('Jabal')->assertSeeText('Salam')
            ->assertHeader('Content-Type', 'application/json')
            ->assertHeader('Author', 'Moorden Creative')
            ->assertHeader('App', 'Belajar Laravel');
    }

    public function testView()
    {
        $this->get('/response/type/view')
            ->assertSeeText('Hello Jabal');
    }

    public function testJson()
    {
        $this->get('/response/type/json')
            ->assertJson([
                "firstName" => "Jabal",
                "lastName" => "Salam"
            ]);
    }

    public function testFile()
    {
        $this->get('/response/type/file')
            ->assertHeader('Content-Type', "image/png");
    }

    public function testDownload()
    {
        $this->get('/response/type/download')
            ->assertDownload("clock.png");
    }


}

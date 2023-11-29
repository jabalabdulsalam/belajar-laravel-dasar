<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\View\View;
use Tests\TestCase;

class ViewTest extends TestCase
{
    public function testView()
    {
        $this->get('/hello')
            ->assertSeeText('Hello Jabal');

        $this->get('/hello-again')
            ->assertSeeText('Hello Jabal');
    }

    public function testNested()
    {
        $this->get('/hello-world')
            ->assertSeeText('World Jabal');

    }

    public function testTemplate()
    {
        $this->view('hello.world', ['name' => 'Jabal'])
                ->assertSeeText('World Jabal');
    }
}

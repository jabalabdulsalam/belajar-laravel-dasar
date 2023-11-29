<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InputControllerTest extends TestCase
{
    public function testInput()
    {
        $this->get('/input/hello?name=Jabal')
            ->assertSeeText('Hello Jabal');

        $this->post('/input/hello',[
           'name' => 'Jabal'
        ])->assertSeeText('Hello Jabal');
    }

    public function testNestedInput()
    {
        $this->post('/input/hello/first',[
            "name"=>[
                "first"=>"Jabal",
                "last"=>"Abdul"
        ]])
            ->assertSeeText("Hello Jabal");
    }

    public function testInputAll()
    {
        $this->post('/input/hello/input',[
            "name"=>[
                "first"=>"Jabal",
                "last"=>"Abdul"
            ]])
            ->assertSeeText("name")->assertSeeText("first")
            ->assertSeeText("last")->assertSeeText("Jabal")
            ->assertSeeText("Abdul");
    }

    public function testArrayInput(){
        $this->post('/input/hello/array',[
            "products"=>[
               [
                   "name" => "Apple Macbook Pro",
                   "price" => 30000000
               ],
                [
                    "name" => "Lenovo Ideapad 330",
                    "price" => 20000000
                ]
            ]
        ])->assertSeeText("Apple Macbook Pro")
            ->assertSeeText("Lenovo Ideapad 330");
    }

    public function testInputType()
    {
        $this->post('/input/type',[
            'name' => 'Jabal',
            'married' => 'true',
            'birth_date' => '2023-01-18'
        ])->assertSeeText('Jabal')->assertSeeText('true')->assertSeeText('2023-01-18');
    }

    public function testFilterOnly()
    {
        $this->post('/input/filter/only',[
            "name" => [
                "first" => "Jabal",
                "middle" => "Abdul",
                "last" => "Salam"
            ]
        ])->assertSeeText("Jabal")->assertDontSeeText("Abdul")->assertSeeText("Salam");
    }

    public function testFilterExcept()
    {
        $this->post('/input/filter/except',[
            "username" => "jabal",
            "password" => "rahasia",
            "admin" => "true"
        ])->assertSeeText("jabal")->assertSeeText("rahasia")->assertDontSeeText("admin");
    }

    public function testFilterMerge()
    {
        $this->post('/input/filter/merge',[
            "username" => "jabal",
            "password" => "rahasia",
            "admin" => "true"
        ])->assertSeeText("jabal")->assertSeeText("rahasia")
            ->assertSeeText("admin")->assertSeeText("false");
    }
}

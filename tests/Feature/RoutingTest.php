<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoutingTest extends TestCase
{
  public function testGet()
  {
      $this->get('/moorden')
          ->assertStatus(200)
          ->assertSeeText('Hello Moorden Creative');
  }

    public function testRedirect()
    {
        $this->get('/youtube')
            ->assertRedirect('/moorden');
    }

    public function testFallback()
    {
        $this->get('/tidakada')
            ->assertSeeText('404 by Moorden Creative');
    }

    public function testRouteParameter(){
      $this->get('/products/1')
          ->assertSeeText('Product 1');

        $this->get('/products/2')
            ->assertSeeText('Product 2');

        $this->get('/products/1/items/XXX')
            ->assertSeeText('Product 1, Item XXX');

        $this->get('/products/2/items/YYY')
            ->assertSeeText('Product 2, Item YYY');
    }

    public function testRouteParameterRegex()
    {
        $this->get('/categories/100')
            ->assertSeeText('Category 100');

        $this->get('/categories/jabal')
            ->assertSeeText('404 by Moorden Creative');
    }

    public function testRouteParameterOptional()
    {
        $this->get('/users/jabal')
            ->assertSeeText('User jabal');

        $this->get('/users/')
            ->assertSeeText('404');
    }

    public function testRouteConflict()
    {
        $this->get('/conflict/budi')
            ->assertSeeText("Conflict budi");

        $this->get('/conflict/jabal')
            ->assertSeeText("Conflict Jabal Abdul Salam");
    }

    public function testNamedRoute()
    {
        $this->get('/product/12345')
            ->assertSeeText('Link http://localhost/products/12345');
        $this->get('/product-redirect/12345')
            ->assertSeeText('/products/12345');
    }
}

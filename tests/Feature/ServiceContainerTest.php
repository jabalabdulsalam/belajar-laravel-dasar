<?php

namespace Tests\Feature;

use App\Data\Bar;
use App\Data\Foo;
use App\Data\Person;
use App\Services\HelloService;
use App\Services\HelloServiceIndonesia;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\App;
use Tests\TestCase;
use function PHPUnit\Framework\assertEquals;

class ServiceContainerTest extends TestCase
{
    public function testDependency()
    {
        //$foo = new Foo();
        $foo1 = $this->app->make(Foo::class); // new Foo
        $foo2 = $this->app->make(Foo::class); // new Foo

        self::assertEquals('Foo', $foo1->foo());
        self::assertEquals('Foo', $foo2->foo());
        self::assertNotSame($foo1, $foo2);
    }

    public function testBind()
    {
        $this->app->bind(Person::class, function ($app){
            return new Person("Jabal", "Salam");
        });

        $person1 = $this->app->make(Person::class); //closure() // new Person("Jabal", "Salam")
        $person2 = $this->app->make(Person::class); //closure() // new Person("Jabal", "Salam")

        self::assertEquals('Jabal', $person1->firstName);
        self::assertEquals('Jabal', $person2->firstName);
        self::assertNotSame($person1, $person2);
    }

    public function testSingleton()
    {
        $this->app->singleton(Person::class, function ($app){
            return new Person("Jabal", "Salam");
        });

        $person1 = $this->app->make(Person::class); // new Person("Jabal", "Salam"); if not exists
        $person2 = $this->app->make(Person::class); // return existing

        self::assertEquals('Jabal', $person1->firstName);
        self::assertEquals('Jabal', $person2->firstName);
        self::assertSame($person1, $person2);
    }

    public function testInstance()
    {
        $person = new Person("Jabal", "Salam");
        $this->app->instance(Person::class, $person);

        $person1 = $this->app->make(Person::class); // $person
        $person2 = $this->app->make(Person::class); // $person

        self::assertEquals('Jabal', $person1->firstName);
        self::assertEquals('Jabal', $person2->firstName);
        self::assertSame($person1, $person2);
    }

    public function testDependencyInjection()
    {
        $this->app->singleton(Foo::class, function ($app){
            return new Foo();
        });

        $this->app->singleton(Bar::class, function ($app){
            $foo = $app->make(Foo::class);
            return new Bar($foo);
        });

        $foo = $this->app->make(Foo::class);
        $bar1 = $this->app->make(Bar::class);
        $bar2 = $this->app->make(Bar::class);

        self::assertSame($foo, $bar1->foo);
        self::assertSame($bar1, $bar2);
    }

    public function testHelloService()
    {
        $this->app->singleton(HelloService::class, HelloServiceIndonesia::class);

        $helloService = $this->app->make(HelloService::class);
        self::assertEquals("Hallo Jabal", $helloService->hello("Jabal"));
    }


}

<?php

declare(strict_types = 1);

namespace Tests\Unit;

use App\Router\RouterMapper;
use PHPUnit\Framework\TestCase;
use App\Router\Exception\RouterException;

class RouterTest extends TestCase
{
    private RouterMapper $router;

    public function setUp(): void
    {
        parent::setUp();

        $this->router = new RouterMapper();
    }

    /** @test */
    public function itRegisterARouter(): void
    {
        $this->router->register("/users", "GET" , ["UserController", "index"]);
        $expected = [
            "/users" => [
                "GET" => ["UserController", "index"],
            ],
        ];

        $this->assertEquals($expected, $this->router->getRoutes());
    }

    /** @test */
    public function itRegistersGetRoutes(): void
    {
        $this->router->get("/users", ["UserController", "index"]);
        $expected = [
            "/users" => [
                "GET" => ["UserController", "index"],
            ],
        ];

        $this->assertEquals($expected, $this->router->getRoutes());
    }

    /** @test */
    public function itRegistersPostRoutes(): void
    {
        $this->router->post("/users", ["UserController", "index"]);
        $expected = [
            "/users" => [
                "POST" => ["UserController", "index"],
            ],
        ];

        $this->assertEquals($expected, $this->router->getRoutes());
    }

    /** @test */
    public function thereAreNoRoutesWhenRouterIsCreated(): void
    {
        $this->assertEmpty($this->router->getRoutes());
    }

    /**
     * @test
     * @dataProvider routeExceptionCases
     */
    public function itThrowsRouterException(string $routeUrl, string $method): void
    {
        $users = new class
        {
            public function delete(): void
            {}
        };
        $this->router->get("/users", ["UserController", "index"]);
        $this->router->post('/users', [$users::class, "store"]);

        $this->expectException(RouterException::class);
        $this->router->handleRoute($routeUrl, $method);
    }


    /** @test */
    public function itHandlesMethod(): void
    {
        $users = new class
        {
            public function index(): array
            {
                return [1,2,3];
            }
        };
        $this->router->get("/users", [$users::class, "index"]);

        $this->assertEquals([1,2,3], $this->router->handleRoute('/users', 'GET'));
    }
    public function routeExceptionCases(): array
    {
        return [
            ['/users','PUT'],
            ['/products', 'POST'],
            ['/users','POST'],
            ['/users','POST'],
        ];
    }
}
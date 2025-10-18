<?php

namespace Tests\Controllers;

use App\Controllers\AuthController;
use App\Http\Request;
use PHPUnit\Framework\TestCase;
use Tests\Support\ArraySession;
use Tests\Support\FakeUserRepository;

class AuthControllerTest extends TestCase
{
    public function testLoginSuccessReturnsJsonResponse(): void
    {
        $repo = new FakeUserRepository();
        $repo->users['admin@example.com'] = [
            'id' => 1,
            'name' => 'Admin',
            'birthday' => '1990-01-01',
            'email' => 'admin@example.com',
            'password' => password_hash('secret', PASSWORD_DEFAULT),
            'role' => 'admin',
        ];

        $session = new ArraySession();
        $controller = new AuthController($repo, $session);
        $request = new Request(
            'POST',
            '/auth/login',
            [],
            ['email' => 'admin@example.com', 'password' => 'secret'],
            [],
            ['Accept' => 'application/json']
        );

        $response = $controller->login($request);
        $this->assertSame(200, $response->status());
        $data = json_decode($response->content(), true);
        $this->assertTrue($data['success']);
        $this->assertSame('admin@example.com', $data['user']['email']);
        $this->assertSame('admin', $session->get('user')['role']);
    }

    public function testLoginFailureReturnsError(): void
    {
        $repo = new FakeUserRepository();
        $session = new ArraySession();
        $controller = new AuthController($repo, $session);
        $request = new Request(
            'POST',
            '/auth/login',
            [],
            ['email' => 'missing@example.com', 'password' => 'nope'],
            [],
            ['Accept' => 'application/json']
        );

        $response = $controller->login($request);
        $this->assertSame(401, $response->status());
        $data = json_decode($response->content(), true);
        $this->assertFalse($data['success']);
    }
}

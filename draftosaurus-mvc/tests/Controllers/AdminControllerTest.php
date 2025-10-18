<?php

namespace Tests\Controllers;

use App\Controllers\AdminController;
use App\Http\Request;
use PHPUnit\Framework\TestCase;
use Tests\Support\FakeGameRepository;
use Tests\Support\FakeUserRepository;

class AdminControllerTest extends TestCase
{
    public function testListUsersRequiresAdminRole(): void
    {
        $users = new FakeUserRepository();
        $users->users['user@example.com'] = [
            'email' => 'user@example.com',
            'role' => 'player',
        ];
        $controller = new AdminController($users, new FakeGameRepository());
        $request = new Request(
            'GET',
            '/admin/users',
            [],
            [],
            ['user' => 'user@example.com'],
            ['Accept' => 'application/json']
        );

        $response = $controller->listUsers($request);
        $this->assertSame(403, $response->status());
        $data = json_decode($response->content(), true);
        $this->assertFalse($data['success']);
    }

    public function testAdminCanListUsers(): void
    {
        $users = new FakeUserRepository();
        $users->users['admin@example.com'] = [
            'email' => 'admin@example.com',
            'role' => 'admin',
        ];
        $users->users['player@example.com'] = [
            'email' => 'player@example.com',
            'role' => 'player',
        ];
        $controller = new AdminController($users, new FakeGameRepository());
        $request = new Request(
            'GET',
            '/admin/users',
            [],
            [],
            ['user' => 'admin@example.com'],
            ['Accept' => 'application/json']
        );

        $response = $controller->listUsers($request);
        $this->assertSame(200, $response->status());
        $data = json_decode($response->content(), true);
        $this->assertTrue($data['success']);
        $this->assertCount(1, $data['users']);
        $this->assertSame('player@example.com', $data['users'][0]['email']);
    }
}

<?php

namespace Tests\Controllers;

use App\Controllers\GameController;
use App\Http\Request;
use PHPUnit\Framework\TestCase;
use Tests\Support\FakeGameRepository;

class GameControllerTest extends TestCase
{
    public function testStorePersistsResults(): void
    {
        $repo = new FakeGameRepository();
        $controller = new GameController($repo);
        $payload = json_encode([
            'modo' => 'invierno',
            'players' => [
                ['name' => 'Alice', 'email' => 'alice@example.com', 'total' => 30, 'winner' => true],
                ['name' => 'Bob', 'email' => 'bob@example.com', 'total' => 15, 'winner' => false],
            ],
        ]);
        $request = new Request(
            'POST',
            '/api/games',
            [],
            [],
            [],
            ['Accept' => 'application/json'],
            $payload
        );

        $response = $controller->store($request);
        $this->assertSame(200, $response->status());
        $data = json_decode($response->content(), true);
        $this->assertTrue($data['success']);
        $this->assertSame(1, $data['game_id']);
        $this->assertCount(1, $repo->saved);
        $this->assertSame('invierno', $repo->saved[0]['mode']);
    }

    public function testStoreValidatesPlayers(): void
    {
        $repo = new FakeGameRepository();
        $controller = new GameController($repo);
        $request = new Request(
            'POST',
            '/api/games',
            [],
            [],
            [],
            ['Accept' => 'application/json'],
            json_encode(['modo' => 'invierno'])
        );

        $response = $controller->store($request);
        $this->assertSame(422, $response->status());
        $data = json_decode($response->content(), true);
        $this->assertFalse($data['success']);
    }
}

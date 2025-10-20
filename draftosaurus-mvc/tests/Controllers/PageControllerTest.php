<?php

namespace Tests\Controllers;

use App\Controllers\PageController;
use App\Http\Request;
use PHPUnit\Framework\TestCase;
use Tests\Support\ArraySession;
use Tests\Support\FakeUserRepository;

class PageControllerTest extends TestCase
{
    public function testGameViewRendersPlayersInRequestedOrder(): void
    {
        $repo = new FakeUserRepository();
        $repo->users['player1@example.com'] = [
            'id' => 2,
            'name' => 'Player 1',
            'email' => 'player1@example.com',
        ];
        $repo->users['player2@example.com'] = [
            'id' => 1,
            'name' => 'Player 2',
            'email' => 'player2@example.com',
        ];

        $session = new ArraySession();
        $controller = new PageController($repo, $session);
        $request = new Request('GET', '/game', [
            'jugadores' => '2,1',
            'modo' => 'invierno',
        ]);

        $response = $controller->game($request);
        $this->assertSame(200, $response->status());

        $content = $response->content();
        $this->assertStringContainsString('window.gameModo = "invierno"', $content);
        $this->assertStringContainsString('Player 1', $content);
        $this->assertStringContainsString('Player 2', $content);
        $this->assertTrue(strpos($content, 'Player 1') < strpos($content, 'Player 2'));
    }
}

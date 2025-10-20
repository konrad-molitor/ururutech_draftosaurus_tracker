<?php

namespace App;

use App\Controllers\AccountController;
use App\Controllers\AdminController;
use App\Controllers\AuthController;
use App\Controllers\PageController;
use App\Controllers\GameController;
use App\Http\Request;
use App\Http\Response;
use App\Repositories\GameRepositoryInterface;
use App\Repositories\MysqlGameRepository;
use App\Repositories\MysqlUserRepository;
use App\Repositories\UserRepositoryInterface;
use App\Support\PHPSession;
use App\Support\Router;
use App\Support\SessionInterface;

class Kernel
{
    private Router $router;

    public function __construct(
        private ?UserRepositoryInterface $users = null,
        private ?GameRepositoryInterface $games = null,
        private ?SessionInterface $session = null
    ) {
        $this->users = $users ?? new MysqlUserRepository();
        $this->games = $games ?? new MysqlGameRepository();
        $this->session = $session ?? new PHPSession();
        $this->router = new Router();
        $this->registerRoutes();
    }

    public function handle(Request $request): Response
    {
        return $this->router->dispatch($request);
    }

    private function registerRoutes(): void
    {
        $this->router->map('GET', '/', fn (Request $req) => $this->pages()->home($req));
        $this->router->map('GET', '/rules', fn (Request $req) => $this->pages()->rules($req));
        $this->router->map('GET', '/account', fn (Request $req) => $this->pages()->account($req));
        $this->router->map('GET', '/tracking', fn (Request $req) => $this->pages()->tracking($req));
        $this->router->map('GET', '/play', fn (Request $req) => $this->pages()->play($req));
        $this->router->map('GET', '/game', fn (Request $req) => $this->pages()->game($req));
        $this->router->map('GET', '/confirmation', fn (Request $req) => $this->pages()->confirmation($req));
        $this->router->map('GET', '/rejection', fn (Request $req) => $this->pages()->rejection($req));

        $this->router->map('POST', '/auth/login', fn (Request $req) => $this->auth()->login($req));
        $this->router->map('POST', '/back/login.php', fn (Request $req) => $this->auth()->login($req));

        $this->router->map('GET', '/auth/logout', fn (Request $req) => $this->auth()->logout($req));
        $this->router->map('GET', '/back/logout.php', fn (Request $req) => $this->auth()->logout($req));

        $this->router->map('POST', '/auth/register', fn (Request $req) => $this->auth()->register($req));
        $this->router->map('POST', '/back/user.php', fn (Request $req) => $this->auth()->register($req));

        $this->router->map('POST', '/auth/check', fn (Request $req) => $this->auth()->checkUser($req));
        $this->router->map('POST', '/back/check_user.php', fn (Request $req) => $this->auth()->checkUser($req));

        $this->router->map('GET', '/account/profile', fn (Request $req) => $this->account()->profile($req));

        $this->router->map('POST', '/account/update', fn (Request $req) => $this->account()->updateProfile($req));
        $this->router->map('POST', '/back/update_user.php', fn (Request $req) => $this->account()->updateProfile($req));

        $this->router->map('POST', '/account/delete', fn (Request $req) => $this->account()->deleteAccount($req));
        $this->router->map('POST', '/back/delete_user.php', fn (Request $req) => $this->account()->deleteAccount($req));

        $this->router->map('GET', '/account/results', fn (Request $req) => $this->account()->results($req));
        $this->router->map('GET', '/back/user_results.php', fn (Request $req) => $this->account()->results($req));

        $this->router->map('GET', '/admin/users', fn (Request $req) => $this->admin()->listUsers($req));
        $this->router->map('GET', '/back/admin_list_users.php', fn (Request $req) => $this->admin()->listUsers($req));

        $this->router->map('POST', '/admin/users', fn (Request $req) => $this->admin()->createUser($req));
        $this->router->map('POST', '/back/admin_create_user.php', fn (Request $req) => $this->admin()->createUser($req));

        $this->router->map('POST', '/admin/users/update', fn (Request $req) => $this->admin()->updateUser($req));
        $this->router->map('POST', '/back/admin_update_user.php', fn (Request $req) => $this->admin()->updateUser($req));

        $this->router->map('POST', '/admin/users/delete', fn (Request $req) => $this->admin()->deleteUser($req));
        $this->router->map('POST', '/back/admin_delete_user.php', fn (Request $req) => $this->admin()->deleteUser($req));

        $this->router->map('GET', '/admin/games', fn (Request $req) => $this->admin()->listGames($req));
        $this->router->map('GET', '/back/admin_list_games.php', fn (Request $req) => $this->admin()->listGames($req));

        $this->router->map('POST', '/admin/games/delete', fn (Request $req) => $this->admin()->deleteGame($req));
        $this->router->map('POST', '/back/admin_delete_game.php', fn (Request $req) => $this->admin()->deleteGame($req));

        $this->router->map('POST', '/api/games', fn (Request $req) => $this->game()->store($req));
        $this->router->map('POST', '/back/save_game_results.php', fn (Request $req) => $this->game()->store($req));
    }

    private function auth(): AuthController
    {
        return new AuthController($this->users, $this->session);
    }

    private function account(): AccountController
    {
        return new AccountController($this->users, $this->games, $this->session);
    }

    private function admin(): AdminController
    {
        return new AdminController($this->users, $this->games);
    }

    private function game(): GameController
    {
        return new GameController($this->games);
    }

    private function pages(): PageController
    {
        return new PageController($this->users, $this->session);
    }
}

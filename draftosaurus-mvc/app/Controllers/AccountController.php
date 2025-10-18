<?php

namespace App\Controllers;

use App\Http\JsonResponse;
use App\Http\RedirectResponse;
use App\Http\Request;
use App\Http\Response;
use App\Repositories\GameRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Support\SessionInterface;

class AccountController
{
    public function __construct(
        private UserRepositoryInterface $users,
        private GameRepositoryInterface $games,
        private SessionInterface $session
    ) {
        $this->session->start();
    }

    public function profile(Request $request): Response
    {
        $user = $this->session->get('user');
        if (!$user) {
            return new JsonResponse(['success' => false, 'message' => 'No autenticado'], 401);
        }

        if ($request->expectsJson()) {
            return new JsonResponse(['success' => true, 'user' => $user]);
        }

        $html = '<h1>Perfil</h1><pre>' . htmlspecialchars(json_encode($user, JSON_PRETTY_PRINT), ENT_QUOTES, 'UTF-8') . '</pre>';
        return new Response($html);
    }

    public function updateProfile(Request $request): Response
    {
        $email = $request->cookie('user') ?? ($this->session->get('user')['email'] ?? '');
        if ($email === '') {
            return new JsonResponse(['success' => false, 'message' => 'No autenticado'], 401);
        }

        $name = trim((string) $request->input('name', ''));
        if ($name === '') {
            return new JsonResponse(['success' => false, 'message' => 'Nombre requerido'], 422);
        }

        $updated = $this->users->update(['email' => $email, 'name' => $name]);
        if ($updated && $this->session->get('user')) {
            $user = $this->session->get('user');
            $user['name'] = $name;
            $this->session->put('user', $user);
        }

        if ($request->expectsJson()) {
            return new JsonResponse(['success' => $updated]);
        }

        return $updated
            ? RedirectResponse::to('/front/index.php')
            : RedirectResponse::to('/front/rechazo.php');
    }

    public function deleteAccount(Request $request): Response
    {
        $email = $request->cookie('user') ?? ($this->session->get('user')['email'] ?? '');
        if ($email === '' || strtoupper($request->method()) !== 'POST') {
            return new JsonResponse(['success' => false, 'message' => 'No autorizado'], 403);
        }

        $deleted = $this->users->deleteByEmail($email);
        $this->session->invalidate();
        $response = $request->expectsJson()
            ? new JsonResponse(['success' => $deleted])
            : RedirectResponse::to('/front/index.php');
        $expiry = time() - 3600;
        $response->cookie('user', '', $expiry);
        $response->cookie('role', '', $expiry);
        return $response;
    }

    public function results(Request $request): Response
    {
        $email = $request->cookie('user') ?? ($this->session->get('user')['email'] ?? '');
        if ($email === '') {
            return new JsonResponse(['success' => false, 'message' => 'No autenticado'], 401);
        }

        $results = $this->games->resultsForUser($email);
        return new JsonResponse(['success' => true, 'results' => $results]);
    }
}

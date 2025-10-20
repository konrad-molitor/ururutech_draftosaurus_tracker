<?php

namespace App\Controllers;

use App\Http\JsonResponse;
use App\Http\RedirectResponse;
use App\Http\Request;
use App\Http\Response;
use App\Repositories\UserRepositoryInterface;
use App\Support\SessionInterface;
use DateTimeImmutable;

class AuthController
{
    public function __construct(
        private UserRepositoryInterface $users,
        private SessionInterface $session
    ) {
        $this->session->start();
    }

    public function login(Request $request): Response
    {
        $email = trim((string) $request->input('email', ''));
        $password = (string) $request->input('password', '');

        $user = $this->users->findByEmail($email);
        if ($user && $this->users->verifyPassword($user, $password)) {
            $payload = [
                'id' => $user['id'] ?? null,
                'name' => $user['name'] ?? '',
                'birthday' => $user['birthday'] ?? '',
                'email' => $user['email'] ?? $email,
                'role' => strtolower(trim($user['role'] ?? 'player')),
            ];
            $this->session->put('user', $payload);

            $response = $request->expectsJson()
                ? new JsonResponse(['success' => true, 'user' => $payload])
                : RedirectResponse::to('/account');

            $expiry = (new DateTimeImmutable('+30 days'))->getTimestamp();
            $response->cookie('user', $payload['email'], $expiry);
            $response->cookie('role', $payload['role'], $expiry);

            return $response;
        }

        if ($request->expectsJson()) {
            return new JsonResponse(['success' => false, 'message' => 'Credenciales inválidas'], 401);
        }

        return RedirectResponse::to('/rejection');
    }

    public function logout(Request $request): Response
    {
        $this->session->invalidate();
        $response = RedirectResponse::to('/');
        $expiry = time() - 3600;
        $response->cookie('user', '', $expiry);
        $response->cookie('role', '', $expiry);
        return $response;
    }

    public function register(Request $request): Response
    {
        $name = trim((string) $request->input('name', ''));
        $birthday = trim((string) $request->input('birthday', ''));
        $email = trim((string) $request->input('email', ''));
        $password = (string) $request->input('password', '');

        if ($name === '' || $email === '' || $password === '') {
            if ($request->expectsJson()) {
                return new JsonResponse(['success' => false, 'message' => 'Campos obligatorios faltan'], 422);
            }
            return RedirectResponse::to('/rejection');
        }

        $existing = $this->users->findByEmail($email);
        if ($existing) {
            if ($request->expectsJson()) {
                return new JsonResponse(['success' => false, 'message' => 'Email ya registrado'], 409);
            }
            return RedirectResponse::to('/rejection');
        }

        $created = $this->users->create([
            'name' => $name,
            'birthday' => $birthday,
            'email' => $email,
            'password' => $password,
            'role' => 'player',
        ]);

        if ($request->expectsJson()) {
            return new JsonResponse(['success' => $created]);
        }

        return $created
            ? RedirectResponse::to('/confirmation')
            : RedirectResponse::to('/rejection');
    }

    public function checkUser(Request $request): Response
    {
        $email = trim((string) $request->input('email', ''));
        if ($email === '') {
            return new JsonResponse(['success' => false, 'message' => 'Email requerido'], 422);
        }

        $user = $this->users->findByEmail($email);
        if (!$user) {
            return new JsonResponse(['success' => false, 'message' => 'Usuario no encontrado'], 404);
        }

        return new JsonResponse([
            'success' => true,
            'user' => [
                'name' => $user['name'] ?? '',
                'email' => $user['email'] ?? $email,
                'id' => $user['id'] ?? null,
            ],
        ]);
    }
}

<?php

namespace App\Controllers;

use App\Http\JsonResponse;
use App\Http\Request;
use App\Http\Response;
use App\Repositories\GameRepositoryInterface;
use App\Repositories\UserRepositoryInterface;

class AdminController
{
    public function __construct(
        private UserRepositoryInterface $users,
        private GameRepositoryInterface $games
    ) {
    }

    public function listUsers(Request $request): Response
    {
        $auth = $this->requireAdmin($request);
        if ($auth instanceof Response) {
            return $auth;
        }

        $users = $this->users->listPlayers();
        return new JsonResponse(['success' => true, 'users' => $users]);
    }

    public function createUser(Request $request): Response
    {
        $auth = $this->requireAdmin($request);
        if ($auth instanceof Response) {
            return $auth;
        }

        if (strtoupper($request->method()) !== 'POST') {
            return new JsonResponse(['success' => false, 'message' => 'Método no permitido'], 405);
        }

        $name = trim((string) $request->input('name', ''));
        $birthday = trim((string) $request->input('birthday', ''));
        $email = trim((string) $request->input('email', ''));
        $password = (string) $request->input('password', '');

        if ($name === '' || $email === '' || $password === '') {
            return new JsonResponse(['success' => false, 'message' => 'Campos obligatorios faltan'], 422);
        }

        if ($this->users->findByEmail($email)) {
            return new JsonResponse(['success' => false, 'message' => 'Email ya registrado'], 409);
        }

        $created = $this->users->create([
            'name' => $name,
            'birthday' => $birthday,
            'email' => $email,
            'password' => $password,
            'role' => 'player',
        ]);

        return new JsonResponse(['success' => $created]);
    }

    public function updateUser(Request $request): Response
    {
        $auth = $this->requireAdmin($request);
        if ($auth instanceof Response) {
            return $auth;
        }

        if (strtoupper($request->method()) !== 'POST') {
            return new JsonResponse(['success' => false, 'message' => 'Método no permitido'], 405);
        }

        $id = (int) $request->input('id', 0);
        $name = trim((string) $request->input('name', ''));
        $birthday = trim((string) $request->input('birthday', ''));
        $email = trim((string) $request->input('email', ''));
        $password = (string) $request->input('password', '');

        if ($id <= 0 || $name === '' || $email === '') {
            return new JsonResponse(['success' => false, 'message' => 'Datos inválidos'], 422);
        }

        $updated = $this->users->update([
            'id' => $id,
            'name' => $name,
            'birthday' => $birthday,
            'email' => $email,
            'password' => $password,
        ]);

        return new JsonResponse(['success' => $updated]);
    }

    public function deleteUser(Request $request): Response
    {
        $auth = $this->requireAdmin($request);
        if ($auth instanceof Response) {
            return $auth;
        }

        if (strtoupper($request->method()) !== 'POST') {
            return new JsonResponse(['success' => false, 'message' => 'Método no permitido'], 405);
        }

        $id = (int) $request->input('id', 0);
        if ($id <= 0) {
            return new JsonResponse(['success' => false, 'message' => 'ID inválido'], 422);
        }

        $deleted = $this->users->deleteById($id);
        return new JsonResponse(['success' => $deleted]);
    }

    public function listGames(Request $request): Response
    {
        $auth = $this->requireAdmin($request);
        if ($auth instanceof Response) {
            return $auth;
        }

        $games = $this->games->listGames();
        return new JsonResponse(['success' => true, 'games' => $games]);
    }

    public function deleteGame(Request $request): Response
    {
        $auth = $this->requireAdmin($request);
        if ($auth instanceof Response) {
            return $auth;
        }

        if (strtoupper($request->method()) !== 'POST') {
            return new JsonResponse(['success' => false, 'message' => 'Método no permitido'], 405);
        }

        $id = (int) $request->input('id', 0);
        if ($id <= 0) {
            return new JsonResponse(['success' => false, 'message' => 'ID inválido'], 422);
        }

        $deleted = $this->games->deleteGame($id);
        return new JsonResponse(['success' => $deleted]);
    }

    private function requireAdmin(Request $request): ?Response
    {
        $email = $request->cookie('user');
        if (!$email) {
            return new JsonResponse(['success' => false, 'message' => 'No autenticado'], 401);
        }

        $role = $this->users->roleForEmail($email);
        if ($role !== 'admin') {
            return new JsonResponse(['success' => false, 'message' => 'No autorizado'], 403);
        }

        return null;
    }
}

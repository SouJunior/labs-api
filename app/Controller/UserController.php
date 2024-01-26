<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace App\Controller;

use App\Model\User;
use Hyperf\HttpServer\Contract\RequestInterface;
use Psr\Http\Message\ResponseInterface as Psr7ResponseInterface;

class UserController extends AbstractController
{
    public function index()
    {
        return User::select(
            'uuid',
            'name',
            'email',
            'created_at',
            'updated_at'
        )->get();
    }

    /**
     *
     * @Todo
     */
    public function create()
    {
        return [
            "id" => 1,
            "linkedin" => "https://picsum.photos/200/300",
            "description" => "Product 1 description",
            "image" => "https://picsum.photos/200/300",
            "token" => "token"
        ];
    }

    public function update(RequestInterface $request, $id)
    {
        if ($user->uuid !== $id) {
            return $this->response->json([
                'error' => 'Você não tem permissão para autalizar este usuário.',
            ], 403);
        }

        $email = $this->request->input('email');
        $name = $this->request->input('name');
        $password = $this->request->input('password');
        $birthDate = $this->request->input('birth_date');
        $document = $this->request->input('document');
        $cellphone = $this->request->input('cellphone');

        $user = User::query()->where('uuid', $id)->first();

        if (empty($user)) {
            return $this->response->json([
                'error' => 'Usuário não encontrado.',
            ], 404);
        }

        $user->name = $name;
        $user->password = password_hash($password, PASSWORD_BCRYPT); // Hash da senha
        $user->birth_date = $birthDate;
        $user->document = $document;
        $user->cellphone = $cellphone;
        $user->save();

        return $this->response->json([
            'message' => 'Usuário atualizado com sucesso!',
            'user' => $user,
        ]);
    }

    public function del($id): Psr7ResponseInterface
    {
        $user = $this->container->get('user');

        if ($user->uuid !== $id) {
            return $this->response->json([
                'error' => 'Você não tem permissão para deletar este usuário.',
            ], 403);
        }

        if (!$id) {
            return $this->response->json([
                'error' => 'O email é necessário para deletar o usuário.',
            ], 400);
        }

        $user = User::query()->where('uuid', $id)->first();

        if (!$user) {
            return $this->response->json([
                'error' => 'Usuário não encontrado.',
            ], 404);
        }

        $user->delete();

        return $this->response->json([
            'message' => 'Usuário deletado com sucesso!',
        ]);
    }
}

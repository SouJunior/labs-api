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

namespace App\Repositories;

use App\Interfaces\LoginRepositoryInterface;
use App\Model\User;
use Carbon\Carbon;
use Firebase\JWT\JWT;
use Hyperf\Config\Annotation\Value;
use Ramsey\Uuid\Uuid;

class LoginRepository implements LoginRepositoryInterface
{
    #[Value(key: 'jwt_secret_key')]
    protected $jwtSecretKey;

    #[Value(key: 'defaultPermissions.admin_default_permissions')]
    private $defaultAdminPermissions;

    #[Value(key: 'defaultPermissions.founder_default_permissions')]
    protected $defaultFounderPermissions;
    

    public function login($request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $user = $this->getUserByEmail($email);

        if (! $user) {
            return ['error' => 'Usuário não encontrado'];
        }

        if (password_verify($password, $user->password)) {
            $tokenPayload = [
                'uuid' => $user->uuid,
                'email' => $user->email,
                'name' => $user->name,
                'user_type' => $user->user_type,
                'iat' => time(),
            ];

            $token = JWT::encode($tokenPayload, $this->jwtSecretKey, 'HS256');

            return ['token' => $token];
        }
        return ['error' => 'Senha incorreta'];
    }

    public function register($request)
    {
        $user = User::create([
            'uuid' => Uuid::uuid4()->toString(),
            'name' => $request->input('name'),
            'cidade' => $request->input('cidade'),
            'estado' => $request->input('estado'),
            'discord' => $request->input('discord'),
            'email' => $request->input('email'),
            'linkedin' => $request->input('linkedin'),
            'user_type' => 'founder',
            'permissions' => serialize($this->defaultFounderPermissions),
            'password' => password_hash($request->input('password'), PASSWORD_BCRYPT),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        if ($user) {
            return true;
        }
        return false;
    }

    private function getUserByEmail($email)
    {
        return User::where('email', $email)->first();
    }
}

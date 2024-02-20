<?php

namespace App\Repositories;

use App\Interfaces\LoginRepositoryInterface;
use App\Model\User;
use App\Request\LoginRequest;
use Firebase\JWT\JWT;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;
use Hyperf\Utils\Str;
use Hyperf\Config\Annotation\Value;
use Hyperf\Config\Config;

class LoginRepository implements LoginRepositoryInterface
{
    #[Value(key: "jwt_secret_key")]
    protected $jwtSecretKey;

    public function login($request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $user = $this->getUserByEmail($email);

        if (!$user) {
            return ['error' => 'Usuário não encontrado'];
        }

        if (password_verify($password, $user->password)) {
            $tokenPayload = [
                'uuid' => $user->uuid,
                'email' => $user->email,
                'name' => $user->name,
                'iat' => time(),
            ];

            $token = JWT::encode($tokenPayload, $this->jwtSecretKey, 'HS256');

            return ['token' => $token];
        } else {
            return ['error' => 'Senha incorreta'];
        }
    }

    private function getUserByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    public function register($request)
    {
        $user = User::create([
            'uuid' => Uuid::uuid4()->toString(),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'linkedin' => $request->input('linkedin'),
            'permission' => serialize(['founder']),
            'password' => password_hash($request->input('password'), PASSWORD_BCRYPT),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        if ($user) {
            return true;
        }
        return false;
    }
}

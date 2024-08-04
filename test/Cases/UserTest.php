<?php

declare(strict_types=1);

namespace HyperfTest\Cases;

use App\Model\User;
use Hyperf\Testing\Client;
use HyperfTest\HttpTestCase;
use Firebase\JWT\JWT;

use Ramsey\Uuid\Uuid;

use Hyperf\Config\Annotation\Value;

use Hyperf\Contract\ConfigInterface;

class UserTest extends HttpTestCase
{

    #[Value(key: 'defaultPermissions.admin_default_permissions')]
    private $defaultAdminPermissions;

    #[Value(key: 'defaultPermissions.founder_default_permissions')]
    private $defaultFounderPermissions;

    protected $jwtSecretKey;

    public function testIndex()
    {
        $res = $this->request('get', '/api/products');
        $this->assertSame(200, $res->getStatusCode());
    }

    public function testListUsers()
    {
        $faker = \Faker\Factory::create();

        $user = User::create(
            [
                'name' => 'test',
                'email' => 'teste@teste.com',
                'uuid' => Uuid::uuid4()->toString(),
                'password' => password_hash('123456', PASSWORD_DEFAULT)
            ]
        );

        $user2 = User::create(
            [
                'name' => $faker->name(),
                'email' => $faker->email(),
                'uuid' => Uuid::uuid4()->toString(),
                'password' => password_hash('123456', PASSWORD_DEFAULT)
            ]
        );

        $tokenPayload = [
            'iss' => 'hyperf',
            'iat' => time(),
            'exp' => time() + 3600,
            'sub' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ];

        $container = \Hyperf\Context\ApplicationContext::getContainer();

        $jwtSecretKey = $container->get(ConfigInterface::class);
        $jwtSecretKey = $jwtSecretKey->get('jwt_secret_key');

        $token = JWT::encode($tokenPayload, $jwtSecretKey, 'HS256');

        $user->delete();

        $res = $this->client->get('/api/users', [], ['Authorization' => 'Bearer ' . $token]);

        $user2->delete();

        $this->assertSame($user2->name, current($res)['name']);
    }

    public function testAlterPermission(){
    
        $user = User::create(
            [
                'uuid' => Uuid::uuid4()->toString(),
                'name' => 'test',
                'email' => 'teste1@teste.com',
                'password' => password_hash('123456', PASSWORD_DEFAULT),
                'linkedin' => 'linkedos',
                'permissions' =>json_encode($this->defaultFounderPermissions), 
                'user_type' => 'admin',
                'active' => 1,
                'cidade' => 'Vitoria da conquista',
                'estado' => 'BA',
                'discord' => 'asdas',

            ]
        );

        $teste = serialize($this->defaultAdminPermissions);
        var_dump($this->defaultAdminPermissions);

        $tokenPayload = [
            'iss' => 'hyperf',
            'iat' => time(),
            'exp' => time() + 3600,
            'sub' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ];
        $container = \Hyperf\Context\ApplicationContext::getContainer();
        $jwtSecretKey = $container->get(ConfigInterface::class);
        $jwtSecretKey = $jwtSecretKey->get('jwt_secret_key');
        $token = JWT::encode($tokenPayload, $jwtSecretKey, 'HS256');

        $payload = [
            'Authorization' => 'Bearer ' . $token,
            'permissions' => "teste",
        ];
        $res = $this->client->patch("/api/user/alterPermissions/{$user->uuid}", $payload , ['Authorization' => 'Bearer ' . $token]);
        $this->assertSame(200, $res['status']);
    }
}

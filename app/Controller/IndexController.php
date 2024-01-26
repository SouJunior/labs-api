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

use Hyperf\Swagger\Annotation as SA;

#[SA\HyperfServer(name: 'http')]
class IndexController extends AbstractController
{
    #[SA\Get(path: '/index', summary: 'GET example', tags: ['/Index'])]
    #[SA\Response(
        response: 200,
        description: 'Description of the returned value',
        content: new SA\JsonContent(
            example: '{"code":200, "data":[]}'
        )
    )]
    public function index()
    {
        $user = $this->request->input('user', 'Hyperf');
        $method = $this->request->getMethod();

        return [
            'method' => $method,
            'message' => "Hello bro, {$user}.",
        ];
    }
}

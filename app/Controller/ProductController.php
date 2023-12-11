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

class ProductController extends AbstractController
{
    public function index()
    {
        $user = $this->request->input('user', 'Hyperf');
        $method = $this->request->getMethod();

        return [
            [
                "id" => 1,
                "name" => "Product 1",
                "price" => 100,
                "description" => "Product 1 description",
                "image" => "https://picsum.photos/200/300",
            ],
            [
                "id" => 2,
                "name" => "Product 2",
                "price" => 100,
                "description" => "Product 1 description",
                "image" => "https://picsum.photos/200/300",
            ],
        ];
    }
}

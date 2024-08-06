<?php

/**
 * This file is part of Hyperf.
 *
 * @see     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

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

use App\Model\Product as ProductModel;
use Psr\Http\Message\ResponseInterface as Psr7ResponseInterface;
use Ramsey\Uuid\Uuid;

final class ProductController extends AbstractController
{
    public function index($userUuid = false): Psr7ResponseInterface
    {
        if (empty($userUuid) === false) {
            $products = ProductModel::where('owner_uuid', $userUuid)->get();
        } else {
            $products = ProductModel::all();
        }

        return $this->response->json($products);
    }

    public function create()
    {
        $user = $this->container->get('user');
        

        if(in_array('cadastrar_produto', unserialize($user->permissions)) === false ) {
        
            return $this->response->json([
                    'error' => 'Você não tem permissão para criar este produto.'
                ],403                
            );
        } 

        $name = $this->request->input('name');
        $description = $this->request->input('description');

        $product = new ProductModel();

        $product->uuid = Uuid::uuid4()->toString();
        $product->owner_uuid = $user->uuid;
        $product->name = $name;
        $product->description = $description;
        $product->save();

        return $this->response->json([
            'message' => 'Produto cadastrado com sucesso!',
            'product' => $product,
        ]);
    }

    public function show($uuid): Psr7ResponseInterface
    {
        $user = $this->container->get('user');
        $product = ProductModel::where('uuid', $uuid)->first();

        if(in_array('consultar_produto', unserialize($user->permissions)) === false ) {
        
            return $this->response->json([
                    'error' => 'Você não tem permissão para visualisar esse produto.'
                ],403                
            );
        }        

        if (! $product) {
            return $this->response->json(['error' => 'Product not found'], 404);
        }

        return $this->response->json($product);
    }

    public function update($uuid): Psr7ResponseInterface
    {
        $user = $this->container->get('user');

        $product = ProductModel::where('uuid', $uuid)->first();

        if (! $product) {
            return $this->response->json(['error' => 'Product not found'], 404);
        }

        if ($user->uuid !== $product->owner_uuid) {
            return $this->response->json(
                [
                    'error' => 'Você não tem permissão para autalizar este produto.',
                ],
                403
            );
        }

        $name = $this->request->input('name');
        $description = $this->request->input('description');

        $product->name = $name;
        $product->description = $description;
        $product->save();

        return $this->response->json([
            'message' => 'Product updated successfully!',
            'product' => $product,
        ]);
    }

    /**
     * Delete a product.
     * @RequestMapping(path="delete/{id}", methods="post")
     * @param mixed $uuid
     */
    public function delete($uuid): Psr7ResponseInterface
    {
        $product = ProductModel::where('uuid', $uuid)->first();

        $user = $this->container->get('user');

        if (! $product) {
            return $this->response->json(['error' => 'Product not found'], 404);
        }

        if ($user->uuid !== $product->owner_uuid) {
            return $this->response->json(
                [
                    'error' => 'Você não tem permissão para autalizar este produto.',
                ],
                403
            );
        }

        $product->delete();

        return $this->response->json(['message' => 'Product deleted successfully!']);
    }

    public function active($uuid): Psr7ResponseInterface
    {
        $user = $this->container->get('user');

        if (in_array('admin', $user->permission) === false) {
            return $this->response->json(
                [
                    'error' => 'Você não tem permissão para autalizar este produto.',
                ],
                403
            );
        }

        $product = ProductModel::where('uuid', $uuid)->first();

        if (! $product) {
            return $this->response->json(['error' => 'Product not found'], 404);
        }

        $product->active = $this->request->input('active');
        $product->save();

        return $this->response->json(['message' => 'Produto ativado com sucesso!']);
    }
}

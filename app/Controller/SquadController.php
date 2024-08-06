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

namespace App\Controller;

use App\Model\Squad;
use App\Model\Product;
use Ramsey\Uuid\Uuid;
use Hyperf\HttpServer\Contract\RequestInterface;
use Psr\Http\Message\ResponseInterface as Psr7ResponseInterface;

class SquadController extends AbstractController
{
    public function index($productUuid = false): Psr7ResponseInterface
    {
        if (empty($productUuid) === false) {
            $squad = Squad::where('product_uuid', $productUuid)->get();
        } else {
            $squad = Squad::all();
        }

        return $this->response->json($squad);
    }

    public function show($uuid): Psr7ResponseInterface
    {
        $user = $this->container->get('user');


        if(in_array('consultar_squad', unserialize($user->permissions)) === false ) {

            return $this->response->json([
                'error' => 'Você não tem permissão para visualizar essa squad.'
                ],403
            );
        }

        $squad = Squad::where('uuid', $uuid)->first();
        

        if (! $squad) {
            return $this->response->json(['error' => 'Squad not found'], 404);
        }

        return $this->response->json($squad);
    }

    public function create(): Psr7ResponseInterface
    {
        $user = $this->container->get('user');


        if(in_array('cadastrar_squad', unserialize($user->permmissions)) === false ) {

            return $this->response->json([
                    'error' => 'Você não tem permissão para criar essa squad.'
                ],403
            );
        }

        $data = $this->request->getParsedBody();
        $squad = new Squad();
        $squad->fill($data);
        $squad->uuid = Uuid::uuid4()->toString();
        $squad->save();

        return $this->response->json([
            'message' => 'Squad created successfully!',
            'squad' => $squad,
        ],200);
    }

    public function update($uuid): Psr7ResponseInterface
    {
        $squad = Squad::where('uuid', $uuid)->first();

        if (! $squad) {
            return $this->response->json(['error' => 'Squad not found'], 404);
        }

        $product = Product::where('uuid', $squad->product_uuid)->first();

        if (! $product) {
            return $this->response->json(['error' => 'Product not found'], 404);
        }

        if ($user->uuid !== $product->owner_uuid) {
            return $this->response->json(
                [
                    'error' => 'Você não tem permissão para atualizar este produto.',
                ],
                403
            );
        }

        $data = $this->request->getParsedBody();

        $squad->name = $data['name'];
        $squad->description = $data['description'];
        $squad->save();

        return $this->response->json([
            'message' => 'Squad updated successfully!',
            'squad' => $squad,
        ],200);
    }

    public function delete($uuid)
    {
        $user = $this->container->get('user');        

        $squad = Squad::where('uuid', $uuid)->first();

        if (! $squad) {
            return $this->response->json(['error' => 'Squad not found'], 404);
        }

        $product = Product::where('uuid', $squad->product_uuid)->first();

        if (! $product) {
            return $this->response->json(['error' => 'Product not found'], 404);
        }

        if ($user->uuid !== $product->owner_uuid) {
            return $this->response->json(
                [
                    'error' => 'Você não tem permissão para atualizar este produto.',
                ],
                403
            );
        }

        $squad->delete();

        return $this->response->json(['message' => 'Squad deleted successfully!']);
    }
}

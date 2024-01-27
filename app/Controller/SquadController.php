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
use Ramsey\Uuid\Uuid;
use Hyperf\HttpServer\Contract\RequestInterface;
use Psr\Http\Message\ResponseInterface as Psr7ResponseInterface;

class SquadController extends AbstractController
{
    public function index(): Psr7ResponseInterface
    {
        $squad = Squad::all();
        return $this->response->json($squad);
    }

    public function show($uuid): Psr7ResponseInterface
    {
        $squad = Squad::where('uuid', $uuid)->first();

        if (! $squad) {
            return $this->response->json(['error' => 'Squad not found'], 404);
        }

        return $this->response->json($squad);
    }

    public function create(): Psr7ResponseInterface
    {
        $data = $this->request->getParsedBody();
        $squad = new Squad();
        $squad->fill($data);
        $squad->uuid = Uuid::uuid4()->toString();
        $squad->save();

        return $this->response->json([
            'message' => 'Squad created successfully!',
            'squad' => $squad,
        ]);
    }

    public function update($uuid): Psr7ResponseInterface
    {
        $squad = Squad::find($uuid);

        if (! $squad) {
            return $this->response->json(['error' => 'Squad not found'], 404);
        }

        $data = $this->request->getParsedBody();
        $squad->fill($data);
        $squad->save();

        return $this->response->json([
            'message' => 'Squad updated successfully!',
            'squad' => $squad,
        ]);
    }

    public function del()
    {
        $squad = Squad::find($id);

        if (! $squad) {
            return $this->response->json(['error' => 'Squad not found'], 404);
        }

        $squad->delete();

        return $this->response->json(['message' => 'Squad deleted successfully!']);
    }
}

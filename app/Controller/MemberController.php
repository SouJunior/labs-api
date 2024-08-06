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

use App\Model\Member as MemberModel;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Psr\Http\Message\ResponseInterface as Psr7ResponseInterface;
use Ramsey\Uuid\Uuid;

class MemberController extends AbstractController
{
    public function index($uuid): Psr7ResponseInterface
    {
        $user = $this->container->get('user');


        if(in_array('consultar_squad', unserialize($user->permissions)) === false ) {

            return $this->response->json([
                'error' => 'Você não tem permissão para visualizar os membros dessa squad.'
                ],403
            );
        }

        $members = MemberModel::where(['squad_uuid' => $uuid])->get();

        return $this->response->json($members);
    }


    public function create(): Psr7ResponseInterface
    {
        $user = $this->container->get('user');


        if(in_array('cadastrar_squad', unserialize($user->permmissions)) === false ) {

            return $this->response->json([
                    'error' => 'Você não tem permissão para criar membros nessa squad.'
                ],403
            );
        }

        $data = $this->request->getParsedBody();
        $member = new MemberModel();
        $member->fill($data);
        $member->uuid = Uuid::uuid4()->toString();
        $member->save();

        return $this->response->json([
            'message' => 'Member created successfully!',
            'member' => $member,
        ],200);
    }

    public function update($uuid, $memberUuid): Psr7ResponseInterface
    {
        $user = $this->container->get('user');


        if(in_array('alterar_squad', unserialize($user->permissions)) === false ) {

            return $this->response->json([
                'error' => 'Você não tem permissão para alterar os membros dessa squad.'
                ],403
            );
        }


        $member = MemberModel::where(['squad_uuid' => $uuid, 'uuid' => $memberUuid])->first();

        if (! $member) {
            return $this->response->json(['error' => 'Member not found'], 404);
        }

        $data = $this->request->getParsedBody();
        $member->fill($data);
        $member->save();

        return $this->response->json([
            'message' => 'Member updated successfully!',
            'member' => $member,
        ],200);
    }

    public function delete($uuid, $memberUuid): Psr7ResponseInterface
    {
         $user = $this->container->get('user');


        if(in_array('alterar_squad', unserialize($user->permissions)) === false ) {

            return $this->response->json([
                'error' => 'Você não tem permissão para deletar os membros dessa squad.'
                ],403
            );
        }


        $member = MemberModel::where(['uuid' => $memberUuid])->first();

        if (! $member) {
            return $this->response->json(['error' => 'Member not found'], 404);
        }

        $member->delete();

        return $this->response->json(['message' => 'Member deleted successfully!']);
    }
}

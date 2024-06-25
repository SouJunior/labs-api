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
return [
    'founder_default_permissions' => [
        'cadastrar_produto' => true,
        'consultar_produto' => true,
        'cadastrar_squad' => true,
        'consultar_squad' => true,
        'alterar_squad' => true,
        'consultar_e_alterar_produtos' => false,
        'excluir_produtos' => false,
        'consultar_e_alterar_usuarios' => false,
        'excluir_usuarios' => false,
        'consultar_e_alterar_permissoes_de_acesso' => false,
    ],

    'admin_default_permissions' => [
        'cadastrar_produto' => false,
        'consultar_produto' => true,
        'cadastrar_squad' => false,
        'consultar_squad' => true,
        'alterar_squad' => true,
        'consultar_e_alterar_produtos' => true,
        'excluir_produtos' => true,
        'consultar_e_alterar_usuarios' => true,
        'excluir_usuarios' => true,
        'consultar_e_alterar_permissoes_de_acesso' => true,
    ],
];

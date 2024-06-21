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

namespace App\Request;

use Hyperf\Validation\Request\FormRequest;

class UserRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // <Modificar
        return [
            'name' => 'required|string|max:60',
            'email' => 'required|email|unique:users',
            'linkedin' => 'required',
            'cidade' => 'required',
            'estado' => 'required',
            'discord' => 'required',
            'password' => 'required|min:8',
            'register_token' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O campo nome deve ser uma string.',
            'name.max' => 'O campo nome não pode ter mais de :max caracteres.',
            /* 'email.required' => 'O campo e-mail é obrigatório.', */
            /* 'email.email' => 'O campo e-mail deve ser um endereço de e-mail válido.', */
            /* 'email.unique' => 'Já existe uma conta com este e-mail.', */
            'password.required' => 'O campo senha é obrigatório.',
            'password.string' => 'O campo senha deve ser uma string.',
            'password.min' => 'O campo senha deve ter pelo menos :min caracteres.',
            'register_token.required' => 'O campo register_token é obrigatório.',
            'linkedin.required' => 'O campo Linkedin é obrigatório.',
            'cidade.required' => 'O campo cidade é obrigatório.',
            'estado.required' => 'O campo estado é obrigatório.',
            'discord.required' => 'O campo discord é obrigatório.',
        ];
    }
}

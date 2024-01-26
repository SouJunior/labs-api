<?php

declare(strict_types=1);

namespace App\Request;

use Hyperf\Validation\Request\FormRequest;
use Hyperf\Validation\ValidationException;
use Hyperf\Validation\Validator;

class LoginRequest extends FormRequest
/* class LoginRequest */
{
    public function authorize()
    {
        return true;
    }

    public function rules():array
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }

    public function messages():array
    {
        return [
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'O campo e-mail deve ser um endereço de e-mail válido.',
            'password.required' => 'O campo senha é obrigatório.',
            'password' => 'required|string|min:8',
        ];
    }

}

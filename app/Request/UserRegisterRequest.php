<?php

declare(strict_types=1);

namespace App\Request;

use Hyperf\Validation\Request\FormRequest;

class UserRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules():array
    {
        return [
            'name' => 'required|string|max:60',
            'email' => 'required|email|unique:users',
            'birth_date' => 'required|date',
            'document' => 'required|string|max:20|unique:users',
            'cellphone' => 'required|string|max:20|unique:users',
            'password' => 'required|string|min:8',
        ];
    }

    public function messages():array
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O campo nome deve ser uma string.',
            'name.max' => 'O campo nome não pode ter mais de :max caracteres.',
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'O campo e-mail deve ser um endereço de e-mail válido.',
            'email.unique' => 'Já existe uma conta com este e-mail.',
            'birth_date.required' => 'O campo data de nascimento é obrigatório.',
            'birth_date.date' => 'O campo data de nascimento deve ser uma data válida.',
            'document.required' => 'O campo documento é obrigatório.',
            'document.string' => 'O campo documento deve ser uma string.',
            'document.max' => 'O campo documento não pode ter mais de :max caracteres.',
            'document.unique' => 'Já existe uma conta com este documento.',
            'cellphone.required' => 'O campo celular é obrigatório.',
            'cellphone.string' => 'O campo celular deve ser uma string.',
            'cellphone.max' => 'O campo celular não pode ter mais de :max caracteres.',
            'cellphone.unique' => 'Já existe uma conta com este celular.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.string' => 'O campo senha deve ser uma string.',
            'password.min' => 'O campo senha deve ter pelo menos :min caracteres.',
        ];
    }



}

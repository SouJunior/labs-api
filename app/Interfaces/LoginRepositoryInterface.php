<?php

namespace App\Interfaces;

interface LoginRepositoryInterface
{
    public function login(array $request);
    public function register(array $request);
}

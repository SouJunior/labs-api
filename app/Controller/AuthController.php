<?php

declare(strict_types=1);

namespace App\Controller;

use App\Request\UserRegisterRequest;
use App\Request\LoginRequest;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\ResponseInterface;

/* use App\Interfaces\LoginRepositoryInterface; */

use App\Repositories\LoginRepository;

class AuthController extends AbstractController
{
    private $loginRepository;

    public function __construct(
        LoginRepository $loginRepository,
    ) {
        $this->loginRepository = $loginRepository;
    }

    public function login(LoginRequest $request)
    {
        return $this->loginRepository->login($request);
    }
}

<?php

namespace Groceries\Api\V1;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Groceries\Credentials\DataAccess;
use Groceries\Api\TokenGenerator;

class TokenResourceHandler
{
    private $dataAccess;
    private $tokenGenerator;

    public function __construct(DataAccess $dataAccess, TokenGenerator $tokenGenerator)
    {
        $this->dataAccess = $dataAccess;
        $this->tokenGenerator = $tokenGenerator;
    }

    public function get(Request $request)
    {
        $status = 400;
        $data = ['error' => 'invalid credentials'];

        $username = filter_var($request->server->get('PHP_AUTH_USER'), FILTER_SANITIZE_STRING);
        $password = filter_var($request->server->get('PHP_AUTH_PW'  ), FILTER_SANITIZE_STRING);

        $credentials = $this->dataAccess->getCredentialsByUsername($username);

        if ($credentials && password_verify($password, $credentials['password'])) {
            $status = 200;
            $data = ['token' => $this->tokenGenerator->generate($credentials['id'])];
        }

        return new Response(serialize($data), $status);
    }
}

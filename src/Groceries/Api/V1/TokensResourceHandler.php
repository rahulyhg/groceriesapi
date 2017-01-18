<?php

namespace Groceries\Api\V1;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Groceries\Credentials\DataAccess;
use Groceries\Api\TokenGenerator;

class TokensResourceHandler
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
        $username = filter_var($request->headers->get('username'), FILTER_SANITIZE_STRING);
        $password = filter_var($request->headers->get('password'), FILTER_SANITIZE_STRING);

        $credentials = $this->dataAccess->getCredentialsByUsername($username);

        if ($credentials && password_verify($password, $credentials['password'])) {
            return new JsonResponse(['token' => $this->tokenGenerator->generate($credentials['id'])]);
        }

        return new JsonResponse(['error' => 'invalid credentials'], 400);
    }
}

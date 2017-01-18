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
}

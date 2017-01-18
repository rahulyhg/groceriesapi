<?php

namespace Groceries\Api;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer;

class TokenGenerator
{
    private $issuer;
    private $audience;
    private $builder;
    private $signer;
    private $signature;

    public function __construct(
        Builder $builder, Signer $signer,
        string $signature, string $issuer, string $audience
    ) {
        $this->builder = $builder;
        $this->signer = $signer;
        $this->signature = $signature;
        $this->issuer = $issuer;
        $this->audience = $audience;
    }

    public function generate(string $userID) : string
    {
        $this->builder->setIssuer($this->issuer)
                      ->setAudience($this->audience)
                      ->setId(uniqid(), true)
                      ->setIssuedAt(time())
                      ->setExpiration(strtotime('+30 day'))
                      ->set('uid', $userID)
                      ->sign($this->signer, $this->signature);

        return (string) $this->builder->getToken();
    }
}

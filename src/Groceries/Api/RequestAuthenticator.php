<?php

namespace Groceries\Api;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Lcobucci\JWT\Token;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer;
use Lcobucci\JWT\ValidationData;

use Exception;

class RequestAuthenticator
{
    public $parser;
    public $signer;
    public $signature;

    public function __construct(Parser $parser, Signer $signer, $signature)
    {
        $this->parser = $parser;
        $this->signer = $signer;
        $this->signature = $signature;
    }

    public function __invoke(Request $request)
    {
        try {
            $token = $this->parser->parse($request->headers->get('Authorization'));

            if ($this->authorize($token))
                $request->request->set('userid', $token->getClaim('uid'));
            else
                return $this->unAuthorized();

        } catch(Exception $exception) {
            return $this->unAuthorized();
        }
    }

    public function authorize(Token $token)
    {
        return $this->verify($token) && $this->validate($token);
    }

    public function verify(Token $token)
    {
        return $token->verify($this->signer, $this->signature);
    }

    public function validate(Token $token)
    {
        return $token->validate(new ValidationData(time()));
    }

    public function unAuthorized()
    {
        $status = 401;
        $data = ['error' => 'invalid authorization token'];

        return new JsonResponse($data, $status);
    }
}

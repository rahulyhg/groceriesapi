<?php

namespace Groceries\Api;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Lcobucci\JWT\Token;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer;
use Lcobucci\JWT\ValidationData;

use Exception;

class RequestAuthentication
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
        /* The JWT parser can raise an exception.
         * In this case the request must also be rejected. */
        try {
            $token = $this->parser->parse($request->headers->get('Authorization'));

            if ($this->authorize($token)) {
                $request->request->set('uid', $token->getClaim('uid'));
            } else {
                return $this->unAuthorized();
            }
        } catch (Exception $exception) {
            error_log('JWT parse error: ' . $exception->getMessage(), E_USER_ERROR);
            return $this->unAuthorized();
        }
    }

    private function authorize(Token $token)
    {
        return $this->verify($token) && $this->validate($token);
    }

    private function verify(Token $token)
    {
        return $token->verify($this->signer, $this->signature);
    }

    private function validate(Token $token)
    {
        return $token->validate(new ValidationData(time()));
    }

    private function unAuthorized()
    {
        $status = 401;
        $data = ['error' => 'invalid authorization token'];

        return new Response(serialize($data), $status);
    }
}

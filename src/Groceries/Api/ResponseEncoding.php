<?php

namespace Groceries\Api;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;

class ResponseEncoding
{
    private $serializer;

    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    public function __invoke(Request $request, Response $response)
    {
        $content = unserialize($response->getContent());

        if (! is_array($content) && ! $content) {
            return;
        }

        $response->headers->set('Content-Type', 'text/plain');
        $acceptable = $request->getAcceptableContentTypes();

        if (in_array('application/xml', $acceptable)) {
            $response->headers->set('Content-Type', 'application/xml');
            $response->setContent($this->serializer->encode($content, 'xml'));

            return;
        }

        if (in_array('application/json', $acceptable)) {
            $response->headers->set('Content-Type', 'application/json');
            $response->setContent($this->serializer->encode($content, 'json'));

            return;
        }
    }
}

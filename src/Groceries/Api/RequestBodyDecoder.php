<?php

namespace Groceries\Api;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Serializer;

class RequestBodyDecoder
{
    private $serializer;

    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    public function __invoke(Request $request)
    {
        $data = null;

        if ($request->headers->get('Content-Type') === 'application/json') {
            $data = $this->serializer->decode($request->getContent(), 'json');
        }

        if ($request->headers->get('Content-Type') === 'application/xml') {
            $data = $this->serializer->decode($request->getContent(), 'xml');
        }

        if (is_array($data)) {
            $request->request->replace($data);
        }
    }
}

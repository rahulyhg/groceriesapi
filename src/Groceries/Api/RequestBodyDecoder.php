<?php

namespace Groceries\Api;

use Symfony\Component\Serializer\Serializer;

class RequestBodyDecoder
{
    private $serializer;

    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }
}

<?php

namespace Groceries\Api;

use Ramsey\Uuid\Uuid;

class UuidGenerator
{
    public function generate() : string
    {
        $uuid = Uuid::uuid4();
        return $uuid->getHex();
    }
}

<?php

namespace Groceries\Api;

use Ramsey\Uuid\Uuid;

class IDGenerator
{
    public function generate() : string
    {
        return Uuid::uuid4()->getHex();
    }
}

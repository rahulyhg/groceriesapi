<?php

namespace Groceries\Api\V1;

use Groceries\Lists\DataAccess;

class ListsResourceHandler
{
    private $dataAccess;

    public function __construct(DataAccess $dataAccess)
    {
        $this->dataAccess = $dataAccess;
    }
}

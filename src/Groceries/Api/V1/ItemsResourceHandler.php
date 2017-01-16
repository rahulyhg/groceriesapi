<?php

namespace Groceries\Api\V1;

use Groceries\Items\DataAccess;

class ItemsResourceHandler
{
    private $dataAccess;

    public function __construct(DataAccess $dataAccess)
    {
        $this->dataAccess = $dataAccess;
    }
}

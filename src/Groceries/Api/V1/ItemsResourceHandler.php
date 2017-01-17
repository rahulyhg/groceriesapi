<?php

namespace Groceries\Api\V1;

use Symfony\Component\HttpFoundation\JsonResponse;
use Groceries\Items\DataAccess;

class ItemsResourceHandler
{
    private $dataAccess;

    public function __construct(DataAccess $dataAccess)
    {
        $this->dataAccess = $dataAccess;
    }

    public function get(string $list)
    {
        $data = $this->dataAccess->getItemsByList($list);
        return new JsonResponse($data);
    }

    public function post()
    {
        return new JsonResponse();
    }
}

<?php

namespace Groceries\Api\V1;

use Symfony\Component\HttpFoundation\JsonResponse;

use Groceries\Items\DataAccess;
use Groceries\Api\UuidGenerator;

class ItemsResourceHandler
{
    private $dataAccess;
    private $uuidGenerator;

    public function __construct(DataAccess $dataAccess, UuidGenerator $uuidGenerator)
    {
        $this->dataAccess = $dataAccess;
        $this->uuidGenerator = $uuidGenerator;
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

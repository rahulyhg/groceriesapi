<?php

namespace Groceries\Api\V1;

use Symfony\Component\HttpFoundation\Request;
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

    public function get(Request $request)
    {
        $list = filter_var($request->query->get('list'), FILTER_SANITIZE_STRING);

        if (! $list) {
            return new JsonResponse(['error' => 'requires a list parameter'], 400);
        }

        $data = $this->dataAccess->getItemsByList($list);
        return new JsonResponse($data);
    }

    public function post(Request $request)
    {
        $data = [
            'description' => filter_var($request->request->get('description'), FILTER_SANITIZE_STRING),
            'price'       => filter_var($request->request->get('price'      ), FILTER_SANITIZE_STRING),
            'list'        => filter_var($request->request->get('list'       ), FILTER_SANITIZE_STRING),
        ];

        $data['id'] = $this->uuidGenerator->generate();
        $this->dataAccess->createItem($data);

        return new JsonResponse($data, 201);
    }

    public function delete(string $id)
    {
        if (! $this->dataAccess->getItemByID($id)) {
            return new JsonResponse(['error' => 'item not found'], 404);
        }

        $this->dataAccess->deleteItem($id);
        return new JsonResponse();
    }
}

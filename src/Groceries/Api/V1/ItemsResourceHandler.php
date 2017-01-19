<?php

namespace Groceries\Api\V1;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
        $status = 400;
        $data = ['error' => 'requires a list parameter'];

        $list = filter_var($request->query->get('list'), FILTER_SANITIZE_STRING);

        if ($list) {
            $status = 200;
            $data = $this->dataAccess->getItemsByList($list);
        }

        return new Response(serialize($data));
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

        return new Response(serialize($data), 201);
    }

    public function delete(string $id)
    {
        $status = 404;
        $data = ['error' => 'item not found'];

        if ($this->dataAccess->getItemByID($id)) {
            $this->dataAccess->deleteItem($id);

            $status = 200;
            $data = ['message' => 'item deleted'];
        }

        return new Response(serialize($data), $status);
    }
}

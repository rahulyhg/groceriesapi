<?php

namespace Groceries\Api\V1;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Groceries\Lists\DataAccess;
use Groceries\Api\UuidGenerator;

class ListsResourceHandler
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
        $data = ['error' => 'requires parameters month and year'];

        $month = filter_var($request->query->get('month'), FILTER_SANITIZE_STRING);
        $year  = filter_var($request->query->get('year'),  FILTER_SANITIZE_STRING);

        if ($month && $year) {
            $status = 200;
            $data = $this->dataAccess->getListsByMonth($month, $year);
        }

        return new Response(serialize($data), $status);
    }

    public function post(Request $request)
    {
        $status = 400;
        $data = ['error' => 'requires date format YYYY-MM-DD'];

        $date = filter_var($request->request->get('date'), FILTER_SANITIZE_STRING);

        if (preg_match('#^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$#', $date)) {
            $status = 201;
            $data = ['id' => $this->uuidGenerator->generate(), 'date' => $date];

            $this->dataAccess->createList($data);
        }

        return new Response(serialize($data), $status);
    }

    public function delete(string $id)
    {
        $status = 404;
        $data = ['error' => 'list not found'];

        if ($this->dataAccess->getListByID($id)) {
            $status = 200;
            $data = ['message' => 'list deleted'];

            $this->dataAccess->deleteList($id);
        }

        return new Response(serialize($data), $status);
    }
}

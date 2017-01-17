<?php

namespace Groceries\Api\V1;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

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
        $month = filter_var($request->query->get('month'), FILTER_SANITIZE_STRING);
        $year  = filter_var($request->query->get('year'),  FILTER_SANITIZE_STRING);

        if (! $month || ! $year) {
            return new JsonResponse(['error' => 'requires parameters month and year'], 400);
        }

        $data = $this->dataAccess->getListsByMonth($month, $year);
        return new JsonResponse($data);
    }

    public function post(Request $request)
    {
        $date = filter_var($request->request->get('date'), FILTER_SANITIZE_STRING);

        if (! preg_match('#^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$#', $date)) {
            return new JsonResponse(['error' => 'requires date format YYYY-MM-DD'], 400);
        }

        $data = ['id' => $this->uuidGenerator->generate(), 'date' => $date];
        $this->dataAccess->createList($data);

        return new JsonResponse($data, 201);
    }

    public function delete(string $id)
    {
        if (! $this->dataAccess->getListByID($id)) {
            return new JsonResponse(['error' => 'list not found'], 404);
        }

        $this->dataAccess->deleteList($id);
        return new JsonResponse();
    }
}

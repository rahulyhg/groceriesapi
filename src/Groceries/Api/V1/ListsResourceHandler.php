<?php

namespace Groceries\Api\V1;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Groceries\Lists\DataAccess;

class ListsResourceHandler
{
    private $dataAccess;

    public function __construct(DataAccess $dataAccess)
    {
        $this->dataAccess = $dataAccess;
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
        return new JsonResponse();
    }
}

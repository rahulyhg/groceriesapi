<?php

namespace Groceries\Lists;

interface DataAccess
{
    public function getListByID(string $id) : array;

    public function getListsByMonth(string $month, string $year) : array;

    public function createList(array $data);

    public function deleteList(string $id);
}

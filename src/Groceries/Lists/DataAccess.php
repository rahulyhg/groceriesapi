<?php

namespace Groceries\Lists;

interface DataAccess
{
    public function getListsByMonth(string $month, string $year) : array;

    public function createList(array $data);
}

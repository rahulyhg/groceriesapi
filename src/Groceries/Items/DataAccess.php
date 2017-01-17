<?php

namespace Groceries\Items;

interface DataAccess
{
    public function getItemByID(string $id) : array;

    public function getItemsByList(string $list) : array;

    public function createItem(array $data);

    public function deleteItem(string $id);
}

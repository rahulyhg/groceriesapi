<?php

namespace Groceries\Items;

interface DataAccess
{
    public function getItemsByList(string $list) : array;
}

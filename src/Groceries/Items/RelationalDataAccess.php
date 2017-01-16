<?php

namespace Groceries\Items;

use PDO;

class RelationalDataAccess implements DataAccess
{
    private $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function getItemsByList(string $list) : array
    {
        $query = '
            SELECT LOWER(HEX(id)) AS id, description, price, LOWER(HEX(list)) AS list
            FROM items
            WHERE list=UNHEX(:list)
        ';

        $statement = $this->connection->prepare($query);
        $statement->execute(['list' => $list]);

        return $statement->fetchAll();
    }
}

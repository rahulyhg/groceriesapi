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

    public function getItemByID(string $id) : array
    {
        $query = '
            SELECT LOWER(HEX(id)) AS id, description, price
            FROM items
            WHERE id=UNHEX(:id)
        ';

        $statement = $this->connection->prepare($query);
        $statement->execute(['id' => $id]);

        $data = $statement->fetch();
        return $data ? $data : [];
    }

    public function getItemsByList(string $list) : array
    {
        $query = '
            SELECT LOWER(HEX(id)) AS id, description, price
            FROM items
            WHERE list=UNHEX(:list)
        ';

        $statement = $this->connection->prepare($query);
        $statement->execute(['list' => $list]);

        return $statement->fetchAll();
    }

    public function createItem(array $data)
    {
        $query = '
            INSERT INTO items (id, description, price, list)
            VALUES (UNHEX(:id), :description, :price, UNHEX(:list))
        ';

        $statement = $this->connection->prepare($query);
        $statement->execute($data);
    }

    public function deleteItem(string $id)
    {
        $query = '
            DELETE FROM items
            WHERE id=UNHEX(:id)
        ';

        $statement = $this->connection->prepare($query);
        $statement->execute(['id' => $id]);
    }
}

<?php

namespace Groceries\Lists;

use PDO;

class RelationalDataAccess implements DataAccess
{
    private $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function getListByID(string $id) : array
    {
        $query = '
            SELECT LOWER(HEX(id)) AS id, date
            FROM lists
            WHERE id=UNHEX(:id)
        ';

        $statement = $this->connection->prepare($query);
        $statement->execute(['id' => $id]);

        $data = $statement->fetch();
        return $data ? $data : [];
    }

    public function getListsByMonth(string $month, string $year) : array
    {
        $query = '
            SELECT LOWER(HEX(lists.id)) AS id, lists.date, SUM(items.price) AS total
            FROM items
            JOIN lists ON lists.id=items.list
            WHERE MONTH(lists.date)=:month AND YEAR(lists.date)=:year
            GROUP BY items.list
        ';

        $statement = $this->connection->prepare($query);
        $statement->execute(['month' => $month, 'year' => $year]);

        return $statement->fetchAll();
    }

    public function createList(array $data)
    {
        $query = '
            INSERT INTO lists (id, date)
            VALUES (UNHEX(:id), :date)
        ';

        $statement = $this->connection->prepare($query);
        $statement->execute($data);
    }

    public function deleteList(string $id)
    {
        $query = '
            DELETE FROM lists
            WHERE id=UNHEX(:id)
        ';

        $statement = $this->connection->prepare($query);
        $statement->execute(['id' => $id]);
    }
}

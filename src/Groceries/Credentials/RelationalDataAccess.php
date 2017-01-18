<?php

namespace Groceries\Credentials;

use PDO;

class RelationalDataAccess implements DataAccess
{
    private $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function getCredentialsByUsername(string $username) : array
    {
        $query = '
            SELECT LOWER(HEX(id)) AS id, username, password
            FROM credentials
            WHERE username=:username
        ';

        $statement = $this->connection->prepare($query);
        $statement->execute(['username' => $username]);

        $data = $statement->fetch();
        return $data ? $data : [];
    }
}

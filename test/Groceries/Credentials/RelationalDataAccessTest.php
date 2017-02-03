<?php

namespace Groceries\Credentials;

use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;

class RelationalDataAccessTest extends TestCase
{
    function test_return_credentials_by_username()
    {
        $expected = [
            'id'       => 'd3bc28d2e0a311e69df65254007e8abd',
            'username' => 'joaorodriguesjr',
            'password' => '$2y$10$GHovLHkUg6VnzQEAM7PeAeglEJcFuOUtTgfapheWT1yeb.wXCClVa'
        ];

        $connection = $this->createMock(PDO::class);
        $statement  = $this->createMock(PDOStatement::class);

        $connection
                ->method('prepare')
                ->willReturn($statement);

        $statement
                ->method('fetch')
                ->willReturn($expected);

        $dataAccess = new RelationalDataAccess($connection);
        $data = $dataAccess->getCredentialsByUsername($expected['username']);

        $this->assertEquals($expected, $data);
    }
}

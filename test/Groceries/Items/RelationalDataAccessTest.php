<?php

namespace Groceries\Items;

use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;

class RelationalDataAccessTest extends TestCase
{
    function test_return_item_by_id()
    {
        $expected = [
            'id'          => '170c1d6dda8311e69df65254007e8abd',
            'description' => 'Milk',
            'price'       => '1.75'
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
        $data = $dataAccess->getItemByID($expected['id']);

        $this->assertEquals($expected, $data);
    }
}

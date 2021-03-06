<?php

namespace Groceries\Items;

use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;

class RelationalDataAccessTest extends TestCase
{
    function test_create_Item()
    {
        $data = [
            'id'          => '170c1d6dda8311e69df65254007e8abd',
            'description' => 'Milk',
            'price'       => '1.75',
            'list'        => '09497bcf4d8240ccb966b89fe8009bfc'
        ];

        $connection = $this->createMock(PDO::class);
        $statement  = $this->createMock(PDOStatement::class);

        $connection
                ->method('prepare')
                ->willReturn($statement);

        $statement
                ->expects($this->once())
                ->method('execute')
                ->with($this->equalTo($data));

        $dataAccess = new RelationalDataAccess($connection);
        $dataAccess->createItem($data);
    }

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

    function test_return_items_by_List()
    {
        $expected = [
            [
                'id'          => '170c1d6dda8311e69df65254007e8abd',
                'description' => 'Milk',
                'price'       => '1.75'
            ],
            [
                'id'          => '640f9555da8211e69df65254007e8abd',
                'description' => 'Chocolate',
                'price'       => '0.99'
            ]
        ];

        $connection = $this->createMock(PDO::class);
        $statement  = $this->createMock(PDOStatement::class);

        $connection
                ->method('prepare')
                ->willReturn($statement);

        $statement
                ->method('fetchAll')
                ->willReturn($expected);

        $dataAccess = new RelationalDataAccess($connection);
        $data = $dataAccess->getItemsByList('09497bcf4d8240ccb966b89fe8009bfc');

        $this->assertEquals($expected, $data);
    }

    function test_delete_item()
    {
        $expected = ['id' => '170c1d6dda8311e69df65254007e8abd'];

        $connection = $this->createMock(PDO::class);
        $statement  = $this->createMock(PDOStatement::class);

        $connection
                ->method('prepare')
                ->willReturn($statement);

        $statement
                ->expects($this->once())
                ->method('execute')
                ->with($this->equalTo($expected));

        $dataAccess = new RelationalDataAccess($connection);
        $dataAccess->deleteItem($expected['id']);
    }
}

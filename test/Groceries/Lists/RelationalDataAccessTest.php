<?php

namespace Groceries\Lists;

use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;

class RelationalDataAccessTest extends TestCase
{
    function test_return_list_by_id()
    {
        $expected = ['id' => '09497bcf4d8240ccb966b89fe8009bfc', 'date' => '2017-02-01'];

        $connection = $this->createMock(PDO::class);
        $statement  = $this->createMock(PDOStatement::class);

        $connection
                ->method('prepare')
                ->willReturn($statement);

        $statement
                ->method('fetch')
                ->willReturn($expected);

        $dataAccess = new RelationalDataAccess($connection);
        $data = $dataAccess->getListByID($expected['id']);

        $this->assertEquals($expected, $data);
    }

    function test_return_lists_by_month()
    {
        $expected = [
            ['id' => '09497bcf4d8240ccb966b89fe8009bfc', 'date' => '2017-02-01'],
            ['id' => '640cc65cda8211e69df65254007e8abd', 'date' => '2017-02-05']
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
        $data = $dataAccess->getListsByMonth('02', '2017');

        $this->assertEquals($expected, $data);
    }
}

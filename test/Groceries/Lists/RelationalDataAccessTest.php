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
}

<?php
namespace Mezon\CrudService\Tests;

use Mezon\PdoCrud\Tests\PdoCrudMock;

class GetRecordsUnitTest extends CrudServiceModelBaseTest
{

    /**
     * Testing getRecords method
     */
    public function testGetRecords()
    {
        // setup
        $connection = new PdoCrudMock();
        $connection->selectResults[] = [
            [
                'id' => 1
            ]
        ];
        $mock = $this->getModelMock($connection);
        $mock->expects($this->once())
            ->method('getRecordsTransformer');

        // test body
        $result = $mock->getRecords(0, 0, 1);

        // assertions
        $this->assertCount(1, $result);
    }
}

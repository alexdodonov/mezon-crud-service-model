<?php
namespace Mezon\CrudService\Tests;

use Mezon\PdoCrud\Tests\PdoCrudMock;

class LastRecordsUnitTest extends CrudServiceModelBaseTest
{

    /**
     * Method tests last N records returning
     */
    public function testLastRecords()
    {
        // setup
        $connection = new PdoCrudMock();
        $connection->selectResults [] = [
            [],
            []
        ];
        $mock = $this->getModelMock($connection);
        $mock->expects($this->once())
            ->method('getRecordsTransformer');

        // test body
        $records = $mock->lastRecords(false, 2, [
            '1 = 1'
        ]);

        // assertions
        $this->assertCount(2, $records, 'Invalid amount of records was returned');
    }
}

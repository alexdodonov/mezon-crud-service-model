<?php
namespace Mezon\CrudService\Tests;

use Mezon\PdoCrud\Tests\PdoCrudMock;
use Mezon\CrudService\CrudServiceModel;

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
        $model = new CrudServiceModel();
        $model->setConnection($connection);

        // test body
        $records = $model->lastRecords(false, 2, [
            '1 = 1'
        ]);

        // assertions
        $this->assertCount(2, $records, 'Invalid amount of records was returned');
    }
}

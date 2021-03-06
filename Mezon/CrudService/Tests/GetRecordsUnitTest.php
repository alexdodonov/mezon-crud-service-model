<?php
namespace Mezon\CrudService\Tests;

use Mezon\PdoCrud\Tests\PdoCrudMock;
use Mezon\CrudService\CrudServiceModel;

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
        $model = new CrudServiceModel();
        $model->setConnection($connection);

        // test body
        $result = $model->getRecords(0, 0, 1);

        // assertions
        $this->assertCount(1, $result);
    }
}

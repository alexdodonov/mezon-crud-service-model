<?php
namespace Mezon\CrudService\Tests;

use Mezon\PdoCrud\Tests\PdoCrudMock;
use Mezon\CrudService\CrudServiceModel;

class UpdateBasicFieldsUnitTest extends CrudServiceModelBaseTest
{

    /**
     * Method tests updateBasicFields method
     */
    public function testUpdateBasicFields()
    {
        // setup
        $connection = new PdoCrudMock();
        $model = new CrudServiceModel();
        $model->setConnection($connection);

        // test body and assertions
        $model->updateBasicFields(false, [
            'id' => 1
        ], [
            '1=1'
        ]);

        // assertions
        $this->assertEquals(1, $connection->updateWasCalledCounter);
    }
}

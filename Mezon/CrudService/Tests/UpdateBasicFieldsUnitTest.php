<?php
namespace Mezon\CrudService\Tests;

use Mezon\PdoCrud\Tests\PdoCrudMock;

class UpdateBasicFieldsUnitTest extends CrudServiceModelBaseTest
{

    /**
     * Method tests updateBasicFields method
     */
    public function testUpdateBasicFields()
    {
        // setup
        $connection = new PdoCrudMock();
        $mock = $this->getModelMock($connection);

        // test body and assertions
        $mock->updateBasicFields(false, [
            'id' => 1
        ], [
            '1=1'
        ]);

        // assertions
        $this->assertEquals(1, $connection->updateWasCalledCounter);
    }
}

<?php
namespace Mezon\CrudService\Tests;

class UpdateBasicFieldsUnitTest extends CrudServiceModelBaseTest
{

    /**
     * Method tests updateBasicFields method
     */
    public function testUpdateBasicFields()
    {
        // setup
        $connection = $this->getConnectionMock();
        $connection->expects($this->once())
            ->method('update');
        $mock = $this->getModelMock($connection);

        // test body and assertions
        $mock->updateBasicFields(false, [
            'id' => 1
        ], [
            '1=1'
        ]);
    }
}

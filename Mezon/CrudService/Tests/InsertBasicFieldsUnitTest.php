<?php
namespace Mezon\CrudService\Tests;

use Mezon\PdoCrud\Tests\PdoCrudMock;
use Mezon\CrudService\CrudServiceModel;

class InsertBasicFieldsUnitTest extends CrudServiceModelBaseTest
{

    /**
     * Method tests insertBasicFields method
     */
    public function testInsertBasicFields()
    {
        // setup
        $connection = new PdoCrudMock();
        $model = new CrudServiceModel();
        $model->setConnection($connection);

        // test body
        $result = $model->insertBasicFields([
            'title' => 'title'
        ]);

        // assertions
        $this->assertTrue(isset($result['id']), 'Invalid record was returned');
        $this->assertTrue(isset($result['title']), 'Invalid record was returned');
        $this->assertEquals(1, $connection->insertWasCalledCounter);
    }

    /**
     * Testing method
     */
    public function testInsertBasicFieldsException(): void
    {
        // assertions
        $this->expectException(\Exception::class);

        // setup
        $connection = new PdoCrudMock();
        $mock = $this->getModelMock($connection);

        // test body
        $mock->insertBasicFields([]);

        // assertions
        $this->assertEquals(0, $connection->insertWasCalledCounter);
    }
}

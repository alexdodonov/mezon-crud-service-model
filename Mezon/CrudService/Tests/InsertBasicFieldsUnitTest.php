<?php
namespace Mezon\CrudService\Tests;

use Mezon\PdoCrud\PdoCrud;
use Mezon\CrudService\CrudServiceModel;

class InsertBasicFieldsUnitTest extends CrudServiceModelBaseTest
{

    /**
     * Method tests insertBasicFields method
     */
    public function testInsertBasicFields()
    {
        // setup
        $connection = $this->getConnectionMock();
        $connection->expects($this->once())
            ->method('insert')
            ->willReturn(1);
        $mock = $this->getModelMock($connection);

        // test body
        $result = $mock->insertBasicFields([
            'title' => 'title'
        ]);

        // assertions
        $this->assertTrue(isset($result['id']), 'Invalid record was returned');
        $this->assertTrue(isset($result['title']), 'Invalid record was returned');
    }

    /**
     * Testing method
     */
    public function testInsertBasicFieldsException(): void
    {
        // assertions
        $this->expectException(\Exception::class);

        // setup
        $connection = $this->getConnectionMock();
        $connection->expects($this->never())
            ->method('insert');
        $mock = $this->getModelMock($connection);

        // test body
        $mock->insertBasicFields([]);
    }
}

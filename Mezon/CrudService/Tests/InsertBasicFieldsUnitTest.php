<?php
namespace Mezon\CrudService\Tests;

use Mezon\PdoCrud\Tests\PdoCrudMock;
use Mezon\CrudService\CrudServiceModel;
use PHPUnit\Framework\TestCase;

/**
 *
 * @psalm-suppress PropertyNotSetInConstructor
 */
class InsertBasicFieldsUnitTest extends TestCase
{

    /**
     * Method tests insertBasicFields method
     */
    public function testInsertBasicFields(): void
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
        $this->assertEquals(1, $connection->executeWasCalledCounter);
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
        $model = new CrudServiceModel();
        $model->setConnection($connection);

        // test body
        $model->insertBasicFields([]);

        // assertions
        $this->assertEquals(0, $connection->executeWasCalledCounter);
    }
}

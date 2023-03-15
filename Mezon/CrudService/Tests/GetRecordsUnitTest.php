<?php
namespace Mezon\CrudService\Tests;

use Mezon\PdoCrud\Tests\PdoCrudMock;
use Mezon\CrudService\CrudServiceModel;
use PHPUnit\Framework\TestCase;

/**
 *
 * @psalm-suppress PropertyNotSetInConstructor
 */
class GetRecordsUnitTest extends TestCase
{

    /**
     * Testing getRecords method
     */
    public function testGetRecords(): void
    {
        // setup
        $connection = new PdoCrudMock();
        // TODO use CrudServiceModelUnitTestUtilities::setup...
        $connection->selectResults[] = [
            CrudServiceModelUnitTestUtilities::emptyRecord()
        ];
        $model = new CrudServiceModel();
        $model->setConnection($connection);

        // test body
        $result = $model->getRecords(0, 0, 1);

        // assertions
        $this->assertCount(1, $result);
    }
}

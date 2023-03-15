<?php
namespace Mezon\CrudService\Tests;

use Mezon\CrudService\CrudServiceModel;
use Mezon\PdoCrud\Tests\PdoCrudMock;
use PHPUnit\Framework\TestCase;

/**
 *
 * @psalm-suppress PropertyNotSetInConstructor
 */
class NewRecordsSinceUnitTest extends TestCase
{

    /**
     * Testing newRecordsSince
     */
    public function testNewRecordsSince(): void
    {
        // setup
        $connection = new PdoCrudMock();
        // TODO use CrudServiceModelUnitTestUtilities::setup...
        $connection->selectResults[] = [
            CrudServiceModelUnitTestUtilities::emptyRecord(),
            CrudServiceModelUnitTestUtilities::emptyRecord()
        ];
        $model = new CrudServiceModel();
        $model->setConnection($connection);

        // test body
        $records = $model->newRecordsSince(false, '2012-01-01');

        // assertions
        $this->assertCount(2, $records);
    }
}

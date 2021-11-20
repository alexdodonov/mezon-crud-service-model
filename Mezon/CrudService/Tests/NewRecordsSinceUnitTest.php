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
        $connection->selectResults[] = [
            [],
            []
        ];
        $model = new CrudServiceModel();
        $model->setConnection($connection);

        // test body
        $records = $model->newRecordsSince(false, '2012-01-01');

        // assertions
        $this->assertEquals(2, count($records));
    }
}

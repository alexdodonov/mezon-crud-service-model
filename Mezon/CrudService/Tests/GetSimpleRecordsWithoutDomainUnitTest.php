<?php
namespace Mezon\CrudService\Tests;

use Mezon\PdoCrud\Tests\PdoCrudMock;
use Mezon\CrudService\CrudServiceModel;
use PHPUnit\Framework\TestCase;

/**
 *
 * @psalm-suppress PropertyNotSetInConstructor
 */
class GetSimpleRecordsWithoutDomainUnitTest extends TestCase
{

    /**
     * Testing getSimpleRecords without domain
     */
    public function testGetSimpleRecordsWithoutDomain(): void
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
        $records = $model->getSimpleRecords(false, 0, 2, [], [
            'field' => 'id',
            'order' => 'ASC'
        ]);

        // assertions
        $this->assertCount(2, $records);
    }
}

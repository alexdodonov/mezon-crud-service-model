<?php
namespace Mezon\CrudService\Tests;

use Mezon\PdoCrud\Tests\PdoCrudMock;
use Mezon\CrudService\CrudServiceModel;
use PHPUnit\Framework\TestCase;

/**
 *
 * @psalm-suppress PropertyNotSetInConstructor
 */
class GetSimpleRecordsWithDomainUnitTest extends TestCase
{

    /**
     * Testing getSimpleRecords with domain
     */
    public function testGetSimpleRecordsWithDomain(): void
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
        $records = $model->getSimpleRecords(1, 0, 2, [], [
            'field' => 'id',
            'order' => 'ASC'
        ]);

        // assertions
        $this->assertCount(2, $records);
    }
}

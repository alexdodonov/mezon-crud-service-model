<?php
namespace Mezon\CrudService\Tests;

use Mezon\PdoCrud\Tests\PdoCrudMock;
use Mezon\CrudService\CrudServiceModel;

/**
 *
 * @psalm-suppress PropertyNotSetInConstructor
 */
class GetSimpleRecordsWithDomainUnitTest extends CrudServiceModelBaseTest
{

    /**
     * Testing getSimpleRecords with domain
     */
    public function testGetSimpleRecordsWithDomain(): void
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
        $records = $model->getSimpleRecords(1, 0, 2, [], [
            'field' => 'id',
            'order' => 'ASC'
        ]);

        // assertions
        $this->assertCount(2, $records, 'Invalid count of not transformed records');
    }
}

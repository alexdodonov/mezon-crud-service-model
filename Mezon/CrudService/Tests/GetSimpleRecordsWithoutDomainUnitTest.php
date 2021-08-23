<?php
namespace Mezon\CrudService\Tests;

use Mezon\PdoCrud\Tests\PdoCrudMock;
use Mezon\CrudService\CrudServiceModel;

/**
 *
 * @psalm-suppress PropertyNotSetInConstructor
 */
class GetSimpleRecordsWithoutDomainUnitTest extends CrudServiceModelBaseTest
{

    /**
     * Testing getSimpleRecords without domain
     */
    public function testGetSimpleRecordsWithoutDomain(): void
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
        $records = $model->getSimpleRecords(false, 0, 2, [], [
            'field' => 'id',
            'order' => 'ASC'
        ]);

        // assertions
        $this->assertCount(2, $records, 'Invalid count of not transformed records');
    }
}

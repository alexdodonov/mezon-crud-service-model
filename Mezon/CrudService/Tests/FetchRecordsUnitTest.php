<?php
namespace Mezon\CrudService\Tests;

use Mezon\PdoCrud\Tests\PdoCrudMock;
use Mezon\CrudService\CrudServiceModel;
use PHPUnit\Framework\TestCase;

/**
 *
 * @psalm-suppress PropertyNotSetInConstructor
 */
class FetchRecordsUnitTest extends TestCase
{

    /**
     * Testing fetchRecordsByIds with domain
     */
    public function testFetchRecordsByIdsWithDomain(): void
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
        $records = $model->fetchRecordsByIds(1, "1,2");

        // assertions
        $this->assertCount(2, $records, 'Invalid count of fetched by ids records');
    }

    /**
     * Testing fetchRecordsByIds with domain
     */
    public function testFetchRecordsByIdsWithoutDomain(): void
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
        $records = $model->fetchRecordsByIds(false, "1,2");

        // assertions
        $this->assertCount(2, $records, 'Invalid count of fetched by ids records');
    }

    /**
     * Testing fetchRecordsByIds not found
     */
    public function testFetchRecordsByIdsNotFound(): void
    {
        // setup
        $connection = new PdoCrudMock();
        $connection->selectResults[] = [];
        $model = new CrudServiceModel();
        $model->setConnection($connection);

        // test body and assertions
        $this->expectException(\Exception::class);

        $model->fetchRecordsByIds(false, "1,2");
    }
}

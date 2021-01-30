<?php
namespace Mezon\CrudService\Tests;

use Mezon\CrudService\CrudServiceModel;
use Mezon\PdoCrud\Tests\PdoCrudMock;

class CrudServiceModelUnitTest extends CrudServiceModelBaseTest
{

    /**
     * Data provider for the testDeleteFiltered
     *
     * @return array Data
     */
    public function deleteFilteredTestData(): array
    {
        return [
            [
                false
            ],
            [
                1
            ]
        ];
    }

    /**
     * Method tests deleteFiltered method
     *
     * @param mixed $domainId
     *            Domain id
     *            
     * @dataProvider deleteFilteredTestData
     */
    public function testDeleteFiltered($domainId)
    {
        // setup
        $connection = new PdoCrudMock();
        $mock = $this->getModelMock($connection);

        // test body
        $mock->deleteFiltered($domainId, [
            'title LIKE "title"'
        ]);

        // assertions
        $this->assertEquals(1, $connection->deleteWasCalledCounter);
    }

    /**
     * Test data for testConstructor test
     *
     * @return array
     */
    public function constructorTestData(): array
    {
        return [
            [
                [
                    'id' => [
                        'type' => 'intger'
                    ]
                ],
                'id'
            ],
            [
                '*',
                '*'
            ],
            [
                new \Mezon\FieldsSet([
                    'id' => [
                        'type' => 'intger'
                    ]
                ]),
                'id'
            ]
        ];
    }

    /**
     * Testing constructor
     *
     * @param mixed $data
     *            Parameterfor constructor
     * @param string $origin
     *            original data for validation
     * @dataProvider constructorTestData
     */
    public function testConstructor($data, string $origin)
    {
        // setup and test body
        $model = new CrudServiceModel($data, 'entity_name');

        // assertions
        $this->assertTrue($model->hasField($origin), 'Invalid contruction');
    }

    /**
     * Testing constructor with exception
     */
    public function testConstructorException()
    {
        // assertions
        $this->expectException(\Exception::class);

        // test body
        $model = new CrudServiceModel(new \stdClass(), 'entity_name');

        // more assertions
        $this->assertEquals('entity_name', $model->getEntityName());
    }

    /**
     * Testing getSimpleRecords without domain
     */
    public function testGetSimpleRecordsWithoutDomain()
    {
        // setup
        $connection = new PdoCrudMock();
        $connection->selectResults[] = [
            [],
            []
        ];
        $model = $this->getModelMock($connection);

        // test body
        $records = $model->getSimpleRecords(false, 0, 2, [], [
            'field' => 'id',
            'order' => 'ASC'
        ]);

        // assertions
        $this->assertCount(2, $records, 'Invalid count of not transformed records');
    }

    /**
     * Testing getSimpleRecords with domain
     */
    public function testGetSimpleRecordsWithDomain()
    {
        // setup
        $connection = new PdoCrudMock();
        $connection->selectResults[] = [
            [],
            []
        ];
        $model = $this->getModelMock($connection);

        // test body
        $records = $model->getSimpleRecords(1, 0, 2, [], [
            'field' => 'id',
            'order' => 'ASC'
        ]);

        // assertions
        $this->assertCount(2, $records, 'Invalid count of not transformed records');
    }

    /**
     * Testing fetchRecordsByIds with domain
     */
    public function testFetchRecordsByIdsWithDomain()
    {
        // setup
        $connection = new PdoCrudMock();
        $connection->selectResult = [
            [],
            []
        ];
        $model = $this->getModelMock($connection);

        // test body
        $records = $model->fetchRecordsByIds(1, "1,2");

        // assertions
        $this->assertCount(2, $records, 'Invalid count of fetched by ids records');
    }

    /**
     * Testing fetchRecordsByIds with domain
     */
    public function testFetchRecordsByIdsWithoutDomain()
    {
        // setup
        $connection = new PdoCrudMock();
        $connection->selectResult = [
            [],
            []
        ];
        $model = $this->getModelMock($connection);

        // test body
        $records = $model->fetchRecordsByIds(false, "1,2");

        // assertions
        $this->assertCount(2, $records, 'Invalid count of fetched by ids records');
    }

    /**
     * Testing fetchRecordsByIds not found
     */
    public function testFetchRecordsByIdsNotFound()
    {
        // setup
        $connection = new PdoCrudMock();
        $connection->selectResult = [];
        $model = $this->getModelMock($connection);

        // test body and assertions
        $this->expectException(\Exception::class);

        $model->fetchRecordsByIds("1,2", false);
    }

    /**
     * Method tests last N records returning
     */
    public function testLastRecords()
    {
        // setup
        $connection = new PdoCrudMock();
        $connection->selectResult = [
            [],
            []
        ];
        $mock = $this->getModelMock($connection);
        $mock->expects($this->once())
            ->method('getRecordsTransformer');

        // test body
        $records = $mock->lastRecords(false, 2, [
            '1 = 1'
        ]);

        // assertions
        $this->assertCount(2, $records, 'Invalid amount of records was returned');
    }

    /**
     * Testing getRecords method
     */
    public function testGetRecords()
    {
        // setup
        $connection = new PdoCrudMock();
        $connection->selectResults[] = [
            [
                'id' => 1
            ]
        ];
        $mock = $this->getModelMock($connection);
        $mock->expects($this->once())
            ->method('getRecordsTransformer');

        // test body
        $result = $mock->getRecords(0, 0, 1);

        // assertions
        $this->assertCount(1, $result);
    }
}

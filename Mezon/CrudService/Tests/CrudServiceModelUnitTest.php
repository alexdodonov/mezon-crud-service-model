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
}

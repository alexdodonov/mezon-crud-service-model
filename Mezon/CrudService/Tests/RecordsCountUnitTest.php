<?php
namespace Mezon\CrudService\Tests;

use Mezon\PdoCrud\Tests\PdoCrudMock;

class RecordsCountUnitTest extends CrudServiceModelBaseTest
{

    /**
     * Testing data provider
     *
     * @return array testing data
     */
    public function recordsCountDataProvider(): array
    {
        return [
            // #0, the first case
            [
                [
                    [
                        'records_count' => 0
                    ]
                ],
                0
            ],
            // #1, the second case
            [
                [
                    [
                        'records_count' => 1
                    ]
                ],
                1
            ],
            // #2, the third case
            [
                [],
                0
            ]
        ];
    }

    /**
     * Testing method
     *
     * @param array $selectResult
     *            select results
     * @param int $expected
     *            expected result
     * @dataProvider recordsCountDataProvider
     */
    public function testRecordsCount(array $selectResult, int $expected): void
    {
        // setup
        $connection = new PdoCrudMock();
        $connection->selectResult = $selectResult;
        $mock = $this->getModelMock($connection);

        // test body and asssertions
        $this->assertEquals($expected, $mock->recordsCount());
    }

    /**
     * Data provider
     *
     * @return array Test data
     */
    public function recordsCountByFieldProvider(): array
    {
        return [
            [
                [
                    'id' => 1,
                    'records_count' => 2
                ],
                2
            ],
            [
                [],
                0
            ]
        ];
    }

    /**
     * Testing recordsCountByField method
     *
     * @dataProvider recordsCountByFieldProvider
     */
    public function testRecordsCountByField(array $selectResult, int $count)
    {
        // setup
        $connection = new PdoCrudMock();
        $connection->selectResult = $selectResult;
        $model = $this->getModelMock($connection);

        // test body
        $result = $model->recordsCountByField(false, 'id', []);

        // assertions
        $this->assertEquals($count, $result['records_count']);
    }
}

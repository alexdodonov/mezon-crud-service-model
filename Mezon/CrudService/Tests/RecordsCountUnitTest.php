<?php
namespace Mezon\CrudService\Tests;

use Mezon\PdoCrud\Tests\PdoCrudMock;
use Mezon\CrudService\CrudServiceModel;
use PHPUnit\Framework\TestCase;

/**
 *
 * @psalm-suppress PropertyNotSetInConstructor
 */
class RecordsCountUnitTest extends TestCase
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
     * @psalm-suppress MixedPropertyTypeCoercion
     */
    public function testRecordsCount(array $selectResult, int $expected): void
    {
        // setup
        $connection = new PdoCrudMock();
        $connection->selectResults[] = $selectResult;
        $model = new CrudServiceModel();
        $model->setConnection($connection);

        // test body and asssertions
        $this->assertEquals($expected, $model->recordsCount());
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
     * @param array $selectResult
     *            select result
     * @param int $count
     *            expected count
     * @dataProvider recordsCountByFieldProvider
     * @psalm-suppress MixedPropertyTypeCoercion
     */
    public function testRecordsCountByField(array $selectResult, int $count): void
    {
        // setup
        $connection = new PdoCrudMock();
        $connection->selectResults[] = $selectResult;
        $model = new CrudServiceModel();
        $model->setConnection($connection);

        // test body
        $result = $model->recordsCountByField(false, 'id', []);

        // assertions
        $this->assertEquals($count, $result['records_count']);
    }
}

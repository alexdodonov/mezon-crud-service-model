<?php
namespace Mezon\CrudService\Tests;

use Mezon\CrudService\CrudServiceModel;
use Mezon\PdoCrud\Tests\PdoCrudMock;

/**
 *
 * @psalm-suppress PropertyNotSetInConstructor
 */
class CrudServiceModelUnitTest extends CrudServiceModelBaseTest
{

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
    public function testConstructor($data, string $origin): void
    {
        // setup and test body
        $model = new CrudServiceModel($data, 'entity_name');

        // assertions
        $this->assertTrue($model->hasField($origin), 'Invalid contruction');
    }

    /**
     * Testing constructor with exception
     */
    public function testConstructorException(): void
    {
        // assertions
        $this->expectException(\Exception::class);

        // test body
        $model = new CrudServiceModel(new \stdClass(), 'entity_name');

        // more assertions
        $this->assertEquals('entity_name', $model->getEntityName());
    }
}

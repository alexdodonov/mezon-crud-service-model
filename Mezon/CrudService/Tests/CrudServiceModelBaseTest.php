<?php
namespace Mezon\CrudService\Tests;

use Mezon\CrudService\CrudServiceModel;
use PHPUnit\Framework\TestCase;

/**
 *
 * @psalm-suppress PropertyNotSetInConstructor
 */
class CrudServiceModelBaseTest extends TestCase
{

    /**
     * Method returns model's mock
     *
     * @param object $connectionMock
     *            Mock of the connection
     * @return object Mock of the model
     */
    protected function getModelMock($connectionMock): object
    {
        $mock = $this->getMockBuilder(CrudServiceModel::class)
            ->setConstructorArgs([
            [
                'id' => [
                    'type' => 'integer'
                ]
            ],
            'table-name'
        ])
            ->onlyMethods([
            'getConnection',
            'getRecordsTransformer'
        ])
            ->getMock();

        $mock->method('getConnection')->willReturn($connectionMock);

        return $mock;
    }
}

<?php
namespace Mezon\CrudService\Tests;

use Mezon\PdoCrud\PdoCrud;
use Mezon\CrudService\CrudServiceModel;
use PHPUnit\Framework\TestCase;

class CrudServiceModelBaseTest extends TestCase
{

    /**
     * Method returns model's mock
     *
     * @param object $connectionMock
     *            Mock of the connection
     * @return object Mock of the model
     */
    protected function getModelMock($connectionMock)
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
            ->setMethods([
            'getConnection',
            'getRecordsTransformer'
        ])
            ->getMock();

        $mock->method('getConnection')->willReturn($connectionMock);

        return $mock;
    }
}

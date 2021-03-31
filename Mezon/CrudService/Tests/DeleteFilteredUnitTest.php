<?php
namespace Mezon\CrudService\Tests;

use Mezon\CrudService\CrudServiceModel;
use Mezon\PdoCrud\Tests\PdoCrudMock;

class DeleteFilteredUnitTest extends CrudServiceModelBaseTest
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
        $this->assertEquals(1, $connection->executeWasCalledCounter);
    }
}

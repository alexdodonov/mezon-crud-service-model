<?php
namespace Mezon\CrudService\Tests;

use Mezon\PdoCrud\Tests\PdoCrudMock;
use Mezon\CrudService\CrudServiceModel;

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
        $model = new CrudServiceModel();
        $model->setConnection($connection);

        // test body
        $model->deleteFiltered($domainId, [
            'title LIKE "title"'
        ]);

        // assertions
        $this->assertEquals(1, $connection->executeWasCalledCounter);
    }
}

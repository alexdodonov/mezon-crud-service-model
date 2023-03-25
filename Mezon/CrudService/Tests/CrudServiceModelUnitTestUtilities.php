<?php
namespace Mezon\CrudService\Tests;

use Mezon\PdoCrud\Tests\PdoCrudMock;
use Mezon\CrudService\CrudServiceModel;

class CrudServiceModelUnitTestUtilities
{

    /**
     * Data compilator
     *
     * @param string $fieldName
     *            field name
     * @param string $fieldValue
     *            field value
     * @return object object
     */
    public static function emptyRecord(string $fieldName = 'name', string $fieldValue = 'value'): object
    {
        // TODO remove one method
        return new \stdClass();
    }

    /**
     * Records count method call mock
     *
     * @param PdoCrudMock $connection
     *            connection
     * @param int $count
     *            count
     * @return PdoCrudMock connection
     */
    public static function setupRecordsCount(?PdoCrudMock $connection, int $count = 1): PdoCrudMock
    {
        if ($connection === null) {
            $connection = new PdoCrudMock();
        }

        $record = new \stdClass();
        $record->records_count = $count;

        $connection->selectResults[] = [
            $record
        ];

        CrudServiceModel::setConnection($connection);

        return $connection;
    }
}

<?php
namespace Mezon\CrudService\Tests;

use Mezon\PdoCrud\Tests\PdoCrudMock;
use Mezon\CrudService\CrudServiceModel;
use Mezon\PdoCrud\Tests\PdoCrudUnitTestUtilities;

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
        return PdoCrudUnitTestUtilities::makeMethodCallMock(
            $connection,
            function (PdoCrudMock $connection) use ($count) {
                $record = new \stdClass();
                $record->records_count = $count;

                $connection->selectResults[] = [
                    $record
                ];

                CrudServiceModel::setConnection($connection);
            });
    }

    /**
     * Records list method call mock
     *
     * @param PdoCrudMock $connection
     *            connection
     * @param object[] $records
     *            records
     * @return PdoCrudMock connection
     */
    public static function setupGetSimpleRecords(?PdoCrudMock $connection, array $records): PdoCrudMock
    {
        return PdoCrudUnitTestUtilities::makeMethodCallMock(
            $connection,
            function (PdoCrudMock $connection) use ($records) {
                $connection->selectResults[] = $records;

                CrudServiceModel::setConnection($connection);
            });
    }
}

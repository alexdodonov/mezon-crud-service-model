<?php
namespace Mezon\CrudService;

use Mezon\Functional\Fetcher;
use Mezon\Service\DbServiceModel;

/**
 * Class CrudServiceModel
 *
 * @package CrudService
 * @subpackage CrudServiceModel
 * @author Dodonov A.A.
 * @version v.1.0 (2019/08/17)
 * @copyright Copyright (c) 2019, aeon.org
 */

/**
 * Crud service's default model
 *
 * @author Dodonov A.A.
 */
class CrudServiceModel extends DbServiceModel
{

    /**
     * Method transforms record before it will be returned with the newRecordsSince method
     *
     * @param array $records
     *            record to be transformed
     */
    protected function lastNewRecordsSince(array &$records): void
    {
        $this->getRecordsTransformer($records);
    }

    /**
     * Method compiles select query
     *
     * @param string[] $where
     *            where conditions
     * @return string select query
     * @psalm-suppress MixedArgumentTypeCoercion
     */
    private function compileSelectQuery(array $where): string
    {
        return 'SELECT ' . $this->getFieldsNames() . ' FROM ' . $this->getTableName() . ' WHERE ' .
            implode('  AND  ', $where);
    }

    use WhereUtilities;

    /**
     * Method returns all records created since $date
     *
     * @param int|false $domainId
     *            do we have domain limitations
     * @param string $date
     *            start of the period
     * @return array list of records created since $date
     * @psalm-suppress MixedArgumentTypeCoercion
     */
    public function newRecordsSince($domainId, $date): array
    {
        $where = $this->addDomainIdCondition($domainId);

        $where[] = 'creation_date >= "' . date('Y-m-d H:i:s', strtotime($date)) . '"';

        $this->getApropriateConnection()->prepare($this->compileSelectQuery($where));

        $records = $this->getApropriateConnection()->executeSelect();

        $this->lastNewRecordsSince($records);

        return $records;
    }

    /**
     * Method returns amount of records in table
     *
     * @param int|bool $domainId
     *            do we have domain limitations
     * @param string[] $where
     *            filter
     * @return int amount of records
     * @psalm-suppress MixedArgumentTypeCoercion
     */
    public function recordsCount($domainId = false, array $where = [
        '1=1'
    ]): int
    {
        $where = $this->addDomainIdCondition($domainId, $where);

        $this->getApropriateConnection()->prepare(
            'SELECT COUNT( * ) AS records_count FROM ' . $this->getTableName() . ' WHERE ' . implode(' AND  ', $where));
        $records = $this->getApropriateConnection()->executeSelect();

        if (empty($records)) {
            return 0;
        }

        return (int)Fetcher::getField($records[0], 'records_count');
    }

    use OrderUtilities;

    /**
     * Method fetches records before transformation
     *
     * @param int|bool $domainId
     *            id of the domain
     * @param int $from
     *            starting record
     * @param int $limit
     *            fetch limit
     * @param string[] $where
     *            fetch condition
     * @param array $order
     *            sorting condition
     * @return array array of records
     * @psalm-suppress MixedArgumentTypeCoercion
     */
    public function getSimpleRecords($domainId, int $from, int $limit, array $where, array $order = []): array
    {
        $where = $this->addDomainIdCondition($domainId, $where);
        $order = $this->getDefaultOrder($order);

        $this->getApropriateConnection()->prepare(
            $this->compileSelectQuery($where) . ' ORDER BY :field :order LIMIT :from, :limit');

        $this->getApropriateConnection()->bindParameter(':field', $order['field']);
        $this->getApropriateConnection()->bindParameter(':order', $order['order']);
        $this->getApropriateConnection()->bindParameter(':from', $from, \PDO::PARAM_INT);
        $this->getApropriateConnection()->bindParameter(':limit', $limit, \PDO::PARAM_INT);

        return $this->getApropriateConnection()->executeSelect();
    }

    /**
     * Method transforms record before it will be returned with the getRecords method
     *
     * @param array $records
     *            record to be transformed
     *            
     * @codeCoverageIgnore
     */
    protected function getRecordsTransformer(array &$records): void
    {
        // should be overriden in the derived class
    }

    /**
     * Method fetches records after transformation
     *
     * @param int|bool $domainId
     *            id of the domain
     * @param int $from
     *            starting record
     * @param int $limit
     *            fetch limit
     * @param string[] $where
     *            fetch condition
     * @param array $order
     *            sorting condition
     * @return array of records
     * @psalm-suppress MixedArgumentTypeCoercion
     */
    public function getRecords($domainId, int $from, int $limit, array $where = [
        '1=1'
    ], array $order = []): array
    {
        $records = $this->getSimpleRecords($domainId, $from, $limit, $where, $order);

        $this->getRecordsTransformer($records);

        return $records;
    }

    /**
     * Method transforms record before it will be returned with the lastRecords method
     *
     * @param array $records
     *            record to be transformed
     */
    protected function lastRecordsTransformer(array &$records): void
    {
        $this->getRecordsTransformer($records);
    }

    /**
     * Method returns last $count records
     *
     * @param int|false $domainId
     *            id of the domain
     * @param int $count
     *            amount of records to be returned
     * @param string[] $where
     *            filter conditions
     * @return array list of the last $count records
     * @psalm-suppress MixedArgumentTypeCoercion
     */
    public function lastRecords($domainId, $count, $where): array
    {
        $where = $this->addDomainIdCondition($domainId, $where);

        $this->getApropriateConnection()->prepare(
            $this->compileSelectQuery($where) . ' ORDER BY id DESC LIMIT 0 , :count');
        $this->getApropriateConnection()->bindParameter(':count', $count, \PDO::PARAM_INT);
        $records = $this->getApropriateConnection()->executeSelect();

        $this->lastRecordsTransformer($records);

        return $records;
    }

    /**
     * Method transforms record before it will be returned with the fetchRecordsByIds method
     *
     * @param array $records
     *            record to be transformed
     */
    protected function fetchRecordsByIdsTransformer(array &$records): void
    {
        $this->getRecordsTransformer($records);
    }

    /**
     * Method fetches records bythe specified fields
     *
     * @param int|false $domainId
     *            domain id
     * @param string $ids
     *            ids of records to be fetched
     * @return array list of records
     */
    public function fetchRecordsByIds($domainId, string $ids): array
    {
        if ($domainId === false) {
            $where = 'id IN ( ' . $ids . ' )';
        } else {
            $where = 'id IN ( ' . $ids . ' ) AND domain_id = ' . intval($domainId);
        }

        $this->getApropriateConnection()->prepare($this->compileSelectQuery([
            $where
        ]));
        $records = $this->getApropriateConnection()->executeSelect();

        if (empty($records)) {
            throw (new \Exception(
                'Record with id in ' . $ids . ' and domain = ' . ($domainId === false ? 'false' : $domainId) .
                ' was not found',
                - 1));
        }

        $this->fetchRecordsByIdsTransformer($records);

        return $records;
    }

    /**
     * Method returns amount of records in table, grouped by the specified field
     *
     * @param int|false $domainId
     *            domain id
     * @param string $fieldName
     *            grouping field
     * @param string[] $where
     *            filtration conditions
     * @return array records with stat
     * @psalm-suppress MixedArgumentTypeCoercion
     */
    public function recordsCountByField($domainId, string $fieldName, array $where): array
    {
        $where = $this->addDomainIdCondition($domainId, $where);

        $this->getApropriateConnection()->prepare(
            'SELECT ' . htmlspecialchars($fieldName) . ', COUNT( * ) AS records_count FROM ' . $this->getTableName() .
            ' WHERE ' . implode('  AND ', $where) . ' GROUP BY ' . $fieldName);
        $records = $this->getApropriateConnection()->executeSelect();

        if (empty($records)) {
            return [
                'records_count' => 0
            ];
        }

        return $records;
    }

    use DeleteFilteredTrait;

    /**
     * Method updates records
     *
     * @param int|false $domainId
     *            domain id. Pass false if we want to ignore domain_id security
     * @param array $record
     *            new values for fields
     * @param string[] $where
     *            condition
     * @return array updated fields
     * @psalm-suppress MixedArgumentTypeCoercion
     */
    public function updateBasicFields($domainId, array $record, array $where): array
    {
        $where = $this->addDomainIdCondition($domainId, $where);

        $connection = $this->getApropriateConnection();

        $connection->prepare(
            'UPDATE ' . $this->getTableName() . 'SET ' . $connection->compileSetQuery($record) . ' WHERE ' .
            implode(' AND ', $where));
        $connection->execute();

        return $record;
    }

    /**
     * Method inserts basic fields
     *
     * @param array<string, mixed> $record
     *            record to be inserted
     * @param mixed $domainId
     *            id of the domain
     * @return array inserted record
     * @psalm-suppress MixedAssignment
     */
    public function insertBasicFields(array $record, $domainId = 0): array
    {
        if ($this->hasField('domain_id')) {
            $record['domain_id'] = $domainId;
        }

        if (empty($record)) {
            $msg = 'Trying to create empty record. Be shure that you have passed at least one of these fields : ';

            throw (new \Exception($msg . $this->getFieldsNames()));
        }

        $this->getApropriateConnection()->prepare(
            'INSERT INTO ' . $this->getTableName() . ' SET ' .
            $this->getApropriateConnection()
                ->compileSetQuery($record));
        $this->getApropriateConnection()->execute();

        $record['id'] = $this->getApropriateConnection()->lastInsertId();

        return $record;
    }
}

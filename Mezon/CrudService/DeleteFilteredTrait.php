<?php
namespace Mezon\CrudService;

/**
 * Trait DeleteFilteredTrait
 *
 * @package CrudService
 * @subpackage CrudServiceModel
 * @author Dodonov A.A.
 * @version v.1.0 (2021/06/22)
 * @copyright Copyright (c) 2021, aeon.org
 */

/**
 * Crud service's utilities
 *
 * @author Dodonov A.A.
 */
trait DeleteFilteredTrait
{

    /**
     * Method deletes filtered records
     *
     * @param mixed $domainId
     *            Domain id
     * @param array $where
     *            Filtration conditions
     */
    public function deleteFiltered($domainId, array $where): int
    {
        if ($domainId !== false) {
            $where[] = 'domain_id = ' . intval($domainId);
        }

        $this->getApropriateConnection()->prepare(
            'DELETE FROM ' . $this->getTableName() . ' WHERE ' . implode(' AND ', $where));

        $this->getApropriateConnection()->execute();

        return $this->getApropriateConnection()->rowCount();
    }
}
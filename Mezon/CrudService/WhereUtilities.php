<?php
namespace Mezon\CrudService;

/**
 * Trait WhereUtilities
 *
 * @package CrudService
 * @subpackage CrudServiceModel
 * @author Dodonov A.A.
 * @version v.1.0 (2021/05/04)
 * @copyright Copyright (c) 2021, aeon.org
 */

/**
 * Crud service's utilities
 *
 * @author Dodonov A.A.
 */
trait WhereUtilities
{

    /**
     * Method adds domain conditions
     *
     * @param int|bool $domainId
     *            Do we have domain limitations
     * @param array $where
     *            where condition
     * @return array where condition with domain_id limitations
     */
    protected function addDomainIdCondition($domainId, array $where = []): array
    {
        if ($domainId === false) {
            if (empty($where)) {
                $where[] = '1 = 1';
            }
        } else {
            $where[] = 'domain_id = ' . intval($domainId);
        }

        return $where;
    }
}
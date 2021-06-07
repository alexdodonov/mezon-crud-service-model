<?php
namespace Mezon\CrudService;

/**
 * Trait WhereUtilities
 *
 * @package CrudService
 * @subpackage WhereUtilities
 * @author Dodonov A.A.
 * @version v.1.0 (2021/05/04)
 * @copyright Copyright (c) 2021, aeon.org
 */

/**
 * Crud service's utilities
 *
 * @author Dodonov A.A.
 */
trait OrderUtilities
{

    /**
     * Method defaults empty order to the default one
     *
     * @param array $order
     *            order data to be defaulted
     * @return array defaulted order data
     */
    protected function getDefaultOrder(array $order): array
    {
        return ! empty($order) ? $order : [
            'field' => 'id',
            'order' => 'ASC'
        ];
    }
}
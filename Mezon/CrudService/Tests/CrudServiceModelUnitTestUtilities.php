<?php
namespace Mezon\CrudService\Tests;

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
        return new \stdClass();
    }
}

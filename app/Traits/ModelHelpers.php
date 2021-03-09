<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

/**
 * Trait ModelHelpers
 * This trait adds some helper functions to a model, which often is handy to have on all models.
 *
 * Example usage (where trait is applied):
 * - $Table = User::getTableName();
 * - $HasColumn = User::tableHas('created_at');
 *
 * @package App\Traits
 */
trait ModelHelpers
{
    /**
     * Fields of this table
     *
     * @var array
     * @see BaseModel::getTableColumns()
     */
    protected static $tableColumns = [];


    /**
     * Get the table name of this model
     *
     * @return mixed
     */
    public static function getTableName()
    {
        return with(new static)->getTable();
    }


    /**
     * Get the table name of this model
     *
     * @deprecated - Use getTableName() instead
     */
    public static function getTName()
    {
        return self::getTableName();
    }


    /**
     * Get the fields of this table
     *
     * @return array
     */
    protected static function getTableColumns()
    {
        $tableName = with(new static)->getTable();

        if (!isset(static::$tableColumns[$tableName])) {
            static::$tableColumns[$tableName] = Schema::getColumnListing($tableName);
        }

        return static::$tableColumns[$tableName];
    }


    /**
     * Does table have a specific field?
     *
     * @param string $field
     * @return bool
     */
    protected static function tableHas($field = '')
    {
        return in_array($field, static::getTableColumns());
    }


    /**
     * Parse an input to a given model
     *
     * @param int|string $input
     * @param Model $model
     * @param string $alternativeKeyName
     * @return bool|Model
     */
    public function getModelFromMixed($input, $model, string $alternativeKeyName = 'key')
    {
        $result = false;

        if ($input instanceof $model) {
            $result = $input;
        }

        if (is_numeric($input)) {
            $result = (new $model)::all()->where('id', '=', $input)->first();
        }

        if (is_string($input) && $this->tableHas($alternativeKeyName)) {
            $result = (new $model)::all()->where($alternativeKeyName, '=', $input)->first();
        }

        return $result;
    }
}

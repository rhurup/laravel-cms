<?php

namespace App\Traits;
use Illuminate\Database\Eloquent\Builder;

/**
 * Trait DataTables
 * This trait lifts filters off from the models.
 *
 * Example usage:
 * - $UsersFiltered = User::DataTablesFilter($Filter);
 *
 * @package App\Traits
 */
trait DataTables
{

    /**
     * Get users (or user) with datatables filters.
     *
     * @param Builder $query
     * @param object $filters
     * @return Builder
     */
    public function scopeWithDatatablesFilter(Builder $query, object $filters, $limit=true)
    {
        if(!empty($filters->select)){
            $query->select($filters->select);
        }
        if(!empty($filters->where)){
            foreach($filters->where as $where){
                $query->where($where->field, $where->operator, $where->value);
            }
        }
        if(!empty($filters->order)){
            foreach($filters->order as $order){
                $query->orderBy($order[0], $order[1]);
            }
        }

        if($limit){
            if($filters->limit_start !== false && $filters->limit_end !== false){
                $query->skip((int)$filters->limit_start)->take((int)$filters->limit_end);
            }
        }
        return $query;
    }
}

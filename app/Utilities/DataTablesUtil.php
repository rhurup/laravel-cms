<?php

namespace App\Utilities;

use Illuminate\Http\Request;

class DataTablesUtil
{
    const DEFAULT_LIMIT = 50; // 5 rows

    public static function fromInput(Request $request)
    {
        $filters = new \stdClass();
        $filters->select = [];
        $filters->where = [];
        $filters->order = [];
        $filters->limit_start = false;
        $filters->limit_end = false;

        $parameters = $request->all();

        foreach($parameters as $p_key => $p_value){
            if($p_key == 'columns') {
                foreach($p_value as $columns){
                    if(!in_array($columns['data'],$filters->select)){
                        if(trim($columns['data']) !== ''){
                            array_push($filters->select, $columns['data']);
                        }
                    }
                    if($columns['search']['value']){
                        $whereClause = new \stdClass();
                        $whereClause->field = $columns['data'];
                        $whereClause->operator = 'LIKE';
                        $whereClause->value = "%".$columns['search']['value']."%";
                        $filters->where[] = $whereClause;
                    }
                }
            }
            if($p_key == 'order'){
                foreach($p_value as $order){
                    if(isset($order['column']) && isset($order['dir'])){
                        if(isset($parameters['columns'][$order['column']])){
                            $filters->order[] = array($parameters['columns'][$order['column']]['data'], $order['dir']);
                        }
                    }
                }
            }

            if($p_key == 'start'){
                if((int)$p_value >= 0){
                    $filters->limit_start = (int)$p_value;
                }
            }
            if($p_key == 'length'){
                if((int)$p_value >= 0){
                    $filters->limit_end = (int)$p_value;
                }
            }
        }
        if(empty($filters->select)){
            $filters->select[] = '*';
        }

        return $filters;
    }
}

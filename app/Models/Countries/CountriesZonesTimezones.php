<?php

namespace App\Models\Countries;

use App\Models\BaseModel;
use App\Traits\DataTables;
use Illuminate\Database\Eloquent\SoftDeletes;

class CountriesZonesTimezones extends BaseModel
{
    use SoftDeletes, DataTables;
    /**
     * @var string
     */
    protected $table = 'countries_zones_timezone';

}

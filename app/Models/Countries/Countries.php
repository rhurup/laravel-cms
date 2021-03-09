<?php

namespace App\Models\Countries;

use App\Models\BaseModel;
use App\Traits\DataTables;
use Illuminate\Database\Eloquent\SoftDeletes;

class Countries extends BaseModel
{
    use SoftDeletes, DataTables;
    /**
     * @var string
     */
    protected $table = 'countries';

    protected $fillable = [
        'code',
        'country',
        'currency_align',
        'currency_code',
        'currency_name',
        'currency_symbol',
        'dec_point',
        'iso_639_1',
        'iso_639_2b',
        'iso_639_2t',
        'iso_639_3',
        'iso_639_6',
        'iso_code',
        'phone_code',
        'thousands_sep'
    ];

    public function languages(){
        return $this->hasMany(CountriesLanguages::class, 'country_id', 'id');
    }

    public function timezones(){
        return $this->hasMany(CountriesZones::class, 'country_id', 'id');
    }

}

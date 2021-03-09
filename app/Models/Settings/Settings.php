<?php

namespace App\Models\Settings;

use App\Models\Acl\AclRole;
use App\Models\BaseModel;
use App\Traits\DataTables;
use App\Traits\ModelActionsBy;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Settings extends BaseModel
{
    use SoftDeletes, ModelActionsBy, DataTables;
    /**
     * @var string
     */
    protected $table = 'settings';


    protected $fillable = [
        'key',
        'value',
        'description',
    ];


    public static function getValue($key, $default = '')
    {
        $value = Cache::rememberForever('settings_'.$key, function () use ($key, $default) {
            $settingvalue = Settings::where("key", $key)->first()->value;
            if($settingvalue == null){
                return $default;
            }else{
                return $settingvalue;
            }
        });
        return $value;
    }
}

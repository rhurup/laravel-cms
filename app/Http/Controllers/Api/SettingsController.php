<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\Api\NotAuthorizedException;
use App\Exceptions\Api\NotFoundException;
use App\Http\Responses\JsonResponse;
use App\Models\Settings\Settings;
use App\Traits\DataTables;
use App\Utilities\DataTablesUtil;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

/**
 * @group Users
 *
 * API endpoints for user - Authenticated request requires a 'Authorization' => 'Bearer {api_token}'
 *
 *
 */
class SettingsController extends Controller
{
    public $PermissionGroup = 'settings';

    use DataTables;

    /**
     * settings
     *
     * Get info for the user of the current api token
     *
     * @authenticated
     * @response 200 { "status": 200, "message": "", "data": {"user":"....."} }
     * @response 401 { "status": 401, "message": "Unauthorized", "data": [] }
     */
    public function index(Request $request)
    {
        $this->init('browse');

        $filters = DataTablesUtil::fromInput($request);

        $recordsTotal = Settings::all()->count();
        $recordsFiltered = Settings::withDatatablesFilter($filters, false)->count();
        $Settings = Settings::withDatatablesFilter($filters)->get();

        return (new JsonResponse($Settings))
            ->add("recordsTotal", $recordsTotal)
            ->add("recordsFiltered", $recordsFiltered);
    }

    /**
     * settings/{id}
     *
     * Get info for the timezone
     *
     * @authenticated
     * @response 200 { "status": 200, "message": "", "data": {"user":"....."} }
     * @response 401 { "status": 401, "message": "Unauthorized", "data": [] }
     */
    public function show(Request $request, $id)
    {
        $this->init('browse');

        $Settings = Settings::find($id);

        if(!$Settings){
            throw new NotFoundException();
        }

        return new JsonResponse($Settings);
    }
    /**
     * settings
     *
     * Update setting
     *
     * @authenticated
     * @response  200 { "status": 200, "message": "", "data": {"user":"....."} }
     * @response  401 { "status": 401, "message": "Unauthorized", "data": [] }
     */
    public function update(Request $request)
    {
        $this->init('update');

        $defaultSettings = $request->post("default");
        $customSettings = $request->post("custom");

        foreach($defaultSettings as $defaultSettingKey => $defaultSetting){
            $setting = Settings::where("key", "default.".$defaultSettingKey)->first();
            $setting->value = $defaultSetting;
            $setting->save();
            if($setting->wasChanged()){
                // @todo - clear cache
            }
        }
        foreach($customSettings as $customSettingKey => $customSetting){
            $setting = Settings::find($customSettingKey);

            if($setting == null){ // Creating
                $setting = new Settings();
                $setting->key           = $customSetting["key"];
                $setting->value         = $customSetting["value"];
                $setting->description   = $customSetting["description"];
                $setting->save();
            }else{
                $setting->key           = $customSetting["key"];
                $setting->value         = $customSetting["value"];
                $setting->description   = $customSetting["description"];
                $setting->save();
            }
        }
        $Settings = Settings::all();

        return new JsonResponse($Settings);
    }
    /**
     * settings/{id}
     *
     * Delete setting
     *
     * @authenticated
     * @response  200 { "status": 200, "message": "", "data": {"user":"....."} }
     * @response  401 { "status": 401, "message": "Unauthorized", "data": [] }
     */
    public function destroy(Request $request, $id)
    {
        $this->init('update');

        $Settings = Settings::find($id);

        if($Settings->locked){
            throw new NotAuthorizedException();
        }

        if(!$Settings){
            throw new NotFoundException();
        }

        $Settings->delete();

        return new JsonResponse([]);
    }
}

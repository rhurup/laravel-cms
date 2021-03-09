<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\Api\NotFoundException;
use App\Http\Responses\JsonResponse;
use App\Models\Countries\CountriesZones;
use App\Models\Countries\CountriesZonesTimezones;
use App\Models\Users\User;
use App\Models\Users\UserEmails;
use App\Services\Models\UserService;
use App\Traits\DataTables;
use App\Utilities\DataTablesUtil;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

/**
 * @group Users
 *
 * API endpoints for user - Authenticated request requires a 'Authorization' => 'Bearer {api_token}'
 *
 *
 */
class TimezonesController extends Controller
{
    public $PermissionGroup = 'timezones';

    use DataTables;

    /**
     * timezones
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

        if(empty($filters->order)){
            $filters->order[] = ['zone_name', "ASC"];
        }

        $recordsTotal = CountriesZones::all()->count();
        $recordsFiltered = CountriesZones::withDatatablesFilter($filters, false)->count();
        $Timezones = CountriesZones::withDatatablesFilter($filters)->with('countries')->get();

        return (new JsonResponse($Timezones))
            ->add("recordsTotal", $recordsTotal)
            ->add("recordsFiltered", $recordsFiltered);
    }

    /**
     * timezones/{id}
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

        $Timezones = CountriesZones::find($id);

        if(!$Timezones){
            throw new NotFoundException();
        }

        return new JsonResponse($Timezones);
    }
    /**
     * timezones/{id}
     *
     * Update timezone
     *
     * @authenticated
     * @response  200 { "status": 200, "message": "", "data": {"user":"....."} }
     * @response  401 { "status": 401, "message": "Unauthorized", "data": [] }
     */
    public function update(Request $request, $id)
    {
        $this->init('update');

        $Timezones = CountriesZones::find($id);

        if(!$Timezones){
            throw new NotFoundException();
        }

        $Timezones->update($request->all());

        return new JsonResponse($Timezones);
    }
    /**
     * timezones/{id}
     *
     * Delete timezone
     *
     * @authenticated
     * @response  200 { "status": 200, "message": "", "data": {"user":"....."} }
     * @response  401 { "status": 401, "message": "Unauthorized", "data": [] }
     */
    public function destroy(Request $request, $id)
    {
        $this->init('update');

        $Timezones = CountriesZones::find($id);

        if(!$Timezones){
            throw new NotFoundException();
        }

        $Timezones->delete();

        return new JsonResponse([]);
    }

}

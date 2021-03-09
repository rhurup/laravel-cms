<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\Api\NotFoundException;
use App\Http\Responses\JsonResponse;
use App\Models\Countries\Countries;
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
class CountriesController extends Controller
{
    public $PermissionGroup = 'countries';

    use DataTables;

    /**
     * countries
     *
     *
     *
     * @authenticated
     * @response 200 { "status": 200, "message": "", "data": {"user":"....."} }
     * @response 401 { "status": 401, "message": "Unauthorized", "data": [] }
     */
    public function index(Request $request)
    {
        $this->init('browse');

        $filters = DataTablesUtil::fromInput($request);

        $recordsTotal = Countries::all()->count();
        $recordsFiltered = Countries::withDatatablesFilter($filters, false)->get()->count();
        $Countries = Countries::withDatatablesFilter($filters)->get();

        return (new JsonResponse($Countries))
            ->add("recordsTotal", $recordsTotal)
            ->add("recordsFiltered", $recordsFiltered);
    }

    /**
     * countries/{id}
     *
     * Get info for the country
     *
     * @authenticated
     * @response 200 { "status": 200, "message": "", "data": {"user":"....."} }
     * @response 401 { "status": 401, "message": "Unauthorized", "data": [] }
     */
    public function show(Request $request, $id)
    {
        $this->init('browse');

        $Country = Countries::with(['languages','timezones'])->find($id);

        if(!$Country){
            throw new NotFoundException();
        }

        return new JsonResponse($Country);
    }
    /**
     * countries/{id}
     *
     * Update country
     *
     * @authenticated
     * @response  200 { "status": 200, "message": "", "data": {"user":"....."} }
     * @response  401 { "status": 401, "message": "Unauthorized", "data": [] }
     */
    public function update(Request $request, $id)
    {
        $this->init('update');

        $Country = Countries::find($id);

        if(!$Country){
            throw new NotFoundException();
        }

        $Country->update($request->all());

        return new JsonResponse($Country);
    }
    /**
     * countries/{id}
     *
     * Delete country
     *
     * @authenticated
     * @response  200 { "status": 200, "message": "", "data": {"user":"....."} }
     * @response  401 { "status": 401, "message": "Unauthorized", "data": [] }
     */
    public function destroy(Request $request, $id)
    {
        $this->init('update');

        $Country = Countries::find($id);

        if(!$Country){
            throw new NotFoundException();
        }

        $Country->delete();

        return new JsonResponse([]);
    }

}

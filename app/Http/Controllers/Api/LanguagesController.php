<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\Api\NotFoundException;
use App\Http\Responses\JsonResponse;
use App\Models\Countries\CountriesLanguages;
use App\Traits\DataTables;
use App\Utilities\DataTablesUtil;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * @group Languages
 *
 * API endpoints for languages - Authenticated request requires a 'Authorization' => 'Bearer {api_token}'
 *
 *
 */
class LanguagesController extends Controller
{
    public $PermissionGroup = 'languages';

    use DataTables;

    /**
     * languages
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
            $filters->order[] = ['lang', "ASC"];
        }

        $recordsTotal = CountriesLanguages::all()->count();
        $recordsFiltered = CountriesLanguages::withDatatablesFilter($filters, false)->count();
        $Languages = CountriesLanguages::withDatatablesFilter($filters)->with('countries')->get();

        return (new JsonResponse($Languages))
            ->add("recordsTotal", $recordsTotal)
            ->add("recordsFiltered", $recordsFiltered);
    }

    /**
     * languages/{id}
     *
     * Get info for the language
     *
     * @authenticated
     * @response 200 { "status": 200, "message": "", "data": {"user":"....."} }
     * @response 401 { "status": 401, "message": "Unauthorized", "data": [] }
     */
    public function show(Request $request, $id)
    {
        $this->init('browse');

        $Languages = CountriesLanguages::find($id);

        if(!$Languages){
            throw new NotFoundException();
        }

        return new JsonResponse($Languages);
    }
    /**
     * languages/{id}
     *
     * Update language
     *
     * @authenticated
     * @response  200 { "status": 200, "message": "", "data": {"user":"....."} }
     * @response  401 { "status": 401, "message": "Unauthorized", "data": [] }
     */
    public function update(Request $request, $id)
    {
        $this->init('update');

        $Languages = CountriesLanguages::find($id);

        if(!$Languages){
            throw new NotFoundException();
        }

        $Languages->update($request->all());

        return new JsonResponse([]);
    }
    /**
     * languages/{id}
     *
     * Delete language
     *
     * @authenticated
     * @response  200 { "status": 200, "message": "", "data": {"user":"....."} }
     * @response  401 { "status": 401, "message": "Unauthorized", "data": [] }
     */
    public function destroy(Request $request, $id)
    {
        $this->init('update');

        $Languages = CountriesLanguages::find($id);

        if(!$Languages){
            throw new NotFoundException();
        }

        $Languages->delete();

        return new JsonResponse([]);
    }

}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CompanyRequest;
use App\Helpers\ApiHelper;
use App\Helpers\Constants;
use App\Models\Company;
use Carbon\Carbon;
use Storage;
use DB;
use Log;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Company::paginate(Constants::DEFAULT_PER_PAGE);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request)
    {
        $currentTime = Carbon::now()->timestamp;
        $logopath = null;

        if ($request->logo) {
            $logopath =  Constants::LOGO_FILE_PATH . $currentTime . '_' . $request->logo->getClientOriginalName();
        }

        DB::beginTransaction();
        try {
            if ($request->logo) {
                Storage::disk('public')->put($logopath, file_get_contents($request->logo->getRealPath()));
            }

            $company = Company::create([
                'name' => $request->name,
                'email' => $request->email,
                'logo' => $logopath ? config('filesystems.disks.public.url') . $logopath : null,
                'website' => $request->website
            ]);

            DB::commit();

            return ApiHelper::apiResponse(Constants::HTTP_RESPONSE_SUCCESSFULLY, 'Create Company Successfully!', $company);
        } catch (\Exception $e) {
            DB::rollback();
            if ($request->logo) {
                Storage::disk('public')->delete([$logopath]);
            }
            Log::info($e);

            return ApiHelper::apiResponse(Constants::HTTP_RESPONSE_SOMETHING_WENT_WRONG, 'Something went wrong!', null);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        return ApiHelper::apiResponse(Constants::HTTP_RESPONSE_SUCCESSFULLY, null, $company);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyRequest $request, Company $company)
    {
        $currentTime = Carbon::now()->timestamp;
        $logopath = null;

        if ($request->logo && !is_string($request->logo)) {
            $logopath =  Constants::LOGO_FILE_PATH . $currentTime . '_' . $request->logo->getClientOriginalName();
        }

        DB::beginTransaction();
        try {
            if ($request->logo  && !is_string($request->logo)) {
                Storage::disk('public')->put($logopath, file_get_contents($request->logo->getRealPath()));
                Storage::disk('public')->delete([ApiHelper::removeDomainFromlink($company->logo)]);
            }

            $company->update([
                'name' => $request->name ? $request->name : $company->name,
                'email' => $request->email ? $request->email : $company->email,
                'logo' => $logopath ? config('filesystems.disks.public.url') . $logopath : $company->logo,
                'website' => $request->website ? $request->website : $company->website
            ]);

            DB::commit();

            return ApiHelper::apiResponse(Constants::HTTP_RESPONSE_SUCCESSFULLY, 'Update Company Successfully!', $company);
        } catch (\Exception $e) {
            DB::rollback();
            Log::info($e);

            return ApiHelper::apiResponse(Constants::HTTP_RESPONSE_SOMETHING_WENT_WRONG, 'Something went wrong!', null);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        Storage::disk('public')->delete([ApiHelper::removeDomainFromlink($company->logo)]);
        $company->delete();

        return ApiHelper::apiResponse(Constants::HTTP_RESPONSE_SUCCESSFULLY, 'Delete Company Successfully!', null);
    }
}

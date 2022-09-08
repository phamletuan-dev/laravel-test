<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use Illuminate\Http\Request;
use App\Helpers\ApiHelper;
use App\Helpers\Constants;
use App\Models\Employee;
use App\Models\Company;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Employee::with('company')->paginate(Constants::DEFAULT_PER_PAGE);
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
    public function store(EmployeeRequest $request)
    {
        if (!Company::where('id', $request->company_id)->exists()) {
            return ApiHelper::apiResponse(Constants::HTTP_RESPONSE_NOT_FOUND, 'Company not found!', null);
        }

        $employee = Employee::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'company_id' => $request->company_id,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return ApiHelper::apiResponse(Constants::HTTP_RESPONSE_SUCCESSFULLY, 'Create Employee Successfully!', $employee);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        
        
        return ApiHelper::apiResponse(Constants::HTTP_RESPONSE_SUCCESSFULLY, null, $employee);
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
    public function update(EmployeeRequest $request, Employee $employee)
    {
        if (!Company::where('id', $request->company_id)->exists()) {
            return ApiHelper::apiResponse(Constants::HTTP_RESPONSE_NOT_FOUND, 'Company not found!', null);
        }

        $employee = $employee->update($request->all());

        return ApiHelper::apiResponse(Constants::HTTP_RESPONSE_SUCCESSFULLY, 'Update Employee Successfully!', $employee);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return ApiHelper::apiResponse(Constants::HTTP_RESPONSE_SUCCESSFULLY, 'Delete Employee Successfully!', null);
    }
}

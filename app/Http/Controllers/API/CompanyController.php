<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Company;
use App\Http\Resources\CompanyResource;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Company::latest()->get();
        return response()->json([CompanyResource::collection($data)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'desc' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $company = Company::create([
            'name' => $request->name,
            'desc' => $request->desc
        ]);

        return response()->json(['Company created successfully.', new CompanyResource($company)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $company = Company::find($id);
        if (is_null($company)) {
            return response()->json('Data not found', 404);
        }
        return response()->json([new CompanyResource($company)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'desc' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $company->name = $request->name;
        $company->desc = $request->desc;
        $company->save();

        return response()->json(['Company updated successfully.', new CompanyResource($company)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $company->delete();

        return response()->json('Company deleted successfully');
    }
}

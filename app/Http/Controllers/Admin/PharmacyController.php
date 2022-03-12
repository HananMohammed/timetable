<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PharmacyRequest;
use App\Http\Resources\Admin\PharmacyResource;
use App\Models\Pharmacy;
use Illuminate\Http\Request;

class PharmacyController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:read pharmacies|create pharmacies|update pharmacies|delete pharmacies', ['only' => ['index','show', 'getPharmacies']]);
        $this->middleware('permission:create pharmacies', ['only' => ['store']]);
        $this->middleware('permission:update pharmacies', ['only' => ['edit','update']]);
        $this->middleware('permission:delete pharmacies', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('admin.pharmacies.index');
    }


    /**getPharmacies
     * @return mixed
     * @throws \Exception
     */
    public function getPharmacies()
    {
        $pharmacies = PharmacyResource::collection(Pharmacy::all());
        return datatables($pharmacies)->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PharmacyRequest  $request
     * @return Response
     */
    public function store(PharmacyRequest $request)
    {
        Pharmacy::create($request->all());
        return response()->json(['status'=> true, 'message'=> 'Pharmacy Stored Successfully']);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  Pharmacy $pharmacy
     * @return Response
     */
    public function edit(Pharmacy $pharmacy)
    {
        return response()->json(['status'=> true, 'message'=> 'Pharmacy returned Successfully', 'data'=>$pharmacy]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Pharmacy $pharmacy
     * @param  int  $id
     * @return Response
     */
    public function update(PharmacyRequest $request, Pharmacy $pharmacy)
    {
        $pharmacy->update($request->all());
        return response()->json(['status'=> true, 'message'=> 'Pharmacy Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Pharmacy $pharmacy
     * @return Response
     */
    public function destroy(Pharmacy $pharmacy)
    {
        $pharmacy->delete();
        return response()->json(['status'=>true,'message'=>__('Pharmacy deleted successfully')],200);
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\PharmacyResource;
use App\Http\Resources\API\TimeTableResource;
use App\Http\Traits\ResponseTrait;
use App\Models\Date;
use App\Models\Pharmacy;
use App\Models\User;
use Illuminate\Http\Request;

class UserTimetableController extends Controller
{
    use ResponseTrait;

    public function timTable(Request $request, $id){
        $timeTable = Date::filter($request)->whereUserId($id)->get();
        return $this->returnData('data', TimeTableResource::Collection($timeTable),'timeTable Returned Successfully');
    }

    public function pharmacies(){
        return $this->returnData('data', PharmacyResource::collection(Pharmacy::all()),'timeTable Returned Successfully');

    }
}

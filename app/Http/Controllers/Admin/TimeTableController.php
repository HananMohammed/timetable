<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AssignPharmacyRequest;
use App\Http\Requests\Admin\TimeTableRequest;
use App\Http\Resources\Admin\TimeTableResource;
use App\Models\Date;
use App\Models\DatePharmacies;
use App\Models\Pharmacy;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TimeTableController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:read time table|create time table|update time table|delete time table', ['only' => ['index','show', 'timeTable']]);
        $this->middleware('permission:create time table', ['only' => ['store']]);
        $this->middleware('permission:update time table', ['only' => ['edit','update']]);
        $this->middleware('permission:delete time table', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the timetable.
     *
     * @return view
     */
    public function index()
    {
        $users = User::select('id', 'name')->whereStatus(1)->get();
        $pharmacies = Pharmacy::select('id', 'name')->whereStatus(1)->get();
        return view('admin.timetables.index', get_defined_vars());
    }

    public function timeTable(){
        $users = TimeTableResource::collection(Date::all());
        return datatables($users)->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TimeTableRequest  $request
     * @return Response
     */
    public function store(TimeTableRequest $request)
    {
        $rangeDates = $request->except('user_id');
        $dates = rangePeriodDates($rangeDates);
        foreach ($dates as $date)
            Date::updateOrCreate(['user_id'=> $request->user_id, 'date' => $date]);

        return response()->json(['status'=> true, 'message'=> 'timeTable Stored Successfully']);
    }

    /**
     * @param AssignPharmacyRequest $request
     */
    public function assignPharmaciesToDate(AssignPharmacyRequest $request){
        $from = explode(' ', $request->time_from);
        $to = explode(' ', $request->time_to);

        foreach ($request->pharmacy_id as $pharmacy_id){
            DatePharmacies::updateOrCreate(
                [ 'time_from' => $from[0], 'time_to' => $to[0], 'from_slot' => $from[1], 'to_slot' => $to[1] ],
                [ 'date_id'=> $request->date_id, 'pharmacy_id' => $pharmacy_id ]
            );
        }
        return response()->json(['status'=> true, 'message'=> 'Day Pharmacies Assigned Successfully']);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $nowDate = Carbon::now();
        $date = Date::find($id);
        if($nowDate->lt($date->date)){
            $datePharmacies = $date->datePharmacies()->get();
            if(!empty($datePharmacies)){
                foreach ($datePharmacies as $datePharmacy)
                    $datePharmacy->delete();
            }
            $date->delete();
            return response()->json(['status'=>true,'message'=>__('TimeTable Date deleted successfully')],200);
        }else{
            return response()->json(['false'=>true,'message'=>__('Cant Delete Old Date')],200);

        }
    }
}

<?php

namespace App\Http\Resources\API;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TimeTableResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|
     */
    public function toArray($request)
    {
        $pharmaciesAndTime = $this->pharmacies->map(function($item, $key){
            return [
                'time_slot' => "[ {$item->time_from} {$item->from_slot} -  {$item->time_to} {$item->to_slot} ]" ,
                'pharmacy' => $item->pharmacy->name,
                'pharmacy_id' => $item->pharmacy->id
            ];
        });
        return [
            'id' => $this->id,
            'date_name' => Carbon::parse($this->date)->format('l'),
            'date' => $this->date,
            'pharmacies' =>$pharmaciesAndTime
        ];
    }
}

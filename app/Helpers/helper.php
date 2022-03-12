<?php

use Carbon\CarbonPeriod;

if(!function_exists('adminDbTablesPermissions')){
    /**
     * @return mixed
     */
    function adminDbTablesPermissions(){

        return [ 'admins','users','roles', 'pharmacies' ,'time table'];
    }
}

if(!function_exists('rangePeriodDates')){
    /**
     * @return mixed
     */
    function rangePeriodDates($rangeDates):array{
        $output =[];
        $rangePeriods = CarbonPeriod::create($rangeDates['start_date'], $rangeDates['end_date']);
        foreach ($rangePeriods as $date) {
            $date = $date->format('Y-m-d');
            array_push($output, $date);
        }
        return $output;
    }
}



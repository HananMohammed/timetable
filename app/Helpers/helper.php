<?php
if(!function_exists('adminDbTablesPermissions')){
    /**
     * @return mixed
     */
    function adminDbTablesPermissions(){

        return [ 'admins','users','roles'];
    }
}

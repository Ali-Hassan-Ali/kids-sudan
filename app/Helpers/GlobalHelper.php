<?php

if (!function_exists('permission_admin')) {
    function permissionAdmin($permission = '')
    {

        if (auth('admin')->check()) {
            return auth('admin')->user()->can($permission);
        }
        return false;

    }//en dof fun

 }//end of exists

if (!function_exists('isInvalid')) {
    function isInvalid($key, $index)
    {

        if (!empty($errors)) {
            
            return $errors?->getMessages()[$key][$index] ?? false;

        } else {
            
            return false;

        }

    }//en dof fun

 }//end of exists


 if(!function_exists('getLanguages')) {
 	
 	function getLanguages($default = false)
 	{
        if($default) {

            return \App\Models\Language::where('default', 1)->first();

        } else {

            return \App\Models\Language::all();

        }

 	}//en dof fun

 }//end of exists
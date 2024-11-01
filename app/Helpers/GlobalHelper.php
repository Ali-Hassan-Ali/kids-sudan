<?php

use \App\Services\DataTables\Actions\ActionBuilderServices;
use \App\Services\DataTables\DatatableServices;
use \App\Services\Settings\SettingsServices;
use \App\Models\Language;

if (!function_exists('permission_admin')) {
    
    function permissionAdmin(string $permission = ''): bool
    {
        return auth('admin')->check() ? auth('admin')->user()->can($permission) : false;

    }//en dof fun

 }//end of exists

if (!function_exists('isInvalid')) {

    function isInvalid(string $key, string | int $index): string | bool
    {
        return !empty($errors) ? ($errors?->getMessages()[$key][$index] ?? false) : false;

    }//en dof fun

 }//end of exists


 if(!function_exists('getLanguages')) {
 	
 	function getLanguages(bool $default = false): object
 	{
        return $default ? Language::where('default', 1)->first() : Language::all();

 	}//end of fun

 }//end of exists


if (!function_exists('datatableServices')) {
    
    function datatableServices(): DatatableServices
    {
        return new DatatableServices();

    }//end of fun

 }//end of exists

 if (!function_exists('datatableAction')) {
    
    function datatableAction($model, $permissions): ActionBuilderServices
    {
        return new ActionBuilderServices($model, $permissions);

    }//end of fun

 }//end of exists

 if (!function_exists('setting')) {
    
    function setting(string $key = ''): SettingsServices
    {
        return new SettingsServices($key);

    }//end of fun

 }//end of exists
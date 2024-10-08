<?php

namespace App\Enums\Admin;

enum StatusType: string
{
    case ACTIVE   = 1;
    case INACTIVE = 0;

    public static function array(): array
    {
    	return [
    		true  => trans('admin.global.inactive'),
    		false => trans('admin.global.active'),
    	];

    }//end of fun

}//end of enum
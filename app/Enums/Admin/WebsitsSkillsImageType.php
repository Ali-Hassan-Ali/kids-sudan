<?php

namespace App\Enums\Admin;

enum WebsitsSkillsImageType: string
{
    case FONT  = 'font';
    case IMAGE = 'image';
    case SVG   = 'svg';

    public static function array(): array
    {
    	return [
    		'image' => trans('admin.files.image'),
    		'font'  => trans('admin.files.font'),
    		'svg'   => trans('admin.files.svg'),
    	];

    }//end of fun

}//end of enum
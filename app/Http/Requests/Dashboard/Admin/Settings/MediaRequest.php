<?php

namespace App\Http\Requests\Dashboard\Admin\Settings;

use Illuminate\Validation\Rule;
use App\Enums\Admin\WebsitsSkillsImageType;
use Illuminate\Foundation\Http\FormRequest;

class MediaRequest extends FormRequest
{
	public function authorize(): bool
    {
        return permissionAdmin('create-settings');

    }//end of authorize

    public function rules(): array
    {
        return [
            'social_types.*'  => ['required', 'string', Rule::enum(WebsitsSkillsImageType::class), 'min:2', 'max:5'],
        	'social_icons.*'  => ['required', 'string'],
            'social_links.*'  => ['required', 'url'],
            'social_status.*' => ['boolean'],
        ];

    }//end of rules

    public function attributes(): array
    {
        return [
            'social_icons.*'    => trans('admin.global.icon'),
            'social_typs.*'     => trans('admin.global.type'),
            'social_links.*'    => trans('admin.global.links'),
            'social_status.*'   => trans('admin.global.status'),
        ];

    }//end of attributes

}//end of class
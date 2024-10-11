<?php

namespace App\Http\Requests\Dashboard\Admin\Websites;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Enums\Admin\WebsitsToolsImageType;

class ToolsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return permissionAdmin('read-tools');

    }//end of authorize

    public function rules(): array
    {    
        $rules = [];

        foreach(getLanguages() as $index=>$language) {

            $rules['tools_type_icon.' . $language->code . '.*']    = ['required','string',Rule::enum(WebsitsToolsImageType::class),'min:2','max:5'];
            $rules['tools_icon.' . $language->code . '.*']         = ['required'];
            $rules['tools_title.' . $language->code . '.*']  	   = ['required','string','min:2','max:150'];
            $rules['tools_description.' . $language->code . '.*']  = ['required','string'];
        }

        return $rules;

    }//end of rules

    public function attributes(): array
    {
        $rules = [];

        foreach(getLanguages() as $language) {

            $rules['tools_type_icon.' . $language->code . '.*']   = trans('admin.global.by', ['name' => trans('admin.global.type'), 'lang' => $language->name]);
            $rules['tools_icon.' . $language->code . '.*'] 	      = trans('admin.global.by', ['name' => trans('admin.global.type'), 'lang' => $language->name]);
            $rules['tools_title.' . $language->code . '.*'] 	  = trans('admin.global.by', ['name' => trans('admin.global.title'), 'lang' => $language->name]);
            $rules['tools_description.' . $language->code . '.*'] = trans('admin.global.by', ['name' => trans('admin.global.description'), 'lang' => $language->name]);
        }

        return $rules;

    }//end of attributes

}//end of class
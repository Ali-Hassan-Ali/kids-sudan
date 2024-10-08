<?php

namespace App\Http\Requests\Dashboard\Admin\Settings;

use Illuminate\Foundation\Http\FormRequest;

class FaqRequest extends FormRequest
{

	public function authorize(): bool
    {
        return permissionAdmin('create-settings');

    }//end of authorize

    public function rules(): array
    {
        foreach(getLanguages() as $language) {

        	$rules['faq_title.' . $language->code . '.*'] 	   = ['required','string','min:2','max:150'];
        	$rules['faq_status.' . $language->code . '.*']     = ['boolean'];
            $rules['faq_description.' . $language->code . '.*']= ['required','string','min:2'];
        }

        return $rules;

    }//end of rules

    public function attributes(): array
    {
        $rules = [];

        foreach(getLanguages() as $language) {

            $rules['faq_title.' . $language->code . '.*']       = trans('admin.global.by', ['name' => trans('admin.global.title'), 'lang' => $language->name]);
            $rules['faq_status.' . $language->code . '.*']      = trans('admin.global.by', ['name' => trans('admin.global.title'), 'lang' => $language->name]);
            $rules['faq_description.' . $language->code . '.*'] = trans('admin.global.by', ['name' => trans('admin.global.description'), 'lang' => $language->name]);
        }

        return $rules;

    }//end of attributes

    // protected function prepareForValidation()
    // {
    //     return $this->merge([
    //         // 'faq_status.*.*'=> request()->has('status'),
    //     ]);

    // }//end of prepare for validation

}//end of class
<?php

namespace App\Http\Requests\Dashboard\Admin\Settings;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return permissionAdmin('create-banner');

    }//end of authorize

    public function rules(): array
    {
        $rules = [];

        $rules['meta_logo'] = ['nullable','image'];

        foreach(getLanguages() as $language) {

            $rules['meta_title.' . $language->code]       = ['required','string','min:2','max:150'];
            $rules['meta_description.' . $language->code] = ['required','string','min:2'];
            $rules['meta_keywords.' . $language->code]    = ['required','array'];
        }

        return $rules;

    }//end of rules

    public function attributes(): array
    {
        $rules = [];

        $rules['meta_logo'] = trans('admin.global.logo');

        foreach(getLanguages() as $language) {

            $rules['meta_title.' . $language->code]       = trans('admin.global.by', ['name' => trans('admin.global.title'), 'lang' => $language->name]);
            $rules['meta_description.' . $language->code] = trans('admin.global.by', ['name' => trans('admin.global.description'), 'lang' => $language->name]);
            $rules['meta_keywords.' . $language->code]    = trans('admin.global.by', ['name' => trans('admin.global.keywords'), 'lang' => $language->name]);
        }

        return $rules;

    }//end of attributes

}//end of class
<?php

namespace App\Http\Requests\Dashboard\Admin\Websites;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return permissionAdmin('read-banner');

    }//end of authorize

    public function rules(): array
    {   
        $rules = [];

        $rules['banner_picture'] = ['nullable','image'];

        foreach(getLanguages() as $language) {

            $rules['banner_welcome.' . $language->code]     = ['required','string','min:2','max:150'];
            $rules['banner_hello.' . $language->code]       = ['required','string','min:2'];
            $rules['banner_name.' . $language->code]        = ['required','string','min:2'];
            $rules['banner_Skills.' . $language->code]      = ['required','array'];

            $rules['banner_rxperiences_title.' . $language->code . '.*']   = ['required','string','min:2','max:150'];
            $rules['banner_rxperiences_number.' . $language->code . '.*']  = ['required','numeric','digits_between:1,100'];
        }

        return $rules;

    }//end of rules

    public function attributes(): array
    {
        $rules = [];

        $rules['banner_picture'] = trans('admin.global.picture');

        foreach(getLanguages() as $language) {

            $rules['banner_welcome.' . $language->code] = trans('admin.global.by', ['name' => trans('admin.websites.banners.welcome'), 'lang' => $language->name]);
            $rules['banner_hello.' . $language->code]   = trans('admin.global.by', ['name' => trans('admin.websites.banners.hello'), 'lang' => $language->name]);
            $rules['banner_name.' . $language->code]    = trans('admin.global.by', ['name' => trans('admin.websites.banners.name'), 'lang' => $language->name]);
            $rules['banner_Skills.' . $language->code]  = trans('admin.global.by', ['name' => trans('admin.websites.banners.Skills'), 'lang' => $language->name]);

            $rules['banner_rxperiences_title.' . $language->code . '.*']  = trans('admin.global.by', ['name' => trans('admin.global.title'), 'lang' => $language->name]);
            $rules['banner_rxperiences_number.' . $language->code . '.*'] = trans('admin.global.by', ['name' => trans('admin.global.number'), 'lang' => $language->name]);
        }

        return $rules;

    }//end of attributes

}//end of class
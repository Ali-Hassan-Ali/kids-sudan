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

        $rules['banner_picture'] = ['required','image'];

        foreach(getLanguages() as $language) {

            $rules['banner_welcome.' . $language->code]     = ['required','string','min:2','max:150'];
            $rules['banner_hello.' . $language->code]       = ['required','string','min:2'];
            $rules['banner_name.' . $language->code]        = ['required','string','min:2'];
            $rules['banner_Skills.' . $language->code]      = ['required','array'];

            $rules['banner_rxperiences_title_' . $language->code . '.*']      = ['required','string','min:2','max:150'];
            $rules['banner_rxperiences_description_' . $language->code . '.*']= ['required','string','min:2'];
        }

        return $rules;

    }//end of rules

    public function attributes(): array
    {
        $rules = [];

        $rules['banner_picture'] = trans('admin.global.picture');

        foreach(getLanguages() as $language) {

            $rules['banner_welcome.' . $language->code] = trans('admin.global.by', ['name' => trans('admin.websits.banners.welcome'), 'lang' => $language->name]);
            $rules['banner_hello.' . $language->code]   = trans('admin.global.by', ['name' => trans('admin.websits.banners.hello'), 'lang' => $language->name]);
            $rules['banner_name.' . $language->code]    = trans('admin.global.by', ['name' => trans('admin.websits.banners.name'), 'lang' => $language->name]);
            $rules['banner_Skills.' . $language->code]  = trans('admin.global.by', ['name' => trans('admin.websits.banners.Skills'), 'lang' => $language->name]);

            $rules['banner_rxperiences_title_' . $language->code . '.*']       = trans('admin.global.by', ['name' => trans('admin.global.title'), 'lang' => $language->name]);
            $rules['banner_rxperiences_description_' . $language->code . '.*'] = trans('admin.global.by', ['name' => trans('admin.global.description'), 'lang' => $language->name]);
        }

        return $rules;

    }//end of attributes

}//end of class
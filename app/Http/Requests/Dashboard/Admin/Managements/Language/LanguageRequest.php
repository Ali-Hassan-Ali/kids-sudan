<?php

namespace App\Http\Requests\Dashboard\Admin\Managements\Language;

use Illuminate\Foundation\Http\FormRequest;
use CodeZero\UniqueTranslation\UniqueTranslationRule;
use Illuminate\Validation\Rule;

class LanguageRequest extends FormRequest
{

	public function authorize(): bool
    {
        return in_array(request()->method(), ['PUT', 'PATCH']) ? permissionAdmin('update-languages') : permissionAdmin('create-languages');

    }//end of authorize

    public function rules(): array
    {
        $rules = [
            'status'  => ['boolean'],
            'admin_id'=> ['nullable','exists:admins,id'],
            'dir'     => ['required', 'in:RTL,LTR'],
        ];

        if (in_array(request()->method(), ['PUT', 'PATCH'])) {
            
            $language = request()->route()->parameter('language');

            $rules['name'] = ['required','string','min:2','max:20', Rule::unique('languages')->ignore($language->id)];
            $rules['code'] = ['required','string','min:2','max:6', Rule::unique('languages')->ignore($language->id)];
            $rules['flag'] = ['nullable','image'];

        } else {

            $rules['name'] = ['required','string','min:2','max:20', 'unique:languages'];
            $rules['code'] = ['required','string','min:2','max:6', 'unique:languages'];
            $rules['flag'] = ['required','image'];

        } //end of if

        return $rules;

    }//end of rules

    public function attributes(): array
    {
        return [
            'name'   => trans('admin.global.name'), 
            'status' => trans('admin.global.status'), 
            'dir'    => trans('admin.managements.languages.dir'), 
            'code'   => trans('admin.managements.languages.code'), 
            'flag'   => trans('admin.managements.languages.flag'), 
        ];

    }//end of attributes

    protected function prepareForValidation()
    {
        return $this->merge([
            'admin_id' => auth('admin')->id(),
            'status'   => request()->has('status'),
        ]);

    }//end of prepare for validation

}//end of class
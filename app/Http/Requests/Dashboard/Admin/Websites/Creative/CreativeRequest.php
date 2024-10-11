<?php

namespace App\Http\Requests\Dashboard\Admin\Websites\Creative;

use Illuminate\Foundation\Http\FormRequest;
use CodeZero\UniqueTranslation\UniqueTranslationRule;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class CreativeRequest extends FormRequest
{
	public function authorize(): bool
    {
    	return in_array(request()->method(), ['PUT', 'PATCH']) ? permissionAdmin('update-creatives') : permissionAdmin('create-creatives');

    }//end of authorize

    public function rules(): array
    {
        $rules = [
            'status'   => ['boolean'],
            'links.*'  => ['required','url'],
            'admin_id' => ['nullable','exists:admins,id'],
        ];

        if (in_array(request()->method(), ['PUT', 'PATCH'])) {

            $creative = request()->route()->parameter('creative');

            $rules['name']  = ['required','string','min:2','max:30', Rule::unique('creatives')->ignore($creative->id)];
            $rules['image'] = ['nullable','image'];
            $rules['date']  = ['nullable','date'];

        } else {

            $rules['name']  = ['required','string','unique:creatives','min:2','max:30'];
            $rules['image'] = ['required','image'];
            $rules['date']  = ['required','date'];

        } //end of if

        return $rules;

    }//end of rules

    public function attributes(): array
    {
        return [
            'name'    => trans('admin.global.name'),
            'status'  => trans('admin.global.status'),
            'image'   => trans('admin.global.image'),
            'links.*' => trans('admin.global.links')
        ];

    }//end of attributes

    protected function prepareForValidation()
    {
        return $this->merge([
            'admin_id' => auth('admin')->id(),
            'status'   => request()->has('status'),
        ]);

    }//end of prepare For Validation

}//end of class
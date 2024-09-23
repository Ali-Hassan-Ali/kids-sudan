<?php

namespace App\Http\Requests\Dashboard\Admin\Auth\Account;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
{
	public function authorize(): bool
    {
        return auth('admin')->check();

    }//end of authorize

    public function rules(): array
    {
        $admin = auth('admin')->id();

        $rules = [
            'name'  => ['required','string','min:2','max:30', Rule::unique('admins')->ignore((int) $admin)],
            'email' => ['required','email','min:2','max:30', Rule::unique('admins')->ignore((int) $admin)],
            'image' => ['nullable','image'],
            // 'phone' => ['numeric','digits_between:6,30'],
        ];

        return $rules;

    }//end of rules

    public function attributes(): array
    {
        return [
            'name'  => trans('admin.global.name'),
            'email' => trans('admin.global.email'),
            'image' => trans('admin.global.image'),
            'phone' => trans('admin.global.phone'),
        ];

    }//end of attributes

}//end of class
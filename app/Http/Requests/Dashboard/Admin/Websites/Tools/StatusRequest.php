<?php

namespace App\Http\Requests\Dashboard\Admin\Websites\Tools;

use Illuminate\Foundation\Http\FormRequest;

class StatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return permissionAdmin('status-tools');

    }//end of authorize

    public function rules(): array
    {
        return [
            'id' => ['required', 'numeric', 'exists:tools,id'],
        ];

    }//end of rules

    public function attributes(): array
    {
        return [
            'id' => trans('admin.global.item'),
        ];        

    }//end of attributes

}//end of class
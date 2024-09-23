<?php

namespace App\Http\Requests\Dashboard\Admin\Settings;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{

	public function authorize(): bool
    {
        return permissionAdmin('create-settings');

    }//end of authorize

    public function rules(): array
    {
        $rules = [
        	'contact_phone'    		=> ['required', 'string', 'min:2', 'max:50'],
            'contact_whatsapp'      => ['required', 'string', 'min:2', 'max:50'],
        	'contact_email'    		=> ['required', 'email', 'min:2', 'max:50'],
        	'contact_address'  		=> ['required', 'string', 'min:2', 'max:255'],
        	'contact_address_link'  => ['required', 'string', 'url'],
        ];

        return $rules;

    }//end of rules

    public function attributes(): array
    {
        $rules = [
            'contact_phone'       => trans('admin.settings.contacts.phone'),
            'contact_whatsapp'    => trans('admin.settings.contacts.whatsapp'),
            'contact_email'       => trans('admin.settings.contacts.email'),
            'contact_address'     => trans('admin.settings.contacts.address'),
            'contact_address_link'=> trans('admin.settings.contacts.address_link'),
        ];

        return $rules;

    }//end of attributes

}//end of class
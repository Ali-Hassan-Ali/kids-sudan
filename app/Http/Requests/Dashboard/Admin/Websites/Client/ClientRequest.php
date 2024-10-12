<?php

namespace App\Http\Requests\Dashboard\Admin\Websites\Client;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Enums\Admin\WebsitsSkillsImageType;
use CodeZero\UniqueTranslation\UniqueTranslationRule;

class ClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return in_array(request()->method(), ['PUT', 'PATCH']) ? permissionAdmin('update-clients') : permissionAdmin('create-clients');

    }//end of authorize

    public function rules(): array
    {
        $rules = [
            'status'    => ['boolean'],
            'admin_id'  => ['nullable','exists:admins,id'],
            // 'links.*'   => ['nullable', 'array'],
        ];

        if (in_array(request()->method(), ['PUT', 'PATCH'])) {

        	$rules['picture'] = ['nullable','image'];

            $client = request()->route()->parameter('client');

            foreach(getLanguages() as $index=>$language) {

                $rules['name.' . $language->code]         = ['required','string','min:2','max:150', UniqueTranslationRule::for('clients', 'name')->ignore($client?->id)];
                $rules['job.' . $language->code]          = ['required','string','min:2','max:150', UniqueTranslationRule::for('clients', 'job')->ignore($client?->id)];
                $rules['description.' . $language->code]  = ['required','string', UniqueTranslationRule::for('clients', 'description')->ignore($client?->id)];                
            }

        } else {

        	$rules['picture'] = ['required','image'];

            foreach(getLanguages() as $index=>$language) {

                $rules['name.' . $language->code]         = ['required','string','min:2','max:150'];
                $rules['job.' . $language->code]          = ['required','string','min:2','max:150'];
                $rules['description.' . $language->code]  = ['required','string'];
            }

        } //end of if

        return $rules;

    }//end of rules

    public function attributes(): array
    {
        $rules = [
            'picture' => trans('admin.global.picture'),
        ];

        foreach(getLanguages() as $language) {

            $rules['name.' . $language->code] 	     = trans('admin.global.by', ['name' => trans('admin.global.name'), 'lang' => $language->name]);
            $rules['job.' . $language->code] 	     = trans('admin.global.by', ['name' => trans('admin.models.job'), 'lang' => $language->name]);
            $rules['description.' . $language->code] = trans('admin.global.by', ['name' => trans('admin.global.description'), 'lang' => $language->name]);
        }

        return $rules;

    }//end of attributes

    protected function prepareForValidation()
    {
        return $this->merge([
            'admin_id' => auth('admin')->id(),
            // 'status'   => request()->has('status'),
        ]);

    }//end of prepare for validation

}//end of class
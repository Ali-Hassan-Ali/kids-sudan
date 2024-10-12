<?php

namespace App\Http\Requests\Dashboard\Admin\Websites\Volunteering;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Enums\Admin\WebsitsSkillsImageType;
use CodeZero\UniqueTranslation\UniqueTranslationRule;

class VolunteeringRequest extends FormRequest
{
    public function authorize(): bool
    {
        return in_array(request()->method(), ['PUT', 'PATCH']) ? permissionAdmin('update-volunteerings') : permissionAdmin('create-volunteerings');

    }//end of authorize

    public function rules(): array
    {
        $rules = [
            'status'    => ['boolean'],
            'date'      => ['required', 'date'],
            'admin_id'  => ['nullable','exists:admins,id'],
            // 'links.*'   => ['nullable', 'array'],
        ];

        if (in_array(request()->method(), ['PUT', 'PATCH'])) {

        	$rules['image'] = ['nullable','image'];

            $volunteering = request()->route()->parameter('volunteering');

            foreach(getLanguages() as $index=>$language) {

                $rules['title.' . $language->code]        = ['required','string','min:2','max:150', UniqueTranslationRule::for('volunteerings', 'title')->ignore($volunteering?->id)];
                $rules['job.' . $language->code]          = ['required','string','min:2','max:150', UniqueTranslationRule::for('volunteerings', 'job')->ignore($volunteering?->id)];
            }

        } else {

        	$rules['image'] = ['required','image'];

            foreach(getLanguages() as $index=>$language) {

                $rules['title.' . $language->code]        = ['required','string','min:2','max:150'];
                $rules['job.' . $language->code]          = ['required','string','min:2','max:150'];
            }

        } //end of if

        return $rules;

    }//end of rules

    public function attributes(): array
    {
        $rules = [
            'image' => trans('admin.global.image'),
            'date'  => trans('admin.global.date'),
        ];

        foreach(getLanguages() as $language) {

            $rules['title.' . $language->code] 	     = trans('admin.global.by', ['title' => trans('admin.global.title'), 'lang' => $language->title]);
            $rules['job.' . $language->code] 	     = trans('admin.global.by', ['title' => trans('admin.models.job'), 'lang' => $language->title]);
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
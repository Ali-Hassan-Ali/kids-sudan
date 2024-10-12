<?php

namespace App\Http\Requests\Dashboard\Admin\Websites\Skills;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Enums\Admin\WebsitsSkillsImageType;
use CodeZero\UniqueTranslation\UniqueTranslationRule;

class SkillsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return in_array(request()->method(), ['PUT', 'PATCH']) ? permissionAdmin('update-skills') : permissionAdmin('create-skills');

    }//end of authorize

    public function rules(): array
    {
        $rules = [
            'status'    => ['boolean'],
            'icon_type' => ['required', 'string', Rule::enum(WebsitsSkillsImageType::class), 'min:2', 'max:5'],
            'icon'      => ['required'],
            'admin_id'  => ['nullable','exists:admins,id'],
        ];

        if (in_array(request()->method(), ['PUT', 'PATCH'])) {

            $skill = request()->route()->parameter('skill');

            foreach(getLanguages() as $index=>$language) {

                $rules['title.' . $language->code]        = ['required','string','min:2','max:150', UniqueTranslationRule::for('skills', 'title')->ignore($skill?->id)];
                $rules['description.' . $language->code]  = ['required','string', UniqueTranslationRule::for('skills', 'description')->ignore($skill?->id)];
            }

        } else {

            foreach(getLanguages() as $index=>$language) {

                $rules['title.' . $language->code]        = ['required','string','min:2','max:150'];
                $rules['description.' . $language->code]  = ['required','string'];
            }

        } //end of if

        return $rules;

    }//end of rules

    public function attributes(): array
    {
        $rules = [
            'icon_type' => trans('admin.global.type'),
            'icon'      => trans('admin.files.' . request('icon_type'))
        ];

        foreach(getLanguages() as $language) {

            $rules['title.' . $language->code] 	     = trans('admin.global.by', ['name' => trans('admin.global.title'), 'lang' => $language->name]);
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
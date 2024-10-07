<?php

namespace App\Http\Requests\Dashboard\Admin\Websites;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Enums\Admin\WebsitsSkillsImageType;

class SkillsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return permissionAdmin('read-skills');

    }//end of authorize

    public function rules(): array
    {
        $rules = [];

        foreach(getLanguages() as $index=>$language) {

            $rules['skills_type_icon.' . $language->code . '.*']    = ['required','string',Rule::enum(WebsitsSkillsImageType::class),'min:2','max:5'];
            $rules['skills_icon.' . $language->code . '.*']         = ['required'];
            $rules['skills_title.' . $language->code . '.*']  		= ['required','string','min:2','max:150'];
            $rules['skills_description.' . $language->code . '.*']  = ['required','string'];
        }

        return $rules;

    }//end of rules

    public function attributes(): array
    {
        $rules = [];

        foreach(getLanguages() as $language) {

            $rules['skills_type_icon.' . $language->code . '.*']   = trans('admin.global.by', ['name' => trans('admin.global.type'), 'lang' => $language->name]);
            $rules['skills_icon.' . $language->code . '.*'] 	   = trans('admin.global.by', ['name' => trans('admin.global.type'), 'lang' => $language->name]);
            $rules['skills_title.' . $language->code . '.*'] 	   = trans('admin.global.by', ['name' => trans('admin.global.title'), 'lang' => $language->name]);
            $rules['skills_description.' . $language->code . '.*'] = trans('admin.global.by', ['name' => trans('admin.global.description'), 'lang' => $language->name]);
        }

        return $rules;

    }//end of attributes

    // public function withValidator($validator)
    // {
    //     foreach (getLanguages() as $language) {

    //         $validator->sometimes('skills_type_icon.' . $language->code . '.*', 'image', fn ($input) => $input->skills_type_icon[$language->code][0] === 'image');
    //         $validator->sometimes('skills_type_icon.' . $language->code . '.*', 'font', fn ($input) => $input->skills_type_icon[$language->code][0] === 'string');
    //         $validator->sometimes('skills_type_icon.' . $language->code . '.*', 'svg', fn ($input) => $input->skills_type_icon[$language->code][0] === 'string');

    //     }//end of each

    // }//end of fun

}//end of class
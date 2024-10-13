<?php

namespace App\Http\Requests\Dashboard\Admin\Websites\Faqs;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use CodeZero\UniqueTranslation\UniqueTranslationRule;

class FaqRequest extends FormRequest
{
    public function authorize(): bool
    {
        return in_array(request()->method(), ['PUT', 'PATCH']) ? permissionAdmin('update-faqs') : permissionAdmin('create-faqs');

    }//end of authorize

    public function rules(): array
    {
        $rules = [
            'status'    => ['boolean'],
            'admin_id'  => ['nullable','exists:admins,id'],
        ];

        if (in_array(request()->method(), ['PUT', 'PATCH'])) {

            $faq = request()->route()->parameter('faq');

            foreach(getLanguages() as $index=>$language) {

                $rules['question.' . $language->code]= ['required','string', UniqueTranslationRule::for('faqs', 'question')->ignore($faq?->id)];
                $rules['answer.' . $language->code]  = ['required','string', UniqueTranslationRule::for('faqs', 'answer')->ignore($faq?->id)];
            }

        } else {

            foreach(getLanguages() as $index=>$language) {

                $rules['question.' . $language->code]= ['required','string','min:2','max:150'];
                $rules['answer.' . $language->code]  = ['required','string'];
            }

        } //end of if

        return $rules;

    }//end of rules

    public function attributes(): array
    {
        $rules = [];

        foreach(getLanguages() as $language) {

            $rules['question.' . $language->code] = trans('admin.global.by', ['name' => trans('admin.websites.faqs.question'), 'lang' => $language->name]);
            $rules['answer.' . $language->code]   = trans('admin.global.by', ['name' => trans('admin.websites.faqs.answer'), 'lang' => $language->name]);
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
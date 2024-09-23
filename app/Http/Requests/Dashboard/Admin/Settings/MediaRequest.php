<?php

namespace App\Http\Requests\Dashboard\Admin\Settings;

use Illuminate\Foundation\Http\FormRequest;

class MediaRequest extends FormRequest
{
	public function authorize(): bool
    {
        return permissionAdmin('create-settings');

    }//end of authorize

    public function rules(): array
    {
        $rules = [
        	'media_facebook'        => ['nullable', 'string', 'url'],
        	'media_twitter'         => ['nullable', 'string', 'url'],
        	'media_instagram'       => ['nullable', 'string', 'url'],
        	'media_video_links'     => ['nullable', 'string', 'url'],
            'media_google_play'     => ['nullable', 'string', 'url'],
            'media_apple_store'     => ['nullable', 'string', 'url'],
        ];

        return $rules;

    }//end of rules

    public function attributes(): array
    {
        $rules = [
            'media_facebook'        => trans('admin.strings.medias.facebook'),
            'media_twitter'         => trans('admin.strings.medias.twitter'),
            'media_instagram'       => trans('admin.strings.medias.instagram'),
            'media_video_links'     => trans('admin.strings.medias.video_links'),
            'media_google_play'     => trans('admin.strings.medias.google_play'),
            'media_apple_store'     => trans('admin.strings.medias.apple_store'),
        ];

        return $rules;

    }//end of attributes

}//end of class
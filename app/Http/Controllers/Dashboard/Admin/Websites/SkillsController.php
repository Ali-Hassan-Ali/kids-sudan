<?php

namespace App\Http\Controllers\Dashboard\Admin\Websites;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Admin\Websites\SkillsRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\View\View;
use App\Enums\Admin\WebsitsSkillsImageType;

class SkillsController extends Controller
{
    public function index()
    {
        abort_if(!permissionAdmin('read-skills'), 403);

        $imageTypes = WebsitsSkillsImageType::array();

        $breadcrumb = [
            ['trans' => 'admin.models.websits'],
            ['trans' => 'admin.websits.banners.skills']
        ];

    	return view('dashboard.admin.websits.skills.index', compact('breadcrumb', 'imageTypes'));

    }//end of index

    public function store(SkillsRequest $request)
    {
        if (!empty($request->get('skills_title')[getLanguages('default')->code]) || !empty($request->get('skills_description')[getLanguages('default')->code])) {

            $skillsIconType    = [];
            $skillsIcon        = [];
            $skillsTitle       = [];
            $skillsDescription = [];
            
            foreach($request->get('skills_title')[getLanguages('default')->code] as $indexName=>$name) {

                $skillsLangIconType    = [];
                $skillsLangIcon        = [];
                $skillsLangTitle       = [];
                $skillsLangDescription = [];

                foreach(getLanguages() as $index=>$language) {

                    $skillsLangIconType[$language->code]    = $request->get('skills_type_icon')[$language->code][$indexName] ?? $request->get('skills_type_icon')[getLanguages('default')->code][$indexName];
                    $skillsLangIcon[$language->code]        = $request->get('skills_icon')[$language->code][$indexName] ?? $request->get('skills_icon')[getLanguages('default')->code][$indexName];
                    $skillsLangTitle[$language->code]       = $request->get('skills_title')[$language->code][$indexName] ?? $request->get('skills_title')[getLanguages('default')->code][$indexName];
                    $skillsLangDescription[$language->code] = $request->get('skills_description')[$language->code][$indexName] ?? $request->get('skills_description')[getLanguages('default')->code][$indexName];;
                }

                $skillsIconType[]    = $skillsLangIconType;
                $skillsIcon[]        = $skillsLangIcon;
                $skillsTitle[]       = $skillsLangTitle;
                $skillsDescription[] = $skillsLangDescription;

            }

            $data = [
                'skills_type_icon'   => $skillsIconType,
                'skills_icon'        => $skillsIcon,
                'skills_title'       => $skillsTitle,
                'skills_description' => $skillsDescription,
            ];

            saveSetting('skills', json_encode($data));

        } else {

            saveSetting('skills', json_encode([]));

        }

        session()->flash('success', __('admin.messages.updated_successfully'));
        return redirect()->back();

    }//end of index

}//end of controller
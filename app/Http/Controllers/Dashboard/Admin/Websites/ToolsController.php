<?php

namespace App\Http\Controllers\Dashboard\Admin\Websites;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Admin\Websites\ToolsRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\View\View;
use App\Enums\Admin\WebsitsToolsImageType;

class ToolsController extends Controller
{
    public function index()
    {
        abort_if(!permissionAdmin('read-tools'), 403);

        $imageTypes = WebsitsToolsImageType::array();

        $breadcrumb = [
            ['trans' => 'admin.models.websits'],
            ['trans' => 'admin.websits.tools']
        ];

    	return view('dashboard.admin.websits.tools.index', compact('breadcrumb', 'imageTypes'));

    }//end of index

    public function store(ToolsRequest $request)
    {
        if (!empty($request->get('tools_title')[getLanguages('default')->code]) || !empty($request->get('tools_description')[getLanguages('default')->code])) {

            $toolsIconType    = [];
            $toolsIcon        = [];
            $toolsTitle       = [];
            $toolsDescription = [];
            
            foreach($request->get('tools_title')[getLanguages('default')->code] as $indexName=>$name) {

                $toolsLangIconType    = [];
                $toolsLangIcon        = [];
                $toolsLangTitle       = [];
                $toolsLangDescription = [];

                foreach(getLanguages() as $index=>$language) {

                    $toolsLangIconType[$language->code]    = $request->get('tools_type_icon')[$language->code][$indexName] ?? $request->get('tools_type_icon')[getLanguages('default')->code][$indexName];
                    $toolsLangIcon[$language->code]        = $request->get('tools_icon')[$language->code][$indexName] ?? $request->get('tools_icon')[getLanguages('default')->code][$indexName];
                    $toolsLangTitle[$language->code]       = $request->get('tools_title')[$language->code][$indexName] ?? $request->get('tools_title')[getLanguages('default')->code][$indexName];
                    $toolsLangDescription[$language->code] = $request->get('tools_description')[$language->code][$indexName] ?? $request->get('tools_description')[getLanguages('default')->code][$indexName];;
                }

                $toolsIconType[]    = $toolsLangIconType;
                $toolsIcon[]        = $toolsLangIcon;
                $toolsTitle[]       = $toolsLangTitle;
                $toolsDescription[] = $toolsLangDescription;

            }

            $data = [
                'tools_type_icon'   => $toolsIconType,
                'tools_icon'        => $toolsIcon,
                'tools_title'       => $toolsTitle,
                'tools_description' => $toolsDescription,
            ];

            saveSetting('tools', json_encode($data));

        } else {

            saveSetting('tools', json_encode([]));

        }

        session()->flash('success', __('admin.messages.updated_successfully'));
        return redirect()->back();

    }//end of index

}//end of controller
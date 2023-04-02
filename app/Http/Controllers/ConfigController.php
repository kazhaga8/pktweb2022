<?php

namespace App\Http\Controllers;

use App\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConfigController extends Controller
{
    function __construct()
    {
        //  $this->middleware('permission:config-list', ['only' => ['index','show']]);
        //  $this->middleware('permission:config-edit', ['only' => ['edit','update']]);
    }

    public function edit(Config $config){
        $page['page'] = 'configs';
        $page['can'] = 'page';
        $page['title'] = 'Web Config Management';
        $page['method'] = 'PUT';
        $page['action'] = route('configs.update',$config->id);
        return view('webmin.configs.index',compact('page', 'config'));
    }

    public function update(Request $request, Config $config)
    {
        request()->validate([
            'main_logo' => 'required',
            'secondary_logo' => 'required',
            'content_footer_en' => 'required',
            'content_footer_id' => 'required',
            'content_shortcut_en' => 'required',
            'content_shortcut_id' => 'required',
            'lang' => 'required',
            'fallback_locale' => 'required',
        ]);
        $store  = $request->all();
        if (!in_array($store['fallback_locale'],  $store['lang'])) {
            return redirect()->back()->withErrors(['fallback_locale' => ['The default language is not in the active language.']]);
        }
        Config::where('id', 1)
            ->update([
                'main_logo' => $store['main_logo'],
                'secondary_logo' => $store['secondary_logo'],
                'content_footer_en' => $store['content_footer_en'],
                'content_footer_id' => $store['content_footer_id'],
                'content_shortcut_en' => $store['content_shortcut_en'],
                'content_shortcut_id' => $store['content_shortcut_id'],
                'lang' => $store['lang'],
                'fallback_locale' => $store['fallback_locale'],
                'meta_title' => $store['meta_title'],
                'meta_desc' => $store['meta_desc'],
                'meta_keyword' => $store['meta_keyword'],
            ]);
        return redirect()->route('configs.index')
                        ->with('success','Config updated successfully');
    }
}

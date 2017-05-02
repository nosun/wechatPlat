<?php

namespace Share\Http\Controllers;

use Illuminate\Http\Request;
use Share\Searches\InfoTypeSearch;
use Share\Searches\CopyfromSearch;
use DB;

class SiteController extends Controller
{
    public function linkList()
    {
        $infotypes = InfoTypeSearch::instance()->where('mid', 11)->orderBy('myorder asc')->get();
        $linkTypes = config('cwzg.linkTypes');
        foreach($infotypes as $key => $infotype){
            $infotype->url = url("type/".$infotype->tpath);
            $infotype->copyfroms = CopyfromSearch::instance()->where('ttid', $infotype->typeid)->limit(15)->orderBy('weight asc')->get();
            $infotype->class = '';
            if(isset($linkTypes[$infotype->tname])){
                $infotype->class = $linkTypes[$infotype->tname];
            }
        }

        return view('link', [
            'infotypes' => $infotypes,
        ]);
    }

    public function link($linkpath)
    {
        $infotype = InfoTypeSearch::instance()->where('tpath', $linkpath)->first();
        if(!$infotype){
           return redirect('/404.html');
        }

        $linkTypes = config('cwzg.linkTypes');
        if(isset($linkTypes[$infotype->tname])){
            $infotype->class = $linkTypes[$infotype->tname];
        }
        $infotype->copyfroms = CopyfromSearch::instance()->where('ttid', $infotype->typeid)->orderBy('weight asc')->get();
        return view('content-link', [
            'infotype' => $infotype,
        ]);
    }


    public function copyfromSave(Request $request){
        $post = $request->all();
        $post = array_map('trim', $post);
        $post = array_map('htmlspecialchars', $post);

        $copyfromClass = DB::table('cwcms_enewsclass')->where('classid', '11')->first();

        $time = time();
        $indexData = [
            'classid' => 11,
            'checked' => 0,
            'newstime' => $time,
            'truetime' => $time,
            'lastdotime' => $time,
            'havehtml' => 0,
        ];
        $id = DB::table('cwcms_ecms_copyfrom_index')->insertGetId($indexData);

        $mainData = [
            'id' => $id,
            'ttid' => $post['ttid'],
            'title' => $post['title'],
            'smalltext' => $post['smalltext'],
            'titleurl' => $post['titleurl'],
            'publicno' => $post['publicno'],
            'titlepic' => $post['titlepic'],
            'classid' => 11,
            'newspath' => date($copyfromClass->newspath, $time),
            'newstime' => $time,
            'truetime' => $time,
            'lastdotime' => $time,
            'filename' => $id,
            'ispic' => !empty($post['titlepic']) ? 1 : 0,
            'isurl' => !empty($post['titleurl']) ? 1 : 0,
            'ishot' => 0,
        ];
        DB::table('cwcms_ecms_copyfrom_check')->insert($mainData);

        $sideData = [
            'id' => $id,
            'classid' => '11',
        ];
        DB::table('cwcms_ecms_copyfrom_check_data')->insert($sideData);

        $allinfos = DB::table('cwcms_ecms_copyfrom_index')->count();
        $infos = DB::table('cwcms_ecms_copyfrom')->count();
        DB::table('cwcms_enewsclass')->where('classid', '11')->update(['allinfos'=>$allinfos, 'infos'=>$infos]);
        return redirect()->back()->with('success', '您的网站信息已经录入成功，请耐心等待管理员审核！');
    }

    public function notFound(){
        return view('404');
    }
}

<?php

namespace Share\Http\Controllers;

use Illuminate\Http\Request;
use Share\Models\Article;
use Share\Models\WechatSite;
use Illuminate\Pagination\LengthAwarePaginator;
use DB;

class WechatSiteController extends Controller
{
    public function index(Request $request){

        $path = '/sites';
        $arguments = $request->all();

        $page = isset($arguments['page']) ? $arguments['page'] : 1;

        unset($arguments['_token']);
        unset($arguments['page']);

        $sites = new WechatSite();

        foreach($arguments as $key => $val){
            if($val == -1){
                continue;
            }

            if($key == "key"){
                $searchKey = $val;
                continue;
            }

            if(isset($searchKey) && $key == "keywords"){
                $sites = $sites->where($searchKey,'like',"%$val%");
            }else{
                $sites = $sites->where($key, '=',$val);
            }

        }

        $query = http_build_query($arguments);
        $path .= '?'.$query;

        $pageSize = 100;

        $count  = $sites->count();
        $sites = $sites->orderBy('elite','desc')->orderBy('id','desc')->skip(($page-1) * $pageSize)->take($pageSize)->get();

        foreach($sites as $site){
            $res = DB::table('wx_article')->select(DB::raw('max(date) as updated'))->where('biz',$site->biz)->first();
            if($res){
                $site->lastUpdated = $res->updated;
            }
        }

        $paginator = new LengthAwarePaginator($sites, $count, $pageSize, $page);
        $paginator->setPath(url($path));

        return view("site.list")
            ->with('sites',$sites)
            ->with('page',$paginator)
            ->with('option',$arguments);
    }

    public function show($id){
        $site = WechatSite::find($id);
        return view("site.show")->with('article',$site);
    }
}

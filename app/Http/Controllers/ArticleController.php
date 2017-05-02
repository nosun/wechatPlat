<?php

namespace Share\Http\Controllers;

use Illuminate\Http\Request;
use Share\Models\Article;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Session;
use Sunra\PhpSimple\HtmlDomParser;
use DB;

class ArticleController extends Controller
{

    public function index(Request $request){

        $path = '/articles';
        $arguments = $request->all();

        $page = isset($arguments['page']) ? $arguments['page'] : 1;

        unset($arguments['_token']);
        unset($arguments['page']);

        $authors = DB::table('wx_article')->select('author')->distinct()->get();

        $article = new Article();

        foreach($arguments as $key => $val){
            if($val == -1){
                continue;
            }

            if($key == "key"){
                $searchKey = $val;
                continue;
            }

            if(isset($searchKey) && $key == "keywords"){
                $article = $article->where($searchKey,'like',"%$val%");
            }else{
                $article = $article->where($key, '=',$val);
            }

        }

        $query = http_build_query($arguments);
        $path .= '?'.$query;

        $pageSize = 15;

        $count  = $article->count();
        $articles = $article->orderBy('date','desc')->skip(($page-1) * $pageSize)->take($pageSize)->get();

        $paginator = new LengthAwarePaginator($articles, $count, $pageSize, $page);
        $paginator->setPath(url($path));

        return view("article.list")
                ->with('articles',$articles)
                ->with('page',$paginator)
                ->with('option',$arguments)
                ->with('authors',$authors);
    }

    public function show($id){
        $article = Article::find($id);
        $content = $article->content->content;
        $dom = HtmlDomParser::str_get_html($content);
        $images = $dom->find('img');

        foreach($images as $image){
            if($src = $image->getAttribute('data-src')){
                $image->setAttribute('src', $src);
            }
        }

        $article->content = (string)$dom;
        return view("article.show")->with('article',$article);
    }
}

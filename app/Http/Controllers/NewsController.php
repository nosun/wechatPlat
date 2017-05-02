<?php

namespace Share\Http\Controllers;

use Illuminate\Http\Request;
use Share\Searches\ArticleSearch;
use Share\Tools\Pagination;
use Share\Searches\AuthorSearch;

class NewsController extends Controller
{
    public function authorArticleList($authorName, $page=1){
        $author = AuthorSearch::instance()->where('filename', $authorName)->first();
        $page404 = config('cwzg.siteUrl').'/404.html';
        if(!$author){
            return redirect($page404);
        }

        $db = ArticleSearch::instance()->author($author->title);
        $pageRow = config('cwzg.pageRow');
        $count = $db->count();
        $pageNum = ceil($count/$pageRow);
        $articles = $db->page($page, $pageRow)->orderBy('newstime desc')->get();

        $hotArticles = ArticleSearch::instance()
            ->author($author->title)
            ->orderBy('onclick desc, newstime desc')
            ->limit(2)
            ->get();
        $recommendArticles = ArticleSearch::instance()
            ->author($author->title)
            ->where('newstime', '>', strtotime('-1 month'))
            ->orderBy('isgood desc,newstime desc')
            ->limit(2)
            ->get();


        $pagination = New Pagination($articles, $pageNum, $page);
        $pagination->setPath(url('/column/'.$author->filename.'/index_{page}.html'));

        $sitename = config('cwzg.sitename');
        $title = $author->title.'-'.$sitename;
        $description = $author->smalltext;
        return view('content-author', [
            'title' => $title,
            'description' => $description,
            'author' => $author,
            'hotArticles'=>$hotArticles,
            'recommendArticles'=>$recommendArticles,
            'pagination' => $pagination
        ]);
    }

    public function authorList(){
        $authors = AuthorSearch::instance()->get();
        return view('list-author', [
            'authors' => $authors
        ]);
    }
}

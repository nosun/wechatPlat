<?php

namespace Share\Http\ViewComposers;

use Illuminate\View\View;
use Share\Searches\ArticleSearch;
use Share\Searches\CopyfromSearch;

class LinkFooterComposer{

    public function compose(View $view)
    {
        $newArticles = ArticleSearch::instance()->orderBy('newstime desc')->limit(5)->get();
        $hotArticle = ArticleSearch::instance()->orderBy('onclick desc')->limit(5)->get();
        $linkCount = CopyfromSearch::instance()->count();
        $updatetime = CopyfromSearch::instance()->max('lastdotime');

        $view->with('newArticles', $newArticles);
        $view->with('hotArticle', $hotArticle);
        $view->with('linkCount', $linkCount);
        $view->with('updatetime', $updatetime);
    }
}
<?php

namespace Share\Http\ViewComposers;

use Illuminate\View\View;
use Share\Searches\InfoTypeSearch;

class LinkHeaderComposer{

    public function compose(View $view)
    {
        $infotypes = InfoTypeSearch::instance()->where('mid', 11)->orderBy('myorder asc')->get();
        $linkNav = [];
        foreach($infotypes as $key => $infotype){
            $infotype->url = url("type/".$infotype->tpath);
            $linkNav[] = $infotype;
        }

        $view->with('linkNav', $linkNav);
        $view->with('infotypes', $infotypes);
    }
}
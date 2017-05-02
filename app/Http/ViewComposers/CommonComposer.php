<?php

namespace Share\Http\ViewComposers;
use Illuminate\View\View;

class CommonComposer{

    public function compose(View $view)
    {   $title_common = config('cwzg.sitename');
        $keywords_common= config('cwzg.keywords');
        $description_common = config('cwzg.description');
        $copyright = config('cwzg.copyright');
        $siteUrl = config('cwzg.siteUrl');
        $sitename = config('cwzg.sitename');
        $serviceLink = config('cwzg.serviceLink');

        $view->with('title_common', $title_common);
        $view->with('keywords_common', $keywords_common);
        $view->with('description_common', $description_common);
        $view->with('copyright', $copyright);
        $view->with('siteUrl', $siteUrl);
        $view->with('sitename', $sitename);
        $view->with('serviceLink', $serviceLink);
    }
}
<?php

namespace Share\Http\Controllers;

use Illuminate\Http\Request;
use Share\Tools\Ajax;
use Sunra\PhpSimple\HtmlDomParser;
use GuzzleHttp\Client;

class ApiController extends Controller
{
    public function WechatArticleCollect(Request $request){
        if(!isset($request->url)){
            return Ajax::argumentsError('Url is required!');
        }

        $client = new Client();
        $response = $client->request('GET', $request->url);
        $bodys = HtmlDomParser::str_get_html($response->getBody())->find('body');
        if(empty($bodys)){
            return Ajax::argumentsError('Html does have a body');
        }
        $body = $bodys[0];

        $article = [];
        $titles = $body->find('.rich_media_title');
        if(!empty($titles)){
            $article['title'] = trim(strip_tags($titles[0]->innertext()));
        }

        $mediaMetaLinks = $body->find('.rich_media_meta_link');
        if(!empty($mediaMetaLinks)){
            $mediaMetaLink = $mediaMetaLinks[0];
            $article['fromurl'] = trim($mediaMetaLink->getAttribute('href'));
            $article['copyfrom'] = trim(strip_tags($mediaMetaLink->innertext()));
        }

        $mediaMetaTexts = $body->find('.rich_media_meta_text');
        foreach($mediaMetaTexts as $metaText){
            if($metaText->nodeName() == 'em' && $metaText->getAttribute('id') != 'post-date'){
                $article['author'] = trim(strip_tags($metaText->innertext()));
            }
        }

        $contents = $body->find('.rich_media_content');
        if(!empty($contents)){
            $content = $contents[0];
            $images = $content->find('img');
            foreach($images as $image){
                if($src = $image->getAttribute('data-src')){
                    $image->setAttribute('src', $src);
                }
            }
            $article['newstext'] = trim($contents[0]->innertext());
        }
        return Ajax::success($article);
    }
}

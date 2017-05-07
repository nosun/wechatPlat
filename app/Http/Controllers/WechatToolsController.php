<?php

namespace Share\Http\Controllers;

use Illuminate\Http\Request;

class WechatToolsController extends Controller
{
    public function editor(){
        return view('tools.editor');
    }
}

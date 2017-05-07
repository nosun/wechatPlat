<?php

namespace Share\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function page404 () {
        return "not found";
    }
}

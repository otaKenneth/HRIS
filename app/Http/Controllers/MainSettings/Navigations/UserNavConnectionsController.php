<?php

namespace App\Http\Controllers\MainSettings\Navigations;

use App\Http\Controllers\Controller;
use App\Models\Navigation\UsersNavigations;
use Illuminate\Http\Request;

class UserNavConnectionsController extends Controller
{
    //
    function index() {
        $main_navs = UsersNavigations::all();

        return view('mainsettings.navigations.navigations', compact('main_navs'));
    }
}

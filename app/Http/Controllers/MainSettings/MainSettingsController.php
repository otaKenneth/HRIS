<?php

namespace App\Http\Controllers\MainSettings;

use App\Http\Controllers\Controller;
use App\Models\Navigation\UsersSubNavigations;
use Illuminate\Http\Request;

class MainSettingsController extends Controller
{
    //
    public function index() {
        $navigations = UsersSubNavigations::where('main_nav_id', 5)->get();

        return view('mainsettings', compact('navigations'));
    }
}

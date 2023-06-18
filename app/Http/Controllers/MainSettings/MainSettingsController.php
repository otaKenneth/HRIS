<?php

namespace App\Http\Controllers\MainSettings;

use App\Http\Controllers\Controller;
use App\Models\Navigation\SubLevelNavigations;
use Illuminate\Http\Request;

class MainSettingsController extends Controller
{
    //
    public function index() {
        $navigations = SubLevelNavigations::where('sub_nav_id', 14)->get();

        return view('mainsettings', compact('navigations'));
    }
}

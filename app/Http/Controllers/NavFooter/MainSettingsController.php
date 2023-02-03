<?php

namespace App\Http\Controllers\NavFooter;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MainSettingsController extends Controller
{
    public function __construct()
    {
        
    }

    public function index()
    {
        $this->authorize('viewAny', auth()->user());
        return view('navfooter.mainSettings');
    }
}

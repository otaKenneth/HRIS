<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        // dd(getdate());
        // $m_date = getdate()['month'] ." ". getdate()['mday'] .", ". getdate()['year'];
        $m_date = date('M d, Y');
        return view('home', compact('m_date'));
    }

    public function logout () 
    {
        auth()->user()->inouts()->create([
            'type' => 1,
            'from' => 'webapp'
        ]);

        Auth::logout();

        return redirect('/login');
    }
}

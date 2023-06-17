<?php

namespace App\Http\Controllers;

use App\Holiday;
use App\Models\Request\Leave;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index ()
    {
        $today = date('Y');
        $leaves = Leave::where('from', 'like', "$today%")->orWhere('to', 'like', "$today%")->get();
        $holidays = Holiday::where('from', 'like', "$today%")->orWhere('to', 'like', "$today%")->get();
        $events = [];
        foreach ($leaves as $key => $value) {
            $user = $value->user()->first();
            $title = "$value->type Request : $user->lastname, $user->firstname";
            $events[] = [
                'name' => $title,
                'start' => $value->from,
                'end' => $value->to,
                'color' => ($value->type == "SL") ? "#9ae6b4":"#b794f4",
                'textColor' => "#000",
            ];
        }
        foreach ($holidays as $key => $value) {
            $events[] = [
                'name' => $value->title,
                'start' => $value->from,
                'end' => $value->to,
                'color' => $value->bg,
                'textColor' => $value->color,
            ];
        }
        // dd($events);
        $events = json_encode($events);

        return view('calendar', compact('events'));
    }
}

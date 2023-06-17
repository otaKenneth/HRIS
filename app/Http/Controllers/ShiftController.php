<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Shift;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    public function __construct()
    {
        $this->check = ['in', 'breakOut', 'breakIn', 'out'];
    }

    public function index (Request $request)
    {
        $this->authorize('viewAny', User::class);
        $shifts = [];
        if ($request['search']) {
            $search = $request['search'];
            $shifts = Shift::where('code', 'like', "%$search%")->orWhere([
                ['in', 'like', "%$search%", 'or'],
                ['breakOut', 'like', "%$search%", 'or'],
                ['breakIn', 'like', "%$search%", 'or'],
                ['out', 'like', "%$search%", 'or']
            ])->get();
            // dd($shifts);
        }else{
            $shifts = Shift::all();
        }

        // $shifts = $this->toHiFormat($shifts, $this->check);

        return view('admin.shift.index', compact('shifts'));
    }

    public function store (Request $request) 
    {
        $this->authorize('create', User::class);
        $data = $this->validate($request, [
            'code' => 'required|string|unique:shifts',
            'opentime' => 'boolean',
            'breaks' => 'boolean',
            'in' => 'nullable|date_format:H:i',
            'breakIn' => 'nullable|date_format:H:i',
            'breakOut' => 'nullable|date_format:H:i',
            'out' => 'nullable|date_format:H:i',
        ]);
        
        Shift::create($data);
    }

    public function update (Request $request, Shift $shift) 
    {
        $this->authorize('update', auth()->user());

        $data = $this->validate($request, [
            'opentime' => 'boolean',
            'breaks' => 'boolean',
            'in' => 'nullable|date_format:H:i',
            'breakIn' => 'nullable|date_format:H:i',
            'breakOut' => 'nullable|date_format:H:i',
            'out' => 'nullable|date_format:H:i',
        ]);

        $shift->update($data);
    }

    public function delete (Shift $shift) 
    {
        $this->authorize('delete', auth()->user());
        $shift->delete();
    }

    public function list () {
        $shifts = Shift::all();

        return response($shifts);
    }

    private function toHiFormat($arr, $needles, $opt = null)
    {
        foreach ($arr as $key => $value) {
            foreach ($needles as $index => $needle) {
                if (strpos($needle, '.') > -1) {
                    $temp = explode('.', $needle);
                    $this->toHiFormat($value[$temp[0]], [$temp[2]]);
                } else {
                    $arr[$key][$needle] = ($value[$needle] == null || $value[$needle] == "" || $value[$needle] == "00:00") ? null : date('h:i a', strtotime($value[$needle]));
                }
            }
        }

        return $arr;
    }
}

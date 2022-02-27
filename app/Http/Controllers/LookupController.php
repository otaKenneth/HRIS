<?php

namespace App\Http\Controllers;

use App\Lookup;
use Illuminate\Http\Request;

class LookupController extends Controller
{
    //
    public function index ()
    {
        return view('admin.extras.lookup');
    }

    public function lookups()
    {
        $lookups = Lookup::all();

        return response($lookups);
    }

    public function getPrettyLookups () {
        $lookups = [];
        $lookup_keys = Lookup::all('key');
        foreach ($lookup_keys as $key) { 
            $lookups[$key['key']] = Lookup::where('key', $key['key'])->orderBy('index')->get();
        }
        $lookups = json_encode($lookups);

        return response($lookups);
    }

    public function store(Request $request)
    {
        $request['label'] = ucwords(strtolower($request['label']), " ");
        $request['key'] = strtolower($request['key']);
        $request['value'] = ucwords(strtolower($request['value']), " ");

        $data = $this->validate($request, [
            'label' => 'required|string',
            'key' => 'required|string',
            'value' => 'required|string|unique:lookups',
            'index' => 'required|integer',
        ]);

        $this->updateLookupIndex($data['key'], $data['index']);

        Lookup::create($data);

        $lookup[$request['key']] = Lookup::where('key', $request['key'])->orderBy('index')->get();

        return response($lookup);
    }

    private function updateLookupIndex($key, $index)
    {
        $lookups = Lookup::where('key', $key)->where('index', '>=', $index)->orderBy('index')->get();

        foreach ($lookups as $lookup) {
            $index++;
            Lookup::where('id', $lookup['id'])->update(
                ['index' => $index]
            );
        }
    }

    public function update(Request $request, Lookup $lookup)
    {

        $request['label'] = ucwords(strtolower($request['label']), " ");
        $request['key'] = strtolower($request['key']);
        $request['value'] = ucwords(strtolower($request['value']), " ");

        $data = $this->validate($request, [
            'label' => 'required|string',
            'key' => 'required|string',
            'value' => 'required|string',
            'index' => 'required|integer',
        ]);

        $lookup->update($data);

        $lookups = Lookup::all();

        return response($lookups);
    }

    public function destroy(Lookup $lookup) {
        $lookup->delete();

        $lookups = Lookup::all();
        return response($lookups);
    }
}

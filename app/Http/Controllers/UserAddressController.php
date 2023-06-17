<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\UserAddress;
use Illuminate\Http\Request;

class UserAddressController extends Controller
{
    //
    public function store (Request $request, User $employee)
    {
        $data = $this->validate($request, [
            'user_id' => 'required|integer',
            'type' => 'required|integer',
            'address' => 'required|string',
            'town' => 'required|integer',
            'province' => 'required|integer',
            'country' => 'required|string',
        ]);
        
        $employee->addresses()->create($data);
    }

    public function update (Request $request, User $employee, UserAddress $address) 
    {
        $data = $this->validate($request, [
            'type' => 'integer',
            'address' => 'string',
            'town' => 'integer',
            'province' => 'integer',
            'country' => 'string',
        ]);

        $address->update($data);
    }
}

<?php

namespace App\Exports;

use App\User;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromArray
{
    private $ids;

    public function __construct(Array $ids)
    {
        $this->ids = $ids;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
        $users = User::whereIn('id', $this->ids)->get()->load('position', 'status', 'user_level', 'gender', 'nationality', 'religion', 'cstatus')->toArray();
        $exportable = [];
        // dump($users->toArray());
        [$exportable[0], $temp] = Arr::divide($users[0]);
        Arr::forget($exportable[0], [38, 39, 40]);
        // array_shift($users);
        foreach ($users as $key => $user) {
            $value = $user;
            $value['cstatus'] = $user['cstatus']['value'];
            $value['gender'] = $user['gender']['value'];
            $value['religion'] = $user['religion']['value'];
            $value['nationality'] = $user['nationality']['value'];
            $value['job_position'] = $user['position']['value'];
            $value['job_status'] = $user['status']['value'];
            $value['userlvl'] = $user['user_level']['value'];
            $value['emp_status'] = ['Employed', 'Resigned'][$user['emp_status']];
            Arr::forget($value, 'position');
            Arr::forget($value, 'status');
            Arr::forget($value, 'user_level');
            $exportable[] = $value;
        }
        // dd($exportable);
        // return $users;
        return $exportable;
    }
}

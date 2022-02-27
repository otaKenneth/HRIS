<?php

namespace App\Imports;

use App\Lookup;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class UsersImport implements ToCollection, WithCustomCsvSettings, WithChunkReading , ShouldQueue
{
    public function __construct()
    {
        $this->check = ['birthdate', 'hire_date', 'training_start', 'training_evaluation', 'probi_start', 'probi_evaluation', 'reg_start', 'reg_end'];
        $this->toTitle = ['firstname', 'middlename', 'lastname'];
    }

    public function collection(Collection $rows)
    {
        $keys = []; $value = [];
        foreach ($rows as $key => $row) {
            $value = Arr::flatten($row);
            if ($key == 0) {
                if ($row[0] == 'id') {
                    $keys = $value;
                    continue;
                }
            }else{
                if (count($keys) == 0) break;
            }
            $user = array_combine($keys, $value);
            $user = $this->fix($user);
            Arr::forget($user, 'created_at');
            Arr::forget($user, 'updated_at');
            // dump($user);
            $check = User::find($user['id']);
            if ($check) {
                $check->update($user);
            }else{
                $user['password'] = Hash::make("default");
                User::create($user);
            }
        }
    }

    public function getCsvSettings(): array
    {
        return [
            'input_encoding' => 'ISO-8859-1'
        ];
    }

    public function chunkSize(): int
    {
        return 10;
    }

    private function fix($user)
    {
        $user = $this->titleCase($user);
        $user = $this->lookups($user);
        $user = $this->toDBDate($user);
        return $user;
    }

    private function titleCase($arr)
    {
        foreach ($this->toTitle as $key) {
            if (array_key_exists($key, $arr)) {
                if ($arr[$key] == null || $arr[$key] == "") {
                    $arr[$key] = null;
                } else {
                    $arr[$key] = Str::title($arr[$key]);
                }
            }
        }

        return $arr;
    }

    private function lookups($arr)
    {
        $gender = $this->createLookup('Gender', 'gender', $arr['gender']);
        $arr['gender'] = Lookup::select('id')->firstOrCreate($gender, $gender)->id;
        
        $cstatus = $this->createLookup('Civil Status', 'cstatus', $arr['cstatus']);
        $arr['cstatus'] = Lookup::select('id')->firstOrCreate($cstatus, $cstatus)->id;
        
        $nationality = $this->createLookup('Nationality', 'nationality', $arr['nationality']);
        $arr['nationality'] = Lookup::select('id')->firstOrCreate($nationality, $nationality)->id;
        
        $position = $this->createLookup('Job Position', 'job_position', $arr['job_position']);
        $arr['job_position'] = Lookup::select('id')->firstOrCreate($position, $position)->id;

        $userlvl = $this->createLookup('User Level', 'userlvl', $arr['userlvl']);
        $arr['userlvl'] = Lookup::select('id')->firstOrCreate($userlvl, $userlvl)->id;
        
        $status = $this->createLookup('Job Status', 'job_status', $arr['job_status']);
        $arr['job_status'] = Lookup::select('id')->firstOrCreate($status, $status)->id;
        
        $religion = $this->createLookup('Religion', 'religion', $arr['religion']);
        $arr['religion'] = Lookup::select('id')->firstOrCreate($religion, $religion)->id;

        $arr['emp_status'] = ['Employed' => 0, 'Resigned' => 1][$arr['emp_status']];

        return $arr;
    }

    private function createLookup ($label, $key, $value)
    {
        return [
            'label' => $label,
            'key' => $key,
            'value' => $value
        ];
    }

    private function toDBDate($arr)
    {
        foreach ($this->check as $key) {
            if (array_key_exists($key, $arr)) {
                if ($arr[$key] == null || $arr[$key] == "" || $arr[$key] == "0000-00-00") {
                    $arr[$key] = null;
                } else {
                    $arr[$key] = date('Y-m-d', strtotime($arr[$key]));
                }
            }
        }

        return $arr;
    }
}

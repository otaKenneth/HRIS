<?php

namespace App\Exports;

use App\Exports\Sheets\PatientsSheets;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

// use Maatwebsite\Excel\Concerns\FromCollection;

class PatientsExport implements WithMultipleSheets
{
    private $ids;

    public function __construct($ids)
    {
        $this->ids = $ids;
    }

    public function sheets(): array
    {
        $titles = ['patients', 'records', 'hospitalizations', 'medications', 'past_medications'];
        $sheets = [];

        foreach ($titles as $key => $title) {
            $sheets[] = new PatientsSheets($this->ids, $title);
        }

        return $sheets;
    }
}

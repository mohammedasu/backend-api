<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DataFilterExport implements FromCollection, WithHeadings
{

    protected $dataFilter;

    public function __construct($dataFilter)
    {
        $this->dataFilter = $dataFilter;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->dataFilter;
    }

    public function headings(): array
    {
        return ['mobile_number', 'fname', 'lname', 'email', 'city','speciality', 'state', 'reg_no', 'reg_state','country_code','type'];
    }
}

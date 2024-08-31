<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;

class downloadArticleUploadLog implements FromArray
{

    protected $logs;

    public function __construct($logs)
    {
        $this->logs = $logs;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function array() : array
    {
        return $this->logs;
    }
}

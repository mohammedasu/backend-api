<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CmeQuestionImport implements ToCollection, WithHeadingRow
{
    use Importable,SkipsFailures;

    public function collection(Collection $collectin){      
    }

    public function headingRow(): int
    {
        return 1;
    }

}

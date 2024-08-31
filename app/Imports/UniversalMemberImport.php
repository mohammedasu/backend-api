<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithLimit;

class UniversalMemberImport implements ToCollection, WithLimit
{
    use Importable;

    public function collection(Collection $collection)
    {
    }

    public function limit(): int
    {
        return 1;
    }
}

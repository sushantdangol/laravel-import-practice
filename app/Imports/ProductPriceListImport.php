<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;

class ProductPriceListImport implements WithHeadingRow
{
    use Importable;
}

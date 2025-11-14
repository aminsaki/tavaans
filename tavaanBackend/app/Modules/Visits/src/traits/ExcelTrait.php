<?php

namespace App\Modules\Visits\src\traits;

use App\Modules\Visits\src\Models\Visits;
use PhpOffice\PhpSpreadsheet\IOFactory;

trait ExcelTrait
{
    public function importExcel($request): true
    {

        $file = $request['excel_file'];
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        foreach ($rows as $index => $row) {
            if ($index === 0) continue;

            Visits::create([
                'fullName' => $row[0] ?? '',
                'phone' => $row[1] ?? '',
                'command' => $row[2] ?? '',
            ]);
        }

        return true;
    }
}

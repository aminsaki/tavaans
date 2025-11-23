<?php

namespace App\Modules\Visits\src\traits;

use App\Models\Cat;
use App\Modules\Visits\src\Models\Visits;
use Illuminate\Support\Facades\Log;
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

        $categoryName = trim($row[3] ?? '');
        $categoryId = null;
        if (!empty($categoryName)) {

            $category = Cat::firstOrCreate(
                ['name' => $categoryName]
            );

            $categoryId = $category->id;
        }
                     Log::info("categoryId=".$categoryId);

            Visits::create([
                'fullName' => $row[0] ?? '',
                'phone' => $row[1] ?? '',
                'command' => $row[2] ?? '',
                'cat_id'  => $categoryId,
            ]);

        }

        return true;
    }
}

<?php

namespace App\Modules\Bases\src\servers\excels;

use Exception;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class FileReaderFactory
{
    public static function create($fileType)
    {
        return match ($fileType) {
            'xlsx' => new Xlsx(),
            'xls' => new Xls(),
            'csv' => new Csv(),
            default => throw new Exception("Unsupported file type: $fileType")
        };
    }
}

<?php

namespace App\Modules\Bases\src\servers\excels;

use holoo\modules\Bases\Helper\Responses;

class ExcelFileReaderService
{

    public function __construct(protected Responses $response)
    { }

    public function readFile($filePath)
    {

        $fileType = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        $reader = FileReaderFactory::create($fileType);

        if (!file_exists($filePath)) {
            return $this->response->notFound('', trans('validation.notFound'));
        }

        $spreadsheet = $reader->load($filePath);

        return $spreadsheet->getActiveSheet()->toArray();
    }

    public static function create(): ExcelFileReaderService
    {
        return new self();
    }
}

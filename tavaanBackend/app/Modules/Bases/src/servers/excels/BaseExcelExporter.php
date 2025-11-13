<?php

namespace holoo\modules\Bases\servers\excels;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

abstract class BaseExcelExporter
{
    public function export()
    {
        $data = $this->prepareData();
        $header = $this->getHeaders();

        $fileName =  $this->generateExcel($data, $header);
        return   asset("public/excels/{$fileName}");
    }

    abstract public function prepareData(): array;


    protected function getHeaders(): array
    {
        return [];
    }

    protected function generateExcel(array $data, array $headers): string
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();


        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue("{$col}1", $header);
            $col++;
        }


        $row = 2;
        foreach ($data as $record) {
            $col = 'A';
            foreach ($record as $value) {
                $sheet->setCellValue("{$col}{$row}", $value);
                $col++;
            }
            $row++;
        }

        $folder = public_path('excels');
        if (!file_exists($folder)) mkdir($folder, 0777, true);
        $fileName = 'report_' . rand(100000, 999999) . '.xlsx';
        IOFactory::createWriter($spreadsheet, 'Xlsx')->save("{$folder}/{$fileName}");
        return $fileName;
    }

}


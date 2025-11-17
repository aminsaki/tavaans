<?php

namespace holoo\modules\Visits\traits;

use App\Modules\Visits\src\Models\Visits;
use holoo\modules\Bases\Helper\Responses;
use holoo\modules\Links\Enums\FestivalStatus;
use Morilog\Jalali\Jalalian;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

trait ReportsTraitExcel
{
    public function exportExcel(): \Illuminate\Http\JsonResponse
    {
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'نام و نام خانوادگی ');
        $sheet->setCellValue('B1', 'شماره تماس');
        $sheet->setCellValue('C1', 'تعداد نفرات');
        $sheet->setCellValue('D1', 'خودرو');
        $sheet->setCellValue('E1', 'توضیحات');
        $sheet->setCellValue('F1', 'پیام ورود');
        $sheet->setCellValue('G1', 'پیام خروجی ');
        $reports =   Visits::all();

         $rows = 2;
        foreach ($reports as $row) {

            $sheet->setCellValue('A' . $rows, $row->fullName);
            $sheet->setCellValue('B' . $rows, $row->phone);
            $sheet->setCellValue('C' . $rows, $row->companions);
            $sheet->setCellValue('D' . $rows, $row->has_car);
            $sheet->setCellValue('E' . $rows, $row->command);
            $sheet->setCellValue('F' . $rows, $row->entry_time);
            $sheet->setCellValue('G' . $rows, $row->exit_time);

            $rows++;
        }

        $spreadsheet->getProperties()
            ->setCreator('Your App payments')
            ->setTitle('Payments Export')
            ->setSubject('Payments')
            ->setDescription('List of payments');

        $folder = public_path('excels');

        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }
        $randomNumber = rand(1000000, 9999999);
        $folderWithRandom = "reports{$randomNumber}.xlsx";
        $folder_add = $folder . '/' . $folderWithRandom;

        $writer = IOFactory::createWriter($spreadsheet, "Xlsx");

        $writer->save($folder_add);
        return Responses::create()->success([$reports, 'fileUrl' => asset("public/excels/{$folderWithRandom}")], trans('validation.success'));
    }
}

<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Santri;
use App\Models\Main;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;


class FormPrint extends BaseController
{

    public function index($section = 'PA')
    {
        if ($section == 'PA') {
            $mainModel = new Main();
            $post = [
                'title'     => esc($this->request->getVar('title')),
                'date'      => esc($this->request->getVar('date')),
                'kobong'    => esc($this->request->getVar('kobong')),
                'orang'     => esc($this->request->getVar('orang')),
                'NB'        => esc($this->request->getVar('NB'))
            ];
            $santri = $mainModel->getSelect('santri.nama_pendek', $post['kobong']);
            shuffle($santri);
            $date = date_create($post['date']);
            $json = [];
            for ($i = 0; $i < ceil(count($santri) / $post['orang']); $i++) {
                for ($j = 0; $j < $post['orang']; $j++) {
                    if (($i * $post['orang'] + $j) < count($santri)) {
                        $json[strval(date_timestamp_get($date))][] = $santri[$i * $post['orang'] + $j]->nama_pendek;
                    }
                }
                date_add($date, date_interval_create_from_date_string('1 day'));
            };
            $firstKey = date('d/m/Y', array_key_first($json));
            $lastKey = date('d/m/Y', array_key_last($json));
            $data = [
                'title' => $post['title'],
                'type' => 'Jadwal PA',
                'date_start' => $firstKey,
                'date_end' => $lastKey,
                'data' => $json,
                'NB'    => $post['NB']
            ];
            $data['file'] = json_encode($data);
            // dd(json_encode($data));
            return view('Form/print', $data);
        }
        if ($section == 'PT') {
            $mainModel = new Main();
            $post = [
                'title'     => esc($this->request->getVar('title')),
                'date'      => esc($this->request->getVar('date')),
                'kelas'    => esc($this->request->getVar('kelas')),
                'orang'     => esc($this->request->getVar('orang')),
                'NB'        => esc($this->request->getVar('NB'))
            ];
            // dd($mainModel);
            $santri = $mainModel->getLike('santri.nama_pendek', $post['kelas']);
            shuffle($santri);
            $date = date_create($post['date']);
            $json = [];
            for ($i = 0; $i < ceil(count($santri) / $post['orang']); $i++) {
                for ($j = 0; $j < $post['orang']; $j++) {
                    if (($i * $post['orang'] + $j) < count($santri)) {
                        $json[strval(date_timestamp_get($date))][] = $santri[$i * $post['orang'] + $j]->nama_pendek;
                    }
                }
                date_add($date, date_interval_create_from_date_string('1 day'));
            };
            $firstKey = date('d/m/Y', array_key_first($json));
            $lastKey = date('d/m/Y', array_key_last($json));
            $data = [
                'title' => $post['title'],
                'data' => $json,
                'type' => 'Jadwal PT',
                'date_start' => $firstKey,
                'date_end' => $lastKey,
                'NB'    => $post['NB']
            ];
            $data['file'] = json_encode($data);
            return view('Form/print', $data);
        }
        if ($section == 'imam') {
            $mainModel = new Main();
            $post = [
                'title'     => esc($this->request->getVar('title')),
                'date'      => esc($this->request->getVar('date')),
                'kelas'    => esc($this->request->getVar('kelas')),
                'waktu'     => esc($this->request->getVar('waktu')),
                'NB'        => esc($this->request->getVar('NB'))
            ];
            $orang = count($post['waktu']);
            // dd($mainModel);
            $santri = $mainModel->getLike('santri.nama_pendek', $post['kelas']);
            shuffle($santri);
            $date = date_create($post['date']);
            $json = [];
            $log = [];
            for ($i = 0; $i < ceil(count($santri) / $orang); $i++) {
                for ($j = 0; $j < $orang; $j++) {
                    if (($i * $orang + $j) < count($santri)) {
                        if (date('D', date_timestamp_get($date)) == "Fri" && $post['waktu'][$j] == "Dzuhur") {
                            $json[strval(date_timestamp_get($date))][$post['waktu'][$j]] = "";
                            $i = $i - 1;
                        } else {
                            $json[strval(date_timestamp_get($date))][$post['waktu'][$j]] = $santri[$i * $orang + $j]->nama_pendek;
                        }
                    }
                }
                date_add($date, date_interval_create_from_date_string('1 day'));
            };
            // dd($log);
            // dd($santri);
            $firstKey = date('d/m/Y', array_key_first($json));
            $lastKey = date('d/m/Y', array_key_last($json));
            $data = [
                'title' => $post['title'],
                'type' => 'Jadwal Imam',
                'date_start' => $firstKey,
                'date_end' => $lastKey,
                'data' => $json,
                'NB'    => $post['NB'],
                'waktu' => $post['waktu']
            ];
            $data['file'] = json_encode($data);
            return view('Form/printImam', $data);
        }
    }
    /**
     * Generate an excel file that contains 'Hello World !' in cell A1,
     * and prompt the user to download it.
     */
    public function create_excel()
    {
        $file_name = $this->request->getVar('nama');
        $file = $this->request->getVar('file');
        $file = str_replace("%27", "'", $file);
        $file = json_decode($file, true);
        // dd($file_name, $file);
        // dd($file);
        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();
        $activeWorksheet->setTitle($file_name);
        $activeWorksheet->mergeCells('A1:D1');
        $activeWorksheet->setCellValue('A1', $file['title']);
        $spreadsheet->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
        $spreadsheet->getActiveSheet()->getPageSetup()->setVerticalCentered(true);
        $activeWorksheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
        $activeWorksheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        // $activeWorksheet->getStyle('A1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $activeWorksheet->getStyle('A1')->getFill()->getStartColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_GREEN);
        $activeWorksheet->getStyle('A1')->getFont()->setSize(20);
        $activeWorksheet->getStyle('A1')->getFont()->setBold(true);
        $activeWorksheet->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('92d050');
        // $activeWorksheet->getStyle('A1')->getFont()->getStartColor()->setARGB('F8F9Fa');
        $grouped_file = [];
        $i = 0;
        foreach ($file['data'] as $date => $santri) {
            $grouped_file[floor($i / 4)][$date] = $santri;
            $i++;
        }
        $col = 'A';
        $row = 3;
        $orang = count(reset($file['data']));
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];
        foreach ($grouped_file as $key => $value) {
            foreach ($value as $key => $santri) {
                $row_start = $row;
                $activeWorksheet->setCellValue($col . $row, date('d-m-Y', $key));
                $activeWorksheet->getStyle($col . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $activeWorksheet->getStyle($col . $row)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $activeWorksheet->getStyle($col . $row)->getFont()->setBold(true);
                $row++;
                foreach ($santri as $nama) {
                    $activeWorksheet->setCellValue($col . $row, $nama);
                    $row++;
                }
                if ($col == "D") {
                    $col = "A";
                } else {
                    $col = chr(ord($col) + 1);
                }
                $activeWorksheet->getStyle('A' . $row_start . ':' . $activeWorksheet->getHighestColumn($row_start) . ($row_start + $orang))->applyFromArray($styleArray);
                $row = $row_start;
            }
            $row += $orang + 2;
        }
        $activeWorksheet->getColumnDimension('A')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('B')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('C')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('D')->setAutoSize(true);
        // $row += 2;
        // dd($row);
        foreach ($file['NB'] as $value) {
            $activeWorksheet->setCellValue('A' . $row, "•" . $value);
            $row++;
        }
        // $activeWorksheet->setCellValue('A', $file['title']);
        $writer = new Xlsx($spreadsheet);
        $writer->save('hello world.xlsx');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $file_name . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();
    }

    public function create_excelimam()
    {
        // dd($this->request->getVar());
        $file_name = $this->request->getVar('nama');
        $file = $this->request->getVar('file');
        $file = str_replace("%27", "'", $file);
        $file = json_decode($file, true);
        $ttd = $this->request->getVar('ttd') == "true";
        // dd($file_name, $file);
        // dd($file);
        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();
        $long = count($file['data'][array_key_first($file['data'])]);
        $long = ($ttd) ? ($long * 2) + 2 : $long + 2;
        // dd($long);
        $activeWorksheet->setTitle($file_name);
        $activeWorksheet->mergeCells('A1:' . \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($long) . '1');
        $activeWorksheet->setCellValue('A1', $file['title']);
        $spreadsheet->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
        $spreadsheet->getActiveSheet()->getPageSetup()->setVerticalCentered(true);
        $activeWorksheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
        $activeWorksheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        // $activeWorksheet->getStyle('A1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $activeWorksheet->getStyle('A1')->getFill()->getStartColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_GREEN);
        $activeWorksheet->getStyle('A1')->getFont()->setSize(20);
        $activeWorksheet->getStyle('A1')->getFont()->setBold(true);
        $activeWorksheet->getStyle('A1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('92d050');
        // $activeWorksheet->getStyle('A1')->getFont()->getStartColor()->setARGB('F8F9Fa');
        $col_index = 3;
        $row = 3;
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, // Gaya border (Thin, Thick, etc)
                    'color' => ['rgb' => '000000'],       // Warna border (opsional)
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,  // Menengahkan teks secara horizontal
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER       // Menengahkan teks secara vertikal (opsional)
            ],
        ];
        $styleArrayborder = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, // Gaya border (Thin, Thick, etc)
                    'color' => ['rgb' => '000000'],       // Warna border (opsional)
                ],
            ],
        ];
        $activeWorksheet->setCellValue('A3', 'No');
        $activeWorksheet->setCellValue('B3', 'tanggal');
        $activeWorksheet->getStyle('A3')->applyFromArray($styleArray);
        $activeWorksheet->getStyle('B3')->applyFromArray($styleArray);


        foreach ($file['data'][array_key_first($file['data'])] as $key => $value) {
            $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col_index);
            $activeWorksheet->setCellValue($col . $row, $key);
            $activeWorksheet->getStyle($col . $row)->applyFromArray($styleArray);
            $col_index++;
            if ($ttd) {
                $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col_index);
                $activeWorksheet->setCellValue($col . $row, '  TTD  ');
                $activeWorksheet->getStyle($col . $row)->applyFromArray($styleArray);
                $col_index++;
            }
        }
        $col_index = 1;
        $row = 4;
        $i = 0;
        foreach ($file['data'] as $tanggal => $santri) {
            $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col_index);
            $activeWorksheet->setCellValue($col . $row, $i + 1);
            $activeWorksheet->getStyle($col . $row)->applyFromArray($styleArray);
            $col_index++;
            $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col_index);
            $activeWorksheet->setCellValue($col . $row, date('d-m-Y', $tanggal));
            $activeWorksheet->getStyle($col . $row)->applyFromArray($styleArray);
            $col_index++;
            foreach ($santri as $key => $value) {
                $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col_index);
                $activeWorksheet->setCellValue($col . $row, $value);
                $activeWorksheet->getStyle($col . $row)->applyFromArray($styleArrayborder);
                $col_index++;
                if ($ttd) {
                    $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col_index);
                    $activeWorksheet->getStyle($col . $row)->applyFromArray($styleArray);
                    $col_index++;
                }
            }

            $col_index = 1;
            $row++;
            $i++;
        }
        for ($i = 1; $i <= $long; $i++) {
            $activeWorksheet->getColumnDimension(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i))->setAutoSize(true);
        }
        foreach ($file['NB'] as $value) {
            $activeWorksheet->setCellValue('A' . $row, "•" . $value);
            $row++;
        }
        // $row += 2;
        // dd($row);
        // $activeWorksheet->setCellValue('A', $file['title']);
        $writer = new Xlsx($spreadsheet);
        $writer->save('hello world.xlsx');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $file_name . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();
    }
}

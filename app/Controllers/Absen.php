<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Main;
use App\Models\AbsenDB;
use App\Models\Kobong;
use App\Models\Santri;
use DateTime;
use PhpOffice\PhpSpreadsheet\Calculation\DateTimeExcel\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpParser\Node\Stmt\TryCatch;

class Absen extends BaseController
{
    protected $absenModel;
    protected $kobongModel;
    protected $mainModel;
    function __construct()
    {
        $this->absenModel = new AbsenDB();
        $this->kobongModel = new Kobong();
        $this->mainModel = new Main();
    }
    public function rekap($kobong = 'UBK-1')
    {
        $kobong = str_replace('-', ' ', strtoupper($kobong));
        $mainModel = new Main();
        $santri = $mainModel->getSelect(['santri.nama_lengkap', 'santri.santri_id'], [$kobong]);
        // dd($santri);
        $data = [
            'santri' => $santri,
            'nama_kobong' => $kobong,
            'list_kobong' => $this->kobongModel->findColumn('kobong')
        ];
        return view('Absen/rekap', $data);
    }
    public function api()
    {
        $post = [
            'keterangan' => esc($this->request->getVar('ket')),
            'date'       => esc($this->request->getVar('date')),
            'jenis_absen' => esc($this->request->getVar('jenis_absen')),
            'kobong'     => esc($this->request->getVar('kobong'))
        ];
        $post['kobong'] = str_replace(' ', '-', strtoupper($post['kobong']));
        // dd($post);
        $data = [];
        $post['date'] = DateTime::createFromFormat('d/m/Y', $post['date'])->format('Y-m-d');
        // dd($post);
        foreach ($post['keterangan'] as $santri_id => $ket) {
            $data[] = [
                'santri_id' => $santri_id,
                'tanggal' => $post['date'],
                'jenis_absen' => $post['jenis_absen'],
                'keterangan_id' => $ket
            ];
        }
        try {
            $this->absenModel->insertBatch($data);
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                return redirect()->to(base_url('/absen/rekap-absen/' . $post['kobong']))->with('data', 'Data Sudah Ada');
            }
        }
        $data = [
            'date' => $post['date'],
        ];
        // dd($post);
        return redirect()->to(base_url('/absen/rekap-absen/' . $post['kobong']));
    }
    /**
     *
     * This function will render `Absen/tahunan` view.
     *
     * @return view
     */
    public function Tahunan()
    {
        $bulan = $this->request->getVar('bulan');
        $tahun = $this->request->getVar('tahun');
        $kobong = $this->request->getVar('kobong');
        $jenis = $this->request->getVar('jenis');
        $jenis = ($jenis == '') ? 'shalat' : $jenis;
        $kobong = ($kobong == '') ? 'ALL' : $kobong;
        $bulan = ($bulan == '') ? (int)date('n') : $bulan;
        $tahun = ($tahun == '') ? (int)date('Y') : $tahun;
        // $kobong = str_replace('-', ' ', strtoupper($kobong));
        // dd($bulan, $tahun, $kobong, $jenis);
        $absen = $this->absenModel->getAbsen($kobong, $bulan, $tahun, $jenis);
        // dd($absen);
        $ress = [];
        if ($kobong != 'All' && substr($kobong, 0, 6) != "Kelas ") {
            $santri = $this->mainModel->select('santri.nama_lengkap')
                ->join('kobong', 'kobong.id = santri.kobong_id')
                ->where('kobong.kobong', $kobong)
                ->get()->getResultArray();
        } elseif ($kobong == 'All') {
            $santri = $this->mainModel->select('santri.nama_lengkap')
                ->join('kobong', 'kobong.id = santri.kobong_id')
                ->join('kelas', 'kelas.id = santri.kelas_id')
                ->orderBy('kelas.kmmi', 'ASC')
                ->get()->getResultArray();
        } elseif (substr($kobong, 0, 6) == "Kelas ") {
            $santri = $this->mainModel->select('santri.nama_lengkap')
                ->join('kobong', 'kobong.id = santri.kobong_id')
                ->join('kelas', 'kelas.id = santri.kelas_id')
                ->Like('kelas.kmmi', substr($kobong, 6), 'after')
                ->get()->getResultArray();
        }

        foreach ($santri as $nama) {
            $ress[$nama['nama_lengkap']] = [];
        }
        if ($jenis == 'kobong') {
            foreach ($absen as $key => $value) {
                if (!isset($ress[$value['nama_lengkap']])) {
                    $ress[$value['nama_lengkap']] = [];
                }
                $ress[$value['nama_lengkap']][$value['tanggal']] = $value['keterangan_id'];
            }
        } elseif ($jenis == 'shalat') {
            foreach ($absen as $key => $value) {
                if (!isset($ress[$value['nama_lengkap']][$value['tanggal']])) {
                    $ress[$value['nama_lengkap']][$value['tanggal']] = [];
                    $sholat = ['subuh', 'dzuhur', 'ashar', 'maghrib', 'isya'];
                    foreach ($sholat as $sh) {
                        $ress[$value['nama_lengkap']][$value['tanggal']][$sh] = "-";
                    }
                }
                $ress[$value['nama_lengkap']][$value['tanggal']][$value['jenis_absen']] = $value['keterangan_id'];
                // $ress[$value['nama_lengkap']][$value['tanggal']][$value['jenis_absen']] = $value['keterangan_id'];
            }
        }
        // dd($santri);
        // dd($ress, $absen);
        $data = [
            'full_month' => cal_days_in_month(CAL_GREGORIAN, (int)$bulan, (int)$tahun),
            'list_kobong' => ['All', 'Kelas 1', 'Kelas 2', 'Kelas 3', 'Kelas 4', 'Kelas 5', 'Kelas 6'],
            'view'        => 'All',
            'absen'       => $ress,
            'bulan'       => $this->request->getVar('bulan'),
            'tahun'       => $this->request->getVar('tahun'),
            'kobong'      => $this->request->getVar('kobong'),
            'jenis'       => $this->request->getVar('jenis'),
        ];
        $data['list_kobong'] = array_merge($data['list_kobong'], $this->kobongModel->findColumn('kobong'));
        return view('Absen/tahunan', $data);
    }
    /**
     * Displays the view for printing attendance recap.
     *
     * @return \CodeIgniter\View\View The view for printing attendance recap.
     */
    public function print()
    {
        if (count($this->request->getVar()) == 0) {
            $data = [
                'none' => true,
                'list_kobong' => $this->kobongModel->findColumn('kobong')
            ];
            return view('Absen/print_rekap', $data);
        }
    }

    public function print_tahunan()
    {
        // dd($this->request->getVar());
        $absen = $this->request->getVar('absen');
        $jenis = $this->request->getVar('jenis');
        $full_month = $this->request->getVar('full_month');
        $tahun = $this->request->getVar('tahun');
        $bulan = $this->request->getVar('bulan');
        $absen = str_replace('%27', "'", $absen);
        $absen = json_decode($absen, true);
        // dd($absen, $jenis);
        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();
        // dd($absen, $full_month); \
        $color = [
            'H' => '198754',
            'S' => 'ffc107',
            'I' => '0d6efd',
            'A' => 'dc3545',
            'P' => 'ffc107',
            'D' => '0d6efd'
        ];
        if ($jenis == 'shalat') {
            $activeWorksheet->mergeCells('A1:A2');
            $activeWorksheet->setCellValue('A1', 'NO');
            $activeWorksheet->getColumnDimension('A')->setAutoSize(true);
            $activeWorksheet->mergeCells('B1:B2');
            $activeWorksheet->setCellValue('B1', 'NAMA');
            $activeWorksheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $activeWorksheet->getStyle('A1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $activeWorksheet->getStyle('B1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $activeWorksheet->getStyle('B1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $row = 1;
            $colIndex = 3;
            for ($i = 1; $i <= $full_month; $i++) {
                $startCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
                $endCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex + 4);

                $range = $startCol . $row . ':' . $endCol . $row;
                $activeWorksheet->mergeCells($range);
                $activeWorksheet->setCellValue($startCol . $row, $i);
                $activeWorksheet->getStyle($startCol . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $activeWorksheet->getStyle($startCol . $row)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $colIndex += 5;
            }
            $colIndex = 3;
            $row = 2;
            for ($i = 1; $i <= $full_month; $i++) {
                $sholat = ['Subuh', 'Dzuhur', 'Ashar', 'Maghrib', 'Isya'];
                // $s_i = 0;
                foreach ($sholat as $sh) {
                    $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
                    $activeWorksheet->setCellValue($col . $row, $sh);
                    $activeWorksheet->getColumnDimension($col)->setAutoSize(true);
                    $activeWorksheet->getStyle($col . $row)->getAlignment()->setTextRotation(-90);
                    $activeWorksheet->getStyle($col . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $activeWorksheet->getStyle($col . $row)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                    $colIndex++;
                };
            }
            $colIndex = 3;
            $row = 3;

            foreach ($absen as $nama => $value) {
                $activeWorksheet->setCellValue('B' . $row, $nama);
                $activeWorksheet->getColumnDimension('B')->setAutoSize(true);
                $activeWorksheet->setCellValue('A' . $row, $row - 2);
                $activeWorksheet->getColumnDimension('A')->setAutoSize(true);
                $activeWorksheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $activeWorksheet->getStyle('A' . $row)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                for ($i = 0; $i < $full_month; $i++) {
                    if (isset($value[$tahun . '-' . $bulan . '-' . (($i + 1 > 9) ? ($i + 1) : '0' . $i + 1)])) {
                        $waktu = ['subuh', 'dzuhur', 'ashar', 'maghrib', 'isya'];
                        for ($j = 0; $j < 5; $j++) {
                            if ($value[$tahun . '-' . $bulan . '-' . (($i + 1 > 9) ? ($i + 1) : '0' . $i + 1)][$waktu[$j]] != "-") {
                                $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
                                $activeWorksheet->setCellValue($col . $row, $value[$tahun . '-' . $bulan . '-' . (($i + 1 > 9) ? ($i + 1) : '0' . $i + 1)][$waktu[$j]]);
                                $activeWorksheet->getColumnDimension($col)->setAutoSize(true);
                                $activeWorksheet->getStyle($col . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                                $activeWorksheet->getStyle($col . $row)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                                $activeWorksheet->getStyle($col . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($color[$value[$tahun . '-' . $bulan . '-' . (($i + 1 > 9) ? ($i + 1) : '0' . $i + 1)][$waktu[$j]]]);
                                $colIndex++;
                            } else {
                                $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
                                $activeWorksheet->setCellValue($col . $row, '-');
                                $activeWorksheet->getColumnDimension($col)->setAutoSize(true);
                                $activeWorksheet->getStyle($col . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                                $activeWorksheet->getStyle($col . $row)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                                $colIndex++;
                            }
                        }
                    } else {
                        for ($j = 0; $j < 5; $j++) {
                            $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
                            $activeWorksheet->setCellValue($col . $row, '-');
                            $activeWorksheet->getColumnDimension($col)->setAutoSize(true);
                            $activeWorksheet->getStyle($col . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                            $activeWorksheet->getStyle($col . $row)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                            $colIndex++;
                        }
                    }
                }
                $colIndex = 3;
                $row++;
            }
            $styleArray = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'],
                    ],
                ],
            ];

            $activeWorksheet->getStyle('A1:' . \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($full_month * 5 + 2) . count($absen) + 2)->applyFromArray($styleArray);
            $activeWorksheet->freezePane('C3');
        } elseif ($jenis == 'kobong') {
            $activeWorksheet->setCellValue('A1', 'NO');
            $activeWorksheet->getColumnDimension('A')->setAutoSize(true);;
            $activeWorksheet->setCellValue('B1', 'NAMA');
            $activeWorksheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $activeWorksheet->getStyle('A1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $activeWorksheet->getStyle('B1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $activeWorksheet->getStyle('B1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $row = 1;
            $colIndex = 3;
            for ($i = 1; $i <= $full_month; $i++) {
                $startCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
                $endCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);

                $range = $startCol . $row . ':' . $endCol . $row;
                $activeWorksheet->mergeCells($range);
                $activeWorksheet->setCellValue($startCol . $row, $i);
                $activeWorksheet->getStyle($startCol . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $activeWorksheet->getStyle($startCol . $row)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $colIndex++;
            }
            $row++;
            $colIndex = 1;
            $no = 1;
            foreach ($absen as $nama => $value) {
                $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
                $activeWorksheet->setCellValue($col . $row, $no);
                $colIndex++;
                $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
                $activeWorksheet->getStyle($col . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $activeWorksheet->getStyle($col . $row)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $activeWorksheet->setCellValue($col . $row, $nama);
                $colIndex++;
                $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
                $activeWorksheet->setCellValue($col . $row, $nama);
                for ($i = 0; $i < $full_month; $i++) {
                    if (isset($value[$tahun . '-' . $bulan . '-' . (($i + 1 > 9) ? ($i + 1) : '0' . $i + 1)])) {
                        $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
                        $activeWorksheet->setCellValue($col . $row, $value[$tahun . '-' . $bulan . '-' . (($i + 1 > 9) ? ($i + 1) : '0' . $i + 1)]);
                        $activeWorksheet->getColumnDimension($col)->setAutoSize(true);
                        $activeWorksheet->getStyle($col . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                        $activeWorksheet->getStyle($col . $row)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                        $activeWorksheet->getStyle($col . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($color[$value[$tahun . '-' . $bulan . '-' . (($i + 1 > 9) ? ($i + 1) : '0' . $i + 1)]]);
                        $colIndex++;
                    } else {
                        $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
                        $activeWorksheet->setCellValue($col . $row, '-');
                        $activeWorksheet->getColumnDimension($col)->setAutoSize(true);
                        $activeWorksheet->getStyle($col . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                        $activeWorksheet->getStyle($col . $row)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                        $colIndex++;
                    }
                }
                $row++;
                $colIndex = 1;
                $no++;
            }
            $styleArray = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'],
                    ],
                ],
            ];
            $activeWorksheet->getStyle('A')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $activeWorksheet->getStyle('B')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $activeWorksheet->getColumnDimension('A')->setAutoSize(true);
            $activeWorksheet->getColumnDimension('B')->setAutoSize(true);
            $activeWorksheet->freezePane('C2');
            $activeWorksheet->getStyle('A1:' . \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($full_month  + 2) . count($absen) + 1)->applyFromArray($styleArray);
        }


        $writer = new Xlsx($spreadsheet);
        // $writer->save('hello world.xlsx');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="coba.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();
    }
    public function rekap_absen()
    {
        $post = $this->request->getVar();
        // dd($post);
        $date = explode(' - ', $post['date']);
        $start_date = DateTime::createFromFormat('d/m/Y', $date[0])->format('Y-m-d');
        $end_date = DateTime::createFromFormat('d/m/Y', $date[1])->format('Y-m-d');
        $db = new AbsenDB();
        $db->select('absen_kamar.tanggal,absen_kamar.keterangan_id,absen_kamar.jenis_absen,santri.nama_lengkap')
            ->join('santri', 'santri.santri_id = absen_kamar.santri_id')
            ->join('kobong', 'kobong.id = santri.kobong_id')
            ->where('kobong.kobong', $post['kobong']);
        if ($post['jenis_absen'] == 'shalat') {
            $db->groupStart();
            $db->Like('absen_kamar.jenis_absen', 'subuh');
            $db->orLike('absen_kamar.jenis_absen', 'dzuhur');
            $db->orLike('absen_kamar.jenis_absen', 'ashar');
            $db->orLike('absen_kamar.jenis_absen', 'maghrib');
            $db->orLike('absen_kamar.jenis_absen', 'isya');
            $db->groupEnd();
        } elseif ($post['jenis_absen'] == 'kobong') {
            $db->where('absen_kamar.jenis_absen', 'kobong');
        }
        $db->where('absen_kamar.tanggal >=', $start_date)
            ->where('absen_kamar.tanggal <=', $end_date);
        $absen = $db->get()->getResultArray();
        $dbmain = new Main();
        $dbmain->select('santri.nama_lengkap')
            ->join('kobong', 'kobong.id = santri.kobong_id')
            ->where('kobong.kobong', $post['kobong']);
        $santri = $dbmain->get()->getResultArray();
        $ress = [];
        $start = new DateTime($start_date);
        $end = new DateTime($end_date);
        $tanggal = [];
        while ($start <= $end) { // Menyimpan tanggal dalam format 'Y-m-d'
            $tanggal[] = $start->format('Y-m-d');
            $start = $start->modify('+1 day');       // Menambahkan 1 hari pada tanggal saat ini
        }
        // dd($tanggal);
        if (count($tanggal) == 0) {
            $tanggal = [$start_date];
        }
        $ket = ['H', 'S', 'A', 'P', 'I', 'D'];



        if ($post['jenis_absen'] == 'shalat') {
            foreach ($santri as $san) {
                $ress[$san['nama_lengkap']] = [];
                foreach ($tanggal as $tgl) {
                    $ress[$san['nama_lengkap']][$tgl] = [];
                    foreach ($ket as $k) {
                        $ress[$san['nama_lengkap']][$tgl][$k] = 0;
                    }
                }
            }

            foreach ($absen as $abs) {
                $ress[$abs['nama_lengkap']][$abs['tanggal']][$abs['keterangan_id']] = $ress[$abs['nama_lengkap']][$abs['tanggal']][$abs['keterangan_id']] + 1;
            }
            $data = [
                'tanggal' => $tanggal,
                'absen' => $ress,
                'kobong' => $post['kobong'],
                'jenis_absen' => $post['jenis_absen'],
                'list_kobong' => $this->kobongModel->findColumn('kobong')
            ];
        } elseif ($post['jenis_absen'] == 'kobong') {
        }
        // dd($data);

        return view('/Absen/print_rekap', $data);
    }
}

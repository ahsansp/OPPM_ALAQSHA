<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Main;
use App\Models\Kelas;
use App\Models\Kobong;
use App\Models\Alumni;

class DataControl extends BaseController
{
    public function kenaikan_kelas()
    {
        return view('dbcontrol/kenaikan_kelas');
    }

    public function kenaikan_kelas_file()
    {
        // dd($file = $this->request->getFile('file'));

        $validationRule = [
            'file' => [
                'rules' => 'uploaded[file]|ext_in[file,xls,xlsx]',
                'errors' => [
                    'uploaded' => 'Tidak ada file yang dipilih',
                    'ext_in'   => 'Jenis file harus xls atau xlsx'
                ]
            ]
        ];
        if (!$this->validate($validationRule)) {
            return redirect()->back()->withInput()->with('validation', \Config\Services::validation());
        }
        $file = $this->request->getFile('file');
        if ($file->isValid()) {
            // Membaca file tanpa menyimpannya di server
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getTempName());
            $worksheet = $spreadsheet->getActiveSheet();
            $row = 5;
            $col = 2;
            $data = [];
            $high_row = 0;
            while ($worksheet->getCell(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col) . $row)->getValue() != null) {
                $high_row = $row;
                $row++;
            }
            $row = 5;
            for ($i = 4; $i < $high_row; $i++) {
                $data[] = [
                    "nama" => $worksheet->getCell(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col) . $row)->getValue(),
                    "kmmi" => $worksheet->getCell(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col + 1) . $row)->getValue(),
                    "nama_con" => 0,
                    "kelas_con" => 0
                ];
                $row++;
            }
            $main = new Main();
            $kelas = new Kelas();
            $array_kelas = $kelas->findAll();
            $main->select('santri.santri_id , santri.nama_lengkap , kelas.kmmi , kelas.umum')
                ->join('kelas', 'santri.kelas_id = kelas.id');
            $santri = $main->findAll();
            for ($i = 0; $i < count($data); $i++) {
                foreach ($santri as $santri_in) {
                    if ($data[$i]['nama'] == $santri_in["nama_lengkap"]) {
                        $data[$i]['nama_con'] = $santri_in["santri_id"];
                        for ($j = 0; $j < count($array_kelas); $j++) {
                            if (strtoupper($data[$i]['kmmi']) == $array_kelas[$j]['kmmi']) {
                                $data[$i]['kelas_con'] = $array_kelas[$j]['id'];
                                break;
                            }
                        }
                        break;
                    }
                }
            }
            if (session()->get("tabel_kelas")) {
                $tabel = session()->get("tabel_kelas");
                $tabel = array_merge($tabel, $data);
            } else {
                $tabel = $data;
            }
            session()->set("tabel_kelas", $tabel);
            return redirect()->to(base_url() . '/datacontrol/kenaikan-kelas');
        }
    }
    public function kenaikan_kelas_update()
    {
        if (!session()->get("tabel_kelas")) {
            return redirect()->to(base_url() . '/datacontrol/kenaikan-kelas');
        }
        $tabel = session()->get("tabel_kelas");
        $updeter = [];
        foreach ($tabel as $data) {
            $updater[] = [
                "santri_id" => $data["nama_con"],
                "kelas_id" => $data["kelas_con"]
            ];
        }
        $main = new Main();
        if (!$main->updateBatch($updater, 'santri_id')) {
            return redirect()->to(base_url() . '/datacontrol/kenaikan-kelas')->with('error', 'Data gagal di update');
        }
        session()->remove("tabel_kelas");
        return redirect()->to(base_url() . '/datacontrol/kenaikan-kelas');
        // dd($tabel);
    }
    public function kenaikan_kelas_cencel()
    {
        session()->remove("tabel_kelas");
        return redirect()->to(base_url() . '/datacontrol/kenaikan-kelas');
    }

    public function perpindahan_kobong()
    {
        return view("dbcontrol/perpindahan_kobong");
    }

    /**
     * Function to upload the excel file for updating the student data,
     * validate the file type, read the file, convert the data to the format
     * that can be used to update the database, and store the data in the session.
     * If the session 'tabel_kobong' is already set, the new data will be merged
     * with the existing data.
     * Redirects to the 'perpindahan-kobong' page.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function perpindahan_kobong_file()
    {
        // dd($file = $this->request->getFile('file'));

        $validationRule = [
            'file' => [
                'rules' => 'uploaded[file]|ext_in[file,xls,xlsx]',
                'errors' => [
                    'uploaded' => 'Tidak ada file yang dipilih',
                    'ext_in'   => 'Jenis file harus xls atau xlsx'
                ]
            ]
        ];
        if (!$this->validate($validationRule)) {
            return redirect()->back()->withInput()->with('validation', \Config\Services::validation());
        }
        $file = $this->request->getFile('file');
        if ($file->isValid()) {
            // Membaca file tanpa menyimpannya di server
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getTempName());
            $worksheet = $spreadsheet->getActiveSheet();
            $row = 5;
            $col = 2;
            $data = [];
            $high_row = 0;
            while ($worksheet->getCell(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col) . $row)->getValue() != null) {
                $high_row = $row;
                $row++;
            }
            $row = 5;
            // dd($high_row);
            for ($i = 4; $i < $high_row; $i++) {
                $data[] = [
                    "nama" => $worksheet->getCell(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col) . $row)->getValue(),
                    "kobong" => $worksheet->getCell(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col + 1) . $row)->getValue(),
                    "nama_con" => null,
                    "kobong_con" => null
                ];
                $row++;
            }
            $main = new Main();
            $kobong = new Kobong();
            $array_kobong = $kobong->findAll();
            $main->select('santri.santri_id , santri.nama_lengkap , kobong.kobong')
                ->join('kobong', 'santri.kobong_id = kobong.id');
            $santri = $main->findAll();
            for ($i = 0; $i < count($data); $i++) {
                foreach ($santri as $santri_in) {
                    if ($data[$i]['nama'] == $santri_in["nama_lengkap"]) {
                        $data[$i]['nama_con'] = $santri_in["santri_id"];
                        for ($j = 0; $j < count($array_kobong); $j++) {
                            if (strtoupper($data[$i]['kobong']) == $array_kobong[$j]['kobong']) {
                                $data[$i]['kobong_con'] = $array_kobong[$j]['id'];
                                break;
                            }
                        }
                        break;
                    }
                }
            }
            // dd($santri, $array_kobong, $data);
            if (session()->get("tabel_kobong")) {
                $tabel = session()->get("tabel_kobong");
                $tabel = array_merge($tabel, $data);
            } else {
                $tabel = $data;
            }
            session()->set("tabel_kobong", $tabel);
            return redirect()->to(base_url() . '/datacontrol/perpindahan-kobong');
        }
    }

    /**
     * Updates the database with the data from the session 'tabel_kobong'.
     * If the session 'tabel_kobong' is not set, redirects to the 'perpindahan-kobong' page.
     * Constructs an array of updates with 'santri_id' and 'kobong_con' and attempts to 
     * update the batch in the database. If the update fails, redirects back with an error message.
     * On success, removes the 'tabel_kobong' session and redirects to 'perpindahan-kobong'.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function perpindahan_kobong_update()
    {
        if (!session()->get("tabel_kobong")) {
            return redirect()->to(base_url() . '/datacontrol/perpindahan-kobong');
        }
        $tabel = session()->get("tabel_kobong");
        $updeter = [];
        foreach ($tabel as $data) {
            if ($data["nama_con"] !== null || $data["kobong_con"] !== null) {
                $updater[] = [
                    "santri_id" => $data["nama_con"],
                    "kobong_id" => $data["kobong_con"]
                ];
            }
        }
        $main = new Main();
        // dd($updater);
        if (!$main->updateBatch($updater, 'santri_id')) {
            return redirect()->to(base_url() . '/datacontrol/perpindahan-kobong')->with('error', 'Data gagal di update');
        }
        session()->remove("tabel_kobong");
        return redirect()->to(base_url() . '/datacontrol/perpindahan-kobong');
        // dd($tabel);
    }
    /*************  ✨ Codeium Command ⭐  *************/
    /**
     * Hapus session tabel_kobong dan redirect ke halaman perpindahan-kobong
     *
     * @return void
     */
    /******  36eb56a2-04af-435c-9896-8e481e830bfb  *******/

    public function perpindahan_kobong_cencel()
    {
        session()->remove("tabel_kobong");
        return redirect()->to(base_url() . '/datacontrol/perpindahan-kobong');
    }

    public function santri_baru()
    {
        return view('dbcontrol/santri_baru');
    }

    public function santri_baru_file()
    {
        // dd($file = $this->request->getFile('file'));

        $validationRule = [
            'file' => [
                'rules' => 'uploaded[file]|ext_in[file,xls,xlsx]',
                'errors' => [
                    'uploaded' => 'Tidak ada file yang dipilih',
                    'ext_in'   => 'Jenis file harus xls atau xlsx'
                ]
            ]
        ];
        if (!$this->validate($validationRule)) {
            return redirect()->back()->withInput()->with('validation', \Config\Services::validation());
        }
        $file = $this->request->getFile('file');
        // dd($file->getTempName());
        if ($file->isValid()) {
            // Membaca file tanpa menyimpannya di server
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getTempName());
            $worksheet = $spreadsheet->getActiveSheet();
            $row = 5;
            $col = 2;
            $data = [];
            $high_row = 0;
            while ($worksheet->getCell(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col) . $row)->getValue() != null) {
                $high_row = $row;
                $row++;
            }
            $row = 5;
            for ($i = 4; $i < $high_row; $i++) {
                $data[] = [
                    "nama" => $worksheet->getCell(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col) . $row)->getValue(),
                    "nama_pendek" => $worksheet->getCell(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col + 1) . $row)->getValue(),
                    "kmmi" => $worksheet->getCell(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col + 2) . $row)->getValue(),
                    "kobong" => $worksheet->getCell(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col + 3) . $row)->getValue(),
                    "angkatan" => $worksheet->getCell(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col + 4) . $row)->getValue(),
                    "nama_ada" => 0,
                    "nama_con" => 0,
                    "kelas_con" => 0,
                    "kobong_con" => 0,
                    "angkatan_con" => 0
                ];
                $row++;
            }
            $log = [];
            $main = new Main();
            $kelas = new Kelas();
            $array_kelas = $kelas->findAll();
            $kobong = new Kobong();
            $array_kobong = $kobong->findAll();
            $main->select('santri.santri_id , santri.nama_lengkap , kelas.kmmi, kobong.kobong')
                ->join('kelas', 'santri.kelas_id = kelas.id')
                ->join('kobong', 'santri.kobong_id = kobong.id');
            $santri = $main->findAll();
            for ($i = 0; $i < count($data); $i++) {
                if ($data[$i]["nama"] == "" || $data[$i]["nama_pendek"] == "" || $data[$i]["nama"] == null || $data[$i]["nama_pendek"] == null) {
                    $data[$i]['nama_ada'] = 1;
                }
                for ($j = 0; $j < count($array_kelas); $j++) {
                    if ($data[$i]["kmmi"] == $array_kelas[$j]["kmmi"]) {
                        $data[$i]["kelas_con"] = $array_kelas[$j]["id"];
                        break;
                    } else {
                        $data[$i]["kelas_con"] = 0;
                    }
                }
                for ($j = 0; $j < count($array_kobong); $j++) {
                    if ($data[$i]["kobong"] == $array_kobong[$j]["kobong"]) {
                        $data[$i]["kobong_con"] = $array_kobong[$j]["id"];
                        break;
                    } else {
                        $data[$i]["kobong_con"] = 0;
                    }
                }
                $santri_id = (int)(str_pad($data[$i]["angkatan"], 3, "0", STR_PAD_LEFT) . "000");
                for ($j = 0; $j < count($santri); $j++) {
                    $data[$i]["angkatan"] = str_pad($data[$i]["angkatan"], 3, "0", STR_PAD_LEFT);
                    if (substr($santri[$j]["santri_id"], 0, 3) == $data[$i]["angkatan"]) {
                        $log[$santri_id] = $santri[$j]["santri_id"];
                        if ($santri_id < (int)$santri[$j]["santri_id"]) {
                            $santri_id = (int)$santri[$j]["santri_id"];
                        }
                    }
                }
                $data[$i]["nama_con"] = $santri_id + 1; 
                for ($j = 0; $j < $i; $j++) {
                    if ((int)$data[$i]["nama_con"] == (int)$data[$j]["nama_con"]) {
                        $data[$i]["nama_con"] = $data[$i]["nama_con"] + 1;
                    }
                }
                $data[$i]["nama_con"] = str_pad($data[$i]["nama_con"], 6, "0", STR_PAD_LEFT);
            }
            // dd($data);
            if (session()->get("tabel_santri_baru")) {
                $tabel = session()->get("tabel_santri_baru");
                $tabel = array_merge($tabel, $data);
            } else {
                $tabel = $data;
            }
            // dd($log);
            session()->set("tabel_santri_baru", $tabel);
            return redirect()->to(base_url() . '/datacontrol/santri-baru');
        }
    }
    public function santri_baru_update()
    {
        if (!session()->get("tabel_santri_baru")) {
            return redirect()->to(base_url() . '/datacontrol/santri-baru');
        }
        $tabel = session()->get("tabel_santri_baru");
        $updeter = [];
        foreach ($tabel as $data) {
            if ($data["nama_ada"] == 0) {
                $updeter[] = [
                    "santri_id" => $data["nama_con"],
                    "kelas_id" => (int)($data["kelas_con"] != 0) ? $data["kelas_con"] : null,
                    "kobong_id" => (int)($data["kobong_con"] != 0) ? $data["kobong_con"] : null,
                    "nama_lengkap" => $data["nama"],
                    "nama_pendek" => $data["nama_pendek"],
                ];
            }
        }
        // dd($updeter);
        $main = new Main();
        if (!$main->insertBatch($updeter, "santri_id")) {
            dd($main->errors());
        }
        session()->remove("tabel_santri_baru");
        return redirect()->to(base_url() . '/datacontrol/santri-baru');
        // dd($tabel);
    }
    public function santri_baru_cencel()
    {
        session()->remove("tabel_santri_baru");
        return redirect()->to(base_url() . '/datacontrol/santri-baru');
    }

    public function db_control()
    {
        $main = new Main();
        $main->select("santri.nama_lengkap, santri.nama_pendek , kelas.kmmi, kobong.kobong, santri.santri_id, kelas.umum")
            ->join("kelas", "santri.kelas_id = kelas.id")
            ->join("kobong", "santri.kobong_id = kobong.id");
        $santri = $main->findAll();
        $kelas = new Kelas();
        $kelas->select("id,kmmi, umum");
        $kelas = $kelas->findAll();
        $kobong = new Kobong();
        $kobong->select("id,kobong");
        $kobong = $kobong->findAll();
        $data = [
            "santri" => $santri,
            "kelas" => $kelas,
            "kobong" => $kobong
        ];
        // dd($data);
        return view('dbcontrol/db_control', $data);
    }
    public function db_control_update_santri()
    {
        $post = $this->request->getVar();
        $kobong = new Kobong();
        $kobong->select("id,kobong");
        $kobong = $kobong->findAll();
        $kelas = new Kelas();
        $kelas->select("id,kmmi, umum");
        $kelas = $kelas->findAll();
        foreach ($kobong as $data) {
            if ($data["kobong"] == $post["kobong"]) {
                $post["kobong_id"] = $data["id"];
                break;
            }
        }
        foreach ($kelas as $data) {
            if ($data["kmmi"] == $post["kelas"]) {
                $post["kelas_id"] = $data["id"];
                break;
            }
        }
        $main = new Main();
        // dd($post);
        $main->update($post["santri_id"], ["kelas_id" => $post["kelas_id"], "kobong_id" => $post["kobong_id"], "nama_lengkap" => $post["nama_lengkap"], "nama_pendek" => $post["nama_pendek"]]);
        return redirect()->to(base_url() . '/datacontrol/db-control');
    }
    public function db_control_update_kelas()
    {
        // dd($this->request->getVar());
        $kelas = new Kelas();
        $post = $this->request->getVar();
        // dd($post);
        $kelas->update($post["kelas_id"], ["kmmi" => $post["kmmi"], "umum" => $post["umum"]]);
        return redirect()->to(base_url() . '/datacontrol/db-control');
    }

    public function db_control_update_kobong()
    {
        // dd($this->request->getVar());
        $kobong = new kobong();
        $post = $this->request->getVar();
        // dd($post);
        $kobong->update($post["kobong_id"], ["kobong" => $post["kobong"]]);
        return redirect()->to(base_url() . '/datacontrol/db-control');
    }
    public function db_control_update_drop(){
        $santri = new Main();
        $post = $this->request->getVar();
        $row = $santri->select("santri.*,kobong.kobong,kelas.kmmi,kelas.umum")
                ->join("kobong","kobong.id = santri.kobong_id")
                ->join("kelas","kelas.id = santri.kelas_id")
                ->where('santri_id', $post["drop_id"])
                ->findAll();
        $santri->where("santri_id",$post["drop_id"])
                ->delete();
        $alumni = new Alumni();
        $data = [
            [
                'santri_id' => $row[0]["santri_id"],
                'nama_lengkap' => $row[0]["nama_lengkap"],
                'nama_pendek' => $row[0]["nama_pendek"],
                'kelas_kmmi' => $row[0]["kmmi"],
                'kelas_umum' => $row[0]["umum"],
                'kobong' => $row[0]["kobong"],
            ]
        ];
        $alumni->insertBatch($data);
        return redirect()->to(base_url() . '/datacontrol/db-control');
    }
}

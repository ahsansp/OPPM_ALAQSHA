<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;

class DirectoryControl extends BaseController
{
    use ResponseTrait;
    public function index()
    {
        $folderPath = WRITEPATH . 'form';
        $bs = str_replace(' ', '', '\ ');
        $folderPath = str_replace($bs, '/', $folderPath);
        $map = directory_map($folderPath, 0, true);
        $data = ['dir' => []];
        foreach ($map as $name) {
            $filePath = $folderPath . "/" . $name;
            if (is_readable($filePath)) {
                $contents = file_get_contents($filePath);  // Read the file contents
                $contents = json_decode($contents);
                $data['dir'][] = [
                    'title' => str_replace(".json", "", $name),
                    'type'  => (isset($contents->type)) ? $contents->type : "-",
                    'date'  => $contents->date_start . " - " . $contents->date_end
                ];
            } else {
                $data['dir'][] = [
                    'title' => "invalid file",
                    'type'  => "-",
                    'date'  => "-"
                ];
            }
        }
        // dd($data);
        return view('directory', $data);
    }
    public function upload()
    {
        // dd($this->request->getVar());
        $folderPath = WRITEPATH . 'form';
        $bs = str_replace(' ', '', '\ ');
        $folderPath = str_replace($bs, '/', $folderPath);
        $file = $this->request->getVar('file');
        $file = str_replace("%27", "'", $file);
        $name = $this->request->getVar('nama');

        write_file($folderPath . "/" . $name . ".json", $file);
        $file = json_decode($file, true);
        // dd($file);
        $jenis = $this->request->getVar('type');
        if ($jenis == 'Jadwal Imam') {
            $file['file'] = json_encode($file);
            $file['saved'] = true;
            return view('Form/printImam', $file);
        }
        $file['file'] = json_encode($file);
        $file['saved'] = true;
        // dd($file);
        if ($jenis == 'Jadwal Imam') {
            return view('Form/printImam', $file);
        } else {
            return view('Form/print', $file);
        }
        // return view('Form/print', $file);
    }
    public function file_name()
    {
        $name = $this->request->getVar('name');
        $name = str_replace("%27", "'", $name);
        $folderPath = WRITEPATH . 'form';
        $bs = str_replace(' ', '', '\ ');
        $folderPath = str_replace($bs, '/', $folderPath);
        $map = directory_map($folderPath, 0, true);
        $data = [
            'success' => true
        ];
        foreach ($map as $key => $value) {
            if ($value == $name . ".json") {
                $data['success'] = false;
            }
        }
        return $this->respond($data, 200);;
    }
    public function open()
    {
        $folderPath = WRITEPATH . 'form';
        $bs = str_replace(' ', '', '\ ');
        $folderPath = str_replace($bs, '/', $folderPath);
        $name = $this->request->getVar('name');
        $data = file_get_contents($folderPath . "/" . $name . ".json");
        $data = json_decode($data, true);
        $data["file"] = json_encode($data);
        $data["saved"] = true;
        // dd($data);
        if ($data["type"] == "Jadwal Imam") {
            return view('Form/printImam',$data);
        }
        return view('Form/print', $data);
    }

    public function delete($name)
    {
        $folderPath = WRITEPATH . 'form';
        unlink($folderPath . "/" . $name . ".json");
        return redirect()->to(base_url() . '/directorycontrol');
    }
}

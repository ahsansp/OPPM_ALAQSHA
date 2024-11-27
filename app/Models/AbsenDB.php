<?php

namespace App\Models;

use CodeIgniter\Model;

class AbsenDB extends Model
{
    protected $table            = 'absen_kamar';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'santri_id', 'tanggal', 'jenis_absen', 'keterangan_id'];

    public function getAbsen($kobong, $bulan, $tahun, $jenis)
    {
        $kobong = (substr($kobong, 0, 6) == "KELAS ") ? substr($kobong, 6) : $kobong;
        // $kobong = ($kobong == 'ALL') ? "*" : $kobong;
        $this->select('santri.nama_lengkap,absen_kamar.tanggal,absen_kamar.keterangan_id,absen_kamar.jenis_absen')
            ->join('santri', 'santri.santri_id = absen_kamar.santri_id')
            ->join('kobong', 'kobong.id = santri.kobong_id')
            ->join('kelas', 'kelas.id = santri.kelas_id')
            // ->where('absen_kamar.jenis_absen', $jenis)
            // ->where('', $kobong)
            ->where('MONTH(absen_kamar.tanggal)', $bulan)
            ->where('YEAR(absen_kamar.tanggal)', $tahun);
        if (substr($kobong, 0, 6) == "Kelas ") {
            $this->Like('kelas.kmmi', substr($kobong, 6), 'after');
        } elseif ($kobong == 'All') {
            $this->where('kobong.kobong IS NOT NULL');
        } else {
            $this->Like('kobong.kobong', $kobong);
        }
        if ($jenis == 'shalat') {
            $this->groupStart();
            $this->Like('absen_kamar.jenis_absen', 'subuh');
            $this->orLike('absen_kamar.jenis_absen', 'dzuhur');
            $this->orLike('absen_kamar.jenis_absen', 'ashar');
            $this->orLike('absen_kamar.jenis_absen', 'maghrib');
            $this->orLike('absen_kamar.jenis_absen', 'isya');
            $this->groupEnd();
            // $this->orderBy("FIELD(jenis_absen, 'subuh', 'dzuhur', 'ashar', 'maghrib', 'isya')", 'ASC');
        } elseif ($jenis == 'kobong') {
            $this->where('absen_kamar.jenis_absen', 'kobong');
        }
        $this->orderBy('kobong.id', 'ASC');
        $this->orderBy('santri.santri_id', 'ASC');

        // dd($this->builder()->getCompiledSelect());
        // $absen = 
        return $this->findAll();
    }
}

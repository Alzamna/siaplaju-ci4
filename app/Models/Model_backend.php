<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_backend extends Model
{
    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect(); // koneksi DB CI4
    }

    public function getKodePengaduan()
    {
        $tgl = date("Ymd");
        $q = $this->db->query("SELECT MAX(RIGHT(id_pengaduan,3)) AS kd_max 
                               FROM tbl_pengaduan 
                               WHERE DATE(tgl_input)=CURDATE()");
        $kd = "";
        if ($q->getNumRows() > 0) {
            foreach ($q->getResult() as $k) {
                $tmp = ((int)$k->kd_max) + 1;
                $kd = sprintf("%03s", $tmp);
            }
        } else {
            $kd = "03";
        }
        return $tgl . $kd;
    }

    // ======================= ADMIN =========================
    public function getAllAdmin()
    {
        return $this->db->query("SELECT * FROM tbl_user a 
                                 INNER JOIN tbl_akses b ON a.id_akses=b.id_akses 
                                 WHERE a.aktif='1' 
                                 ORDER BY a.id_akses")
                        ->getResult();
    }

    public function getAllKecamatan()
    {
        return $this->db->query("SELECT * FROM tbl_kecamatan a 
                                 INNER JOIN tbl_rayon b ON a.id_rayon=b.id_rayon 
                                 ORDER BY b.id_rayon DESC, nama_kecamatan ASC")
                        ->getResult();
    }

    public function getAllKabupaten()
    {
        return $this->db->query("SELECT * FROM tbl_kabupaten a 
                                 INNER JOIN tbl_provinsi b ON a.id_provinsi=b.id_provinsi 
                                 ORDER BY id_kabupaten DESC")
                        ->getResult();
    }

    public function getJmlJalan()
    {
        return $this->db->query("SELECT * FROM tbl_jalan a 
                                 INNER JOIN tbl_kecamatan b ON a.id_kecamatan=b.id_kecamatan")
                        ->getNumRows();
    }

    public function getAllJalan($sampai, $dari)
    {
        return $this->db->query("SELECT * FROM tbl_jalan a 
                                 INNER JOIN tbl_kecamatan b ON a.id_kecamatan=b.id_kecamatan 
                                 ORDER BY id_jalan DESC 
                                 LIMIT $dari, $sampai")
                        ->getResult();
    }

    // ======================= PJU =========================
    public function getJmlPju()
    {
        return $this->db->query("SELECT * FROM tbl_pju a 
                                 INNER JOIN tbl_jalan b ON a.id_jalan=b.id_jalan 
                                 INNER JOIN tbl_kecamatan c ON b.id_kecamatan=c.id_kecamatan 
                                 INNER JOIN tbl_rayon d ON c.id_rayon=d.id_rayon")
                        ->getNumRows();
    }

    public function getAllPju($sampai, $dari)
    {
        return $this->db->query("SELECT * FROM tbl_pju a 
                                 INNER JOIN tbl_jalan b ON a.id_jalan=b.id_jalan 
                                 INNER JOIN tbl_kecamatan c ON b.id_kecamatan=c.id_kecamatan 
                                 INNER JOIN tbl_rayon d ON c.id_rayon=d.id_rayon 
                                 ORDER BY id_pju DESC 
                                 LIMIT $dari, $sampai")
                        ->getResult();
    }

    public function getCariPju($id)
    {
        return $this->db->query("SELECT * FROM tbl_pju a 
                                 INNER JOIN tbl_jalan b ON a.id_jalan=b.id_jalan 
                                 INNER JOIN tbl_kecamatan c ON b.id_kecamatan=c.id_kecamatan 
                                 WHERE a.id_pju LIKE '%$id%' 
                                    OR b.nama_jalan LIKE '%$id%'")
                        ->getResult();
    }
	function getDataPju($id){
		return $this->db->query("SELECT * from tbl_pju a INNER JOIN tbl_jalan b
		ON a.id_jalan=b.id_jalan INNER JOIN tbl_kecamatan c
		ON b.id_kecamatan=c.id_kecamatan where id_pju='$id'")->getResult();
	}
	
	function getLihatPju($id){
		return $this->db->query("SELECT * from tbl_pju a INNER JOIN tbl_jalan b
		ON a.id_jalan=b.id_jalan INNER JOIN tbl_kecamatan c
		ON b.id_kecamatan=c.id_kecamatan INNER JOIN tbl_rayon d
		ON c.id_rayon=d.id_rayon where a.id_pju='$id'")->getResult();
	}
	
	function getPetaPju(){
		return $this->db->query("SELECT * from tbl_pju a INNER JOIN tbl_jalan b
		ON a.id_jalan=b.id_jalan INNER JOIN tbl_kecamatan c
		ON b.id_kecamatan=c.id_kecamatan where lat!=''")->getResult();
	}
	
	function getFilterPeta($kec,$jln,$jns,$kds){
		return $this->db->query("SELECT * from tbl_pju a INNER JOIN tbl_jalan b
		ON a.id_jalan=b.id_jalan INNER JOIN tbl_kecamatan c
		ON b.id_kecamatan=c.id_kecamatan where lat!='' AND c.id_kecamatan like '$kec' AND b.id_jalan like '$jln' AND a.jenis like '$jns' AND a.kondisi like '$kds'")->getResult();
	}
	
	function getAllJenisLampu(){
		return $this->db->query("SELECT jenis from tbl_pju group by jenis")->getResult();
	}
	
	function getAllKondisiLampu(){
		return $this->db->query("SELECT kondisi from tbl_pju group by kondisi")->getResult();
	}
	
	function getFilterPetaPublik($kec,$jln){
		return $this->db->query("SELECT * from tbl_pju a INNER JOIN tbl_jalan b
		ON a.id_jalan=b.id_jalan INNER JOIN tbl_kecamatan c
		ON b.id_kecamatan=c.id_kecamatan where lat!='' AND c.id_kecamatan like '$kec' AND b.id_jalan like '$jln'")->getResult();
	}
	
	// JALAN
	
	function getDataJalan(){
		return $this->db->query("SELECT * from tbl_jalan a INNER JOIN tbl_kecamatan b
		ON a.id_kecamatan=b.id_kecamatan order by id_jalan")->getResult();
	}
	
	function getJalan($id){
		return $this->db->query("SELECT *,(SELECT COUNT(*) from tbl_pju where id_jalan='$id') as pju_terpasang from tbl_jalan a INNER JOIN tbl_kecamatan b
		ON a.id_kecamatan=b.id_kecamatan INNER JOIN tbl_rayon c
		ON b.id_rayon=c.id_rayon where a.id_jalan='$id'")->getResult();
	}
	
	function getPengaduanJalan($id){
		return $this->db->query("SELECT * from tbl_pengaduan a INNER JOIN tbl_jalan b
		ON a.id_jalan=b.id_jalan where a.id_jalan='$id'")->getResult();
	}

	public function getLihatJalan($id)
	{
    return $this->db->query("SELECT * FROM tbl_pju a 
                             INNER JOIN tbl_jalan b ON a.id_jalan=b.id_jalan 
                             INNER JOIN tbl_kecamatan c ON b.id_kecamatan=c.id_kecamatan 
                             INNER JOIN tbl_rayon d ON c.id_rayon=d.id_rayon 
                             WHERE b.id_jalan='$id'")
                    ->getResult();
	}
	
	// PENGADUAN
	
	function getJmlPengaduan(){
		return $this->db->query("SELECT * from tbl_pengaduan a left join tbl_jalan b ON a.id_jalan=b.id_jalan")->getNumRows();
	}
	
	function getAllPengaduan($sampai,$dari){
		return $this->db->query("SELECT * from tbl_pengaduan a left join tbl_jalan b ON a.id_jalan=b.id_jalan order by id_pengaduan desc LIMIT $dari, $sampai")->getResult();
	}
	
	function getDataPengaduan($id){
		return $this->db->query("SELECT * from tbl_pengaduan where id_pengaduan='$id'")->getResult();
	}
	
	function getJalanPengaduan($id){
		return $this->db->query("SELECT * from tbl_pengaduan a left join tbl_jalan b
		ON a.id_jalan=b.id_jalan left join tbl_kecamatan c
		ON b.id_kecamatan=c.id_kecamatan where id_pengaduan='$id'")->getResult();
	}
	
	function getCariPengaduan($id){
		return $this->db->query("SELECT * from tbl_pengaduan a left join tbl_jalan b
		ON a.id_jalan=b.id_jalan where a.id_pengaduan like '%$id%' OR a.pelapor like '%$id%' OR b.nama_jalan like '%$id%'")->getResult();
	}
	
	function getPetaPengaduan(){
		return $this->db->query("SELECT * from tbl_pengaduan a left join tbl_jalan b
		ON a.id_jalan=b.id_jalan where a.aktif='1' and lat!=''")->getResult();
	}
	
	// ASPIRASI
	
	function getJmlAspirasi(){
		return $this->db->query("SELECT * from tbl_aspirasi")->getNumRows();
	}
	
	function getAllAspirasi($sampai,$dari){
		return $this->db->query("SELECT * from tbl_aspirasi order by id_aspirasi desc LIMIT $dari, $sampai")->getResult();
	}
	
	function getCariAspirasi($id){
		return $this->db->query("SELECT * from tbl_aspirasi where nama like '%$id%' OR aspirasi like '%$id%'")->getResult();
	}
	
	function getDataAspirasi($id){
		return $this->db->query("SELECT * from tbl_aspirasi where id_aspirasi='$id'")->getResult();
	}
	
	// REKAP
	
	function getFilterRekapPju($kec,$jln,$jns,$kds){
		return $this->db->query("SELECT * from tbl_pju a INNER JOIN tbl_jalan b
		ON a.id_jalan=b.id_jalan INNER JOIN tbl_kecamatan c
		ON b.id_kecamatan=c.id_kecamatan where c.id_kecamatan like '$kec' AND b.id_jalan like '$jln' AND a.jenis like '$jns' AND a.kondisi like '$kds'")->getResult();
	}
	
	function getFilterRekapPengaduan($kec,$jln,$mda,$sts,$tgl_awal,$tgl_akhir){
		return $this->db->query("SELECT * from tbl_pengaduan a INNER JOIN tbl_jalan b
		ON a.id_jalan=b.id_jalan INNER JOIN tbl_kecamatan c
		ON b.id_kecamatan=c.id_kecamatan where c.id_kecamatan like '$kec' AND b.id_jalan like '$jln' AND a.media like '$mda' AND a.status like '$sts' AND a.tgl_pengaduan BETWEEN '$tgl_awal' AND '$tgl_akhir'")->getResult();
	}


    // ======================= CRUD =========================
    public function getAllData($table)
    {
        return $this->db->table($table)->get()->getResult();
    }

    public function getSelectedData($table, $data)
    {
        return $this->db->table($table)->getWhere($data);
    }

    public function updateData($table, $data, $field_key)
    {
        return $this->db->table($table)->update($data, $field_key);
    }

    public function deleteData($table, $data)
    {
        return $this->db->table($table)->delete($data);
    }

    public function insertData($table, $data)
    {
        return $this->db->table($table)->insert($data);
    }

    public function manualQuery($q)
    {
        return $this->db->query($q);
    }
}

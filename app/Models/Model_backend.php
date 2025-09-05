<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_backend extends CI_Model{
    function __construct(){
        parent::__construct();
    }

	public function getKodePengaduan(){
		$tgl = date("Ymd");
		$q = $this->db->query("SELECT MAX(RIGHT(id_pengaduan,3)) AS kd_max FROM tbl_pengaduan WHERE DATE(tgl_input)=CURDATE()");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%03s", $tmp);
            }
        }else{
            $kd = "03";
        }
        return $tgl."".$kd;
	}
	
	// ADMIN	
	function getAllAdmin(){
		return $this->db->query("SELECT * FROM tbl_user a inner join tbl_akses b
		ON a.id_akses=b.id_akses where a.aktif='1' order by a.id_akses")->result();
	}
	
	function getAllKecamatan(){
		return $this->db->query("SELECT * FROM tbl_kecamatan a inner join tbl_rayon b
		ON a.id_rayon=b.id_rayon order by b.id_rayon desc, nama_kecamatan asc")->result();
	}
	
	function getAllKabupaten(){
		return $this->db->query("SELECT * FROM tbl_kabupaten a inner join tbl_provinsi b
		ON a.id_provinsi=b.id_provinsi order by id_kabupaten desc")->result();
	}
	
	function getJmlJalan(){
		return $this->db->query("SELECT * from tbl_jalan a inner join tbl_kecamatan b
		ON a.id_kecamatan=b.id_kecamatan")->num_rows();
	}
	
	function getAllJalan($sampai,$dari){
		return $this->db->query("SELECT * from tbl_jalan a inner join tbl_kecamatan b
		ON a.id_kecamatan=b.id_kecamatan order by id_jalan desc LIMIT $dari, $sampai")->result();
	}
	
	// PJU
	
	function getJmlPju(){
		return $this->db->query("SELECT * from tbl_pju a inner join tbl_jalan b
		ON a.id_jalan=b.id_jalan inner join tbl_kecamatan c
		ON b.id_kecamatan=c.id_kecamatan inner join tbl_rayon d
		ON c.id_rayon=d.id_rayon")->num_rows();
	}
	
	function getAllPju($sampai,$dari){
		return $this->db->query("SELECT * from tbl_pju a inner join tbl_jalan b
		ON a.id_jalan=b.id_jalan inner join tbl_kecamatan c
		ON b.id_kecamatan=c.id_kecamatan inner join tbl_rayon d
		ON c.id_rayon=d.id_rayon order by id_pju desc LIMIT $dari, $sampai")->result();
	}
	
	function getCariPju($id){
		return $this->db->query("SELECT * from tbl_pju a inner join tbl_jalan b
		ON a.id_jalan=b.id_jalan inner join tbl_kecamatan c
		ON b.id_kecamatan=c.id_kecamatan where a.id_pju like '%$id%' OR b.nama_jalan like '%$id%'")->result();
	}
	
	function getDataPju($id){
		return $this->db->query("SELECT * from tbl_pju a inner join tbl_jalan b
		ON a.id_jalan=b.id_jalan inner join tbl_kecamatan c
		ON b.id_kecamatan=c.id_kecamatan where id_pju='$id'")->result();
	}
	
	function getLihatPju($id){
		return $this->db->query("SELECT * from tbl_pju a inner join tbl_jalan b
		ON a.id_jalan=b.id_jalan inner join tbl_kecamatan c
		ON b.id_kecamatan=c.id_kecamatan inner join tbl_rayon d
		ON c.id_rayon=d.id_rayon where a.id_pju='$id'")->result();
	}
	
	function getPetaPju(){
		return $this->db->query("SELECT * from tbl_pju a inner join tbl_jalan b
		ON a.id_jalan=b.id_jalan inner join tbl_kecamatan c
		ON b.id_kecamatan=c.id_kecamatan where lat!=''")->result();
	}
	
	function getFilterPeta($kec,$jln,$jns,$kds){
		return $this->db->query("SELECT * from tbl_pju a inner join tbl_jalan b
		ON a.id_jalan=b.id_jalan inner join tbl_kecamatan c
		ON b.id_kecamatan=c.id_kecamatan where lat!='' AND c.id_kecamatan like '$kec' AND b.id_jalan like '$jln' AND a.jenis like '$jns' AND a.kondisi like '$kds'")->result();
	}
	
	function getAllJenisLampu(){
		return $this->db->query("SELECT jenis from tbl_pju group by jenis")->result();
	}
	
	function getAllKondisiLampu(){
		return $this->db->query("SELECT kondisi from tbl_pju group by kondisi")->result();
	}
	
	function getFilterPetaPublik($kec,$jln){
		return $this->db->query("SELECT * from tbl_pju a inner join tbl_jalan b
		ON a.id_jalan=b.id_jalan inner join tbl_kecamatan c
		ON b.id_kecamatan=c.id_kecamatan where lat!='' AND c.id_kecamatan like '$kec' AND b.id_jalan like '$jln'")->result();
	}
	
	// JALAN
	
	function getDataJalan(){
		return $this->db->query("SELECT * from tbl_jalan a inner join tbl_kecamatan b
		ON a.id_kecamatan=b.id_kecamatan order by id_jalan")->result();
	}
	
	function getJalan($id){
		return $this->db->query("SELECT *,(SELECT COUNT(*) from tbl_pju where id_jalan='$id') as pju_terpasang from tbl_jalan a inner join tbl_kecamatan b
		ON a.id_kecamatan=b.id_kecamatan inner join tbl_rayon c
		ON b.id_rayon=c.id_rayon where a.id_jalan='$id'")->result();
	}
	
	function getLihatJalan($id){
		return $this->db->query("SELECT * from tbl_pju a inner join tbl_jalan b
		ON a.id_jalan=b.id_jalan inner join tbl_kecamatan c
		ON b.id_kecamatan=c.id_kecamatan inner join tbl_rayon d
		ON c.id_rayon=d.id_rayon where b.id_jalan='$id'")->result();
	}
	
	function getPengaduanJalan($id){
		return $this->db->query("SELECT * from tbl_pengaduan a inner join tbl_jalan b
		ON a.id_jalan=b.id_jalan where a.id_jalan='$id'")->result();
	}
	
	// PENGADUAN
	
	function getJmlPengaduan(){
		return $this->db->query("SELECT * from tbl_pengaduan a left join tbl_jalan b ON a.id_jalan=b.id_jalan")->num_rows();
	}
	
	function getAllPengaduan($sampai,$dari){
		return $this->db->query("SELECT * from tbl_pengaduan a left join tbl_jalan b ON a.id_jalan=b.id_jalan order by id_pengaduan desc LIMIT $dari, $sampai")->result();
	}
	
	function getDataPengaduan($id){
		return $this->db->query("SELECT * from tbl_pengaduan where id_pengaduan='$id'")->result();
	}
	
	function getJalanPengaduan($id){
		return $this->db->query("SELECT * from tbl_pengaduan a left join tbl_jalan b
		ON a.id_jalan=b.id_jalan left join tbl_kecamatan c
		ON b.id_kecamatan=c.id_kecamatan where id_pengaduan='$id'")->result();
	}
	
	function getCariPengaduan($id){
		return $this->db->query("SELECT * from tbl_pengaduan a left join tbl_jalan b
		ON a.id_jalan=b.id_jalan where a.id_pengaduan like '%$id%' OR a.pelapor like '%$id%' OR b.nama_jalan like '%$id%'")->result();
	}
	
	function getPetaPengaduan(){
		return $this->db->query("SELECT * from tbl_pengaduan a left join tbl_jalan b
		ON a.id_jalan=b.id_jalan where a.aktif='1' and lat!=''")->result();
	}
	
	// ASPIRASI
	
	function getJmlAspirasi(){
		return $this->db->query("SELECT * from tbl_aspirasi")->num_rows();
	}
	
	function getAllAspirasi($sampai,$dari){
		return $this->db->query("SELECT * from tbl_aspirasi order by id_aspirasi desc LIMIT $dari, $sampai")->result();
	}
	
	function getCariAspirasi($id){
		return $this->db->query("SELECT * from tbl_aspirasi where nama like '%$id%' OR aspirasi like '%$id%'")->result();
	}
	
	function getDataAspirasi($id){
		return $this->db->query("SELECT * from tbl_aspirasi where id_aspirasi='$id'")->result();
	}
	
	// REKAP
	
	function getFilterRekapPju($kec,$jln,$jns,$kds){
		return $this->db->query("SELECT * from tbl_pju a inner join tbl_jalan b
		ON a.id_jalan=b.id_jalan inner join tbl_kecamatan c
		ON b.id_kecamatan=c.id_kecamatan where c.id_kecamatan like '$kec' AND b.id_jalan like '$jln' AND a.jenis like '$jns' AND a.kondisi like '$kds'")->result();
	}
	
	function getFilterRekapPengaduan($kec,$jln,$mda,$sts,$tgl_awal,$tgl_akhir){
		return $this->db->query("SELECT * from tbl_pengaduan a inner join tbl_jalan b
		ON a.id_jalan=b.id_jalan inner join tbl_kecamatan c
		ON b.id_kecamatan=c.id_kecamatan where c.id_kecamatan like '$kec' AND b.id_jalan like '$jln' AND a.media like '$mda' AND a.status like '$sts' AND a.tgl_pengaduan BETWEEN '$tgl_awal' AND '$tgl_akhir'")->result();
	}
	
	// CRUD DATA
	public function getAllData($table)
    {
        return $this->db->get($table)->result();
    }
	 public function getSelectedData($table,$data)
    {
        return $this->db->get_where($table, $data);
    }
    function updateData($table,$data,$field_key)
    {
        $this->db->update($table,$data,$field_key);
    }
    function deleteData($table,$data)
    {
        $this->db->delete($table,$data);
    }
    function insertData($table,$data)
    {
        $this->db->insert($table,$data);
    }
    function manualQuery($q)
    {
        return $this->db->query($q);
    }
}
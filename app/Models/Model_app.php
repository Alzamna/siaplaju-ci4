<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_app extends Model
{
    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    // ================== KODE ==================
    public function getKodePengaduan()
    {
        $tgl = date("Ymd");
        $query = $this->db->query("
            SELECT MAX(RIGHT(id_pengaduan,3)) AS kd_max 
            FROM tbl_pengaduan 
            WHERE DATE(tgl_input) = CURDATE()
        ");

        $kd = "03";
        if ($query->getNumRows() > 0) {
            $row = $query->getRow();
            if ($row->kd_max) {
                $tmp = ((int)$row->kd_max) + 1;
                $kd = sprintf("%03s", $tmp);
            }
        }
        return $tgl . $kd;
    }

    public function getKodePengaduanTanggal($tgl)
    {
        $tanggal = date("Ymd");
        $query = $this->db->query("
            SELECT MAX(RIGHT(id_pengaduan,3)) AS kd_max 
            FROM tbl_pengaduan 
            WHERE DATE(tgl_input) = ?", [$tgl]
        );

        $kd = "03";
        if ($query->getNumRows() > 0) {
            $row = $query->getRow();
            if ($row->kd_max) {
                $tmp = ((int)$row->kd_max) + 1;
                $kd = sprintf("%03s", $tmp);
            }
        }
        return $tanggal . $kd;
    }

    public function getKodeAspirasi()
    {
        $tgl = date("Ymd");
        $query = $this->db->query("
            SELECT MAX(RIGHT(id_aspirasi,3)) AS kd_max 
            FROM tbl_aspirasi 
            WHERE DATE(tgl_aspirasi) = CURDATE()
        ");

        $kd = "03";
        if ($query->getNumRows() > 0) {
            $row = $query->getRow();
            if ($row->kd_max) {
                $tmp = ((int)$row->kd_max) + 1;
                $kd = sprintf("%03s", $tmp);
            }
        }
        return "ASP" . $tgl . $kd;
    }

    // ================== ADMIN ==================
    public function getAllAdmin()
    {
        return $this->db->query("
            SELECT * 
            FROM tbl_user a 
            INNER JOIN tbl_akses b ON a.id_akses = b.id_akses 
            WHERE a.aktif = '1' 
            ORDER BY a.id_akses
        ")->getResult();
    }

    public function getAllKecamatan()
    {
        return $this->db->query("
            SELECT * 
            FROM tbl_kecamatan a 
            INNER JOIN tbl_rayon b ON a.id_rayon = b.id_rayon 
            ORDER BY b.id_rayon DESC, nama_kecamatan ASC
        ")->getResult();
    }

    public function getAllKabupaten()
    {
        return $this->db->query("
            SELECT * 
            FROM tbl_kabupaten a 
            INNER JOIN tbl_provinsi b ON a.id_provinsi = b.id_provinsi 
            ORDER BY id_kabupaten DESC
        ")->getResult();
    }

    public function getJmlJalan()
    {
        return $this->db->query("
            SELECT * 
            FROM tbl_jalan a 
            INNER JOIN tbl_kecamatan b ON a.id_kecamatan = b.id_kecamatan
        ")->getNumRows();
    }

    public function getAllJalan($limit, $offset)
    {
        return $this->db->query("
            SELECT * 
            FROM tbl_jalan a 
            INNER JOIN tbl_kecamatan b ON a.id_kecamatan = b.id_kecamatan 
            ORDER BY id_jalan DESC 
            LIMIT ?, ?
        ", [$offset, $limit])->getResult();
    }

    // ================== PJU ==================
    public function getJmlPju()
    {
        return $this->db->query("
            SELECT * 
            FROM tbl_pju a 
            INNER JOIN tbl_jalan b ON a.id_jalan = b.id_jalan 
            INNER JOIN tbl_kecamatan c ON b.id_kecamatan = c.id_kecamatan 
            INNER JOIN tbl_rayon d ON c.id_rayon = d.id_rayon
        ")->getNumRows();
    }

    public function getAllPju($limit, $offset)
    {
        return $this->db->query("
            SELECT * 
            FROM tbl_pju a 
            INNER JOIN tbl_jalan b ON a.id_jalan = b.id_jalan 
            INNER JOIN tbl_kecamatan c ON b.id_kecamatan = c.id_kecamatan 
            INNER JOIN tbl_rayon d ON c.id_rayon = d.id_rayon 
            ORDER BY id_pju DESC 
            LIMIT ?, ?
        ", [$offset, $limit])->getResult();
    }

    public function getCariPju($id)
    {
        return $this->db->query("
            SELECT * 
            FROM tbl_pju a 
            INNER JOIN tbl_jalan b ON a.id_jalan = b.id_jalan 
            INNER JOIN tbl_kecamatan c ON b.id_kecamatan = c.id_kecamatan 
            WHERE a.id_pju LIKE ? OR b.nama_jalan LIKE ?
        ", ["%$id%", "%$id%"])->getResult();
    }

    public function getDataPju($id)
    {
        return $this->db->query("
            SELECT * 
            FROM tbl_pju a 
            INNER JOIN tbl_jalan b ON a.id_jalan = b.id_jalan 
            INNER JOIN tbl_kecamatan c ON b.id_kecamatan = c.id_kecamatan 
            WHERE id_pju = ?
        ", [$id])->getResult();
    }

    public function getLihatPju($id)
    {
        return $this->db->query("
            SELECT * 
            FROM tbl_pju a 
            INNER JOIN tbl_jalan b ON a.id_jalan = b.id_jalan 
            INNER JOIN tbl_kecamatan c ON b.id_kecamatan = c.id_kecamatan 
            INNER JOIN tbl_rayon d ON c.id_rayon = d.id_rayon 
            WHERE a.id_pju = ?
        ", [$id])->getResult();
    }

    public function getPetaPju()
    {
        return $this->db->query("
            SELECT * 
            FROM tbl_pju a 
            INNER JOIN tbl_jalan b ON a.id_jalan = b.id_jalan 
            INNER JOIN tbl_kecamatan c ON b.id_kecamatan = c.id_kecamatan 
            WHERE lat != ''
        ")->getResult();
    }

    public function getFilterPeta($kec, $jln, $jns, $kds)
    {
        return $this->db->query("
            SELECT * 
            FROM tbl_pju a 
            INNER JOIN tbl_jalan b ON a.id_jalan = b.id_jalan 
            INNER JOIN tbl_kecamatan c ON b.id_kecamatan = c.id_kecamatan 
            WHERE lat != '' 
            AND c.id_kecamatan LIKE ? 
            AND b.id_jalan LIKE ? 
            AND a.jenis LIKE ? 
            AND a.kondisi LIKE ?
        ", [$kec, $jln, $jns, $kds])->getResult();
    }

    public function getAllJenisLampu()
    {
        return $this->db->query("
            SELECT jenis 
            FROM tbl_pju 
            GROUP BY jenis
        ")->getResult();
    }

    public function getAllKondisiLampu()
    {
        return $this->db->query("
            SELECT kondisi 
            FROM tbl_pju 
            GROUP BY kondisi
        ")->getResult();
    }

    public function getFilterPetaPublik($kec, $jln)
    {
        return $this->db->query("
            SELECT * 
            FROM tbl_pju a 
            INNER JOIN tbl_jalan b ON a.id_jalan = b.id_jalan 
            INNER JOIN tbl_kecamatan c ON b.id_kecamatan = c.id_kecamatan 
            WHERE lat != '' 
            AND c.id_kecamatan LIKE ? 
            AND b.id_jalan LIKE ?
        ", [$kec, $jln])->getResult();
    }

    public function getGroupFilterPeta($kec, $jln)
    {
        return $this->db->query("
            SELECT * 
            FROM tbl_pju a 
            INNER JOIN tbl_jalan b ON a.id_jalan = b.id_jalan 
            INNER JOIN tbl_kecamatan c ON b.id_kecamatan = c.id_kecamatan 
            WHERE lat != '' 
            AND c.id_kecamatan LIKE ? 
            AND b.id_jalan LIKE ? 
            GROUP BY c.id_kecamatan
        ", [$kec, $jln])->getResult();
    }

    // ================== JALAN ==================
    public function getDataJalan()
    {
        return $this->db->query("
            SELECT * 
            FROM tbl_jalan a 
            INNER JOIN tbl_kecamatan b ON a.id_kecamatan = b.id_kecamatan 
            ORDER BY id_jalan
        ")->getResult();
    }

    public function getJalan($id)
    {
        return $this->db->query("
            SELECT *, 
                (SELECT COUNT(*) FROM tbl_pju WHERE id_jalan = ?) AS pju_terpasang 
            FROM tbl_jalan a 
            INNER JOIN tbl_kecamatan b ON a.id_kecamatan = b.id_kecamatan 
            INNER JOIN tbl_rayon c ON b.id_rayon = c.id_rayon 
            WHERE a.id_jalan = ?
        ", [$id, $id])->getResult();
    }

    public function getLihatJalan($id)
    {
        return $this->db->query("
            SELECT * 
            FROM tbl_pju a 
            INNER JOIN tbl_jalan b ON a.id_jalan = b.id_jalan 
            INNER JOIN tbl_kecamatan c ON b.id_kecamatan = c.id_kecamatan 
            INNER JOIN tbl_rayon d ON c.id_rayon = d.id_rayon 
            WHERE b.id_jalan = ?
        ", [$id])->getResult();
    }

    // ================== PENGADUAN ==================
    public function getJmlPengaduan()
    {
        return $this->db->query("
            SELECT * 
            FROM tbl_pengaduan 
            WHERE aktif = '1'
        ")->getNumRows();
    }

    public function getAllPengaduan($limit, $offset)
    {
        return $this->db->query("
            SELECT * 
            FROM tbl_pengaduan 
            WHERE aktif = '1' 
            ORDER BY id_pengaduan DESC 
            LIMIT ?, ?
        ", [$offset, $limit])->getResult();
    }

    public function getLihatPengaduan($id)
    {
        return $this->db->query("
            SELECT * 
            FROM tbl_pengaduan a 
            LEFT JOIN tbl_jalan b ON a.id_jalan = b.id_jalan 
            LEFT JOIN tbl_kecamatan c ON b.id_kecamatan = c.id_kecamatan 
            WHERE id_pengaduan = ? 
            AND a.aktif = '1'
        ", [$id])->getResult();
    }

    public function getPengaduanBeranda()
    {
        return $this->db->query("
            SELECT * 
            FROM tbl_pengaduan 
            WHERE aktif = '1' 
            ORDER BY id_pengaduan DESC 
            LIMIT 0, 4
        ")->getResult();
    }

    // ================== ASPIRASI ==================

    public function getJmlAspirasi()
    {
        return $this->db->query("
            SELECT * 
            FROM tbl_aspirasi 
            WHERE aktif = '1'
        ")->getNumRows();
    }

    public function getAllAspirasi($limit, $offset)
    {
        return $this->db->query("
            SELECT * 
            FROM tbl_aspirasi 
            WHERE aktif = '1' 
            ORDER BY id_aspirasi DESC 
            LIMIT ?, ?
        ", [$offset, $limit])->getResult();
    }

    public function getLihatAspirasi($id)
    {
        return $this->db->query("
            SELECT * 
            FROM tbl_aspirasi a
            WHERE id_aspirasi = ? 
            AND a.aktif = '1'
        ", [$id])->getResult();
    }

    public function getAspirasiBeranda()
    {
        return $this->db->query("
            SELECT * 
            FROM tbl_aspirasi 
            WHERE aktif = '1' 
            ORDER BY id_aspirasi DESC 
            LIMIT 0, 4
        ")->getResult();
    }

    // ================== CRUD GENERIC ==================
    public function getAllData($table)
    {
        return $this->db->table($table)->get()->getResult();
    }

    public function getSelectedData($table, $where)
    {
        return $this->db->table($table)->getWhere($where)->getResult();
    }

    public function updateData($table, $data, $where)
    {
        return $this->db->table($table)->update($data, $where);
    }

    public function deleteData($table, $where)
    {
        return $this->db->table($table)->delete($where);
    }

    public function insertData($table, $data)
    {
        return $this->db->table($table)->insert($data);
    }

    public function manualQuery($sql, $params = [])
    {
        return $this->db->query($sql, $params);
    }
}

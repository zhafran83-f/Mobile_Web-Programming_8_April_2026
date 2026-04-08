<?php
class Peserta_model extends CI_Model {

    public function getAll(){
        $this->db->select('
            p.*, 
            p.jenis_kelamin,
            k.nama_kabupaten, 
            ko.nama_kota
        ');
        $this->db->from('Peserta p');
        $this->db->join('Kabupaten k', 'p.kabupaten = k.id_kabupaten', 'left');
        $this->db->join('Kota ko', 'p.kota = ko.id_kota', 'left');

        return $this->db->get()->result();
    }

    public function insert($data){
        return $this->db->insert('Peserta', $data);
    }

    public function getKabupaten(){
        return $this->db->get('Kabupaten')->result();
    }

    public function getKotabyKab($id_kab){
        $this->db->where('id_kabupaten', $id_kab);
        return $this->db->get('Kota')->result();
    }
}
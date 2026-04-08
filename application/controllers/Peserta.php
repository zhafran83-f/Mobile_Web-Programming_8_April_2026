<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peserta extends CI_Controller {


    public function simpan(){

    $this->load->model('Peserta_model');

$hobi = $this->input->post('hobi');
$hobi_string = is_array($hobi) ? implode(',', $hobi) : '';

$data = array(
    'nama' => $this->input->post('nama'),
    'tempatLahir' => $this->input->post('tempat'),
    'tanggalLahir' => $this->input->post('tanggal'),
    'agama' => $this->input->post('agama'),
    'alamat' => $this->input->post('alamat'),
    'telepon' => $this->input->post('telp'),
    'jenis_kelamin' => $this->input->post('jk'),
    'hobi' => $hobi_string,
    'kabupaten' => $this->input->post('kabupaten'),
    'kota' => $this->input->post('kota')
);

$config['upload_path'] = './upload/';
$config['allowed_types'] = 'jpg|png|jpeg';

$this->load->library('upload', $config);

if($this->upload->do_upload('foto')){
    $upload_data = $this->upload->data();
    $data['foto'] = $upload_data['file_name'];
}

    $this->Peserta_model->insert($data);

    redirect('peserta');
    }

    public function getKota(){

        $id_kab = $this->input->post('id_kab');

        $this->load->model('Peserta_model');
        $kota = $this->Peserta_model->getKotaByKab($id_kab);

        echo '<select name="kota" class="form-control">';
        echo '<option value="">-- Pilih Kota --</option>';

        foreach($kota as $k){
            echo '<option value="'.$k->id_kota.'">'.$k->nama_kota.'</option>';
        }

        echo '</select>';
    }

    public function hapus($id){
        $this->db->where('id', $id);
        $this->db->delete('Peserta');
        redirect('peserta');
    }

    public function index(){
        $this->load->model('Peserta_model');

        $data['peserta'] = $this->Peserta_model->getAll();
        $data['kabupaten'] = $this->Peserta_model->getKabupaten();
        $data['edit'] = null; // penting!

        $this->load->view('peserta_view', $data);
    }

    public function edit($id){
        $this->load->model('Peserta_model');

        $data['peserta'] = $this->Peserta_model->getAll();
        $data['kabupaten'] = $this->Peserta_model->getKabupaten();
        $data['edit'] = $this->db->get_where('Peserta', ['id'=>$id])->row();

        $this->load->view('peserta_view', $data);
    }

    public function update(){

    $id = $this->input->post('id');

    $data = array(
        'nama' => $this->input->post('nama'),
        'tempatLahir' => $this->input->post('tempat'),
        'tanggalLahir' => $this->input->post('tanggal'),
        'agama' => $this->input->post('agama'),
        'alamat' => $this->input->post('alamat'),
        'telepon' => $this->input->post('telp'),
        'jenis_kelamin' => $this->input->post('jk'),
        'hobi' => implode(',', $this->input->post('hobi')),
        'kabupaten' => $this->input->post('kabupaten'),
        'kota' => $this->input->post('kota')
    );

    $this->db->where('id', $id);
    $this->db->update('Peserta', $data);

    redirect('peserta');
    }

}
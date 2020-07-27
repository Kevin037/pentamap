<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cpmi extends CI_Controller

{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Master');
        $this->load->model('Penempatan');
    }

    public function index()
    {

        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $data['role'] = $this->db->get('user_role')->result_array();

        // load data count cpmi pmi tka pengangguran
        $data['tka'] = $this->Penempatan->getTotalTKA();
        $data['pmib'] = $this->Penempatan->getTotalPMIB();
        $data['cpmi'] = $this->Penempatan->getTotalCPMI();

        // load data wilayah

        $data['data_cpmi'] = $this->Penempatan->get_cpmi();
        $data['formal'] =  $this->Penempatan->getTotFormalByPenempatan();
        $data['a'] =  $this->Penempatan->getTotalTKA();
        $data['b'] =  $this->Penempatan->getTotalPMIB();

        $data['title'] = 'Data Perusahaan Penempatan Pekerja Migran Indonesia (P3MI) ';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('cpmi/index', $data);
        $this->load->view('templates/footer', $data);
    }

    public function tambah()
    {
        //load data user login session
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $data['role'] = $this->db->get('user_role')->result_array();

        // load data count cpmi pmi tka pengangguran
        $data['tka'] = $this->Penempatan->getTotalTKA();
        $data['pmib'] = $this->Penempatan->getTotalPMIB();
        $data['cpmi'] = $this->Penempatan->getTotalCPMI();

        $data['negara'] = $this->db->get('tb_negara')->result_array();

        // load data 
        $data['data_cpmi'] = $this->Penempatan->get_cpmi();
        $data['perusahaan'] = $this->Penempatan->get_perusahaan();

        $this->form_validation->set_rules('perusahaan', 'Nama Perusahaan PPMI', 'required');

        $this->form_validation->set_rules('nama_pmi', 'Nama PMI', 'required');
        $this->form_validation->set_rules('gender', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat PMI', 'required');
        $this->form_validation->set_rules('lokasi', 'Lokasi Wilayah PMI', 'required');
        $this->form_validation->set_rules('jabatan', 'Jabatan Kerja', 'required');
        $this->form_validation->set_rules('pendidikan', 'Pendidikan Terakhir', 'required');
        $this->form_validation->set_rules('gaji', 'Gaji PMI', 'required');
        $this->form_validation->set_rules('paspor', 'Nomor Paspor', 'required');
        $this->form_validation->set_rules('negara_penempatan', 'Negara Penempatan', 'required');
        $this->form_validation->set_rules('kode_pesawat', 'Kode Pesawat', 'required');
        $this->form_validation->set_rules('pengguna_jasa', 'Pengguna Jasa', 'required');
        $this->form_validation->set_rules('alamat_pengguna_jasa', 'Alamat Pengguna Jasa', 'required');



        if ($this->form_validation->run() == false) {
            $data['title'] = 'Form Data PPPMI (Perusahan Penempatan Pekerja Migran Indonesia)';
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('cpmi/tambah', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $data = [
                'perusahaan' => $this->input->post('perusahaan'),

                'nama_pmi' => $this->input->post('nama_pmi'),
                'jenis_kelamin' => $this->input->post('gender'),
                'tempat_lahir' => $this->input->post('tempat_lahir'),
                'tanggal_lahir' => $this->input->post('tanggal_lahir'),
                'alamat' => $this->input->post('alamat'),
                'wilayah' => $this->input->post('lokasi'),
                'jabatan' => $this->input->post('jabatan'),
                'pendidikan_formal' => $this->input->post('pendidikan'),
                'gaji' => $this->input->post('gaji'),
                'paspor' => $this->input->post('paspor'),
                'negara_penempatan' => $this->input->post('negara_penempatan'),
                'kode_pesawat' => $this->input->post('kode_pesawat'),
                'pengguna_jasa' => $this->input->post('pengguna_jasa'),
                'alamat_pengguna_jasa' => $this->input->post('alamat_pengguna_jasa'),

                'date_created' => date('Y-m-d'),
            ];

            // $data_perusahaan_negara = [
            //     'perusahaan' => $this->input->post('perusahaan'),
            //     'negara_penempatan' => $this->input->post('negara_penempatan'),
            // ];

            $this->db->insert('tb_cpmi', $data);
            // $this->db->insert('tb_perusahaan_negara', $data_perusahaan_negara);
            $this->session->set_flashdata('message', '<div class="alert 
                alert-success" role="alert"> Data PPPMI succesfully Added! </div>');
            redirect('cpmi');
        }
    }

    public function edit($id)
    {
        //load data user login session
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $data['role'] = $this->db->get('user_role')->result_array();

        // load data count cpmi pmi tka pengangguran
        $data['tka'] = $this->Penempatan->getTotalTKA();
        $data['pmib'] = $this->Penempatan->getTotalPMIB();
        $data['cpmi'] = $this->Penempatan->getTotalCPMI();

        // load data 
        $data['negara'] = $this->db->get('tb_negara')->result_array();

        // $data['data_cpmi'] = $this->Penempatan->get_cpmi();
        $data['perusahaan'] = $this->Penempatan->get_perusahaan();
        $data['edit_cpmi'] = $this->Penempatan->get_edit_cpmi($id);


        $this->form_validation->set_rules('perusahaan', 'Nama Perusahaan PPMI', 'required');

        $this->form_validation->set_rules('nama_pmi', 'Nama PMI', 'required');
        $this->form_validation->set_rules('gender', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat PMI', 'required');
        $this->form_validation->set_rules('lokasi', 'Lokasi Wilayah PMI', 'required');
        $this->form_validation->set_rules('jabatan', 'Jabatan Kerja', 'required');
        $this->form_validation->set_rules('pendidikan', 'Pendidikan Terakhir', 'required');
        $this->form_validation->set_rules(
            'gaji',
            'Gaji PMI',
            'required'
        );
        $this->form_validation->set_rules('paspor', 'Nomor Paspor', 'required');
        $this->form_validation->set_rules('negara_penempatan', 'Negara Penempatan', 'required');
        $this->form_validation->set_rules('kode_pesawat', 'Kode Pesawat', 'required');
        $this->form_validation->set_rules('pengguna_jasa', 'Pengguna Jasa', 'required');
        $this->form_validation->set_rules('alamat_pengguna_jasa', 'Alamat Pengguna Jasa', 'required');
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Edit Data Form Laporan TKA per Perusahaan';
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('cpmi/edit', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $data = [
                'perusahaan' => $this->input->post('perusahaan'),

                'nama_pmi' => $this->input->post('nama_pmi'),
                'jenis_kelamin' => $this->input->post('gender'),
                'tempat_lahir' => $this->input->post('tempat_lahir'),
                'tanggal_lahir' => $this->input->post('tanggal_lahir'),
                'alamat' => $this->input->post('alamat'),
                'wilayah' => $this->input->post('lokasi'),
                'jabatan' => $this->input->post('jabatan'),
                'pendidikan_formal' => $this->input->post('pendidikan'),
                'gaji' => $this->input->post('gaji'),
                'paspor' => $this->input->post('paspor'),
                'negara_penempatan' => $this->input->post('negara_penempatan'),
                'kode_pesawat' => $this->input->post('kode_pesawat'),
                'pengguna_jasa' => $this->input->post('pengguna_jasa'),
                'alamat_pengguna_jasa' => $this->input->post('alamat_pengguna_jasa'),
            ];

            // $data_perusahaan_negara = [
            //     'perusahaan' => $this->input->post('perusahaan'),
            //     'negara_penempatan' => $this->input->post('negara_penempatan'),
            // ];

            $this->db->where('id', $id);
            $this->db->update('tb_cpmi', $data);

            // $this->db->update('tb_perusahaan_negara',$data_perusahaan_negara);
            $this->session->set_flashdata('message', '<div class="alert 
                alert-success" role="alert"> Data PPPMI succesfully Updated! </div>');
            redirect('cpmi');
        }
    }

    public function hapus($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tb_cpmi');

        $this->session->set_flashdata('message', '<div class="alert 
            alert-success" role="alert"> Your selected PPPMI has succesfully deleted, be carefull for manage data. </div>');
        redirect('cpmi');
    }

    public function laporan_pmi()
    {

        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $data['role'] = $this->db->get('user_role')->result_array();

        // load data count cpmi pmi tka pengangguran
        $data['tka'] = $this->Penempatan->getTotalTKA();
        $data['pmib'] = $this->Penempatan->getTotalPMIB();
        $data['cpmi'] = $this->Penempatan->getTotalCPMI();

        // load data wilayah

        $data['data_pppmi'] = $this->Penempatan->get_lap_pppmi();
        // count
        $data['data_taiwan_lk'] = $this->Penempatan->get_taiwan_lk();
        $data['data_taiwan_pr'] = $this->Penempatan->get_taiwan_pr();
        $data['data_hongkong_lk'] = $this->Penempatan->get_hongkong_lk();
        $data['data_hongkong_pr'] = $this->Penempatan->get_hongkong_pr();
        $data['data_sin_lk'] = $this->Penempatan->get_sin_lk();
        $data['data_sin_pr'] = $this->Penempatan->get_sin_pr();
        $data['data_may_lk'] = $this->Penempatan->get_may_lk();
        $data['data_may_pr'] = $this->Penempatan->get_may_pr();
        // $data['formal'] =  $this->Penempatan->getTotFormalByPenempatan();
        // $data['a'] =  $this->Penempatan->getTotalTKA();
        // $data['b'] =  $this->Penempatan->getTotalPMIB();

        $data['title'] = 'Data AN Penempatan Pekerja Migran Indonesia ';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('cpmi/laporan_pmi', $data);
        $this->load->view('templates/footer', $data);
    }
}

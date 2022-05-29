<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gejala extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('M_gejala');
        if ($this->session->userdata('email') == null) {
            redirect('Login', 'refresh');
        }
    }
    public function index()
    {
        $data['title'] = 'Halaman Gejala';
        $data['kode'] = $this->M_gejala->kode();
        $data['gejala'] = $this->M_gejala->SemuaData();
        // $data['data'] = $this->db->get_where('admin', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('gejala/v_gejala', $data);
        $this->load->view('templates/footer', $data);
    }

    public function tambah_gejala()
    {
        $data['title'] = 'Halaman Tambah Gejala';
        $data['gejala'] = $this->M_gejala->SemuaData();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('gejala/v_gejala', $data);
        $this->load->view('templates/footer');
    }
    public function proses_tambah_gejala()
    {
        $this->M_gejala->proses_tambah_gejala();

        redirect('Gejala');
    }
    public function edit_gejala($id)
    {
        $data['title'] = 'Halaman Edit Gejala';
        $data['gejala'] = $this->M_gejala->ambil_id_gejala($id);
        // $data['data'] = $this->db->get_where('admin', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('gejala/v_gejala', $data);
        $this->load->view('templates/footer', $data);
    }
    public function proses_edit_gejala($id = null)
    {
        $this->M_gejala->proses_edit_gejala($id);

        redirect('Gejala');
    }

    public function hapus_gejala($id)
    {
        $this->M_gejala->hapus_gejala($id);

        redirect('Gejala');
    }
}

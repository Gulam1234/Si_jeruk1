<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengetahuan extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('M_pengetahuan');
        if ($this->session->userdata('email') == null) {
            redirect('Login', 'refresh');
        }
    }

    public function index()
    {
        $data['title'] = 'Halaman Basis Pengetahuan';
        $data['basis_pengetahuan'] = $this->M_pengetahuan->SemuaData();
        $data['kode'] = $this->M_pengetahuan->kode();
        // $data['data'] = $this->db->get_where('admin', ['email' => $this->session->userdata('email')])->row_array();
        $data['penyakit'] = $this->M_pengetahuan->penyakit();
        $data['gejala'] = $this->M_pengetahuan->gejala();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('pengetahuan/v_pengetahuan', $data);
        $this->load->view('templates/footer', $data);
    }
    public function tambah_pengetahuan()
    {
        $data['title'] = 'Halaman Tambah Pengetahuan';
        $data['basis_pengetahuan'] = $this->M_pengetahuan->SemuaData();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('pengetahuan/v_pengetahuan', $data);
        $this->load->view('templates/footer');
    }
    public function proses_tambah_pengetahuan()
    {
        $this->M_pengetahuan->proses_tambah_pengetahuan();



        redirect('Pengetahuan');
    }
    public function edit_pengetahuan($id)
    {

        $data['title'] = 'Halaman Edit Pengetahuan';
        $data['basis_pengetahuan'] = $this->M_pengetahuan->ambil_id_pengetahuan($id);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('pengetahuan/v_pengetahuan', $data);
        $this->load->view('templates/footer');
    }
    public function proses_edit_pengetahuan($id = null)
    {
        $this->M_pengetahuan->proses_edit_pengetahuan($id);

        redirect('Pengetahuan');
    }

    public function hapus_pengetahuan($id)
    {
        $this->M_pengetahuan->hapus_pengetahuan($id);

        redirect('Pengetahuan');
    }
}

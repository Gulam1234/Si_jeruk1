<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Beranda extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('M_beranda');
        if ($this->session->userdata('email') == null) {
            redirect('Login', 'refresh');
        }
    }
    public function index()
    {
        // $data['data'] = $this->db->get_where('admin', ['email' => $this->session->userdata('email')])->row_array();
        $data['gejala'] = $this->M_beranda->jml_gejala()->row();
        $data['penyakit'] = $this->M_beranda->jml_penyakit()->row();
        $data['pengetahuan'] = $this->M_beranda->jml_pengetahuan()->row();
        $data['user'] = $this->M_beranda->jml_user()->row();
        $data['title'] = 'Halaman Beranda';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('v_beranda', $data);
        $this->load->view('templates/footer', $data);
    }
}

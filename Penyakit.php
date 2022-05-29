<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penyakit extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('M_penyakit');
        if ($this->session->userdata('email') == null) {
            redirect('Login', 'refresh');
        }
    }
    public function index()
    {
        $data['title'] = 'Halaman Hama/Penyakit';
        $data['kode'] = $this->M_penyakit->kode();
        $data['penyakit'] = $this->M_penyakit->SemuaData();
        // $data['data'] = $this->db->get_where('admin', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('penyakit/v_penyakit', $data);
        $this->load->view('templates/footer', $data);
    }
    public function tambah_penyakit()
    {
        $data['title'] = 'Halaman Tambah Hama/Penyakit';
        $data['penyakit'] = $this->M_penyakit->SemuaData();
        // $data['data'] = $this->db->get_where('admin', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('penyakit/v_penyakit', $data);
        $this->load->view('templates/footer', $data);
    }
    public function proses_tambah_penyakit()
    {
        $config['upload_path']          = './assets/gambar/';
        $config['allowed_types']        = 'gif|jpg|png|PNG|jpeg';
        $config['max_size']             = 2048;
        $config['max_width']            = 10000;
        $config['max_height']           = 10000;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('userfile')) {
            echo "Gagal Tambah";
        } else {
            $gambar = $this->upload->data();
            $gambar = $gambar['file_name'];
            $kode = $this->input->post('kode', TRUE);
            $nama_penyakit = $this->input->post('nama_penyakit', TRUE);
            $kategori = $this->input->post('kategori', TRUE);
            $srn_penyakit = $this->input->post('srn_penyakit', TRUE);

            $data = array(
                'kode_penyakit' => $kode,
                'nama_penyakit' => $nama_penyakit,
                'kategori' => $kategori,
                'srn_penyakit' => $srn_penyakit,
                'gambar' => $gambar,
            );
            $tambah = $this->db->insert('penyakit', $data);
            if ($tambah) {
                $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">
                Data Berhasil ditambah! 
                </div>');
            } else {
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">
                Data Gagal ditambah! 
                </div>');
            }

            redirect('Penyakit');
        }
    }
    public function edit_penyakit($id)
    {
        $data['title'] = 'Halaman Edit Hama/Penyakit';
        $data['admin'] = $this->M_penyakit->ambil_id_penyakit($id);
        // $data['data'] = $this->db->get_where('admin', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('penyakit/v_penyakit', $data);
        $this->load->view('templates/footer', $data);
    }
    public function proses_edit_penyakit($id = null)
    {
        $id = $this->input->post('kode_penyakit');
        $config['upload_path']          = './assets/gambar/';
        $config['allowed_types']        = 'gif|jpg|png|PNG|jpeg';
        $config['max_size']             = 2048;
        $config['max_width']            = 10000;
        $config['max_height']           = 10000;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('userfile')) {
            $nama_penyakit = $this->input->post('nama_penyakit', TRUE);
            $kategori = $this->input->post('kategori', TRUE);
            $srn_penyakit = $this->input->post('srn_penyakit', TRUE);

            $data = array(
                'nama_penyakit' => $nama_penyakit,
                'kategori' => $kategori,
                'srn_penyakit' => $srn_penyakit,
            );
            $this->db->where('kode_penyakit', $id);
            $edit = $this->db->update('penyakit', $data);

            if ($edit) {
                $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">
                Data Berhasil diubah! 
                </div>');
            } else {
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">
                Data Gagal diubah! 
                </div>');
            }

            redirect('Penyakit');
        } else {
            $gambar = $this->upload->data();
            $gambar = $gambar['file_name'];
            $nama_penyakit = $this->input->post('nama_penyakit', TRUE);
            $kategori = $this->input->post('kategori', TRUE);
            $srn_penyakit = $this->input->post('srn_penyakit', TRUE);

            $data = array(
                'nama_penyakit' => $nama_penyakit,
                'kategori' => $kategori,
                'srn_penyakit' => $srn_penyakit,
                'gambar' => $gambar,
            );
            $this->db->where('kode_penyakit', $id);
            $edit = $this->db->update('penyakit', $data);
            if ($edit) {
                $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">
                Data Berhasil diubah! 
                </div>');
            } else {
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">
                Data Gagal diubah! 
                </div>');
            }
            redirect('Penyakit');
        }
    }

    public function hapus_Penyakit($id)
    {
        $this->M_penyakit->hapus_penyakit($id);

        $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">
            Data Berhasil Dihapus!  
            </div>');

        redirect('Penyakit');
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        // $this->load->model('m_login');
    }
    public function index()
    {

        $this->form_validation->set_rules('email', 'Email', 'required|trim', [
            'required' => 'Field tidak boleh kosong'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim', [
            'required' => 'Field tidak boleh kosong'
        ]);

        if ($this->form_validation->run() == false) {
            $this->load->view('v_login');
        } else {
            $this->_login();
        }
    }
    public function _login()
    {
        $username = $this->input->post('email');
        $password = $this->input->post('password');

        if ($username == 'admin@admin.com') {
            if ($password == 'admin') {
                $data = [
                    'email' => 'admin@admin.com'
                ];
                $this->session->set_userdata($data);
                redirect('Beranda');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password anda salah!</div>');
                redirect('Login');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email Anda salah!</div>');
            redirect('Login');
        }
    }
    // public function index()
    // {
    //     $this->load->view('v_login');
    // }
    // public function login_aksi()
    // {
    //     $email = $this->input->post('email', true);
    //     $pass = md5($this->input->post('password', true));

    //     //rule login
    //     $this->form_validation->set_rules('email', 'Email', 'required');
    //     $this->form_validation->set_rules('password', 'Password', 'required');

    //     if ($this->form_validation->run() != false) {
    //         $where = array(
    //             'email' => $email,
    //             'password' => $pass
    //         );

    //         $ceklogin = $this->m_login->cek_login($where)->num_rows();
    //         if ($ceklogin > 0) {
    //             $sess_data = array(
    //                 'email' => $email,
    //                 'login' => 'OK'
    //             );
    //             $this->session->set_userdata($sess_data);
    //             redirect(base_url('Beranda'));
    //         } else {
    //             redirect(base_url('login'));
    //         }
    //     } else {
    //         $this->load->view('v_login');
    //     }
    // }

    public function logout()
    {
        $this->session->sess_destroy();
        $this->session->set_flashdata('message', '<div class="alert alert-succes" role="alert">Berhasil Logout</div>');
        redirect('Login');
    }
}

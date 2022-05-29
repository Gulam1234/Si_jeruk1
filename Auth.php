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

    public function resetPasswordUser()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

            if ($user_token) {
                $this->session->set_userdata('reset_email', $email);
                $this->ubahPasswordUser();
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Token Tidak Tersedia</div>');
                redirect('auth/forgotPassword');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Email Tidak Tersedia</div>');
            redirect('auth/forgotPassword');
        }
    }

    public function ubahPasswordUser()
    {
        if (!$this->session->userdata('reset_email')) {
            redirect('Auth');
        }

        $this->form_validation->set_rules('password1', 'Password', 'trim|required|min_length[4]|matches[password2]', [
            'required' => 'Field tidak boleh kosong',
            'min_length' => 'Masukkan minimal 4 karakter',
            'matches' => 'Password tidak sama'
        ]);
        $this->form_validation->set_rules('password2', 'Repeat Password', 'trim|required|min_length[4]|matches[password1]', [
            'required' => 'Field tidak boleh kosong',
            'min_length' => 'Masukkan minimal 4 karakter',
            'matches' => 'Password tidak sama'
        ]);

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Ubah Paswword';
            $this->load->view('auth/ubahPassword');
        } else {
            // $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
            // $password = md5($this->input->post('password'));
            $password = $this->input->post('password1');
            $email = $this->session->userdata('reset_email');


            $this->db->set('password', md5($password));
            $this->db->where('email', $email);
            $this->db->update('user');

            $this->session->unset_userdata('reset_email');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Password Berhasil Di Reset, Silahkan Login Kembali!</div>');
            redirect('Auth/notif');
        }
    }
}

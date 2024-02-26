<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Model_Login');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index()
	{
		if ($this->session->userdata('id_user')) {
			redirect(base_url('Dashboard'));
		} else {
			$this->session->set_userdata("judul", "Home");
			$this->load->view('login');
		}
	}

	public function proses()
	{
		$this->form_validation->set_rules('username', 'Username', 'required|trim|xss_clean',  array('required' => '%s tidak boleh kosong.'));
		$this->form_validation->set_rules('password', 'Password', 'required|trim|xss_clean', array('required' => '%s tidak boleh kosong.'));

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', 'Username atau password tidak boleh kosong !');
			redirect('Login');
		} else {
			$usr = $this->input->post('username');
			$psw = $this->input->post('password');
			$u = $usr;
			$p = $psw;
			$cek = $this->Model_Login->cek($u, $p);
			if ($cek->num_rows() > 0) {
				$data = $cek->row();
				foreach ($cek->result() as $qad) {
					$sess_data['id_user'] = $qad->log_id;
					$sess_data['username'] = $qad->log_user;
					$sess_data['password'] = $qad->log_pass;
					$sess_data['nama'] = $qad->log_nama;
					$sess_data['level'] = $qad->log_level;
					$sess_data['agen'] = $qad->log_agen;
					$this->session->set_userdata($sess_data);
				}
				$this->session->set_flashdata("success", "Login Berhasil, welcome {$sess_data['nama']}");
				redirect('Dashboard/tampil');
			} else {
				$this->session->set_flashdata('error', 'Username atau password salah !');
				redirect('Login');
			}
		}
	}

	public function ubah_pass()
	{
		$this->form_validation->set_rules('log_pass', 'Password Lama', 'required|trim|xss_clean',  array('required' => '%s tidak boleh kosong.'));
		$this->form_validation->set_rules('log_passBaru', 'Password Baru', 'required|trim|xss_clean', array('required' => '%s tidak boleh kosong.'));
		$this->form_validation->set_rules('log_passBaru2', 'Konfirmasi Password Baru', 'required|trim|xss_clean', array('required' => '%s tidak boleh kosong.'));
		if ($this->form_validation->run() == FALSE) {
			$up_data['status'] = FALSE;
			$up_data['pesan'] = validation_errors();
		} else {
			$u = $this->session->userdata("username");
			$p = $this->input->post('log_pass');
			$cek = $this->Model_Login->cek($u, $p, $this->session->userdata("level"));
			if ($cek->num_rows() > 0) {
				$data = array(
					'log_pass' => md5($this->input->post('log_passBaru'))
				);
				$up_pass = $this->Model_Login->update('sys_login', array('log_user' => $u, 'log_pass' => md5($p)), $data);
				if ($up_pass >= 0) {
					$this->session->sess_destroy();
					$up_data['status'] = TRUE;
					$up_data['pesan'] = "Password berhasil diubah";
				}
			} else {
				$up_data['status'] = FALSE;
				$up_data['pesan'] = "Password lama salah";
			}
		}
		echo json_encode($up_data);
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url("Login"));
	}
}

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_auth');
  }

  function index()
  {
    $this->load->view('login');
  }

  function login()
  {
    redirect('general');
  }

	public function prosesLogin(){
		$this->form_validation->set_rules('email','Email','required');
		$this->form_validation->set_rules('password','Password','required');

		if($this->form_validation->run() == TRUE){
			$email = $this->input->post('email',TRUE);
			$password = $this->input->post('password',TRUE);
      $cek = $this->M_auth->cek_user($email, $password);
			if( $cek->num_rows() != 1){
				$this->session->set_flashdata('msg','Email Dan Password Salah');
				redirect(base_url());
			}else {
				$isi = $cek->row();
        $data_session = array(
          'id' => $isi->id,
          'nama' => $isi->nama,
          'email' => $isi->email,
          'status' => 'login',
          'role' => $isi->id_users_role,
        );

        $this->session->set_userdata($data_session);

        redirect(base_url('general'));
			}
		} else {
      redirect(base_url());
    }
	}

  function logout()
  {
    session_destroy();
    redirect('auth');
  }
}

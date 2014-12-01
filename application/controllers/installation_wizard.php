<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Installation_Wizard extends CI_Controller {
	public function index()
	{
		$this->load->model('Wizard');
		$data['cur_wizard'] = $this->Wizard->set_current_wizard(1);
		$data['wizard'] = $this->Wizard->load_fields();
		
		$this->load->view('header');
		$this->load->view('wizard', $data);
		$this->load->view('footer', $data);
	}
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_settings extends CI_Controller {
	public function index($data, $method=''){
		$this->load->model('wizard');
		$this->wizard->set_current_wizard(6);
		if(isset($_POST['next-step']) && is_numeric($method)){
			$method++;
		}
		$data['step'] = ($method != '' && $method != 'index' ? $method : 1);
		$data['fields'] = $this->wizard->load_fields();
		if(!isset($data['fields'][($data['step']-1)])){
			//echo $data['step'];
			header("Location: ".$data['base'].'dashboard');
		}
		$this->load->view('dashboard/header', $data);
		$this->load->view('dashboard/settings', $data);

		$this->load->view('dashboard/footer', $data);


	}
	public function _remap($method, $params = array()){
		// Standard variables for header
		$data['logged_in'] = ($this->user->isLoggedIn() == true ? true : false);
		$data['base'] = $this->config->item('base_url');
		$data['active_menu'] = 'settings';
		// Load the header
		// check if the user is logged in
		if ($this->user->isLoggedIn()) {
			$this->load->model('promoter/settings');
			if(isset($_POST) && !empty($_POST) || isset($_FILES) && !empty($_FILES)){
				$this->settings->saveSettings();
			}
			$data['settings'] = $this->settings->getAllSettings();
			$this->index($data, $method);
		} else {
			$this->load->view('header', $data);
			$this->load->view('login', $data);
		}
	}
}
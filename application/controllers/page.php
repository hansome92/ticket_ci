<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends CI_Controller {
	public function index($data, $method){
		$this->load->model('pages');
		$data['page'] = $this->pages->load_page($method);
		$this->load->view('frontend/header', $data);
		$this->load->view('frontend/page', $data);

		$this->load->view('frontend/footer', $data);


	}
	/*
		Remapping this controller
	 */
	public function _remap($method, $params = array()){
		// Standard variables for header
		$data['asset_url'] = 'frontend/';
		$data['logged_in'] = ($this->user->isLoggedIn() == true ? true : false);
		$data['fb_login_url'] = $this->facebook_controller->getLoginUrl();
		$data['base'] = $this->config->item('base_url');
		$this->index($data, $method, $params);

	}
}
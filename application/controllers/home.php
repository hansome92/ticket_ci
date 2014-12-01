<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	public function index(){
		$data['base'] = $this->config->item('base_url');

		// Central url for alls assets like .js, .css and images
		$data['asset_url'] = 'frontend/';
		$data['homepage'] = true;
		$data['logged_in'] = ($this->user->isLoggedIn() == true ? true : false);
		$data['fb_login_url'] = $this->facebook_controller->getLoginUrl();
		$data['active_languages'] = $this->translation->getLanguages();
		$this->load->view('frontend/header', $data);
		$this->load->view('frontend/index', $data);
		$this->load->view('frontend/footer', $data);
	}
}
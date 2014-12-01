<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Event extends CI_Controller {
	public function index($meta)
	{
		$data['base'] = $this->config->item('base_url');
		$data['logged_in'] = ($this->user->isLoggedIn() == true ? true : false);
		$data['fb_login_url'] = $this->facebook_controller->getLoginUrl();

		$data['meta'] = $meta;
		$data['event'] = $this->buyer_events->load_event($meta);

		$this->load->view('header', $data);
		$this->load->view('event', $data);
		$this->load->view('footer', $data);
	}
	public function _remap($meta='', $params=null){
		if($meta != '' && $params == null){
			$this->index($meta);
		}
	}
}
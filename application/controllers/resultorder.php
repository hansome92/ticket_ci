<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Resultorder extends CI_Controller {
	public function index()
	{
		$this->buyer_tickets->handle_order();
		$this->buyer_tickets->saveLog($_REQUEST);
		// Standard variables for header
		/*$data['logged_in'] = ($this->user->isLoggedIn() == true ? true : false);
		$data['base'] = $this->config->item('base_url');
		// Laad de header in
		$this->load->view('header', $data);
		if ($this->user->isLoggedIn()) {

			//$data['events'] = $this->events->load_event();
			$this->load->view('promoter', $data);
		} else {
			$this->load->view('login', $data);
		}*/
	}
}
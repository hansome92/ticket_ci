<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {
	public function index()
	{
		if ($this->user->isLoggedIn()) {
			$this->user->logout();
		} 
		header("Location: ".$this->config->item('base_url'));	
	}
}
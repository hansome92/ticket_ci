<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ticket extends CI_Controller {
	public function _remap($method, $params=null)
	{
		$data['base'] = $this->config->item('base_url');
		$data['logged_in'] = ($this->user->isLoggedIn() == true ? true : false);
		if($data['logged_in'] == false){
			
		}
		else{
			
		}
		/*$data['fb_login_url'] = $this->facebook_controller->getLoginUrl();
		$this->load->view('header', $data);
		$data['events'] = $this->buyer_events->load_frontpage_events();
		$this->load->view('events', $data);*/
		$result = $this->buyer_tickets->getTicketByTicketnumber($method, $params);
		if($result == 1){
			echo 'This ticket does not exist.';
		}
		else if(is_array($result)){
			$this->pdf->showTicket($result['ticket'], $result['order']);
		}
	}
}
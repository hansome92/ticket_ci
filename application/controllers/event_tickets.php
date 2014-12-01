<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Event_tickets extends CI_Controller {
	public function index()
	{
		// Standard variables for header
		$data['logged_in'] = ($this->user->isLoggedIn() == true ? true : false);
		$data['base'] = $this->config->item('base_url');
		// Laad de header in
		$this->load->view('header', $data);
		if ($this->user->isLoggedIn()) {

			//$data['events'] = $this->events->load_event();
			$this->load->view('promoter', $data);
		} else {
			$this->load->view('login', $data);
		}
	}
	public function newtickets($event_id){
		if(isset($_POST['preferences'])){
			// Make the new ticket, $result contains the ID the system generates so we can direct the user to the proper eventpage
			$result = $this->promoter_events->registerNewTickettype($event_id);
			if($result !== false){
				// Returns json code so the script 
				//echo 'Location: '.$this->config->item('base_url')."dashboard/event/".$event_id;
				header('Location: '.$this->config->item('base_url')."dashboard/event/".$event_id);
				//echo json_encode(array('redirect', $this->config->item('base_url')."promoter/event/".$result));
			}
		}
		else{
			// Standard variables for header
			$data['logged_in'] = ($this->user->isLoggedIn() == true ? true : false);
			$data['base'] = $this->config->item('base_url');
			$this->load->model('Wizard');
			$data['cur_wizard'] = $this->Wizard->set_current_wizard(5);
			$data['wizard'] = $this->Wizard->load_fields();
			$data['wizard_url'] = $this->config->item('base_url').'dashboard/event/'.$event_id.'/newtickets';
			$this->load->view('header', $data);
			if ($this->user->isLoggedIn()) {
				$this->load->view('wizard', $data);

			}
		}
	}
}
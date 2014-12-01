<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Events extends CI_Controller {
	public function index()
	{
		$data['logged_in'] = ($this->user->isLoggedIn() == true ? true : false);
		$data['base'] = $this->config->item('base_url');
		$data['fb_login_url'] = $this->facebook_controller->getLoginUrl();
		$this->load->view('header', $data);
		$data['events'] = $this->buyer_events->load_frontpage_events();
		$this->load->view('events', $data);
	}
	/************************************
			   		Login
	************************************/
	/*public function login(){
		if(isset($_POST['naam']) && isset($_POST['password'])){
			if($this->user->doLoginPromoter($_POST['naam'], $_POST['password']) === true){
				header("Location: ".$this->config->item('base_url')."promoter");
			}
			else{ 

			}
		}
	}
	/************************************
				New buyer
	************************************/
	/*public function register(){
		if(isset($_POST['preferences'])){
			if($this->user->doesUserExist($_POST['preferences'][4]) == false){
				$result = $this->user->registerPromoter();
				if($this->user->doLoginPromoter($_POST['preferences'][4], $_POST['preferences'][7]) == true){
					echo json_encode(array('redirect', $this->config->item('base_url')."promoter"));
				}
			}
			else{
				echo 'Gebruiker bestaat al.';
			}
		}
		else{
			$data['base'] = $this->config->item('base_url');
			$this->load->model('Wizard');
			$data['cur_wizard'] = $this->Wizard->set_current_wizard(2);
			$data['wizard_url'] = 'promoter/register';
			$data['wizard'] = $this->Wizard->load_fields();
			$this->load->view('header', $data);
			$this->load->view('wizard', $data);
		}
	}
	/**************************************
				   New event
	**************************************/
	/*public function newevent(){
		// If the preferences are set in a form, the system maken a new event.
		if(isset($_POST['preferences'])){
			// Make the new event, $result contains the ID the system generates so we can direct the user to the proper eventpage
			$result = $this->events->registerNewEvent();
			if($result !== false){
				// Returns json code so the script 
				echo json_encode(array('redirect', $this->config->item('base_url')."promoter/event/".$result));
			}
		}
		else{
			$data['base'] = $this->config->item('base_url');
			$this->load->model('Wizard');
			$data['cur_wizard'] = $this->Wizard->set_current_wizard(4);
			$data['wizard_url'] = 'promoter/newevent';
			$data['wizard'] = $this->Wizard->load_fields();
			$this->load->view('header', $data);
			$this->load->view('wizard', $data);
		}
	}*/
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function index()
	{
		$data['logged_in'] = ($this->user->isLoggedIn() == true ? true : false);
		$data['module'] = 'dashboard';
		$data['base'] = $this->config->item('base_url');
		if ($this->user->isLoggedIn() === true) {

			$data['events'] = $this->promoter_events->load_events(5);

			$this->load->model('promoter/statistics');
			$data['statistics'] = $this->statistics->frontpageStatistics();
			$this->load->view('dashboard/header', $data);

			$this->load->view('dashboard/index', $data);
			
		} else {
			header('Location: '.$this->config->item('base_url').'#login');
		}
	}
	/************************************
			   		Login
	************************************/
	public function login(){
		if(isset($_POST['naam']) && isset($_POST['password'])){
			if($this->user->doLoginPromoter($_POST['naam'], $_POST['password']) === true){
				header("Location: ".$this->config->item('base_url')."promoter");
			}
			else{
				
			}
		}
	}
	public function tickets($method){
		$data['event'] = $this->promoter_events->load_event($method);

		$data['logged_in'] = ($this->user->isLoggedIn() == true ? true : false);
		$data['module'] = 'dashboard';
		$data['base'] = $this->config->item('base_url');
		if ($this->user->isLoggedIn() === true) {
			/*
				If there are new tickets in the post, add them to database
			 */
			if(isset($_POST['new-tickets']) && !empty($_POST['tickets'])){
				
				if($this->promoter_events->registerNewTickettypes($method) === true){
					header('Location: '.$this->config->item('base_url_dashboard').'newevent/step_two/'.$method);
				}
				exit();
			}
			$this->load->view('dashboard/header', $data);

			$data['events'] = $this->promoter_events->load_events();
			$this->load->view('dashboard/tickets', $data);
			
		} else {
			header('Location: '.$this->config->item('base_url').'#login');
		}
	}
	/************************************
				New promoter
	************************************/
	public function register(){
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
	public function deleteevent($param=''){
		if($param != ''){
			$this->promoter_events->deleteEvent($param);
		}
		header('Location: '.$this->config->item('base_url').'dashboard/events');
	}
}
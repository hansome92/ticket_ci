<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboardajax extends CI_Controller {
	public function index()
	{
		/*$data['logged_in'] = ($this->user->isLoggedIn() == true ? true : false);
		$data['base'] = $this->config->item('base_url');
		$this->load->view('header', $data);
		$data['events'] = $this->buyer_events->load_frontpage_events();
		$this->load->view('buyer', $data);*/
	}
	/************************************
			   		Login
	************************************/
	public function getdropdownsubtypes(){
		header('Access-Control-Allow-Origin: *');
		$chosen_id = $_POST['chosen_id'];
		$subtypes = array();

		echo json_encode(array('result' => true, 'options' => $subtypes));
		exit();
	}
	public function get_fb_header(){
		$fb_id = $_POST['fb_event_id'];
		$event_id = $_POST['event_id'];
		$this->load->model('facebook_controller');
		$result = $this->facebook_controller->get_fb_header($fb_id, $event_id);

		echo json_encode(array('result' => true, 'url' => $result));
	}
	public function postticketelement(){
		header('Access-Control-Allow-Origin: *');
		$this->load->model('promoter/sponsorships');
		$result = $this->sponsorships->saveElement();
		if(!isset($result['result'])){
			$result['result'] = true;
		}
		echo json_encode($result);
	}
	public function saveanswer(){
		header('Access-Control-Allow-Origin: *');
		$this->load->model('promoter/popups');
		$result = $this->popups->saveAnswer();
		if($result === true){
			echo json_encode( array('result' => true) );
		}
		else{
			echo json_encode( array('result' => false) );
		}
	}
	public function getpopupcontent(){
		header('Access-Control-Allow-Origin: *');
		$this->load->model('promoter/popups');
		$result = $this->popups->getPopupContent();
		if(!empty($result)){
			if(strlen($result['Descript']) > 35){
				$result['Title'] = $result['Descript'];
				$result['Descript'] = substr($result['Descript'], 0, 35).'...';
			}
			echo json_encode( $result );
		}
		else{
			echo json_encode( array('result' => false, 'post' => $_POST) );
		}
	}
	public function savenotofacebookevent(){// Small function to save 'no' to the question if a person wants to load a Facebook event in
		$this->session->set_userdata( array('show-popups' => false) );
	}
}
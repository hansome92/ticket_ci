<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller {
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
	public function login(){
		header('Access-Control-Allow-Origin: *');
		if(isset($_POST['username']) && isset($_POST['password'])){
			if($this->user->doLogin($_POST['username'], $_POST['password']) === true){
				echo json_encode(array('result' => true, 'user_id' => $this->session->userdata('user_id')));
			}
			else{ 
				$data['error'] = 'Login failed, please try again.';
				echo json_encode(array('result' => false, 'error' => $data['error']));
			}
		}
	}
	/************************************
			   		Register // To be changed when things get serious
	************************************/
	public function register(){
		header('Access-Control-Allow-Origin: *');
		if(isset($_POST['username']) && isset($_POST['password']) && $_POST['username'] != '' && $_POST['password'] != ''){
			if(isset($_POST['username']) && isset($_POST['password'])){
				$result = $this->user->temporaryRegister($_POST['username'], $_POST['password']);
				if($this->user->doLogin($_POST['username'], $_POST['password']) === true){
					echo json_encode(array('result' => true));
				}
				else{ 
					$data['error'] = 'Het registreren is niet gelukt.';
					echo json_encode(array('result' => false, 'error' => $data['error']));
				}
			}
			else{
				$data['error'] = 'Het registreren is niet gelukt.';
				echo json_encode(array('result' => false, 'error' => $data['error']));
			}
		}
		else{
			$data['error'] = 'Niet alle velden zijn ingevuld.';
			echo json_encode(array('result' => false, 'error' => $data['error']));
		}
	}
	/*
		Register function 
	 */
	public function registerticketbox(){
		header('Access-Control-Allow-Origin: *');
		$_POST['preferences']['birthday'] = $_POST['preferences']['birthday-day'] . '/'.$_POST['preferences']['birthday-month'] . '/'.$_POST['preferences']['birthday-year'];
		unset($_POST['preferences']['birthday-day']);
		unset($_POST['preferences']['birthday-month']);
		unset($_POST['preferences']['birthday-year']);
		$_POST['username'] = $_POST['emailaddress'];
		$_POST['preferences'][7] = $this->user->randomPassword(8);
		if(isset($_POST['username']) && isset($_POST['preferences'][7]) && $_POST['preferences'][7] != '' && $_POST['preferences'][7] != ''){
			if(isset($_POST['username']) && isset($_POST['preferences'][7])){
				$result = $this->user->ticketboxRegister();
				if($this->user->doLogin($_POST['username'], $_POST['preferences'][7]) === true){
					echo json_encode(array('result' => true));
				}
				else{ 
					$data['error'] = 'Het inloggen is niet gelukt.';
					echo json_encode(array('result' => false, 'error' => $data['error']));
				}
			}
			else{
				$data['error'] = 'Het registreren is niet gelukt.';
				echo json_encode(array('result' => false, 'error' => $data['error']));
			}
		}
		else{
			$data['error'] = 'Niet alle velden zijn ingevuld.';
			echo json_encode(array('result' => false, 'error' => $data['error']));
		}
	}
	/************************************
			Facebook share function
	************************************/
	public function checkiffbshared(){
		header('Access-Control-Allow-Origin: *');
		$data['meta'] = $_POST['meta'];
		$order_id = (isset($_POST['orderid']) ? $_POST['orderid'] : '');
		$this->facebook_controller->checkForsharedStatus($order_id);
		
		/************************************
			Get new payment data(totals)
		************************************/
		$data['order'] = $this->buyer_orders->getOrderById($order_id);
		$data['tickets'] = $this->buyer_tickets->getTicketsByOrderID($order_id);
		$this->load->model('payment_model');
		$data['total'] = $this->payment_model->getTotalPrice($data);
		$data['adminfee'] = $data['total']['adminfee'];
		$data['ensurance'] = $data['total']['ensurance'];
		$data['total'] = $data['total']['total'];
		$data['paymentform'] = $this->payment_model->getPaymentformData(array('merchantReference' => $order_id, 'paymentAmount' => $data['total'] ), $data);

		echo json_encode(array(
			'result' => true, 
			'order_id' => $order_id, 
			'administration_fee_after_shared' => number_format(($data['adminfee']), 2, ',', ' '), 
			'new_total' => $data['total'], 
			'new_total_formatted' => number_format(($data['total']/100), 2, ',', ' '),
			'new_url' => $data['paymentform']['payment_url']
			));
	}
	/**
	 * Send a new password
	 */
	public function sendpassword(){
		require_once('./phpmailer/class.phpmailer.php');
		$result = $this->user->sendNewPassword($_POST['username']);
		if($result === true){
			echo json_encode(array('result' => true));
		}
		else{
			echo json_encode(array('result' => false, 'error' => $result));
		}
	}
	/************************************
				Scan ticket
	************************************/
	public function scanticket(){
		$this->load->model('promoter/app_api');
		$result = $this->app_api->checkTicket();
		echo json_encode(array('result' => $result));
	}
	/*
		Delete ticket from an order
	 */
	public function deleteticketfromorder(){
		$ticket_id = $_POST['ticketid'];
		$result = $this->buyer_tickets->removeTicketFromOrder($ticket_id, $this->session->userdata('user_id'));
		if($result === true){
			echo json_encode(array('result' => true, 'bla' => $_POST['ticketid']));
		}
		else{
			echo json_encode(array('result' => false, 'error' => $result));
		}
		
	}
}
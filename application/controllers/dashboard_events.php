<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_events extends CI_Controller {
	public function index($data){
		$data['events'] = $this->promoter_events->load_events();
		$this->load->view('dashboard/header', $data);
		$this->load->view('dashboard/events', $data);

		$this->load->view('dashboard/footer', $data);


	}
	public function step_one($params, $data){
		/*
			If the post is filled with data, make a new event
		*/
		if(isset($_POST['facebook_event'])){
			$fb_event_id = $_POST['facebook_event'];
			$result = $this->facebook_controller->getFBEventInfo($fb_event_id);
			if($result !== false){
				$_POST["description"] = (isset($result['description']) ? $result['description'] : '' );
				$_POST["venue"] = (isset($result['location']) ? $result['location'] : '' ); 
				$_POST["eventname"] = (isset($result['name']) ? $result['name'] : '' );
				$_POST["start_date"] = (isset($result['start_time']) ? date('d/m/Y', strtotime($result['start_time'])) : '' );
				$_POST["start_time"] = (isset($result['start_time']) ? date('G:i', strtotime($result['start_time'])) : '' );
				$_POST["end_date"] = (isset($result['end_time']) ? date('d/m/Y', strtotime($result['end_time'])) : '' );
				$_POST["end_time"] = (isset($result['end_time']) ? date('G:i', strtotime($result['end_time'])) : '' );
				$_POST["timezone"] = (isset($result['timezone']) ? $result['timezone'] : '' );
				$_POST["city"] = (isset($result['venue']['city']) ? $result['venue']['city'] : '' );
				$_POST["country"] = (isset($result['venue']['country'])  ? $result['venue']['country'] : '' );
				$_POST["location"] = (isset($result['venue']['latitude']) && isset($result['venue']['longitude']) ? '('.$result['venue']['latitude'].', '. $result['venue']['longitude'].')' : '' );
				$_POST["address"] = (isset($result['venue']['street']) ? $result['venue']['street'] : '' );
				$_POST["zip"] = (isset($result['venue']['zip']) ? $result['venue']['zip'] : '' );
				$_POST["fb_event_id"] = (isset($result['id'])  ? $result['id'] : '' );

				$result = $this->promoter_events->registerNewEvent();
				$resultImage = $this->facebook_controller->getFBEventHeader($result, $_POST["fb_event_id"]);
				if($resultImage !== false){
					unset($_POST);
					$_POST['header_photo'] = $resultImage;
					$_POST['event_id'] = $result;
					$this->promoter_events->registerCustomisationVariables();
				}
				header('Location:'.$this->config->item('base_url_dashboard').'newevent/'.$result);
			}
			else{
				$data['error'] = 'Facebook ID is incorrect or the event isn\'t set public.';
			}
		}
		elseif(isset($_POST['eventname']) && $_POST['eventname'] != '' || isset($_POST['event_id']) && $_POST['event_id'] != ''){
			$result = $this->promoter_events->registerNewEvent();
			if($result !== false && is_numeric($result)){
				header('Location:'.$this->config->item('base_url_dashboard').'event/'.$result.'/tickets');
			}
			else{
				exit( 'fout' );
			}
		}
		if(isset($params[0]) && $params[0] != ''){
			$data['event'] = $this->promoter_events->load_event($params[0]);
		}
		else{
			$data['event'] = array();
		}
		$data['eventtypes'] = $this->promoter_events->getTypes();
		/*
			If the post is filled with data, make a new event
		*/
		$data['pageId'] = (isset($params[0]) && $params[0] != '' ? '' : 'newevent');
		$this->load->view('dashboard/header', $data);
		$this->load->view('dashboard/newevent', $data);

		$this->load->view('dashboard/footer', $data);
	}
	/*
		Customizing the events with colorpicking
	 */
	public function step_two($params, $data){
		/*
			If the post is filled with data, make a new preset
		*/
		if(isset($_POST['event_id']) && $_POST['event_id'] != ''){
			if(isset($_POST['header-change'])){
				$postHeader = true;
				unset($_POST['header-change']);
			}
			$result = $this->promoter_events->registerCustomisationVariables();
			if(isset($postHeader) || isset($_POST['submit-type']) && $_POST['submit-type'] == 'Save and edit'){
				if(isset($result['resized']) && $result['resized'] == 1){
					$data['uploaderror'] = 'File extension is not correct.';
				}
			}
			elseif($result !== false){
				header('Location:'.$this->config->item('base_url_dashboard').'newevent/step_four/'.$_POST['event_id']);
			}
			else{
				exit( 'fout' );
			}
		}
		/*
			If the post is filled with data, make a new event
		*/
		$this->load->view('dashboard/header', $data);
		$data['event'] = $this->promoter_events->load_event($params[1]);
		$data['presets'] = $this->promoter_events->load_presets( $this->session->userdata('user_id') );
		$this->load->view('dashboard/customise_event', $data);
		$this->load->view('dashboard/footer', $data);
	}
	public function step_four($params, $data){
		$this->load->model('promoter/sponsorships');
		if(isset($_POST['w'])){
			$targ_w = $targ_h = (isset($_POST['ration']) ? 300*round($_POST['ration']) : 300 );
			$jpeg_quality = 100;

			ini_set('display_errors', 1); 
			error_reporting(E_ALL); 

			$src = './uploads/promotion_images/'.$_POST['url'];
			if($img_r = @imagecreatefromjpeg($src)){
				$sizes = getimagesize($src);
				$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );
				imagecopyresampled($dst_r,$img_r,0,0,$_POST['x1'],$_POST['y1'],
				$targ_w,$targ_h,$_POST['w'],$_POST['h']);
				imagejpeg($dst_r,'./uploads/promotion_images/cropped-'.$_POST['url'],$jpeg_quality);
				header('Location: '.$data['base'].'dashboard/newevent/step_four/'.$data['event_id']);
			}
			else{
				$this->sponsorships->deleteElement($_POST['url']);
				unset($_POST);
				$data['errorupload'] = 'Something went wrong with the uploaded image, please try again later or try to contact us.';
			}
		}
		/*
			If the post is filled with data, make a new event
		*/
		if(!empty($_FILES['upload-element']) && $_FILES['upload-element']['size'] != 0){

			$this->sponsorships->connectSponsorshipsToTicket($_POST['event_id']);
			$result = $this->sponsorships->saveElement();
			$sizes = getimagesize("./uploads/promotion_images/".$result['url']);
			if($sizes[0] > 300 && $sizes[1] > 300){
				$data['posted_image'] = $result['url'];
				$this->load->view('dashboard/header', $data);
				$this->load->view('dashboard/imagecrop', $data);
				$this->load->view('dashboard/footer', $data);
			}
			else{
				header('Location: '.$this->config->item('base_url').'dashboard/newevent/step_four/'.$params[1]);
			}
		}
		else{
			if(isset($_POST) && !empty($_POST)){
				$this->sponsorships->connectSponsorshipsToTicket($_POST['event_id']);
				if(isset($_POST['submit-type']) && $_POST['submit-type'] == 'Publish' || $_POST['submittype'] == 'publish'){
					header('Location: '.$this->config->item('base_url').'dashboard/events');
				}
			}
			$data['sponsorships'] = $this->sponsorships->getsponsorships();
			$data['event'] = $this->promoter_events->load_event($params[1]);
			if(isset($params[2]) && $params[2] == 'pdf'){
				$this->pdf->previewTickets(null, $data['event']);
			}
			else{
				$this->load->view('dashboard/header', $data);
				$this->load->view('dashboard/customise_ticket', $data);
				$this->load->view('dashboard/footer', $data);
			}
		}
	}
	/*
		Remapping this controller
	 */
	public function _remap($method, $params = array()){
		// Standard variables for header
		$data['logged_in'] = ($this->user->isLoggedIn() == true ? true : false);
		$data['base'] = $this->config->item('base_url');
		$data['active_menu'] = 'events';
		$data['event_id'] = (isset($params[1]) && $params[1] != '' ? $params[1] : '');
		// Load the header
		// check if the user is logged in
		if ($this->user->isLoggedIn()) {
			if($method === 'newevent'){
				if(isset($params[0]) && $params[0] == 'step_four'){
					$this->step_four($params, $data);
				}
				elseif(isset($params[0]) && $params[0] == 'step_three'){
					$this->step_three($params, $data);
				}
				elseif(isset($params[0]) && $params[0] == 'step_two'){
					$this->step_two($params, $data);
				}
				else{
					$this->step_one($params, $data);
				}
			}	
			else{
				if(method_exists($this, $method)){
					$this->$method($data);
				}
			}		
		} else {
			header('Location: '.$this->config->item('base_url').'#login');
		}

	}
}
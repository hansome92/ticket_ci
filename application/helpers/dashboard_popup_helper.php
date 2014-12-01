<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('getPopup'))
{
	
	/**
	 * function _getVar
	 * shortcut to model translation->get(); for quicker use
	 */
	function _getPopup($page_id='') 
	{
		// Load current CodeIgniter instance
		$CI = get_instance();
		$CI->load->model('promoter/popups');
		$result = $CI->popups->getPopup( $page_id );
		if(!empty($result)){
			return $result;
		}
		else{
			return array();
		}
	}
}
?>
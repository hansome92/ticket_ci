<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('e'))
{
	
	/**
	 * function _e
	 * shortcut to model translation->get(); for quicker use
	 */
	function _e($string) 
	{
		// Load current CodeIgniter instance
		$CI = get_instance();
		
		// Load model 'Translation'
		$CI->load->model('translation');
		
		// Return translation
		return $CI->translation->get($string);
	}
}
?>
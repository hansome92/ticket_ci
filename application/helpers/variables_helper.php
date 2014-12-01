<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('getVar'))
{
	
	/**
	 * function _getVar
	 * shortcut to model translation->get(); for quicker use
	 */
	function _getVar($string='') 
	{
		// Load current CodeIgniter instance
		$CI = get_instance();

		if($string === 'languages'){
			$CI->load->model('translation');
			
			// Return translation
			return $CI->translation->getLanguages();
		}
		elseif($string === 'curLanguage'){
			$CI->load->model('translation');
			
			// Return translation
			return $CI->translation->get_language();
		}
		else{
			// Load model 'Translation'
			$CI->load->model('translation');
			
			// Return translation
			return $CI->translation->get($string);
		}
	}
}
?>
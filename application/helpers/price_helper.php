<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('getFormattedNumber'))
{
	
	/**
	 * function _getVar
	 * shortcut to model translation->get(); for quicker use
	 */
	function _getFormattedNumber($number='') 
	{
		// Load current CodeIgniter instance
		$CI = get_instance();
		if(is_numeric($number)){
			return NUMBER_FORMAT( $number, 2, ',', '');
		}
		else{
			return $number;
		}
	}
}
?>
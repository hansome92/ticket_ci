<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function base_url($uri = null){
   $CI =& get_instance();

   $cdn = $CI->config->item('base_url');
   if (!empty($cdn))
      return $cdn . $uri;

   return $CI->config->base_url($uri);
}
function sys_url($uri = null){
   $CI =& get_instance();

   $cdn = $CI->config->item('sysadmin_url');
   if (!empty($cdn))
      return $cdn . $uri;

   return $CI->config->base_url($uri);
}
function sys_asset($uri = null){
   $CI =& get_instance();

   $cdn = $CI->config->item('sysadmin_assets_url');
   if (!empty($cdn))
      return $cdn . $uri;

   return $CI->config->base_url($uri);
}
?>
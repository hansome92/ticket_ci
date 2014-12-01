<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['cron/(:any)'] = "cron/$1";

$route['sysadmin/(:any)/(:any)/(:any)'] = "sysadmin/$1/$2/$3";
$route['sysadmin/(:any)/(:any)'] = "sysadmin/$1/$2";
$route['sysadmin/(:any)'] = "sysadmin/$1";
$route['sysadmin'] = "sysadmin";

$route['dashboard/settings/(:any)'] = "dashboard_settings/$1";
$route['dashboard/settings'] = "dashboard_settings";

$route['dashboard/newevent/(:num)'] = "dashboard_events/newevent/$1";
$route['dashboard/newevent/(:any)/(:num)/pdf'] = "dashboard_events/newevent/$1/$2/pdf";
$route['dashboard/newevent/(:any)/(:num)'] = "dashboard_events/newevent/$1/$2";
$route['dashboard/newevent'] = "dashboard_events/newevent";
$route['dashboard/event/(:num)/tickets'] = "dashboard/tickets/$1";
$route['dashboard/event/(:num)/newtickets'] = "event_tickets/newtickets/$1";
$route['dashboard/event/(:num)'] = "dashboard_events/$1";
$route['dashboard/events'] = "dashboard_events/index";

$route['confirmation'] = "order_complete"; // Temporarily, needs to be changed to order/confirmation on Adyen
$route['order/success'] = "order_complete/success";
$route['order/failed'] = "order_complete/failed";
$route['order/postback'] = "order_complete/postback";
$route['order/confirmation'] = "order_complete";
$route['order/(:any)/3'] = "order_tickets/fourth_step/$1";
$route['order/(:any)/2'] = "order_tickets/third_step/$1";
$route['order/(:any)/1'] = "order_tickets/second_step/$1";
$route['order/(:any)/0'] = "order_tickets/first_step/$1";
$route['order/(:any)/(:any)'] = "order_tickets/$2/$1";
$route['order/(:any)'] = "order_tickets/any/$1";
$route['event/(:any)'] = "event/$1";
$route['default_controller'] = "home";
$route['404_override'] = '';
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

/* End of file routes.php */
/* Location: ./application/config/routes.php */
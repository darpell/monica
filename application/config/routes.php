<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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

$route['404_override'] = '';
$route['mobile'] = 'mobile/pages/view/home';
$route['mobile/page/(:any)'] = 'mobile/pages/view/$1';
$route['mobile/login'] = 'mobile/login';
$route['mobile/tasks'] = 'mobile/tasks';
$route['mobile/tasks/(:any)'] = 'mobile/tasks/view/$1';
$route['mobile/tasks/done'] = 'mobile/tasks/done';
$route['mobile/mob_check'] = 'mobile/login/mob_check';
$route['mobile/page/addls'] = 'user/lsform/addls';
$route['mobile/page/new_poi'] = 'mobile/poi/add';
$route['mobile/page/uninvestigated_cases'] = 'mobile/investigate_cases';
$route['mobile/cases/(:num)'] = 'mobile/investigate_cases/plot/$1';
$route['mobile/cases/add'] = 'mobile/investigate_cases/add';
$route['mobile/immediate_case'] = 'mobile/immediate_case';
$route['mobile/page/case_add'] = 'mobile/immediate_case/add';
$route['mobile/riskmap_options'] = 'mobile/larval/options';
$route['mobile/larval_dialog'] = 'mobile/larval/filter_points';
$route['mobile/case_dialog'] = 'mobile/cases/filterPoints';
$route['mobile/riskmap'] = 'mobile/larval';
$route['mobile/case_report'] = 'mobile/case_report';
$route['mobile/page/master_list'] = 'mobile/master_list';
$route['mobile/page/master_list/(:any)'] = 'mobile/master_list/$1';
$route['mobile/household/(:num)'] = 'mobile/master_list/view_household/$1';
// Mob Serious Cases
$route['mobile/view/serious_cases'] = 'mobile/monitored_cases/serious_cases';
$route['mobile/view/serious_cases/(:num)'] = 'mobile/monitored_cases/view_serious_case_details/$1';
// Mob Suspected Casses
$route['mobile/view/suspected_cases'] = 'mobile/monitored_cases/suspected_cases';
$route['mobile/view/suspected_cases/(:num)'] = 'mobile/monitored_cases/view_suspected_case_details/$1';

$route['mobile/view/person/(:num)'] = 'mobile/master_list/edit_immediate_case/$1'; # DONE
$route['mobile/view/household/(:num)/case/(:num)'] = 'mobile/master_list/view_edit_person';
$route['mobile/view/household/(:num)/case/(:num)/edit_case'] = 'mobile/master_list/edit_immediate_case';
$route['mobile/view/household/(:num)/person/(:num)'] = 'mobile/master_list/view_person';
$route['mobile/view/household/(:num)/person/(:num)/add_im'] = 'mobile/master_list/add_immediate_case';
$route['mobile/case_report_filter/province'] = 'mobile/case_report/province';
$route['mobile/case_report_filter/cities'] = 'mobile/case_report/cities';
$route['mobile/case_report_filter/brgys'] = 'mobile/case_report/brgys';
$route['mobile/case_report_filter/places'] = 'mobile/case_report/places';
$route['mobile/case_report_filter/filter_places'] = 'mobile/case_report/filter_places';
$route['upload'] = 'user/upload';
$route['case_report'] = 'user/crform';
$route['upload/(:any)'] = 'user/upload/$1';
$route['avemap'] = 'user/avemap';
$route['mapping'] = 'user/mapform';
$route['mapping/(:any)'] = 'user/mapform/$1';
$route['addmap'] = 'user/addmap';
$route['addmap/(:any)'] = 'user/addmap/$1';
$route['deletemap'] = 'user/deletemap';
$route['deletemap/(:any)'] = 'user/deletemap/$1';
$route['investigatedcases'] = 'user/investigatedcases';
$route['investigatedcases/(:any)'] = 'user/investigatedcases/$1';
$route['login'] = 'user/login';
$route['login/(:any)'] = 'user/login/$1';
$route['larval_survey'] = 'user/lsform';
$route['larval_survey/(:any)'] = 'user/lsform/$1';
$route['case_report/(:any)'] = 'user/crform/$1';
$route['CHO'] = 'user/cho';
$route['CHO/(:any)'] = 'user/cho/$1';
$route['suggested'] = 'user/suggest';
$route['suggested/(:any)'] = 'user/suggest/$1';
$route['tweet'] = 'user/twtest';
$route['tweet/(:any)'] = 'user/twtest/$1';
$route['master_list'] = 'user/master_list';
$route['master_list/(:any)'] = 'user/master_list/$1';
$route['remap'] = 'user/remap';
$route['default_controller'] = 'user/pages/view';
$route['logout'] = 'user/login/logout';
$route['mobile/logout'] = 'mobile/login/logout';
$route['(:any)'] = 'user/pages/view/$1';


/* End of file routes.php */
/* Location: ./application/config/routes.php */

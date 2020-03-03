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

$route['default_controller'] = "webapp";
$route['404_override'] = 'httperrors/show_404';

$route['registration/(:any)'] = 'registrations/index/$1';
$route['registration'] = 'registrations/index';


$route['language'] = 'webapp/language';
$route['daily-quest'] = 'webapp/dailyquest';
$route['daily-quest/activity'] = 'webapp/activity';
$route['explore'] = 'webapp/explore';
$route['explore/wordy-birdy'] = 'webapp/wordybirdy';
$route['stories/video'] = 'webapp/video';
$route['stories/books'] = 'webapp/books';
$route['stories/rhymes'] = 'webapp/rhymes';
$route['stories/my-friends'] = 'webapp/myfriends';
$route['stories/my-friends1'] = 'webapp/myfriends1';
$route['stories/story1'] = 'webapp/story1';
$route['stories/story2'] = 'webapp/story2';
$route['stories/story-complete'] = 'webapp/storycomplete';
$route['changelanguage/(:any)'] = 'webapp/changelanguage/$1';
$route['profile'] = 'webapp/profile';
$route['profile/edit-info'] = 'webapp/editinfo';
$route['login/(:any)'] = 'webapp/login/$1';
$route['login'] = 'webapp/login';
$route['dashboard'] = 'webapp/dashboard';
$route['sign-up'] = 'webapp/signup';
$route['logout'] = 'webapp/logout';
$route['registration-complete/(:any)'] = 'webapp/registrationcomplete/$1';
$route['registration-complete'] = 'webapp/registrationcomplete';
$route['onboarding'] = 'webapp/onboarding';


$route['explore/world/(:any)'] = 'webapp/exploreworld/$1';
$route['stories/start/(:any)'] = 'webapp/storiesstart/$1';
$route['stories/vstart/(:any)'] = 'webapp/storiesvstart/$1';
$route['stories/pages/(:any)/(:any)'] = 'webapp/storiespage/$1/$2';
$route['stories/complete/(:any)'] = 'webapp/storiescomplete/$1';
$route['stories/vcomplete/(:any)'] = 'webapp/storiesvcomplete/$1';

$route['activity/(:any)/start'] = 'webapp/activitystart/$1';
$route['activity/question/(:any)'] = 'webapp/activitypage/$1';
$route['stories/questions/(:any)'] = 'webapp/storiesquestions/$1';
$route['stories/questionsv/(:any)'] = 'webapp/storiesquestionsv/$1';

$route['rest/api/v1/authenticate_user'] = 'webapp/authenticateuser';
$route['sso/token/(:any)'] = 'webapp/ssotoken/$1';
$route['rest/api/v1/student_report'] = 'webapp/studetrecord';

/* End of file routes.php */
/* Location: ./application/config/routes.php */
?>

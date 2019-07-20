<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//custom

//default
$route['default_controller'] = 'HomeController';
$route['404_override'] = 'HomeController/error';
$route['translate_uri_dashes'] = FALSE;

?>
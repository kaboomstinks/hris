<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function fn_print_r()
{
	static $count = 0;
	$args = func_get_args();

	if (!empty($args)) {
		echo '<ol id="fn_print_r" style="font-family: Courier; font-size: 12px; border: 1px solid #dedede; background-color: #efefef; float: left; padding-right: 20px;">';
		foreach ($args as $k => $v) {
			$v = htmlspecialchars(print_r($v, true));
			if ($v == '') {
				$v = '    ';
		}

			echo '<li><pre>' . $v . "\n" . '</pre></li>';
		}
		echo '</ol><div style="clear:left;"></div>';
	}
	$count++;
}

function fn_print_die()
{
	$args = func_get_args();
	call_user_func_array('fn_print_r', $args);
	die();
}

function checkIsAjax() {
	if($_SERVER['REQUEST_METHOD'] === 'POST') {
		return true;
	} 
	
	return false;
}

function isAdmin(){
	$ci =& get_instance();

	if($ci->session->userdata['credential'] == 1){
		return true;
	} 
		return false;
}

function isLoggedIn(){
	$ci =& get_instance();
	
	if(!isset($ci->session->userdata['usersession'])) {
		redirect('login', 'refresh');
	} 
	
}
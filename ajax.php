<?php
/*
 * *************************************************************
 * Copyright notice
 *
 * (c) 2014 exabis internet solutions <info@exabis.at>
 * All rights reserved
 *
 * You can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This module is based on the Collaborative Moodle Modules from
 * NCSA Education Division (http://www.ncsa.uiuc.edu)
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 * *************************************************************
 */

require_once dirname(__FILE__)."/../../config.php";

global $DB, $OUTPUT, $PAGE, $USER;

$context = context_system::instance();
require_login();
$PAGE->set_context($context);

if(!has_capability('block/exadelete:admin', $context)){
	die('not allowed to access this site');
}

require_sesskey();



$action = required_param('action', PARAM_TEXT);

switch($action){
	case ('exacomp'):
		require_once dirname(__FILE__)."/../exacomp/lib/lib.php";
		$users = required_param('users', PARAM_TEXT);
		$user_ids = json_decode($users);
		
		foreach($user_ids as $user){
			block_exacomp_delete_user_data($user);
		}
		
		break;
	case ('exaport'):
		require_once dirname(__FILE__)."/../exaport/lib/lib.php";
		$users = required_param('users', PARAM_TEXT);
		$user_ids = json_decode($users);
		
		foreach($user_ids as $user){
			block_exaport_delete_user_data($user);
		}
		break;
	case('exastud'):
		require_once dirname(__FILE__)."/../exastud/lib/lib.php";
		$users = required_param('users', PARAM_TEXT);
		$user_ids = json_decode($users);
		
		foreach($user_ids as $user){
			block_exastud_delete_user_data($user);
		}
		
		break;
	default:
		print_error('wrong action: '.$action);
}

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
		$users = required_param('users', PARAM_TEXT);
		$user_ids = json_decode($users);
		
		foreach($user_ids as $user){
			$result = $DB->delete_records('block_exacompcompuser', array("userid"=>$user));
			$result = $DB->delete_records('block_exacompcompuser_mm', array("userid"=>$user));
			$result = $DB->delete_records('block_exacompprofilesettings', array("userid"=>$user));
			
			$result = $DB->delete_records('block_exacompcrossstud_mm', array("studentid"=>$user));
			$result = $DB->delete_records('block_exacompdescrvisibility', array("studentid"=>$user));
			$result = $DB->delete_records('block_exacompexameval', array("studentid"=>$user));
			$result = $DB->delete_records('block_exacompexampvisibility', array("studentid"=>$user));
			$result = $DB->delete_records('block_exacompexternaltrainer', array("studentid"=>$user));
			$result = $DB->delete_records('block_exacompschedule', array("studentid"=>$user));
			
			$result = $DB->delete_records('block_exacompcrosssubjects', array("creatorid"=>$user));
			$result = $DB->delete_records('block_exacompexamples', array("creatorid"=>$user));
			$result = $DB->delete_records('block_exacompschedule', array("creatorid"=>$user));
			
			$result = $DB->delete_records('block_exacompexameval', array("teacher_reviewerid"=>$user));
			
			$result = $DB->delete_records('block_exacompexternaltrainer', array("trainerid"=>$user));
			
			$result = $DB->delete_records('block_exacompcompuser', array("reviewerid"=>$user));
			$result = $DB->delete_records('block_exacompcompuser_mm', array("reviewerid"=>$user));	
		}
		
		break;
	case ('exaport'):
		$users = required_param('users', PARAM_TEXT);
		$user_ids = json_decode($users);
		
		foreach($user_ids as $user){
			$result = $DB->delete_records('block_exaportcate', array('userid'=>$user));
			$result = $DB->delete_records('block_exaportcatshar', array('userid'=>$user));
			$result = $DB->delete_records('block_exaportcat_structshar', array('userid'=>$user));
			$result = $DB->delete_records('block_exaportitem', array('userid'=>$user));
			$result = $DB->delete_records('block_exaportitemcomm', array('userid'=>$user));
			$result = $DB->delete_records('block_exaportitemshar', array('userid'=>$user));
			$result = $DB->delete_records('block_exaportview', array('userid'=>$user));
			$result = $DB->delete_records('block_exaportviewshar', array('userid'=>$user));
			
			$result = $DB->delete_records('block_exaportresume', array('user_id'=>$user));
			$result = $DB->delete_records('block_exaportresume_certif', array('user_id'=>$user));
			$result = $DB->delete_records('block_exaportresume_edu', array('user_id'=>$user));
			$result = $DB->delete_records('block_exaportresume_employ', array('user_id'=>$user));
			$result = $DB->delete_records('block_exaportresume_mbrship', array('user_id'=>$user));
			$result = $DB->delete_records('block_exaportresume_public', array('user_id'=>$user));
			$result = $DB->delete_records('block_exaportuser', array('user_id'=>$user));
		}
		break;
	case('exastud'):
		$users = required_param('users', PARAM_TEXT);
		$user_ids = json_decode($users);
		
		foreach($user_ids as $user){
			$result = $DB->delete_records('block_exastudclass', array('userid'=>$user));
			$result = $DB->delete_records('block_exastudperiod', array('userid'=>$user));
			
			$result = $DB->delete_records('block_exstudclassteachers', array('teacherid'=>$user));
			$result = $DB->delete_records('block_exastudreview', array('teacherid'=>$user));
			
			$result = $DB->delete_records('block_exastudclassstudents', array('studentid'=>$user));
			$result = $DB->delete_records('block_exastudreview', array('studentid'=>$user));
		}
		
		break;
	default:
		print_error('wrong action: '.$action);
}

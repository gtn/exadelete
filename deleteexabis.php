<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * delete user details
 *
 * @package   block_exadelete
 * @copyright GTN solutions, Michaela Murauer <mmurauer@gtn-solutions.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once dirname(__FILE__)."/../../config.php";

global $DB, $OUTPUT, $PAGE;

$context = context_system::instance();
require_login();

/* PAGE IDENTIFIER - MUST BE CHANGED. Please use string identifier from lang file */
$page_identifier = 'deleteexabis';

/* PAGE URL - MUST BE CHANGED */
$PAGE->set_context($context);
$PAGE->set_url('/blocks/exadelete/deleteexabis.php');
$PAGE->set_heading(get_string('pluginname', 'block_exadelete'));
$PAGE->set_title(get_string($page_identifier, 'block_exadelete'));
$PAGE->requires->css('/blocks/exadelete/styles.css');
$PAGE->requires->js('/blocks/exadelete/javascript/jquery.js', true);
$PAGE->requires->js('/blocks/exadelete/javascript/jquery-ui.js', true);
$PAGE->requires->js('/blocks/exadelete/javascript/deleteexabis.js', true);

$navnode = $PAGE->navigation->add(get_string('deleteexabis', 'block_exadelete'), new moodle_url('/blocks/exadelete/deleteexabis'), navigation_node::TYPE_CONTAINER);
$navnode->make_active();// build tab navigation & print header


echo $OUTPUT->header();

//CONTENT-REGION
echo html_writer::tag('p', get_string('description_exa', 'block_exadelete'));

//alle noch nicht gelöschten Benutzer
$users = $DB->get_records('user', array('deleted'=>0));
echo html_writer::start_tag('ul');
foreach($users as $user){
	echo html_writer::start_tag('li').
		html_writer::checkbox('cb-'.$user->id, 'cb-'.$user->id, false, $user->firstname." ".$user->lastname, array('userid'=>$user->id))
		.html_writer::end_tag('li');
}
echo html_writer::end_tag('ul');
$buttons = "";

if(check_block_available('exacomp'))
	$buttons .= html_writer::empty_tag('input', array('type'=>'submit', 'value'=>get_string('exacomp_data', 'block_exadelete'), 'name'=>'exacomp'));

if(check_block_available('exaport'))	
	$buttons .= html_writer::empty_tag('input', array('type'=>'submit', 'value'=>get_string('exaport_data', 'block_exadelete'), 'name'=>'exaport'));

if(check_block_available('exastud'))	
	$buttons .= html_writer::empty_tag('input', array('type'=>'submit', 'value'=>get_string('exastud_data', 'block_exadelete'), 'name'=>'exastud'));

echo html_writer::div($buttons, 'buttons');

echo $OUTPUT->footer();

function check_block_available($name) {
	global $DB;
	
	$result = $DB->get_records('block', array("name"=>$name));
	if($result)
		return true;
		
	return false;
}

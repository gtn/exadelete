<?php
// This file is part of Exabis Delete
//
// (c) 2016 GTN - Global Training Network GmbH <office@gtn-solutions.com>
//
// Exabis Delete is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// This script is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You can find the GNU General Public License at <http://www.gnu.org/licenses/>.
//
// This copyright notice MUST APPEAR in all copies of the script!

require_once __DIR__.'/inc.php';
require_once __DIR__.'/../exastud/inc.php';

$context = context_system::instance();
require_login();
if (!has_capability('block/exadelete:admin', $context)) {
	die('not allowed to access this site');
}

/* PAGE IDENTIFIER - MUST BE CHANGED. Please use string identifier from lang file */
$page_identifier = 'deleteexabis';

/* PAGE URL - MUST BE CHANGED */
$PAGE->set_context($context);
$PAGE->set_url('/blocks/exadelete/admin.php');
$PAGE->set_heading(get_string('blocktitle', 'block_exadelete'));
$PAGE->set_title(get_string($page_identifier, 'block_exadelete'));
$PAGE->requires->css('/blocks/exadelete/styles.css');
$PAGE->requires->jquery();
// $PAGE->requires->js('/blocks/exadelete/javascript/deleteexabis.js');

$navnode = $PAGE->navigation->add(get_string('deleteexabis', 'block_exadelete'), $PAGE->url, navigation_node::TYPE_CONTAINER);
$navnode->make_active();// build tab navigation & print header

echo $OUTPUT->header();

if (optional_param('action', '', PARAM_TEXT) == 'deletedata') {
	require_sesskey();

	$deleteusers = \block_exadelete\param::optional_array('deleteusers', [PARAM_INT => (object)[
		'bildungsstandard_erreicht' => PARAM_TEXT,
		'dropped_out' => PARAM_BOOL,
	]]);
	$exastud = optional_param('exastud', 0, PARAM_BOOL);
	$exacomp = optional_param('exacomp', 0, PARAM_BOOL);

	foreach ($deleteusers as $userid => $deleteuser) {
		if ($deleteuser->dropped_out) {
			echo "Benutzer #$userid: Ausgeschieden";
		} elseif ($deleteuser->bildungsstandard_erreicht) {
			echo "Benutzer #$userid: Bildungsstandard {$deleteuser->bildungsstandard_erreicht} erreicht";
		} else {
			continue;
		}

		echo "<br/>";
		if ($exastud && block_exadelete\check_block_available('exastud')) {
			block_exastud\api::delete_user_data($userid);
		}
		if ($exacomp && block_exadelete\check_block_available('exacomp')) {
			block_exacomp\api::delete_user_data($userid);
		}
	}

	notice(\block_exadelete\trans(['de:Ausgewählte Benutzerdaten wurden entfernt!']), new moodle_url('/blocks/exadelete/admin.php'));
}

//CONTENT-REGION

echo html_writer::tag("h2", \block_exadelete\trans('de:Schüler Daten löschen'));

$table = new html_table();

$table->head = [
	'',
	'Typ',
	\block_exadelete\get_string('firstname'),
	\block_exadelete\get_string('lastname'),
	\block_exadelete\get_string('email'),
];
$table->align = array("left", "left", "left", "left");
$table->attributes['style'] = "width: 100%;";
$table->size = ['5%', '20%', '20%', '20%', '20%'];

$users_dropped_out = $DB->get_recordset_sql("
	SELECT u.*, dropped_out.classid
	FROM {user} u
	JOIN {block_exastuddata} dropped_out ON dropped_out.studentid=u.id AND dropped_out.name='dropped_out' AND dropped_out.value
	WHERE deleted=0
");
$users_dropped_out = iterator_to_array($users_dropped_out, false);

// $users = $DB->get_records('user', array('deleted' => 0));
foreach ($users_dropped_out as $user) {
	if (!$class = block_exastud_get_class($user->classid)) {
		continue;
	}
	if (!$userdata = block_exastud_get_class_student_data($user->classid, $user->id)) {
		continue;
	}
	if (isset($table->data[$user->id])) {
		continue;
	}
	// [$user->id] => prevent to list a user twice
	$table->data[$user->id] = [
		'<input type="checkbox" name="deleteusers['.$user->id.'][dropped_out]" value="1" />',
		'Ausgeschieden am '.userdate($userdata->dropped_out_time),
		$user->firstname,
		$user->lastname,
		$user->email,
	];
}

$users_bildungsstandard_erreicht = $DB->get_recordset_sql("
	SELECT u.*, bildungsstandard_erreicht.classid
	FROM {user} u
	JOIN {block_exastuddata} bildungsstandard_erreicht ON bildungsstandard_erreicht.studentid=u.id AND bildungsstandard_erreicht.name='bildungsstandard_erreicht' AND bildungsstandard_erreicht.value
	WHERE deleted=0
");
$users_bildungsstandard_erreicht = iterator_to_array($users_bildungsstandard_erreicht, false);
// $users = $DB->get_records('user', array('deleted' => 0));
foreach ($users_bildungsstandard_erreicht as $user) {
	if (!$class = block_exastud_get_class($user->classid)) {
		continue;
	}
	if (!$userdata = block_exastud_get_class_student_data($user->classid, $user->id)) {
		continue;
	}
	if (isset($table->data[$user->id])) {
		continue;
	}
	// [$user->id] => prevent to list a user twice
	$table->data[$user->id] = [
		'<input type="checkbox" name="deleteusers['.$user->id.'][bildungsstandard_erreicht]" value="'.$userdata->bildungsstandard_erreicht.'" />',
		'Bildungsstandard '.$userdata->bildungsstandard_erreicht.' erreicht am '.userdate($userdata->bildungsstandard_erreicht_time),
		$user->firstname,
		$user->lastname,
		$user->email,
	];
}

echo '<form method="post">';
echo '<input type="hidden" name="sesskey" value="'.sesskey().'" />';
echo '<input type="hidden" name="action" value="deletedata" />';

echo html_writer::table($table);

echo html_writer::tag("h2", \block_exadelete\trans('de:Löschverhalten'));
?>
	<input type="checkbox" name="exastud" value="1"/> Lernentwicklungsbericht<br/>
	<input type="checkbox" name="exacomp" value="1"/> Kompetenzraster<br/>
	<input type="submit"
	       value="Daten löschen"
	       onclick="return confirm('Wirklich löschen?');"
	/>
<?php

echo '</form>';

echo $OUTPUT->footer();

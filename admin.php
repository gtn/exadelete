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

$context = context_system::instance();
require_login();
if (!has_capability('block/exadelete:admin', $context))
	die('not allowed to access this site');

/* PAGE IDENTIFIER - MUST BE CHANGED. Please use string identifier from lang file */
$page_identifier = 'deleteexabis';

/* PAGE URL - MUST BE CHANGED */
$PAGE->set_context($context);
$PAGE->set_url('/blocks/exadelete/deleteexabis.php');
$PAGE->set_heading(get_string('blocktitle', 'block_exadelete'));
$PAGE->set_title(get_string($page_identifier, 'block_exadelete'));
$PAGE->requires->css('/blocks/exadelete/styles.css');
$PAGE->requires->jquery();
$PAGE->requires->js('/blocks/exadelete/javascript/deleteexabis.js');

$navnode = $PAGE->navigation->add(get_string('deleteexabis', 'block_exadelete'), new moodle_url('/blocks/exadelete/deleteexabis'), navigation_node::TYPE_CONTAINER);
$navnode->make_active();// build tab navigation & print header

echo $OUTPUT->header();

/*
if (optional_param('delete_exaport', null, PARAM_RAW)) {
	$action = 'delete_exaport';
} elseif (optional_param('delete_exastud', null, PARAM_RAW)) {
	$action = 'delete_exastud';
} elseif (optional_param('delete_exacomp', null, PARAM_RAW)) {
	$action = 'delete_exacomp';
} else {
	$action = '';
}

if ($action) {
	require_sesskey();

	switch ($action) {
		case 'delete_exacomp':
			if (!block_exadelete\check_block_available('exacomp')) {
				throw new moodle_exception('action not available');
			}

			$userids = clean_param_array(explode(',', required_param('userids', PARAM_SEQUENCE)), PARAM_INT);

			foreach ($userids as $userid) {
				block_exacomp\api::delete_user_data($userid);
			}

			break;
		case 'delete_exaport':
			if (!block_exadelete\check_block_available('exaport')) {
				throw new moodle_exception('action not available');
			}

			$userids = clean_param_array(explode(',', required_param('userids', PARAM_SEQUENCE)), PARAM_INT);

			foreach ($userids as $userid) {
				block_exaport\api::delete_user_data($userid);
			}

			break;
		case('delete_exastud'):
			if (!block_exadelete\check_block_available('exastud')) {
				throw new moodle_exception('action not available');
			}

			$userids = clean_param_array(explode(',', required_param('userids', PARAM_SEQUENCE)), PARAM_INT);

			foreach ($userids as $userid) {
				block_exastud\api::delete_user_data($userid);
			}

			break;
		default:
			print_error('wrong action: '.$action);
	}

	notice(\block_exadelete\trans(['de:Ausgewählte Benutzerdaten wurden entfernt!']), new moodle_url('/blocks/exadelete/deleteexabis.php'));
}
*/

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

for ($i = 0; $i < 15; $i++) {
	$table->data[] = [
		'<input type="checkbox" />',
		$i < 5 ? 'Ausgeschieden' : 'Bildungsstandard 5-6 erreicht',
		'Vorname',
		'Nachanme',
		'email',
	];
}
//

echo html_writer::table($table);

echo html_writer::tag("h2", \block_exadelete\trans('de:Löschverhalten'));
?>
	<input type="checkbox" value="leb" /> Lernentwicklungsbericht<br/>
	<input type="checkbox" value="kompetenzraster" /> Kompetenzraster<br/>
	<input type="button"
		   value="Daten löschen"
		   onclick="if (confirm('Wirklich löschen?')) alert('TODO: Löschroutine hier einbinden');"
	/>
<?php
echo $OUTPUT->footer();

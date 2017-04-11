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

/* PAGE IDENTIFIER - MUST BE CHANGED. Please use string identifier from lang file */
$page_identifier = 'deleteexabis';

/* PAGE URL - MUST BE CHANGED */
$PAGE->set_context($context);
$PAGE->set_url('/blocks/exadelete/student.php');
$PAGE->set_heading(get_string('blocktitle', 'block_exadelete'));
$PAGE->set_title(get_string($page_identifier, 'block_exadelete'));
$PAGE->requires->css('/blocks/exadelete/styles.css');
$PAGE->requires->jquery();
$PAGE->requires->js('/blocks/exadelete/javascript/deleteexabis.js');

$navnode = $PAGE->navigation->add(get_string('deleteexabis', 'block_exadelete'), $PAGE->url, navigation_node::TYPE_CONTAINER);
$navnode->make_active();// build tab navigation & print header

echo $OUTPUT->header();

$bildungsstandard = block_exadelete\check_block_available('exastud') ? \block_exastud\api::get_bildungsstandard_erreicht($USER->id) : null;

if (!$bildungsstandard) {
	?>
		Du hast noch keinen Bildungsstandard erreicht
	<?php
} elseif (optional_param('action', null, PARAM_TEXT) == 'delete') {
	if (block_exadelete\check_block_available('exacomp')) {
		block_exacomp\api::delete_student_assessment_data_up_until($USER->id, $bildungsstandard->bildungsstandard_erreicht_time);
	}

	echo 'Deine Daten wurden gelöscht.';
} else {
	$dateformat = get_string('strftimedate');

	?>
		Du hast den Bildungsstandard <?=$bildungsstandard->bildungsstandard_erreicht?> am <?=userdate($bildungsstandard->bildungsstandard_erreicht_time, $dateformat)?> erreicht und kannst hier die Daten in den Kompetenzrastern unwiderruflich löschen:
		<br/>
		<ul>
			<li>Alle Selbsteinschätzungen</li>
			<li>Alle Lehrerbewertungen</li>
		</ul>
		<br/>
		<form method="post">
			<input type="hidden" name="action" value="delete"/>
			<input type="submit"
				   value="Kompetenzraster des Bildungsstandard <?=$bildungsstandard->bildungsstandard_erreicht?> jetzt löschen"
			/>
		</form>
	<?php
}

echo $OUTPUT->footer();

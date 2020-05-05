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
if (!has_capability('block/exadelete:admin', $context)) {
    die('not allowed to access this site');
}

$withoutEnrollment = optional_param('without_enrollment', 0, PARAM_INT); // delete only users without enrollments
$submit_action = optional_param('submit_action', 0, PARAM_INT); // delete only users without enrollments

/* PAGE IDENTIFIER - MUST BE CHANGED. Please use string identifier from lang file */
$page_identifier = 'anonymizeusers';

/* PAGE URL - MUST BE CHANGED */
$PAGE->set_context($context);
$PAGE->set_url('/blocks/exadelete/anonymizeuser.php', ['without_enrollment' => $withoutEnrollment]);
$PAGE->set_heading(get_string('blocktitle', 'block_exadelete'));
$PAGE->set_title(get_string($page_identifier, 'block_exadelete'));
$PAGE->requires->css('/blocks/exadelete/styles.css');


$navnode = $PAGE->navigation->add(get_string('anonymizeusers', 'block_exadelete'), $PAGE->url, navigation_node::TYPE_CONTAINER);
$navnode->make_active(); // build tab navigation & print header

echo $OUTPUT->header();

$do_action = true;

/* CONTENT REGION */
// Select users for deleting
if ($withoutEnrollment) {
    // users without enrollments
    $select = 'SELECT *
                FROM mdl_user 
                WHERE deleted != 1 
                  AND id != 1
                  AND timecreated < '.(time()-43200).' 
                  AND EXISTS ( SELECT userid FROM mdl_user_enrolments ) 
                  AND id NOT IN ( SELECT userid FROM mdl_user_enrolments )
                ORDER BY firstname';

    $users = $DB->get_records_sql($select);
} else {
    // anonymize users list
    $select = "deleted = 1 AND firstname <> 'Deleted'";
    $users = $DB->get_records_select("user", $select);
}

echo html_writer::start_tag('div', array('class' => 'exadelete'));
if ($withoutEnrollment) {
    echo html_writer::tag('p', get_string('withoutEnrollment_description', 'block_exadelete'));
    $do_action = false; // We need a confirmation first
    if ($submit_action) {
        $do_action = 1; // submit action!
    }
    // list of users
    if ($users && !$do_action) {
        $adminIds = array_keys(get_admins());
        $userNames = '';
        foreach ($users as $k => $user) {
            if (in_array($user->id, $adminIds)) {
                unset($users[$k]);
                continue;
            }
            $userNames .= fullname($user).'<br>';
        }
        if (count($users) > 0) {
            echo html_writer::tag('div', get_string('deleteusers_without_confirmation_message', 'block_exadelete'),
                    ['class' => 'alert alert-info']);
            echo html_writer::div($userNames, 'exadelete-user-list');
            echo html_writer::tag('button',
                            get_string('delete_button', 'block_exadelete'),
                            ['class' => 'btn btn-danger', 'onClick' => 'window.location.href = \''.$PAGE->url.'&submit_action=1'.'\'']);
        }
    }
} else {
    echo html_writer::tag('p', get_string('description', 'block_exadelete'));
}


if (!$users || count($users) == 0) {
	echo html_writer::empty_tag('br').get_string('nousersfound', 'block_exadelete');
} else {
    if ($do_action) {
        $res = \block_exadelete\block_exadelete_clean_anonimize_users($users);
        if ($res['message']) {
            echo $res['message'];
        }
    }
}

echo html_writer::end_tag('div');
/* END CONTENT REGION */

echo $OUTPUT->footer();

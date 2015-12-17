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
if(!has_capability('block/exadelete:admin', $context))
	die('not allowed to access this site');

/* PAGE IDENTIFIER - MUST BE CHANGED. Please use string identifier from lang file */
$page_identifier = 'anonymizeusers';

/* PAGE URL - MUST BE CHANGED */
$PAGE->set_context($context);
$PAGE->set_url('/blocks/exadelete/anonymizeuser.php');
$PAGE->set_heading(get_string('pluginname', 'block_exadelete'));
$PAGE->set_title(get_string($page_identifier, 'block_exadelete'));


$navnode = $PAGE->navigation->add(get_string('anonymizeusers', 'block_exadelete'), new moodle_url('/blocks/exadelete/anonymize.php'), navigation_node::TYPE_CONTAINER);
$navnode->make_active();// build tab navigation & print header

echo $OUTPUT->header();

/* CONTENT REGION */
$array = array("assignfeedback_editpdf_quick", "assignment_submissions", "assign_grades", "assign_submission", 
	"assign_user_flags", "assign_user_mapping", "backup_controllers", "badge_backpack", "badge_criteria_met",
	"badge_issued", "block_community", "block_recent_activity", "block_rss_client", "chat_messages", 
	"chat_messages_current", "chat_users", "choice_answers", "cohort_members", "comments", "config_log", 
	"course_completions", "course_completion_crit_compl", "course_modules_completion", "data_records", 
	"editor_atto_autosave", "enrol_flatfile", "enrol_paypal", "event", "events_queue", "event_subscriptions",
 	"external_services_users", "external_tokens", "feedback_completed", "feedback_completedtmp", 
 	"feedback_tracking", "forum_digests", "forum_discussions", "forum_discussion_subs", 
 	"forum_posts", "forum_queue", "forum_read", "forum_subscriptions", "forum_track_prefs", 
 	"glossary_entries", "grade_grades", "grade_grades_history", "grade_import_values", "groups_members", 
 	"lesson_attempts", "lesson_branch", "lesson_grades", "lesson_high_scores", "lesson_overrides", 
 	"lesson_timer", "log", "logstore_standard_log", "lti_submission", "messageinbound_messagelist", 
 	"message_contacts", "mnetservice_enrol_enrolments", "mnet_log", "mnet_session", "my_pages", 
 	"portfolio_instance_user", "portfolio_log", "portfolio_tempdata", "post", "question_attempt_steps", 
 	"quiz_attempts", "quiz_grades", "quiz_overrides", "rating", "repository_instances", "role_assignments", 
 	"role_sortorder", "scale", "scale_history", "scorm_aicc_session", "scorm_scoes_track", "sessions", 
	"stats_user_daily", "stats_user_monthly", "stats_user_weekly", "survey_analysis", "survey_answers", 
	"tag", "tool_monitor_history", "tool_monitor_rules", "tool_monitor_subscriptions", "upgrade_log", 
	"user_devices", "user_enrolments", "user_info_data", "user_lastaccess", "user_password_history", 
	"user_password_resets", "user_preferences", "user_private_key", "wiki_locks", 
	"wiki_subwikis", "wiki_versions", "workshop_aggregations", "workshop_assessments_old", 
	"workshop_comments_old", "workshop_submissions_old");

if(check_block_available('exacomp')){
	require_once dirname(__FILE__)."/../exacomp/lib/lib.php";
}
if(check_block_available('exaport')){
	require_once dirname(__FILE__)."/../exaport/lib/lib.php";
}
if(check_block_available('exastud')){
	require_once dirname(__FILE__)."/../exastud/lib/lib.php";
}

$select = "deleted = 1 AND firstname <> 'Deleted'";
$users = $DB->get_records_select("user", $select);

echo html_writer::start_tag('div', array('class'=>'exadelete'));
echo html_writer::tag('p', get_string('description', 'block_exadelete'));


if(!$users){
	echo html_writer::empty_tag('br').get_string('nousersfound', 'block_exadelete');
}else{
	foreach($users as $user){
		$userid = $user->id;


		// delete entry in every table where the column with userid is named userid
		foreach($array as $entry){
			$result = $DB->delete_records($entry, array("userid"=>$userid));
		}

		// delete messages that where received and sended by the user
		$result = $DB->delete_records("message", array("useridfrom"=>$userid));
		$result = $DB->delete_records("message", array("useridto"=>$userid));
		$result = $DB->delete_records("message_read", array("useridfrom"=>$userid));
		$result = $DB->delete_records("message_read", array("useridto"=>$userid));
		
		//delete badges created and modified by the user
		$result = $DB->delete_records("badge", array("usercreated"=>$userid));
		$result = $DB->delete_records("badge", array("usermodified"=>$userid));
	
		//delete manual awarded badges where user was recipient or issuer
		$result = $DB->delete_records('badge_manual_award', array("recipientid"=>$userid));
		$result = $DB->delete_records('badge_manual_award', array("issuerid"=>$userid));
		
		//delete external_tokens created by the user
		$result = $DB->delete_records('external_tokens', array("creatorid"=>$userid));

		//delete log entries
		$result = $DB->delete_records('logstore_standard_log', array("realuserid"=>$userid));
		$result = $DB->delete_records('logstore_standard_log', array("relateduserid"=>$userid));
		
		//delete questions created by the user
		$result = $DB->delete_records('question', array("createdby"=>$userid));
		
		//delete workshop assesment reviewed by the user
		$result = $DB->delete_records('workshop_assessments', array("reviewerid"=>$userid));
		
		//delete workshop submission of the user
		$result = $DB->delete_records('workshop_submissions', array("authorid"=>$userid));

		// delete entry in mdl_tag_instance
		$result = $DB->delete_records("tag_instance", array("tiuserid"=>$userid));

		// delelte wiki pages only if there are no earlier versions from other users
		$result = $DB->get_records("wiki_pages", array("userid"=>$userid));

		foreach($result as $entry){
			$result = $DB->get_records("wiki_versions", array("pageid"=>$entry->id));

			if(!$result)
				$result = $DB->delete_records("wiki_pages", array("userid"=>$userid));
		}

		// delete files in database and in file system
		$fs = get_file_storage();
		$result = $DB->get_records("files", array("userid"=>$userid));

		foreach($result as $entry){
			// Prepare file record object
			$fileinfo = array(
				'component' => $entry->component,
				'filearea' => $entry->filearea,     // usually = table name
				'itemid' => $entry->itemid,               // usually = ID of row in table
				'contextid' => $entry->contextid, // ID of context
				'filepath' => $entry->filepath,           // any path beginning and ending in /
				'filename' => $entry->filename); // any filename

			// Get file
			$file = $fs->get_file($fileinfo['contextid'], $fileinfo['component'], $fileinfo['filearea'],
			$fileinfo['itemid'], $fileinfo['filepath'], $fileinfo['filename']);

			// get it if it exists
			if ($file) {
				$file->delete();
			}
		}

		$result = $DB->delete_records("files", array("userid"=>$userid));
		
		if(check_block_available('exacomp')){
			block_exacomp_delete_user_data($userid);
		}
		if(check_block_available('exaport')){
			block_exaport_delete_user_data($userid);
		}
		if(check_block_available('exastud')){
			block_exastud_delete_user_data($userid);
		}

		
		// don't delete entry in mdl_user, just make is anonymous and set deleted = true
		$update = new stdClass();
		$update->id = $userid;
		$update->username = "deletedUser".$userid;
		$update->firstname = "Deleted";
		$update->lastname = "User";
		$update->email = "deleted.user@iwas.com";
		$update->deleted = 1;

		$result = $DB->update_record("user", $update);

		echo get_string('alluserdata', 'block_exadelete').$user->firstname." ".$user->lastname.get_string('deleted', 'block_exadelete')."<br/>";
	}
}
function check_block_available($name) {
	global $DB;
	
	$result = $DB->get_records('block', array("name"=>$name));
	if($result)
		return true;
		
	return false;
}

echo html_writer::end_tag('div');
/* END CONTENT REGION */

echo $OUTPUT->footer();

?>
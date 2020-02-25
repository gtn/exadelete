* exabis delete Block - Installation *

1) Save the zip file somewhere onto your local computer and extract all the files

2) Transfer the folder exadelete to the blocks-directory of Moodle

3) Log in as 'administrator' and click on the 'Home' link

NOTE: This is a block that requires admin capability. Only the admin can add this plugin to the Website-Startpage

Teacher Options
- Schüler Daten löschen:
data of Students in exastud and/or exacomp who are set as "ausgeschieden" in exastud are deleted
- Daten gelöschter Benutzer bereinigen
user where deleted flag=1 are anonymisized in the mdl_user table and data in various tables with this userid are deleted
this tables are cleared:
"assignfeedback_editpdf_quick", "assignment_submissions", "assign_grades", "assign_submission",
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
	"workshop_comments_old", "workshop_submissions_old"

Student Options:
- Delete his own exacomp Data - Kompetenzraster
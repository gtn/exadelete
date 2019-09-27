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

defined('MOODLE_INTERNAL') || die();

require __DIR__.'/inc.php';

class block_exadelete extends block_list {

	function init() {
		$this->title = get_string('blocktitle', 'block_exadelete');
	}

	function get_content() {
		global $OUTPUT;

		if ($this->content !== null) {
			return $this->content;
		}

		if (empty($this->instance)) {
			$this->content = '';

			return $this->content;
		}

		$this->content = new stdClass();
		$this->content->items = array();
		$this->content->icons = array();
		$this->content->footer = '';

		$globalcontext = context_system::instance();

		$this->content->items[] = 'Option für Schüler:';
		$icon = '<img src="'.$OUTPUT->image_url('userban', 'block_exadelete').'" class="icon" alt="" />';
		$this->content->items[] = html_writer::link(new moodle_url('/blocks/exadelete/student.php'), $icon.block_exadelete\trans(['de:Meine Daten löschen']));

		/*
		$this->content->items[] = 'Option für Lehrer:';
		$icon = '<img src="'.$OUTPUT->image_url('klassenzuteilung', 'block_exastud').'" class="icon" alt="" />';
		$this->content->items[] = html_writer::link(new moodle_url('/blocks/exadelete/teacher.php'), $icon.block_exadelete\trans(['de:Erreichte Bildungsstandards festlegen']));
		*/

		if (has_capability('block/exadelete:admin', $globalcontext)) {    //Admin sieht immer Modulkonfiguration
			$this->content->items[] = 'Optionen für Administrator:';

			$icon = '<img src="'.$OUTPUT->image_url('userban', 'block_exadelete').'" class="icon" alt="" />';
			$this->content->items[] = html_writer::link(new moodle_url('/blocks/exadelete/admin.php'), $icon.\block_exadelete\trans('de:Schüler Daten löschen'));

			$icon = '<img src="'.$OUTPUT->image_url('userban', 'block_exadelete').'" class="icon" alt="" />';
			$this->content->items[] = html_writer::link(new moodle_url('/blocks/exadelete/anonymizeuser.php'), $icon.get_string('anonymizeusers', 'block_exadelete'));

			// disabled for now
			/*
			$icon = '<img src="'.$OUTPUT->image_url('serverban', 'block_exadelete').'" class="icon" alt="" />';
			$this->content->items[] = html_writer::link(new moodle_url('/blocks/exadelete/deleteexabis.php'), $icon.get_string('deleteexabis', 'block_exadelete'));
			*/
		} else {
			// not admin, is teacher or student
			// -> show student options
		}

		return $this->content;
	}

	public function applicable_formats() {
		return array('all' => false,
			'site' => false,
			'my' => true,
			'site-index' => true,
			'admin' => true,
			'course-view' => false,
			'mod' => false,
		);
	}

	public function instance_allow_multiple() {
		return false;
	}

	function has_config() {
		return false;
	}

	public function cron() {
		return true;
	}
}

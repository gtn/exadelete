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
 *
 * @package   block_exadelete
 * @copyright GTN solutions, Michaela Murauer <mmurauer@gtn-solutions.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

class block_exadelete extends block_list {

    function init() {
        $this->title = get_string('pluginname', 'block_exadelete');
    }

    function get_content() {
        global $CFG, $OUTPUT;

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

        // user/index.php expect course context, so get one if page has module context.
        $currentcontext = $this->page->context->get_course_context(false);
        $globalcontext = context_system::instance();

    	if(has_capability('block/exadelete:admin', $globalcontext)){	//Admin sieht immer Modulkonfiguration
			$this->content->items[] = html_writer::link(new moodle_url('/blocks/exadelete/anonymizeuser.php'), get_string('anonymizeusers', 'block_exadelete'), array('title'=>get_string('anonymizeusers', 'block_exadelete')));
			$this->content->icons[] = html_writer::empty_tag('img', array('src'=>new moodle_url('/blocks/exadelete/pix/userban.png'), 'alt'=>'', 'height'=>16, 'width'=>23));
			
			$this->content->items[] = html_writer::link(new moodle_url('/blocks/exadelete/deleteexabis.php'), get_string('deleteexabis', 'block_exadelete'), array('title'=>get_string('deleteexabis', 'block_exadelete')));
			$this->content->icons[] = html_writer::empty_tag('img', array('src'=>new moodle_url('/blocks/exadelete/pix/serverban.png'), 'alt'=>'', 'height'=>16, 'width'=>23));
			
    	}
		
        return $this->content;
    }

    public function applicable_formats() {
        return array('all' => false,
                     'site' => true,
                     'site-index' => true,
                     'course-view' => false, 
                     'course-view-social' => false,
                     'mod' => false, 
                     'mod-quiz' => false);
    }

    public function instance_allow_multiple() {
          return false;
    }

    function has_config() {return true;}

    public function cron() {
        return true;
    }
}

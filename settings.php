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

defined('MOODLE_INTERNAL') || die;

require_once __DIR__.'/inc.php';

$settings->add(new admin_setting_configcheckbox('exadelete/show_block_for_users',
        get_string('settings_show_block_for_users', 'block_exadelete'),
        get_string('settings_show_block_for_users_description', 'block_exadelete'), 0));



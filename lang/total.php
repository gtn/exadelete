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

return [
	'blocktitle' => [
		'Datenschutz',
		'Exabis Cleanup',
	],
	'pluginname' => [
		'Exabis Cleanup',
		'Exabis Cleanup',
	],
	'exadelete:addinstance' => [
		'Exabis Cleanup zum Kurs hinzufügen',
		'Add Exabis Cleanup to the course',
	],
	'exadelete:myaddinstance' => [
		'Exabis Cleanup zur eigenen Startseite hinzufügen',
		'Add Exabis Cleanup on My home',
	],
	'exadelete:admin' => [
		'Zugriff auf Exabis Cleanup erlauben',
		'Allow access to Exabis Cleanup block',
	],
	'anonymizeusers' => [
		'Daten gelöschter Benutzer bereinigen',
		'Clean up user data',
	],
	'nousersfound' => [
		'Keine in Moodle gelöschten Personen zum Bereinigen gefunden.',
		'No users found, that are deleted in your Moodle.',
	],
	'description' => [
		'Diese Funktion wird verwendet um einen in Moodle gelöschten User vollständig aus dem System zu entfernen. Um diese Funktion verwenden zu können, muss ein Benutzer voher in Moodle gelöscht werden. Exabis Cleanup greift nur auf Benutzerdaten zu, es werden hier keine Informationen hinterlegt.',
		'This block is used to eliminate data from deleted users. To use this function you have to delete users in your Moodle first',
	],
	'alluserdata' => [
		'Alle Benutzerdaten von {$a} entfernt.',
		'All given data from user {$a} deleted.',
	],
	'description_exa' => [
		'Auf dieser Seite können Sie die Daten von einem bestehenden Benutzer aus den Exabis Modulen entfernen. Beachten Sie, dass dies nicht rückgängig gemacht werden kann. Exabis Cleanup greift nur auf Benutzerdaten zu, es werden hier keine Informationen hinterlegt.',
		'Delete user data from an Exabis module. This can not be undone!',
	],
	'exacomp_data' => [
		'Benutzerdaten aus Exabis Kompetenzraster entfernen',
		'Delete user data from Exabis Competence grid',
	],
	'exaport_data' => [
		'Benutzerdaten aus Exabis ePortfolio entfernen',
		'Delete user data from Exabis ePortfolio',
	],
	'exastud_data' => [
		'Benutzerdaten aus Exabis Lernentwicklungsbericht entfernen',
		'Delete user data from Exabis Student Review',
	],
	'deleteexabis' => [
		'Daten aus Exabis Modulen bereinigen',
		'Delete data form Exabis modules',
	],
	'alluserdatadeleted' => [
		'Die Daten von diesem Benutzer wurden gelöscht: ',
		'Data was deleted from User: ',
	],
    'deleteusers_without_enrollments' => [
        'Nutzer ohne Kurseinschreibung löschen',
        'Delete Users without Enrollment',
    ],
    'deleteusers_without_confirmation_message' => [
        'Wollen sie wirklich diese Benutzer löschen?',
        'Do you really want to delete these users?',
    ],
    'withoutEnrollment_description' => [
        'Nutzer ohne Kurseinschreibung löschen',
        'Delete Users without Enrollment',
    ],
    'delete_button' => [
        'Löschen',
        'Delete',
    ],
    'task_delete_without_enrolement_and_anonymize' => [
        'Nutzer ohne Kurseinschreibung löschen und Daten gelöschter Benutzer bereinigen',
        'Delete Users without Enrollment and clean up user data'
    ],
    'settings_show_block_for_users' => [
        'Users can see the block',
        'Users can see the block'
    ],
    'settings_show_block_for_users_description' => [
        'If checked, users can see the block, if not, only admin can see the block',
        'If checked, users can see the block, if not, only admin can see the block'
    ],
];

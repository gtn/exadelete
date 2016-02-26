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

$(document).on('submit', 'form#block_exadelete_delete_users', function(){
	return confirm("Dieser Schritt kann nicht mehr rückgängig gemacht werden, sind Sie ganz sicher?");
});

$(document).on('change', '.exadeleteul :checkbox', function(){
	var userids = $('.exadeleteul :checkbox:checked').map(function(){ return this.value }).toArray().join(',');
	$('#block_exadelete_delete_users input[name=userids]').val(userids);
});

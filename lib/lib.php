<?php

namespace block_exadelete;

function check_block_available($name) {
	global $DB;

	$result = $DB->get_records('block', array("name"=>$name));
	if($result)
		return true;

	return false;
}

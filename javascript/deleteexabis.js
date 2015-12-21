
$(document).on('submit', 'form#block_exadelete_delete_users', function(){
	return confirm("Dieser Schritt kann nicht mehr rückgängig gemacht werden, sind Sie ganz sicher?");
});

$(document).on('change', '.exadeleteul :checkbox', function(){
	var userids = $('.exadeleteul :checkbox:checked').map(function(){ return this.value }).toArray().join(',');
	$('#block_exadelete_delete_users input[name=userids]').val(userids);
});

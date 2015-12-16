window.jQueryExadelete = jQuery.noConflict(true);

(function($) {
	
	$(document).on('click', 'input[name=exacomp]', function(){
		var users = [];
		
		$("input[name^=cb\-]").each(function() {
			if($(this).prop("checked")){
				users.push($(this).attr("userid"));
			}
		});

		if (confirm("Dieser Schritt kann nicht mehr rückgängig gemacht werden, sind Sie ganz sicher?")) {
			call_ajax({
				users : JSON.stringify(users),
				action : 'exacomp'
			}).done(function (ret) {
				alert('Ausgewählte Benutzerdaten aus Exabis Competencies entfernt!');
				$('input[name=exacomp]').removeAttr('disabled');
				$('input[name=exacomp]').blur();
			});
		}
		
	});
	
	$(document).on('click', 'input[name=exaport]', function(){
		var users = [];
		
		$("input[name^=cb\-]").each(function() {
			if($(this).prop("checked")){
				users.push($(this).attr("userid"));
			}
		});

		if (confirm("Dieser Schritt kann nicht mehr rückgängig gemacht werden, sind Sie ganz sicher?")) {
			
			call_ajax({
				users : JSON.stringify(users),
				action : 'exaport'
			}).done(function (ret) {
				alert('Ausgewählte Benutzerdaten aus Exabis e-Portfolio entfernt!');
				$('input[name=exaport]').removeAttr('disabled');
				$('input[name=exaport]').blur();
			});
		}
		
	});
	
	$(document).on('click', 'input[name=exastud]', function(){
		var users = [];
		
		$("input[name^=cb\-]").each(function() {
			if($(this).prop("checked")){
				users.push($(this).attr("userid"));
			}
		});

		if (confirm("Dieser Schritt kann nicht mehr rückgängig gemacht werden, sind Sie ganz sicher?")) {
			
			call_ajax({
				users : JSON.stringify(users),
				action : 'exastud'
			}).done(function (ret) {
				alert('Ausgewählte Benutzerdaten aus Exabis Studentreview entfernt!');
				$('input[name=exastud]').removeAttr('disabled');
				$('input[name=exastud]').blur();
			});
		}
		
	});
	
	call_ajax = function(data) {
		data.sesskey = M.cfg.sesskey;
		
		var ajax = $.ajax({
			method : "POST",
			url : "ajax.php",
			data : data
		})
		.done(function(ret) {
			console.log(data.action, 'ret', ret);
		}).error(function(ret) {
			var errorMsg = '';
			if (ret.responseText[0] == '<') {
				// html
				errorMsg = $(ret.responseText).find('.errormessage').text();
			}
			console.log("Error in action '" + data.action +"'", errorMsg, 'ret', ret);
		});
		
		return ajax;
	};
	
})(jQueryExadelete);

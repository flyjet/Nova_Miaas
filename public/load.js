+function ($) {
	$body = $("body");

	$(document).on({
	    ajaxStart: function() { $body.addClass("loading");    },
	     ajaxStop: function() { $body.removeClass("loading"); }    
	});

	// Initiates an AJAX request on click
	$(document).on("click", function(){
	    $.get("/mockjax");        
	});

}();
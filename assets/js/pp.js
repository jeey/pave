/* global $ */

var donateUrl = "https://don.partipirate.org";
var joinUrl = "https://adhesion.partipirate.org";

function computeCost() {
	var cost = 0;

	switch($("#paveInput").val()) {
		case "with":
			cost += 60;
			break;
		case "without":
			cost += 45;
			break;
	}

	switch($("#deliveryInput").val()) {
		case "postal":
			cost += 5;
			break;
	}
	
	return cost;
}

$(function() {
//	function changeStatus(id, status, message) {
//		var glyphStatus = $("#" + id + "Status");
//
//		glyphStatus.removeClass("otbHidden");
//
//		if (status == "success") {
//			glyphStatus.removeClass("glyphicon-remove");
//			glyphStatus.addClass("glyphicon-ok");
//		}
//		else {
//			glyphStatus.removeClass("glyphicon-ok");
//			glyphStatus.addClass("glyphicon-remove");
//		}
//
//		glyphStatus.parents(".has-feedback").removeClass("has-success").removeClass("has-error").addClass("has-" + status);
//	}
//
//	function check_firstname() {
//		if ($("#firstname").val() == "") {
//			changeStatus("firstname", "error", "");
//			return false;
//		}
//		changeStatus("firstname", "success", "");
//		return true;
//	}
//
//	function check_lastname() {
//		if ($("#lastname").val() == "") {
//			changeStatus("lastname", "error", "");
//			return false;
//		}
//		changeStatus("lastname", "success", "");
//		return true;
//	}

//	function check_xxx() {
//	    var mailRegExp = new RegExp("^[A-Z0-9._%+-]+@[A-Z0-9.-]+\\.[A-Z]{2,4}$");
//
//		if ($("#xxx").val() == "") {
//			changeStatus("xxx", "error", "");
//			return false;
//		}
//
//		if (mailRegExp.test($("#xxx").val().toUpperCase()) === false) {
//			changeStatus("xxx", "error", "");
//			return false;
//		}
//
//		changeStatus("xxx", "success", "");
//		return true;
//	}

//	function check_confirmationMail() {
//		if ($("#xxx").val() != $("#confirmationMail").val()) {
//			changeStatus("confirmationMail", "error", "");
//			return false;
//		}
//		changeStatus("confirmationMail", "success", "");
//		return true;
//	}

	function check(form, showError) {
		var status = true;
//
//		form.find("input").each(function() {
//
//			if (form.find("#" + $(this).attr("id") + "Status").length) {
//				if (!eval("check_" + $(this).attr("id") + "();")) {
//					status = false;
//				}
//			}
//		});
//

		if ($("#paveInput").val() == "") {
			status = false;
			// error
		}
		else if ($("#paveInput").val() == "with") {
			if ($("#vpnLogin").val() == "") {
				status = false;
				// error
			}

			if ($("#vpnPassword").val() == "") {
				status = false;
				// error
			}
		}

		if ($("#deliveryInput").val() == "") {
			status = false;
			// error
		}

		if ($("#identity").val() == "") {
			status = false;
			// error
		}

		if ($("#xxx").val() == "") {
			status = false;
			// error
		}
		else if ($("#confirmationMail").val() == "") {
			status = false;
			// error
		}
		else if ($("#confirmationMail").val() != $("#xxx").val()) {
			status = false;
			// error
		}

		if ($("#line1").val() == "") {
			status = false;
			// error
		}

		if ($("#zipCode").val() == "") {
			status = false;
			// error
		}

		if ($("#city").val() == "") {
			status = false;
			// error
		}

		if (status) {
			$("#order-by-cb-button, #order-by-transfer-button, #order-by-check-button").removeAttr("disabled");
		}
		else {
			$("#order-by-cb-button, #order-by-transfer-button, #order-by-check-button").attr("disabled", "disabled");
		}

		return status;
	}

	function progressHandlingFunction(e) {
	    if (e.lengthComputable){
//	        $('progress').attr({value:e.loaded, max:e.total});
//	        console.log(e.loaded / e.total);
	    }
	}

	function submit(form) {
		if (!check(form, true)) return;

		$("#veil").show();

	    var formData = new FormData(form[0]);
	    $.ajax({
	        url: 'do_order.php',  //Server script to process data
	        type: 'POST',
//	        xhr: function() {  // Custom XMLHttpRequest
//	            var myXhr = $.ajaxSettings.xhr();
//	            if(myXhr.upload){ // Check if upload property exists
//	                myXhr.upload.addEventListener('progress', progressHandlingFunction, false); // For handling the progress of the upload
//	            }
//	            return myXhr;
//	        },
	        //Ajax events
	        success: function(data) {
    			$("#veil").hide();
        		data = JSON.parse(data);

        		if (data.ko) {
	    			$("#contactForm").hide();
	    			$("#problem").show();
        		}
        		else {
	    			$("#contactForm").hide();
	    			$("#response").show();
        			window.location = data.paymentLink
        		}
	        },
	        data: formData,
	        cache: false,
	        contentType: false,
	        processData: false
	    });
	}

	$("#paveButtons button").click(function() {
		if (!$(this).hasClass("active")) {
			$("#paveButtons button").removeClass("active");
			$(this).addClass("active");

			$("#paveInput").val($(this).val());
		}
		$(".vpn-with").hide();
		$(".vpn-" + $("#paveInput").val()).show();
		
		$(".cost").text(computeCost());
		
		check($("#contactForm"), false);
	});

	$("#deliveryButtons button").click(function() {
		if (!$(this).hasClass("active")) {
			$("#deliveryButtons button").removeClass("active");
			$(this).addClass("active");

			$("#deliveryInput").val($(this).val());
		}

		$(".cost").text(computeCost());

		check($("#contactForm"), false);
	});

	$('#confirmationMail').bind('paste', function(event) {
		event.preventDefault();
	});

	$("#contactForm").submit(function(event) {
		event.preventDefault();
		submit($("#contactForm"));
	});

	$("#order-by-cb-button").click(function(event) {
		event.preventDefault();
		$("#paymentType").val("cb");
		submit($("#contactForm"));
	});

	$("#order-by-transfer-button").click(function(event) {
		event.preventDefault();
		$("#paymentType").val("transfer");
		submit($("#contactForm"));
	});

	$("#order-by-check-button").click(function(event) {
		event.preventDefault();
		$("#paymentType").val("check");
		submit($("#contactForm"));
	});

	$("#vpnLogin, #vpnPassword, #deliveryInput, #identity, #xxx, #confirmationMail, #line1, #zipCode, #city").keyup(function() {
		check($("#contactForm"), false);
	});

	$(".vpn-with").hide();
	check($("#contactForm"), false);
});
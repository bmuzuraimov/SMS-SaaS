$(document).ready(function() {
    $('.menu-toggle').on('click', function() {
        $('.nav').toggleClass('showing');
        $('.nav ul').toggleClass('showing');
    });
    $("input").keypress(function() {
        $('.msg').removeClass('success error');
        $(".msg").empty();
    });
});

function ajax_update_request(form_id, button_id, message_class, button_message, is_animate = false) {
    $.post($('#' + form_id).attr('action'), $('#' + form_id + ' :input').serializeArray(), function(info) {
        if (info == 'success') {
            $('#' + button_id).html(button_message);
            $('.' + message_class).addClass('success');
            $('.' + message_class).html('Сохранено!');
            if (is_animate == true) {
                $('html, body').animate({
                    scrollTop: 0
                }, 'slow');
            }
        } else {
            $('.' + message_class).addClass('error');
            $('.' + message_class).html('Произошла ошибка!');
            if (is_animate === true) {
                $('html, body').animate({
                    scrollTop: 0
                }, 'slow');
            }
        }
    });
    $('#' + form_id).submit(function() {
        return false;
    });
}

function ajax_insert_request(form_id, button_id, message_class, button_message, is_clear = false) {
    $.post($('#'+form_id).attr('action'), $('#'+form_id+' :input').serializeArray(), function(info) {
        if (info == 'success') {
            $('#'+button_id).html(button_message);
            if (is_clear === true) {
	            $('.text-input').val(null);
	            $('.contact-checkbox').prop('checked', false);
            }
        } else{
            $('.'+message_class).addClass('error');
            $('.'+message_class).html('Ошибка!');
        }
    });
    $('#' + form_id).submit(function() {
        return false;
    });
}

function ajax_signin_request(form_id, message_class = 'msg', timer = 0) {
    $.post($('#' + form_id).attr('action'), $('#' + form_id + ' :input').serializeArray(), function(response) {
		responseObj = JSON.parse(response);
		if (responseObj.success==true) {
			$('.'+message_class).addClass('success');
			$('.'+message_class).html(responseObj.message);	
			$('html, body').animate({scrollTop: 0}, 'slow');
			window.setTimeout(function () {
        		location.href = '/'+responseObj.link;
    		}, timer);
		}else {
			$('.'+message_class).addClass('error');
			$('.'+message_class).html(responseObj.message);
		}
		});
    $('#' + form_id).submit(function() {
        return false;
    });
}
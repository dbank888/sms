
jQuery(document).ready(function() {
	
    /*
        Fullscreen background
    */
    $.backstretch([
                    "css/login/img/2.jpg"
	              , "css/login/img/3.jpg"
	              , "css/login/img/1.jpg"
	             ], {duration: 3000, fade: 750});
    
    /*
        Form validation
    */
    $('.login-form input[type="text"], .login-form input[type="password"], .login-form textarea').on('focus', function() {
    	$(this).removeClass('input-error');
    });
    
    $('.login-form').on('submit', function(e) {


        e.preventDefault();
        var account = $("input[name='account']");
    	if(account.val() == ""){
            account.addClass('input-error');
            return false;
		}else{
            account.removeClass('input-error');
		}

		var password = $("input[name='password']");
        if(password.val() == ""){
            password.addClass('input-error');
            return false;
        }else {
            password.removeClass('input-error');
        }

        var _data = $(this).serializeArray().reduce(function(result, item){
            result[item.name] = item.value;
            return result;
        }, {});
        $.ajax({
            type: "POST",
            url: base_path + "/auth/login",
            dataType: "json",
            data:_data,
            headers: {
                'X-CSRF-TOKEN': csrf_token
            },
            error: function (request) {
                error(request.responseJSON.ErrorMsg);
            },
            success: function (rs) {
                window.location.href = rs.url;
            }
        });
    	
    });
});

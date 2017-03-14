var add_friend_sign;
var add_interest_sign;

$(function(){
    // Add csrf token to ajax requests
    // @link http://api.jquery.com/extending-ajax/
    // @link http://aymsystems.com/ajax-csrf-protection-codeigniter-20/
    $.ajaxPrefilter( function( options, originalOptions, jqXHR ) {
        // Only when post
        if (options.type == "post") {
            // console.log("ajaxPrefilter");
            // console.log("options", options);
            // console.log("originalOptions", originalOptions);
            var cct = $.cookie('csrf_cookie_doniuren');
            //console.log('csrf_cookie', cct);
            if (cct && (cct.length > 0) && (options.data.indexOf('csrf_doniuren=') == -1)) {
                options.data += '&csrf_doniuren='+cct
            }
        }
    });

    $("input[type=text]").each(function() {
        if (typeof($(this).attr("_default_value")) != "undefined") {
            $(this).attr("value", $(this).attr("_default_value"));
            $(this).bind("focus", function(){
                if ($(this).attr("value") == $(this).attr("_default_value")) {
                    $(this).attr("value", "");
                }
            })
            $(this).bind("focusout", function(){
                if ($(this).attr("value") == "") {
                    $(this).attr("value", $(this).attr("_default_value"));
                }
            })
        }
    });
});

function count_down(secs,surl){    
     if(--secs>0) {    
         setTimeout("count_down("+secs+",'"+surl+"')",1000);
     } else{      
        location.href = surl;    
    }    
 }
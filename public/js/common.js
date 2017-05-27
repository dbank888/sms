/**
 * Created by summerway on 26/05/2017.
 */

function info(msg){
    layer.alert(msg,{title:'提示',icon:0})
}

function success(msg){
    layer.alert(msg,{title:'提示',icon:1})
}

function error(msg){
    layer.alert(msg,{title:'错误',icon:2})
}

function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};
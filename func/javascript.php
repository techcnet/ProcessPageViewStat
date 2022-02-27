<?php namespace ProcessPageViewStat;

function get_javascript() {
return '(function(){var starttime=0;function send(){if(starttime>0){var utime=(Date.now()-starttime)/1000;starttime=0;var async=true;if(navigator.userAgent.indexOf("Firefox")!=-1){async=false;}var request=window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");request.open("get","/vts/?t="+Math.ceil(utime)+"&u="+encodeURIComponent(document.URL)+"&r="+encodeURIComponent(document.referrer),async);request.send();}};function onload(){starttime=Date.now();};function onfocus(){starttime=Date.now();};function onblur(){send()};function onbeforeunload(){send()};if(window.addEventListener){window.addEventListener("load",onload,!1);window.addEventListener("beforeunload",onbeforeunload,!1);window.addEventListener("blur",onblur,!1);window.addEventListener("focus",onfocus,!1)}else if(window.attachEvent){window.attachEvent("onload",onload);window.attachEvent("onbeforeunload",onbeforeunload);window.attachEvent("onblur",onblur);window.attachEvent("onfocus",onfocus)}else{window.onload=onload;window.onbeforeunload=onbeforeunload;window.onblur=onblur;window.onfocus=onfocus}return{}})()';
}
?>

<?php namespace ProcessPageViewStat;

function get_javascript() {
return '(function(){var idletimer;var starttime=0;var idyletimeout=0;var idletimer=0;function send(){if(starttime>0){utime=(new Date()-starttime)/1000;starttime=0;var request=new XMLHttpRequest;request.open("get","/vts/?t="+Math.ceil(utime)+"&u="+encodeURIComponent(document.URL)+"&r="+encodeURIComponent(document.referrer));request.send()}};function idleincrement(){idyletimeout=idyletimeout+1}
function onload(){starttime=new Date();idyletimeout=0;idletimer=setInterval(idleincrement,1000)};function onfocus(){starttime=new Date();idyletimeout=0};function onactivity(){idyletimeout=0};function onblur(){send()}
function onbeforeunload(){send()}
if(window.addEventListener){window.addEventListener("load",onload,!1);window.addEventListener("beforeunload",onbeforeunload,!1);window.addEventListener("blur",onblur,!1);window.addEventListener("focus",onfocus,!1);window.addEventListener("scroll",onactivity,!1);window.addEventListener("mousemove",onactivity,!1);window.addEventListener("keypress",onactivity,!1);window.addEventListener("touchstart",onactivity,!1)}else if(window.attachEvent){window.attachEvent("onload",onload);window.attachEvent("onbeforeunload",onbeforeunload);window.attachEvent("onblur",onblur);window.attachEvent("onfocus",onfocus);window.attachEvent("onscroll",onactivity);window.attachEvent("onmousemove",onactivity);window.attachEvent("onkeypress",onactivity);window.attachEvent("ontouchstart",onactivity)}else{window.onload=onload;window.onbeforeunload=onbeforeunload;window.onblur=onblur;window.onfocus=onfocus;window.onscroll=onactivity;window.onmousemove=onactivity;window.onkeypress=onactivity;window.ontouchstart=onactivity}
return{}})()';
}
?>
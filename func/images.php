<?php

function get_os_img($osname) {
  if (strpos($osname, 'android') !== false) {
    return 'android';
  } elseif (strpos($osname, 'freebsd') !== false) {
    return 'freebsd';
  } elseif (strpos($osname, 'ios') !== false) {
    return 'ios';
  } elseif (strpos($osname, 'linux') !== false) {
    return 'linux';
  } elseif (strpos($osname, 'mac osx') !== false) {
    return 'mac_osx';
  } elseif (strpos($osname, 'openbsd') !== false) {
    return 'openbsd';
  } elseif (strpos($osname, 'powerpc') !== false) {
    return 'powerpc';
  } elseif (strpos($osname, 'windows 7') !== false) {
    return 'windows_7';
  } elseif (strpos($osname, 'windows 8') !== false) {
    return 'windows_8';
  } elseif (strpos($osname, 'windows 10') !== false) {
    return 'windows_10';
  } elseif (strpos($osname, 'windows 95') !== false) {
    return 'windows_95';
  } elseif (strpos($osname, 'windows 98') !== false) {
    return 'windows_98';
  } elseif (strpos($osname, 'windows 2000') !== false) {
    return 'windows_2000';
  } elseif (strpos($osname, 'windows me') !== false) {
    return 'windows_me';
  } elseif (strpos($osname, 'windows vista') !== false) {
    return 'windows_vista';
  } elseif (strpos($osname, 'windows xp') !== false) {
    return 'windows_xp';
  } elseif ($osname != '') {
    return 'unknown';
  } else {
    return 'none';
  }
}

function get_browser_img($browsername) {
  if (strpos($browsername, 'arora') !== false) {
    return 'arora';
  } elseif (strpos($browsername, 'chrome') !== false) {
    return 'chrome';
  } elseif (strpos($browsername, 'explorer') !== false) {
    return 'explorer';
  } elseif (strpos($browsername, 'firefox') !== false) {
    return 'firefox';
  } elseif (strpos($browsername, 'icab') !== false) {
    return 'icab';
  } elseif (strpos($browsername, 'iceweasel') !== false) {
    return 'iceweasel';
  } elseif (strpos($browsername, 'k-meleon') !== false) {
    return 'k-meleon';
  } elseif (strpos($browsername, 'lunascape') !== false) {
    return 'lunascape';
  } elseif (strpos($browsername, 'maxthon') !== false) {
    return 'maxthon';
  } elseif (strpos($browsername, 'mozilla') !== false) {
    return 'mozilla';
  } elseif (strpos($browsername, 'netscape') !== false) {
    return 'netscape';
  } elseif (strpos($browsername, 'opera') !== false) {
    return 'opera';
  } elseif (strpos($browsername, 'safari') !== false) {
    return 'safari';
  } elseif (strpos($browsername, 'seamonkey') !== false) {
    return 'seamonkey';
  } elseif (strpos($browsername, 'sleipnir') !== false) {
    return 'sleipnir';
  } elseif (strpos($browsername, ' (app)') !== false) {
    return 'app';
  } elseif (strpos($browsername, ' (bot)') !== false) {
    return 'bot';
  } elseif (strpos($browsername, ' (downloader)') !== false) {
    return 'downloader';
  } elseif (strpos($browsername, ' (mobile)') !== false) {
    return 'mobile';
  } elseif (strpos($browsername, ' (pc)') !== false) {
    return 'pc';
  } elseif (strpos($browsername, ' (script)') !== false) {
    return 'script';
  } elseif ($browsername == 'unknown') {
    return 'unknown';
  } elseif ($browsername != '') {
    return 'unknown';
  } else {
    return 'none';
  }
}
?>
<?php namespace ProcessPageViewStat;

function get_platform_img($platform) {
  if (strpos($platform, 'macintosh') !== false) {
    return 'osx';
  } elseif (strpos($platform, 'chrome') !== false) {
    return 'chrome';
  } elseif (strpos($platform, 'linux') !== false) {
    return 'linux';
  } elseif (strpos($platform, 'windows') !== false) {
    return 'windows';
  } elseif (strpos($platform, 'android') !== false) {
    return 'android';
  } elseif (strpos($platform, 'blackberry') !== false) {
    return 'blackberry';
  } elseif (strpos($platform, 'playbook') !== false) {
    return 'blackberry';
  } elseif (strpos($platform, 'freebsd') !== false) {
    return 'freebsd';
  } elseif (strpos($platform, 'ipad') !== false) {
    return 'ios';
  } elseif (strpos($platform, 'iphone') !== false) {
    return 'ios';
  } elseif (strpos($platform, 'ipod') !== false) {
    return 'ios';
  } elseif (strpos($platform, 'kindle') !== false) {
    return 'kindle';
  } elseif (strpos($platform, 'netbsd') !== false) {
    return 'netbsd';
  } elseif (strpos($platform, 'nintendo') !== false) {
    return 'Nintendo';
  } elseif (strpos($platform, 'openbsd') !== false) {
    return 'openbsd';
  } elseif (strpos($platform, 'playstation') !== false) {
    return 'playstation';
  } elseif (strpos($platform, 'sailfish') !== false) {
    return 'sailfish';
  } elseif (strpos($platform, 'symbian') !== false) {
    return 'symbian';
  } elseif (strpos($platform, 'tizen') !== false) {
    return 'tizen';
  } elseif (strpos($platform, 'xbox') !== false) {
    return 'xbox';
  } elseif ($platform != '') {
    return 'unknown';
  } else {
    return 'none';
  }
}

function get_browser_img($browser) {
  if (strpos($browser, 'bot') !== false) {
    return 'bot';
  } elseif (strpos($browser, 'baiduspider') !== false) {
    return 'bot';
  } elseif (strpos($browser, 'android browser') !== false) {
    return 'android';
  } elseif (strpos($browser, 'blackBerry browser') !== false) {
    return 'blackberry';
  } elseif (strpos($browser, 'bunjalloo') !== false) {
    return 'bunjalloo';
  } elseif (strpos($browser, 'camino') !== false) {
    return 'camino';
  } elseif (strpos($browser, 'chrome') !== false) {
    return 'chrome';
  } elseif (strpos($browser, 'curl') !== false) {
    return 'curl';
  } elseif (strpos($browser, 'edge') !== false) {
    return 'edge';
  } elseif (strpos($browser, 'mozilla') !== false) {
    return 'mozilla';
  } elseif (strpos($browser, 'facebookexternalhit') !== false) {
    return 'facebook';
  } elseif (strpos($browser, 'feedvalidator') !== false) {
    return 'feed';
  } elseif (strpos($browser, 'firefox') !== false) {
    return 'firefox';
  } elseif (strpos($browser, 'headlesschrome') !== false) {
    return 'chrome';
  } elseif (strpos($browser, 'iemobile') !== false) {
    return 'msie';
  } elseif (strpos($browser, 'kindle') !== false) {
    return 'kindle';
  } elseif (strpos($browser, 'lynx') !== false) {
    return 'lynx';
  } elseif (strpos($browser, 'midori') !== false) {
    return 'midori';
  } elseif (strpos($browser, 'miuibrowser') !== false) {
    return 'xiaomi';
  } elseif (strpos($browser, 'msie') !== false) {
    return 'msie';
  } elseif (strpos($browser, 'netfront') !== false) {
    return 'netfront';
  } elseif (strpos($browser, 'nintendobrowser') !== false) {
    return 'nintendo';
  } elseif (strpos($browser, 'oculusbrowser') !== false) {
    return 'oculus';
  } elseif (strpos($browser, 'opera') !== false) {
    return 'opera';
  } elseif (strpos($browser, 'puffin') !== false) {
    return 'puffin';
  } elseif (strpos($browser, 'safari') !== false) {
    return 'safari';
  } elseif (strpos($browser, 'sailfishbrowser') !== false) {
    return 'sailfish';
  } elseif (strpos($browser, 'samsungbrowser') !== false) {
    return 'samsung';
  } elseif (strpos($browser, 'silk') !== false) {
    return 'silk';
  } elseif (strpos($browser, 'tizenbrowser') !== false) {
    return 'tizen';
  } elseif (strpos($browser, 'uc browser') !== false) {
    return 'uc';
  } elseif (strpos($browser, 'valve steam tenfoot') !== false) {
    return 'vst';
  } elseif (strpos($browser, 'vivaldi') !== false) {
    return 'vivaldi';
  } elseif (strpos($browser, 'wget') !== false) {
    return 'wget';
  } elseif (strpos($browser, 'wordpress') !== false) {
    return 'wordpress';
  } elseif (strpos($browser, 'yandex') !== false) {
    return 'yandex';
  } elseif (strpos($browser, 'browser') !== false) {
    return 'browser';
  } elseif ($browser != '') {
    return 'unknown';
  } else {
    return 'none';
  }
}
?>
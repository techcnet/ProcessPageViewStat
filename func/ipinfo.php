<?php namespace ProcessPageViewStat;

function query_whois($server, $domain) {
  $ip = gethostbyname($server);
  if ($ip == '') return '';
  $fp = fsockopen($ip, 43, $errno, $errstr, 10);
  if ($fp) {
    fputs($fp, $domain."\r\n");
    $out = '';
    while(!feof($fp)){
      $out .= fgets($fp);
    }
    fclose($fp);
    return $out;
  } else {
    return '';
  }
} 

function parse_request($s, $x) {
  $s = str_ireplace("\r", "\n", $s);
  $parts = explode("\n", $s);
  foreach ($parts as $part) {
    $i = strpos($part, $x);
    if ($i !== false) {
      return trim(substr($part, $i+strlen($x)));
    }
  }
}

function get_whois($q) {
  $request = query_whois('whois.iana.org', $q);
  $server = parse_request($request, 'refer:');
  if ($server == '') return '';
  $request = query_whois($server, $q);
  return $request;
}

function showIPInfo($ip, $module_url) {
  echo '<!DOCTYPE html>';
  echo '<html>';
  echo '<head>';
  echo '<title>IP Info</title>';
  echo '<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />';
  echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
  echo '<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />';
  echo '<meta http-equiv="Pragma" content="no-cache" />';
  echo '<meta http-equiv="Expires" content="0" />';
  echo '<style>';
  echo '*{';
  echo 'margin:0;';
  echo 'padding:0;';
  echo 'box-sizing:border-box;';
  echo '-webkit-box-sizing:border-box;';
  echo '-moz-box-sizing:border-box;';
  echo '-ms-box-sizing:border-box;';
  echo '-o-box-sizing:border-box;';
  echo '}';
  echo 'body{';
  echo 'padding:20px;';
  echo 'line-height:1.5em;';
  echo 'font-family:Helvetica,Arial;';
  echo 'font-size:13px;';
  echo '}';
  echo 'pre{';
  echo 'margin-top:20px;';
  echo '}';
  echo '.flag{';
  echo 'margin-left:5px;';
  echo 'vertical-align:middle;';
  echo '}';
  echo '</style>';
  echo '</head>';
  echo '<body>';
  echo '<h1>'.$ip.'</h1>';
  echo '<pre>';
  $array = explode("\n", get_whois($ip));
  $space = false;
  foreach ($array as $s) {
    if ((!str_starts_with($s, '%')) && (!str_starts_with($s, '#'))) {
      if (trim($s) == '') {
        if ($space == true) {
          continue;
        }
        $space = true;
      } else {
        $space = false;
      }
      if (str_starts_with(strtolower($s), 'country:')) {
        echo $s.'<img class="flag" src="'.$module_url.'/images/country/'.strtolower(substr($s, strrpos($s, ' ') + 1)).'.png" />'."\r\n";
      } else {
        echo $s."\r\n";
      }
    }
  }
  echo '</pre>';
  echo '</body>';
  echo '</html>';
}
?>
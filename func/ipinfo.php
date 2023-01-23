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

function showIPInfo($ip, $module_url, $show_map) {
  echo '<!DOCTYPE html>';
  echo '<html>';
  echo '<head>';
  echo '<title>IP Info</title>';
  echo '<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />';
  echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
  echo '<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />';
  echo '<meta http-equiv="Pragma" content="no-cache" />';
  echo '<meta http-equiv="Expires" content="0" />';
  echo '<link rel="stylesheet" type="text/css" href="'.$module_url.'/OpenLayers.css" />';
  echo '<script src="'.$module_url.'/OpenLayers.js"></script>';
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
  echo 'margin-bottom:20px;';
  echo '}';
  echo '.flag{';
  echo 'margin-left:5px;';
  echo 'vertical-align:middle;';
  echo 'color-scheme:light dark;';
  echo '}';
  echo '#mapdiv{height:300px}';
  echo '</style>';
  echo '</head>';
  echo '<body>';
  echo '<h1>'.$ip.'</h1><br />';
  if ($ip != '') {
    echo '<pre>';
    $hostname = gethostbyaddr($ip);
    if ($hostname != $ip) echo 'Hostname: '.$hostname.'<br />';
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

    if ($show_map) {
      $geoplugin = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip));
      if ($geoplugin !== null) {
        if ((isset($geoplugin['geoplugin_latitude'])) && is_numeric($geoplugin['geoplugin_latitude']) && 
            (isset($geoplugin['geoplugin_longitude'])) && is_numeric($geoplugin['geoplugin_longitude'])) {
          echo '<pre>';
          if (isset($geoplugin['geoplugin_timezone'])) echo 'Timezone: '.$geoplugin['geoplugin_timezone'].'<br />';
          if (isset($geoplugin['geoplugin_currencyCode'])) echo 'Currency: '.$geoplugin['geoplugin_currencyCode'].'<br />';
          echo 'Latitude: '.$geoplugin['geoplugin_latitude'].'<br />';
          echo 'Longitude: '.$geoplugin['geoplugin_longitude'].'<br />';
          echo '</pre>';

          echo '<div id="mapdiv"></div>';
          echo '<script>';
          echo 'var epsg4326=new OpenLayers.Projection("EPSG:4326");';
          echo 'var map=new OpenLayers.Map("mapdiv");';
          echo 'map.addLayer(new OpenLayers.Layer.OSM());';
          echo 'map.addControls([new OpenLayers.Control.ScaleLine()]);';
          echo 'var projectTo=map.getProjectionObject();';
          echo 'var vector=new OpenLayers.Layer.Vector();';
          echo 'var feature=new OpenLayers.Feature.Vector(new OpenLayers.Geometry.Point('.$geoplugin['geoplugin_longitude'].','.$geoplugin['geoplugin_latitude'].').transform(epsg4326,projectTo));';
          echo 'feature.style={externalGraphic:"'.$module_url.'/images/marker.png",graphicHeight:32,graphicWidth:32,graphicXOffset:-16,graphicYOffset:-32};';
          echo 'vector.addFeatures(feature);';
          echo 'map.addLayer(vector);';
          echo 'map.setCenter(new OpenLayers.LonLat('.$geoplugin['geoplugin_longitude'].','.$geoplugin['geoplugin_latitude'].').transform(epsg4326,projectTo),4);';
          echo '</script>';
        }
      }
    }
  }
  
  echo '</body>';
  echo '</html>';
}
?>
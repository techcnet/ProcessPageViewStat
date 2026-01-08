<?php namespace ProcessPageViewStat;

function auto_download($url, $dir_name, $zip_name) {
  $download_file = $dir_name.$zip_name;
  if (file_exists($download_file)) {
    if (!unlink($download_file)) {
      $LastError = error_get_last();
      if ((is_array($LastError)) && (isset($LastError['message']))) {
        return 'Error: delete '.$download_file.'. '.$LastError['message'];
      } else {
        return 'Error: delete '.$download_file.'. '.$LastError;
      }
    }
  }

  $fp = fopen($download_file, 'w+');
  if (!$fp) {
    return 'Error: create '.$download_file;
  }
  $ContextOptions = array(
    'http' => array(
      'timeout' => 60,
      'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36\r\n"
    )
  );
  $Context = stream_context_create($ContextOptions);
  $ch = fopen($url, 'rb', false, $Context);
  if ($ch) {
    while(!feof($ch)) {
      fwrite($fp, fread($ch, 1048576), 1048576);
    }
    fclose($ch);
  }
  fclose($fp);

  if (file_exists($download_file)) {
    $zip = new \ZipArchive;
    $res = $zip->open($download_file);
    if ($res === true) {
      $zip->extractTo($dir_name);
      for($i=0; $i<$zip->numFiles; $i++){
        touch($dir_name.$zip->statIndex($i)['name'], $zip->statIndex($i)['mtime']);
      }
      $zip->close();
      return $download_file.' update successfully';
    } else {
      return 'Error: unzip '.$download_file;
    }
  } else {
    return 'Error: download '.$download_file;
  }
}
?>
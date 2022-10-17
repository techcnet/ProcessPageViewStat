<?php namespace ProcessWire;

/**
 * Page View Statistic for ProcessWire
 * Logs page views of the CMS.
 *
 * @author tech-c.net
 * @license Licensed under GNU/GPL v2
 * @link https://tech-c.net/posts/page-view-statistic-for-processwire/
 * @version 1.1.9
 * 
 * @see Forum Thread: https://processwire.com/talk/topic/24189-pageviewstatistic-for-processwire/
 * @see Donate: https://tech-c.net/donation/
 */

class ProcessPageViewStatConfig extends ModuleConfig {
  const dbTableMain = 'process_pageviewstat_main';
  const dbTableCache = 'process_pageviewstat_cache';
  /**
   * Get default configuration, automatically passed to input fields.
   * @return array
   */
  public function getDefaults() {
    return array(
      'whois_service' => 'https://whatismyipaddress.com/ip/%s',
      'row_limit' => 100,
      'time_format' => 'H:i:s',
      'time_zone' => 'UTC',
      'auto_delete_older' => 0,
      'record_admin' => 1,
      'record_loggedin' => 1,
      'record_user' => 0,
      'record_404' => 0,
      'record_hidden' => 0,
      'record_time' => 1,
      'auto_update_ip2loc' => 1,
      'cache_update_interval' => '',
      'log_update_cache' => 0,
      'whois_external' => 0,
      'whois_dlg' => 1
    );
  }
  /**
   * Render input fields on config Page.
   * @return string
   */
  public function getInputfields() {
    $fields = parent::getInputfields();
// General
    $fieldset = $this->modules->get('InputfieldFieldset');
    $fieldset->label = __('General');
    $fieldset->collapsed = Inputfield::collapsedNever;
    
    $timezoneIdentifiers = \DateTimeZone::listIdentifiers();
    $utcTime = new \DateTime('now', new \DateTimeZone('UTC'));
    $timezones = array();
    foreach ($timezoneIdentifiers as $timezoneIdentifier) {
      $currentTimezone = new \DateTimeZone($timezoneIdentifier);
      $sign = ((int)$currentTimezone->getOffset($utcTime) > 0) ? '+' : '-';
      $offset = gmdate('H:i', abs((int)$currentTimezone->getOffset($utcTime)));
      $timezones[$timezoneIdentifier] = 'UTC '.$sign.' '.$offset.' '.str_replace('_', ' ', $timezoneIdentifier);
    }
    $field = $this->modules->get('InputfieldSelect');
    $field->name = 'time_zone';
    $field->label = __('Timezone');
    $field->description = __('Timezone of the displayed time. This timezone also affects the creation of the cache.');
    $field->required = true;
    $field->addOptions($timezones);
    $fieldset->add($field);

    $field = $this->modules->get('InputfieldCheckbox');
    $field->name = 'record_admin';
    $field->label = __('Record admin template');
    $field->label2 = __('Enable');
    $field->description = __('Records pages with admin template.');
    $field->attr('name', 'record_admin');
    $fieldset->add($field);

    $field = $this->modules->get('InputfieldCheckbox');
    $field->name = 'record_loggedin';
    $field->label = __('Record loggedin user');
    $field->label2 = __('Enable');
    $field->description = __('Records pages visited by loggedin users.');
    $field->attr('name', 'record_loggedin');
    $fieldset->add($field);

    $field = $this->modules->get('InputfieldCheckbox');
    $field->name = 'record_user';
    $field->label = __('Record user names');
    $field->label2 = __('Enable');
    $field->description = __('Records user names. Note, that you have also to enable "Record loggedin user".');
    $field->attr('name', 'record_user');
    $fieldset->add($field);

    $field = $this->modules->get('InputfieldCheckbox');
    $field->name = 'record_404';
    $field->label = __('Record 404 pages');
    $field->label2 = __('Enable');
    $field->description = __('Records pages redirected to the 404 page (http404).');
    $field->attr('name', 'record_404');
    $fieldset->add($field);

    $field = $this->modules->get('InputfieldCheckbox');
    $field->name = 'record_hidden';
    $field->label = __('Record hidden pages');
    $field->label2 = __('Enable');
    $field->description = __('Records pages which set as hidden.');
    $field->attr('name', 'record_hidden');
    $fieldset->add($field);

    $field = $this->modules->get('InputfieldSelect');
    $field->name = 'row_limit';
    $field->label = __('Row limit');
    $field->description = __('Number of rows visible per page.');
    $field->required = true;
    $field->addOptions(array(
      '10' => '10',
      '20' => '20',
      '25' => '25',
      '50' => '50', 
      '75' => '75', 
      '100' => '100',
      '250' => '250',
      '500' => '500',
      '750' => '750',
      '1000' => '1000'
    ));
    $fieldset->add($field);

    $fields->add($fieldset);
// Records
    $fieldset = $this->modules->get('InputfieldFieldset');
    $fieldset->label = __('Detailed records');
    $fieldset->collapsed = Inputfield::collapsedNever;

    $field = $this->modules->get('InputfieldMarkup');
    $field->description = __('Following settings affecting the detailed records.');
    $field->value = '<img style="margin:auto;" src="'.wire('config')->urls->siteModules.'ProcessPageViewStat'.'/images/records.png" />';
    $field->collapsed = Inputfield::collapsedNever;
    $fieldset->add($field);

    $field = $this->modules->get('InputfieldCheckbox');
    $field->name = 'record_time';
    $field->label = __('Record view time');
    $field->label2 = __('Enable');
    $field->description = __('Records the time of view in seconds. If activated you will find a column (S.) in the detailed records which means the time of view in seconds.');
    $field->attr('name', 'record_time');
    $fieldset->add($field);

    $dt = new \DateTime();
    $field = $this->modules->get('InputfieldSelect');
    $field->name = 'time_format';
    $field->label = __('Time format');
    $field->description = __('Format of the displayed time.');
    $field->required = true;
    $field->addOptions(array(
      'H:i:s' => $dt->format('H:i:s'),
      'h:i:s A' => $dt->format('h:i:s A')
    ));
    $fieldset->add($field);

    $field = $this->modules->get('InputfieldSelect');
    $field->name = 'auto_delete_older';
    $field->label = __('Automatically delete records');
    $field->description = __('Automatically deletes records unrecoverable if older than the specified days. The execution will be schedulled once a day.');
    $field->notes = __('Note, that this will not delete cached visitor counts.');
    $arraydays = array(0,2,5,10,20,30,60,90,180,365,730,1095);
    foreach ($arraydays as $arrayday) {
      if ($arrayday < 2) {
        $field->addOptions(array($arrayday => __('don\'t automatically delete')));
      } else {
        $field->addOptions(array($arrayday => sprintf(__('older than %d days'), $arrayday)));
      }
    }
    $field->appendMarkup  = '<script type="text/javascript">';
    $field->appendMarkup .= '$("select[name=\'auto_delete_older\']").change(function(){';
    $field->appendMarkup .= 'if(this.value > 0){';
    $field->appendMarkup .= 'if(!confirm("'.__('Are you sure you want to automatically delete records?').'")){';
    $field->appendMarkup .= '$(this).val("0");';
    $field->appendMarkup .= '}';
    $field->appendMarkup .= '}';
    $field->appendMarkup .= '});</script>';
    $data = $this->modules->getModuleConfigData('ProcessPageViewStat');
    if ((isset($data['auto_delete_older'])) && ($data['auto_delete_older'] < 2)) {
      $field->collapsed = Inputfield::collapsedYes;
    }
    $fieldset->add($field);

    $field = $this->modules->get('InputfieldCheckbox');
    $field->name = 'delete_all_records';
    $field->label = __('Delete all records');
    $field->description = __('Deletes all records unrecoverable.');
    $field->notes = __('Note, that this will not delete cached visitor counts.');
    $field->appendMarkup  = '<script type="text/javascript">';
    $field->appendMarkup .= '$("input[name=\'delete_all_records\']").change(function(){';
    $field->appendMarkup .= 'if(this.checked){';
    $field->appendMarkup .= 'if(!confirm("'.__('Are you sure you want to delete all records?').'")){';
    $field->appendMarkup .= '$(this).removeAttr("checked")';
    $field->appendMarkup .= '}';
    $field->appendMarkup .= '}';
    $field->appendMarkup .= '});</script>';
    $field->attr('name', 'delete_all_records');
    $field->attr('checked', '');
    $field->collapsed = Inputfield::collapsedYes;
    $fieldset->add($field);

    $query = wire('database')->query("SHOW TABLES LIKE '".self::dbTableMain."'");
    if ($query->fetchColumn() > 0) {
      $query = wire('database')->query("SELECT COUNT(*) FROM ".self::dbTableMain);
      $rows = $query->fetchColumn();
      $query = wire('database')->query("SHOW TABLE STATUS LIKE '".self::dbTableMain."'");
      $result = $query->fetch(\PDO::FETCH_ASSOC);
      $size = $result['Data_length'];
      $field = $this->modules->get('InputfieldMarkup');
      $field->label = __('Table statistic');
      $field->value = __('Rows: ').$rows.'<br>'.__('Size: ').$size.' '.__('bytes');
      $field->collapsed = Inputfield::collapsedNever;
      $fieldset->add($field);
    }
 
    $fields->add($fieldset);
// Cache
    $fieldset = $this->modules->get('InputfieldFieldset');
    $fieldset->label = __('Cached visitor counts');
    $fieldset->collapsed = Inputfield::collapsedNever;

    $field = $this->modules->get('InputfieldMarkup');
    $field->description = __('Following settings affecting the cached visitor counts. The cache is updated based on existsing records.');
    $field->value = '<img style="margin:auto;" src="'.wire('config')->urls->siteModules.'ProcessPageViewStat'.'/images/cache.png" />';
    $field->collapsed = Inputfield::collapsedNever;
    $fieldset->add($field);

    $field = $this->modules->get('InputfieldSelect');
    $field->name = 'cache_update_interval';
    $field->label = __('Cache update interval');
    $field->description = __('If selected "only manually" the cache is updated every time you open the "Cached visitor counts". If not selected "only manually" the cache is updated in the specified time period.');
    $field->addOptions(array(
      '' => __('only manually'),
      'everyMinute' => __('every minute'),
      'every5Minutes' => __('every 5 minutes'),
      'every10Minutes' => __('every 10 minutes'), 
      'every30Minutes' => __('every 30 minutes'), 
      'everyHour' => __('every hour'),
      'everyDay' => __('every day')
    ));
    $fieldset->add($field);

    $field = $this->modules->get('InputfieldCheckbox');
    $field->name = 'log_update_cache';
    $field->label = __('Log successful update');
    $field->label2 = __('Enable');
    $field->description = __('Writes to the log when the cache has been successfully updated.');
    $field->attr('name', 'log_update_cache');
    $fieldset->add($field);

    $query = wire('database')->query("SHOW TABLES LIKE '".self::dbTableCache."'");
    if ($query->fetchColumn() > 0) {
      $field = $this->modules->get('InputfieldCheckbox');
      $field->name = 'rebuild_cache';
      $field->label = __('Rebuild cache');
      $field->description = __('Rebuilds the cache based on existsing records.');
      $field->notes = __('Note, that the cache cannot be rebuilded from already deleted records! Building the cache from the scratch might take longer. Execute the rebuild again if you encounter an error 500.');
      $field->appendMarkup  = '<script type="text/javascript">';
      $field->appendMarkup .= '$("input[name=\'rebuild_cache\']").change(function(){';
      $field->appendMarkup .= 'if(this.checked){';
      $field->appendMarkup .= 'if(!confirm("'.__('Are you sure you want to rebuild the cache?').'")){';
      $field->appendMarkup .= '$(this).removeAttr("checked")';
      $field->appendMarkup .= '}';
      $field->appendMarkup .= '}';
      $field->appendMarkup .= '});</script>';
      $field->attr('name', 'rebuild_cache');
      $field->attr('checked', '');
      $field->collapsed = Inputfield::collapsedYes;
      $fieldset->add($field);
    
      $query = wire('database')->query("SELECT COUNT(*) FROM ".self::dbTableCache);
      $rows = $query->fetchColumn();
      $query = wire('database')->query("SHOW TABLE STATUS LIKE '".self::dbTableCache."'");
      $result = $query->fetch(\PDO::FETCH_ASSOC);
      $size = $result['Data_length'];
      $field = $this->modules->get('InputfieldMarkup');
      $field->label = __('Table statistic');
      $field->value = __('Rows: ').$rows.'<br>'.__('Size: ').$size.' '.__('bytes');
      $field->collapsed = Inputfield::collapsedNever;
      $fieldset->add($field);
    }

    $fields->add($fieldset);
// Whois
    $fieldset = $this->modules->get('InputfieldFieldset');
    $fieldset->label = __('Whois');
    $fieldset->collapsed = Inputfield::collapsedNever;

    $field = $this->modules->get('InputfieldCheckbox');
    $field->name = 'whois_external';
    $field->label = __('Use external service');
    $field->label2 = __('Enable');
    $field->description = __('Uses an external service specified below to show WHOIS information about the IP address.');
    $field->attr('name', 'whois_external');
    $fieldset->add($field);

    $field = $this->modules->get('InputfieldText');
    $field->name = 'whois_service';
    $field->label = __('External WHOIS service');
    $field->description = __('Specify an external WHOIS service. Note the place holder %s for the IP address. For example: https://whatismyipaddress.com/ip/%s');
    $fieldset->add($field);

    $field = $this->modules->get('InputfieldCheckbox');
    $field->name = 'whois_dlg';
    $field->label = __('Open in dialog');
    $field->label2 = __('Enable');
    $field->description = __('Shows the WHOIS page in a dialog instead of opening a new tab.');
    $field->attr('name', 'whois_dlg');
    $fieldset->add($field);
    
    $fields->add($fieldset);
// IP2Location
    $fieldset = $this->modules->get('InputfieldFieldset');
    $fieldset->label = __('IP2Location database');
    $fieldset->collapsed = Inputfield::collapsedNever;

    $field = $this->modules->get('InputfieldCheckbox');
    $field->name = 'auto_update_ip2loc';
    $field->label = __('Automatically update IP2Location database');
    $field->label2 = __('Enable');
    $temp = __('IPv4 database file time: ');
    if (file_exists(__DIR__.'/iploc/IP2LOCATION-LITE-DB1.BIN')) {
      $temp .= date("F d Y H:i:s", filemtime(__DIR__.'/iploc/IP2LOCATION-LITE-DB1.BIN')).' (UTC)';
    } else {
      $temp .= __('File not exists');
    }
    $temp .= "\n".__('IPv6 database file time: ');
    if (file_exists(__DIR__.'/iploc/IP2LOCATION-LITE-DB1.IPV6.BIN')) {
      $temp .= date("F d Y H:i:s", filemtime(__DIR__.'/iploc/IP2LOCATION-LITE-DB1.IPV6.BIN')).' (UTC)';
    } else {
      $temp .= __('File not exists.');
    }
    $field->notes = $temp;
    $field->description = __('Automatically download the IP2Location database monthly. You do not have to update this database more often. This database is required to obtain the country from the IP address. Note, that automatically download will not work if your webspace do not allow allow_url_fopen.');
    $field->attr('name', 'auto_update_ip2loc');
    $fieldset->add($field);

    $fields->add($fieldset);
// About
    $fieldset = $this->modules->get('InputfieldFieldset');
    $fieldset->label = __('Contributors');
    $fieldset->collapsed = Inputfield::collapsedNever;

    $field = $this->modules->get('InputfieldMarkup');
    $field->value = '<p style="text-align:center">'.__('This module uses:').' <a target="_blank" href="https://www.ip2location.com/">IP2Location</a>, <a target="_blank" href="http://github.com/asvd/dragscroll">dragscroll</a> and <a target="_blank" href="https://github.com/donatj/PhpUserAgent">PhpUserAgent</a>.</p>
    <p style="text-align:center">ProcessPageViewStat @ <a href="https://modules.processwire.com/modules/process-page-view-stat/">processwire.com</a><br>
    ProcessPageViewStat @ <a href="https://github.com/techcnet/ProcessPageViewStat">github.com</a><br>
    ProcessPageViewStat @ <a href="https://tech-c.net/posts/page-view-statistic-for-processwire/">tech-c.net</a>
    </p>
    <a target="_blank" href="https://tech-c.net/donation/"><img style="margin:auto;" src="'.wire('config')->urls->siteModules.'ProcessPageViewStat'.'/images/donate.png" /></a>';
    $field->collapsed = Inputfield::collapsedNever;
    $fieldset->add($field);

    $fields->add($fieldset);
// End
    return $fields;
  }
}
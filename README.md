# ProcessPageViewStat
Logs page views of CMS ProcessWire.


PageViewStatistic for ProcessWire is a module to log page visits of the CMS. The records including some basic information like IP-address, browser, operating system, requested page and originate page. Please note that this module doesn't claim to be the best or most accurate.

## Advantages
One of the biggest advantage is that this module doesn't require any external service like Google Analytics or similar. You don't have to modify your templates either. There is also no JavaScript or image required.

## Disadvantages
There is only one disadvantage. This module doesn't record visits if the browser loads the page from its browser cache. To prevent the browser from loading the page from its cache, add the following meta tags to the header of your page:

````html
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />
````

## How to use
The records can be accessed via the Setup-menu of the CMS backend. The first dropdown control changes the view mode. There are 4 different view modes.

* View mode **Day** shows all visits of the selected day individually with IP-address, browser, operating system, requested page and originate page. Click the update button to see new added records.

!["Screenshot showing view mode Day"](https://tech-c.net/site/assets/files/1188/view-mode-day.jpg)

* View mode **Month** shows the total of all visitors per day from the first to the last day of the selected month.

!["Screenshot showing view mode Month"](https://tech-c.net/site/assets/files/1188/view-mode-month.jpg)

* View mode **Year** shows the total of all visitors per month from the first to the last month of the selected year.

!["Screenshot showing view mode Year"](https://tech-c.net/site/assets/files/1188/view-mode-year.jpg)

* View mode **Total** shows the total of all visitors per year for all recorded years.

!["Screenshot showing view mode Total"](https://tech-c.net/site/assets/files/1188/view-mode-total.jpg)

Please note that multiple visits from the same IP address within the selected period are counted as a single visitor.

## Settings
You can access the module settings by clicking the Configuration button at the bottom of the records page. The settings page is also available in the menu: Modules->Configure->ProcessPageViewStat.

## IP2Location
This module uses the IP2Location database from: http://www.ip2location.com. This database is required to obtain the country from the IP address. IP2Location updates this database at the begin of every month. The settings of ProcessPageViewStat offers the ability to automatically download the database monthly. Please note, that automatically download will not work if your webspace doesn't allow allow_url_fopen.

## Dragscroll
This module uses DragScroll a JavaScript available from: http://github.com/asvd/dragscroll. Dragscroll adds the ability in view mode "Day" to drag the records horizontally with the mouse pointer.

## parseUserAgentStringClass
This module uses the PHP class parseUserAgentStringClass available from: http://www.toms-world.org/blog/parseuseragentstring/. This class is required to filter out the browser type and operating system from the server request.

## Special Feature
PageViewStatistic for ProcessWire can record the time a visitor viewed the page. This feature is deactivated by default. To activate open the module configuration page and activate "Record view time". If activated you will find a new column **S.** in the records which means the time of view in seconds. With every page request, a Javascript code is insert directly after the <body> tag. Every time the visitor switches to another tab or closes the tab, this script reports the number of seconds the tab was visible. The initial page request is recorded only as a hyphen (-).
!["Screenshot showing time of view"](https://tech-c.net/site/assets/files/1188/time-of-view.jpg)

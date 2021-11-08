# Process page view stat for ProcessWire

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
The records can be accessed via the Setup-menu of the CMS backend. The first dropdown control changes the view mode.

!["Select a view mode"](https://tech-c.net/site/assets/files/1188/view-mode.jpg)

## Detailed records
View mode **Detailed records** shows all visits of the selected day individually with IP-address, browser, operating system, requested page and originate page. Click the update button to see new added records.

!["View mode detailed records"](https://tech-c.net/site/assets/files/1188/detailed-records.jpg)

## Cached visitor records
View modes other than **Detailed records** are cached visitor counts which will be collected on a daily basis from the detailed records. This procedure ensures a faster display even with a large number of data records. Another advantage is that the detailed records can be deleted while the cache remains. The cache can be updated manually or automatically in a specified time period. Multiple visits from the same IP address on the same day are counted as a single visitor.

!["View mode months of year"](https://tech-c.net/site/assets/files/1188/cached-visitor-records.jpg)

## Upgrade from older versions
Cached visitor counts is new in version 1.0.8. If you just upgraded from an older version you might expire a delay or even an error 500 if you display cached visitor counts. The reason for this is that the cache has to be created from the records. This can take longer if your database contains many records. Sometimes it might hit the maximally execution time. Don't be worry about that and keep reloading the page until the cache is completely created.

## Special Feature
PageViewStatistic for ProcessWire can record the time a visitor viewed the page. This feature is deactivated by default. To activate open the module configuration page and activate "Record view time". If activated you will find a new column **S.** in the records which means the time of view in seconds. With every page request, a Javascript code is insert directly after the <body> tag. Every time the visitor switches to another tab or closes the tab, this script reports the number of seconds the tab was visible. The initial page request is recorded only as a hyphen (-).

!["Time of view"](https://tech-c.net/site/assets/files/1188/time-of-view.jpg)

## New in version 1.1.0
A new feature comes with version 1.1.0 which offers to record user names of loggedin visitors. Just activate "Record user names" and "Record loggedin user" in the module settings.

## New in version 1.1.3
New in version 1.1.3 is a internal WHOIS feature (see screenshot below). The internal WHOIS feature shows IP information in a JavaScript dialog instead of a new page as like with the external WHOIS feature. The configuration offers an option to switch between internal and external WHOIS.

!["Internal WHOIS feature"](https://tech-c.net/site/assets/files/1188/whois.jpg)

## Settings
You can access the module settings by clicking the Configuration button at the bottom of the records page. The settings page is also available in the menu: Modules->Configure->ProcessPageViewStat.

## IP2Location
This module uses the IP2Location database from: http://www.ip2location.com. This database is required to obtain the country from the IP address. IP2Location updates this database at the begin of every month. The settings of ProcessPageViewStat offers the ability to automatically download the database monthly. Please note, that automatically download will not work if your webspace doesn't allow allow_url_fopen.

## Dragscroll
This module uses DragScroll a JavaScript available from: http://github.com/asvd/dragscroll. Dragscroll adds the ability in view mode "Day" to drag the records horizontally with the mouse pointer.

## User-Agent-Parser
This module uses the PHP class User-Agent-Parser available from: http://www.toms-world.org/blog/parseuseragentstring/. This class is required to filter out the browser type and operating system from the server request.

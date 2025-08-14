TMEP
====

----

EN: Hosting of the upgraded TMEP app with administration, mobile phone apps, lots of new features and extensive sensor support including many other enhancements can be found at [https://www.tmep.cz](https://www.tmep.cz). 

CZ: Hosting inovované aplikace TMEP s administrací, aplikacemi do mobilních telefonů, spoustou nových funkcí a širokou podporou čidel včetně mnoha dalších vychytávek naleznete na [https://www.tmep.cz](https://www.tmep.cz).

----

Simple application written in PHP using MySQL for visualising measured values from TME - ethernet thermometer or TH2E - Ethernet thermometer and hygrometer (from [papouch.com](http://www.papouch.com)) or basically from any thermomether/hygrometer if you can save every minute value into database from it.

Application was written very straightforwardly for our home usage, but owners of TME wanted to use this app as well. So I did released code and added more functionality later.

TMEP use Highcharts JS for graph generation ([highcharts.com](http://www.highcharts.com), Free for Non-commercial) and jQuery for AJAX, datepicker and so on. TMEP itself is [CC BY-NC-SA 4.0](http://creativecommons.org/licenses/by-nc-sa/4.0/)

App demo: [roudnice.eu](http://www.roudnice.eu)

Read tmep-info-en.html or tmep-info-cz.html for more information.

----

### License info 

![CC BY-NC-SA 4.0](https://i.creativecommons.org/l/by-nc-sa/4.0/88x31.png)

TMEP app is licensed under a [Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International License](http://creativecommons.org/licenses/by-nc-sa/4.0/):

Attribution—Noncommercial—Share Alike  
✖ | Sharing without ATTRIBUTION  
✖ | Commercial Use  
✖ | Free Cultural Works  
✖ | Meets Open Definition

----

### Version history

  * **Version 8.4.3 released at 2023-06-22** Fixed bug with $minDate initialization.
  * Version 8.4.2 released at 2023-02-20 Yet another tiny fix to be compatible with PHP 8.
  * Version 8.4.1 released at 2022-02-02 Another tiny fix to be compatible with PHP 8, tested also on PHP 8.1.1
  * Version 8.4 released at 2021-10-05 Small fix to be compatible with PHP 8 and some other code improvements along the way
  * Version 8.3 released at 2018-11-22 (Added spanish translation - thank you [Emilio Cortés Martínez](emicor@me.com), fixed measured humidity detection on Yearly statistics tab, minimum version of PHP is 5.4.0+)
  * Version 8.2.1 released at 2017-05-09 (Minor changes - custom page heading in config, humidity detected separately from temperature, proposed by [mikrom](http://www.mikrom.cz))
  * Version 8.2 released at 2017-02-23 (New Highcharts library, better graphs on Actually tab)
  * Version 8.1.3 released at 2016-12-20 (Fixed XSS vulnerability, thank you [@spazef0rze](https://www.michalspacek.cz)!)
  * Version 8.1.2 released at 2016-11-18 (Fix for MySQL 5.7)
  * Version 8.1.1 released at 2016-05-09 (Small fixes)
  * Version 8.1 released at 2015-04-21 (Portuguese translation)
  * Version 8.0 released at 2014-10-19 (redesigned)
  * Version 7.0.4 released at 2014-03-22 (Bugfixes)
  * Version 7.0 released at 2014-01-03 (Responsive and adaptive version of app! One code rule all devices. Mobile version was deleted.)
  * Version 6.5 released at 2013-12-31 (Performance tuning - tabs loaded with AJAX, CSS sprites; Hightcharts 3.0.7)
  * Version 6.4 released at 2013-12-29 (Just replaced MySQL with MySQLi extension)
  * Version 6.3 released at 2013-06-27 (Finnish, Swedish, Russian and Slovakia translations, XML export for Win 7 gadget, input script for MikroTik, typos, bugfixes)
  * Version 6.2 released at 2013-02-27 (Optimalized SQL queries and some minor changes and bugfixes)
  * Version 6.1 released at 2013-02-02 (Polish translation and some minor changes and bugfixes)
  * Version 6.0 released at 2012-12-01 (New graphs and statistics!)
  * Version 5.0 released at 2012-10-28 (New graphing engine [using Highcharts JS], lots of fixes and clean up.)
  * Version 4.2 released at 2011-08-08 (New polished mobile version by Cyrille David)
  * Version 4.1.1 released at 2011-07-01 (French translation, Dominique Stussi)
  * Version 4.1 released at 2011-03-26 (dew point, combined graphs)
  * Version 4.0 released at 2011-03-10
  * Version 4.0 rc1 added at 2011-02-12 - now for both TME and TH2E
  * Version 3.0 added at 2011-01-14

<?php

 /*************************************************************************
 ***  Systém pro TME/TH2E - TMEP, mobile version                        ***
 ***  (c) Cyrille David 2011 - cyrille@david-gooris.com                 ***
 ***  Hlavni vseobjimajici soubor, verze pro mobily a PDA               ***
 *************************************************************************/

 //////////////////////////////////////////////////////////////////////////
 //// VLOZENI SOUBORU
 //////////////////////////////////////////////////////////////////////////

  require_once "config.php";         // skript s nastavenim
  require_once "scripts/language/".$l.".php";       // skript s jazykovou mutaci
  require_once "scripts/db.php";        // skript s databazi
  require_once "scripts/fce.php";       // skript s nekolika funkcemi

 //////////////////////////////////////////////////////////////////////////
 //// STRANKA
 //////////////////////////////////////////////////////////////////////////

?>
<!DOCTYPE html> 
<html> 
  <head> 
    <META HTTP-EQUIV="content-type" CONTENT="text/html; charset=UTF-8">
    <meta name="viewport" content="user-scalable=no, width=device-width" />
    <TITLE><?php echo $umisteni." - ".$lang['titulekstranky']; ?></TITLE>
    <link rel='stylesheet' href='css/jquery-mobile.css' />
    <script src='scripts/js/jquery.tools.ui.timer.colorbox.tmep.js'></script>
    <script src='scripts/js/jquery-mobile.js'></script>
    <script src='scripts/js/highcharts.js'></script>
    <style type='text/css'>.graf{ width: 280px; height: 200px; }</style>
  </head>
<body> 
<?php
  // Posledni mereni
  $dotaz = MySQLi_query($GLOBALS["DBC"], "SELECT kdy, teplota, vlhkost FROM tme ORDER BY kdy DESC LIMIT 1");
  $posledni = MySQLi_fetch_assoc($dotaz);

  // Nejvyssi namerena teplota
  $dotaz = MySQLi_query($GLOBALS["DBC"], "SELECT kdy, teplota FROM tme ORDER BY teplota DESC LIMIT 1");
  $nejvyssi = MySQLi_fetch_assoc($dotaz);

  // Nejnizsi namerena teplota
  $dotaz = MySQLi_query($GLOBALS["DBC"], "SELECT kdy, teplota FROM tme ORDER BY teplota ASC LIMIT 1");
  $nejnizsi = MySQLi_fetch_assoc($dotaz);
?>
<div data-role='page' data-theme='a' id='home'>
  <div data-role='header'data-position='fixed' > 
    <a href='index.php?nemobile=1' data-role='button' data-icon='home' data-iconpos='notext' rel='external'><?php echo $lang['kompletnistranky']; ?></a>
    <h1><?php echo $lang['hlavninadpis']; ?></h1>

    <a href='javascript:history.go(0)' data-role='button' data-icon='refresh' data-iconpos='notext'>Refresh</a>
  </div><!-- /header -->
  
  <div data-role='content'>  
        <center>
    
    <div data-inline="true">
      <a href="" data-role="button" data-inline="true">
        <?php echo $lang['aktualniteplota']; ?><br>
        <H1>
        <?php echo jednotkaTeploty($posledni['teplota'], $u, 1);
        if($vlhkomer == 1){ echo "<br>".$posledni['vlhkost']."%"; }
        echo "<br></H1>".formatData($posledni['kdy']);
        ?>
      </a>
    </div>
        <br>
    
    <ul data-role="listview" data-inset="true" data-inline="true"> 
      <li data-icon="false" data-role="list-divider"><strong>  <?php echo $lang['umisteni']; ?></strong> <?php echo $umisteni; ?></li>
      
      <li data-icon="false">
        <p><strong><?php echo $lang['nejvyssiteplota']; ?></strong></p>
        <p> <?php echo formatData($nejvyssi['kdy']); ?> </p>
        <p class="ui-li-aside"><strong> <?php echo jednotkaTeploty($nejvyssi['teplota'], $u, 1)?></strong></p>
      </li>
      <li data-icon="false">
        <p><strong><?php echo $lang['nejnizsiteplota']; ?></strong></p>
        <p> <?php echo formatData($nejnizsi['kdy']); ?> </p>
        <p class="ui-li-aside"><strong> <?php echo jednotkaTeploty($nejnizsi['teplota'], $u, 1)?></strong></p>
      </li>
      <!-- data-divider-theme="c"-->
      <li data-icon="false" data-role="list-divider" ><?php echo $lang['drivetoutodobou']; ?></li>
      
        <?php // posledni tri dny do pole
        $dny2[0] = date("Y-m-d H:i", mktime(date("H"), date("i"), date("s"), date("m"), date("d")-1, date("Y")));
        $dny2[] = date("Y-m-d H:i", mktime(date("H"), date("i"), date("s"), date("m"), date("d")-2, date("Y")));
        $dny2[] = date("Y-m-d H:i", mktime(date("H"), date("i"), date("s"), date("m"), date("d")-3, date("Y")));

        // projdeme pole, pro kazdy den a podobnou dobu nalezneme teplotu a vypiseme  
        for($a = 0; $a < count($dny2); $a++)
        {

          $dotaz = MySQLi_query($GLOBALS["DBC"], "SELECT kdy, teplota
                                FROM tme 
                                WHERE kdy >= CAST('".substr($dny2[$a], 0, 14)."0' AS datetime) 
                                      AND kdy <= CAST('".substr($dny2[$a], 0, 14)."9' AS datetime) 
                                LIMIT 1");
          $hod = MySQLi_fetch_assoc($dotaz);
  
          echo "<li data-icon='false'>
                 <p>".formatDnu($dny2[$a])."</p>
                 <p class='ui-li-aside'><abbr title='".substr($hod['kdy'], 11, 5)."'>".jednotkaTeploty($hod['teplota'], $u, 1)."</abbr></p>
               </li>";

        }

      // MIN/AVG/MAX za dnesni den
      // Data pro mereni z dneska
      // Dnes nejnizsi namerena teplota/vlhkost
      $dotaz = MySQLi_query($GLOBALS["DBC"], "SELECT MIN(teplota) as teplota, MIN(vlhkost) as vlhkost
                            FROM tme 
                            WHERE kdy >= CAST('".date("Y-m-d")." 00:00:00' AS datetime)
                                  AND kdy <= CAST('".date("Y-m-d")." 23:59:59' AS datetime)");
      $nejnizsiDnes = MySQLi_fetch_assoc($dotaz);
      // Dnes prumerna teplota/vlhkost
      $dotaz = MySQLi_query($GLOBALS["DBC"], "SELECT AVG(teplota) as teplota, AVG(vlhkost) as vlhkost
                            FROM tme 
                            WHERE kdy >= CAST('".date("Y-m-d")." 00:00:00' AS datetime)
                                  AND kdy <= CAST('".date("Y-m-d")." 23:59:59' AS datetime)");
      $prumernaDnes = MySQLi_fetch_assoc($dotaz);
      // Dnes nejvyssi namerena teplota/vlhkost
      $dotaz = MySQLi_query($GLOBALS["DBC"], "SELECT MAX(teplota) as teplota, MAX(vlhkost) as vlhkost
                            FROM tme 
                            WHERE kdy >= CAST('".date("Y-m-d")." 00:00:00' AS datetime)
                                  AND kdy <= CAST('".date("Y-m-d")." 23:59:59' AS datetime)");
      $nejvyssiDnes = MySQLi_fetch_assoc($dotaz);

      echo "<li data-icon=\"false\" data-role=\"list-divider\">{$lang['dnes']}</li>";
  
      // Mame nuly? MIN a MAX za den? To nemuze byt pravda... :)
      if(round($nejnizsiDnes['teplota']) == 0 && round($nejvyssiDnes['teplota']) == 0)
      {
        $nejnizsiDnes['teplota'] = "-";
        $nejvyssiDnes['teplota'] = "-";
        $prumernaDnes['teplota'] = "-";
      }
      else
      {
        $nejnizsiDnes['teplota'] = jednotkaTeploty(round($nejnizsiDnes['teplota'],2), $u, 1);
        $prumernaDnes['teplota'] = jednotkaTeploty(round($prumernaDnes['teplota'],2), $u, 1);
        $nejvyssiDnes['teplota'] = jednotkaTeploty(round($nejvyssiDnes['teplota'],2), $u, 1);
      }

      echo "<li data-icon=\"false\" data-role=\"list-divider\">{$lang['teplota']}</li>
            <li data-icon='false'>
             <p>{$lang['min2']}</p>
             <p class='ui-li-aside'>{$nejnizsiDnes['teplota']}</abbr></p>
           </li>
           <li data-icon='false'>
             <p>{$lang['prumer']}</p>
             <p class='ui-li-aside'>{$prumernaDnes['teplota']}</abbr></p>
           </li>
           <li data-icon='false'>
             <p>{$lang['max2']}</p>
             <p class='ui-li-aside'>{$nejvyssiDnes['teplota']}</abbr></p>
           </li>";

      if($vlhkomer == 1)
      {
        // Mame nuly? Nulova vlhkost? To nemuze byt pravda...
        if(round($nejnizsiDnes['vlhkost']) == 0 && round($nejvyssiDnes['vlhkost']) == 0)
        {
          $nejnizsiDnes['vlhkost'] = "- ";
          $nejvyssiDnes['vlhkost'] = "- ";
          $prumernaDnes['vlhkost'] = "- ";
        }
        else
        {
          $nejnizsiDnes['vlhkost'] = round($nejnizsiDnes['vlhkost'],2);
          $prumernaDnes['vlhkost'] = round($prumernaDnes['vlhkost'],2);
          $nejvyssiDnes['vlhkost'] = round($nejvyssiDnes['vlhkost'],2);
        }

      echo "<li data-icon=\"false\" data-role=\"list-divider\">{$lang['vlhkost']}</li>
            <li data-icon='false'>
             <p>{$lang['min2']}</p>
             <p class='ui-li-aside'>{$nejnizsiDnes['vlhkost']}%</abbr></p>
           </li>
           <li data-icon='false'>
             <p>{$lang['prumer']}</p>
             <p class='ui-li-aside'>{$prumernaDnes['vlhkost']}%</abbr></p>
           </li>
           <li data-icon='false'>
             <p>{$lang['max2']}</p>
             <p class='ui-li-aside'>{$nejvyssiDnes['vlhkost']}%</abbr></p>
           </li>";

      }
     echo "</tr>
  </table>";

        ?>

    </ul>

    <br>

    </center>

  <div data-role='collapsible' data-collapsed='true'>
  <h3><?php echo $lang['teplota']; ?></h3>
    <p align='center'><div class='graf' id='graf-24-hodin-teplota-mobile'><?php require 'scripts/grafy/teplota/24-hodin-mobile.php'; ?></div><br></p>
  </div><!-- /collapse -->
  
<?php
  // mame vlhkomer?
  if($vlhkomer == 1)
  {

    echo "<div data-role='collapsible' data-collapsed='true'>
    <h3>{$lang['vlhkost']}</h3>
      <p align='center'><div class='graf' id='graf-24-hodin-vlhkost-mobile'>"; require 'scripts/grafy/vlhkost/24-hodin-mobile.php'; echo "</div><br></p>
    </div><!-- /collapse -->";

  }
?>

  </div><!-- /content -->

</div><!-- /page -->

</body>
</html>
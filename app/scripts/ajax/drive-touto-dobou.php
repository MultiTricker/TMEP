<?php

 /*************************************************************************
 ***  Systém pro TME/TH2E - TMEP                                        ***
 ***  (c) Michal Ševčík 2007-2013 - multi@tricker.cz                    ***
 *************************************************************************/

 //////////////////////////////////////////////////////////////////////////
 //// VLOZENI SOUBORU
 //////////////////////////////////////////////////////////////////////////

  require "../../config.php"; // skript s nastavenim
  require "../db.php";        // skript s databazi
  require "../fce.php";       // skript s nekolika funkcemi

 //////////////////////////////////////////////////////////////////////////
 //// STYL GRAFU, JAZYK A JEDNOTKA
 //////////////////////////////////////////////////////////////////////////

  // pokud je povolene vlastni nastaveni...
  if($zobrazitNastaveni == 1)
  {

    // jazyk
    if(isset($_GET['ja']) AND ($_GET['ja'] == "cz" OR $_GET['ja'] == "en" OR 
       $_GET['ja'] == "de"))
    {
      $l = $_GET['ja'];
    }

    require_once "../language/".$l.".php";       // skript s jazykovou mutaci    

    // jednotka
    if(isset($_GET['je']) AND ($_GET['je'] == 'C' OR $_GET['je'] == 'F' OR
     $_GET['je'] == 'K' OR $_GET['je'] == 'R' OR $_GET['je'] == 'D' OR 
     $_GET['je'] == 'N' OR $_GET['je'] == 'Ro' OR $_GET['je'] == 'Re'))
    {
      $u = $_GET['je'];
    }


  }
  else
  {

    require_once "../language/".$l.".php";       // skript s jazykovou mutaci

  }

  header('Content-type: text/html; charset=UTF-8');

  echo "<table width='250' class='tabulkaVHlavicce'>
    <tr class='radek'>
      <td colspan='3' align='center'><a href='./scripts/modals/driveToutoDobou.php?je=".$_GET['je']."&amp;ja=".$_GET['ja']."' class='modal'><b>{$lang['drivetoutodobou']}</b> <img src='./images/nw.png' title='{$lang['historie']}'></a></td>
    </tr>";

    // posledni dny do pole
    $dny2 = Array();
    for($a = 1; $a < 6; $a++)
    {
      $dny2[] = date("Y-m-d H:i", mktime(date("H"), date("i"), date("s"), date("m"), date("d")-$a, date("Y")));
    }

    // projdeme pole, pro kazdy den a podobnou dobu nalezneme teplotu a vypiseme        
    for($a = 0; $a < count($dny2); $a++)
    {

      $dotaz = MySQLi_query($GLOBALS["DBC"], "SELECT kdy, teplota, vlhkost
                            FROM tme 
                            WHERE kdy >= CAST('".substr($dny2[$a], 0, 14)."0' AS datetime)
                                  AND kdy <= CAST('".substr($dny2[$a], 0, 14)."9' AS datetime)
                            LIMIT 1");
      $hod = MySQLi_fetch_assoc($dotaz);

      echo "<tr>
              <td align='center'>".formatDnu($dny2[$a])."</td>
              <td align='center'><abbr title='".substr($hod['kdy'], 11, 5)."'>".jednotkaTeploty($hod['teplota'], $u, 1)."</abbr></td>";
              if($vlhkomer == 1){ echo "<td align='center'>".($hod['vlhkost'] != 0 ? "{$hod['vlhkost']}%" : "")."</td>"; }
            echo "</tr>";

    }

 echo "</table>";

?>
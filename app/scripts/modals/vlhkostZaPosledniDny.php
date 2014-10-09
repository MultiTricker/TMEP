<?php

  // Hlavicka
  require "head.php";
  // Osetreni vstupu
  if(!isset($_GET['hodina']) OR !is_numeric($_GET['hodina']) OR $_GET['hodina'] < 0 OR $_GET['hodina'] > 23)
  { $_GET['hodina'] = date("H");}
  if(!isset($_GET['minuta']) OR !is_numeric($_GET['minuta']) OR $_GET['minuta'] < 0 OR $_GET['minuta'] > 59)
  { $_GET['minuta'] = date("i");}
    
  // kvuli grafu
  $dny = Array();
  $minmax = Array();
  $kolik = 0;

  echo "<h3>{$lang['vlhkostzaposlednidny']} (%)</h3>";

  // nacteme teploty do tabulky pro poslednich dny
  $qStat = MySQLi_query($GLOBALS["DBC"], "SELECT den, mereni, nejnizsi_vlhkost, nejvyssi_vlhkost, prumer_vlhkost
                    FROM tme_denni 
                    WHERE nejnizsi_vlhkost > 0
                    ORDER BY den DESC 
                    LIMIT 250");

  ///////////////////////////
  // teploty za posledni dny
  $tabulka = "<table class='tabulkaVHlavicceModal' width='340'>
      <tr class='radek zelenyRadek'>
        <td><b>{$lang['den']}</b></td>
        <td><b>{$lang['min2']}</b></td>
        <td><b>{$lang['prumer']}</b></td>
        <td><b>{$lang['max2']}</b></td>
        <td><b>{$lang['mereni']}</b></td>
      </tr>";

      while($r = MySQLi_fetch_assoc($qStat))
      {

        $vikend = jeVikend($r['den']);

        $tabulka .= "<tr class='radekStat'>
           <td>".($vikend == 1 ? "<font style='color: #009000;'>" : "").formatDnu($r['den']).($vikend == 1 ? "</font>" : "")."</td>
           <td>".jednotkaTeploty($r['nejnizsi_vlhkost'], $u, 0)."</td>
           <td>".jednotkaTeploty(round($r['prumer_vlhkost'], 2), $u, 0)."</td>
           <td>".jednotkaTeploty($r['nejvyssi_vlhkost'], $u, 0)."</td>
           <td>".number_format($r['mereni'], 0, "", " ")."</td>
        </tr>";

        if($kolik < 130)
        {
          // kvuli grafu
          $dny[] = formatDnu($r['den']);
          $minmax[] = $r['nejnizsi_vlhkost'].", ".$r['nejvyssi_vlhkost'];
          $kolik++;
        }

      }

      $tabulka .= "</table>";

  // Vlozeni grafu
  echo "<div id='vlhkostZaPosledniDny' class='grafModal'></div>";
  require "../grafy/vlhkost/zaPosledniDny.php";

  // Tabulka s hodnotami
  echo $tabulka;

  // Paticka
  require "foot.php";
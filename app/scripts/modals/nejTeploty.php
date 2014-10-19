<?php

  // Hlavicka
  require "head.php";
    
  echo "<h3>{$lang['historie']}: {$lang['nejnizsiteplota']}/{$lang['nejvyssiteplota']}</h3>";

  ////////////////////////////////////////////
  // NEJNIZSI
  // Tabulka s hodnotami + krmeni dat pro graf
  $tabulka = "<center>
              <table width='600'><tr><td width='300' class='padding5'>
              <table width='260' class='tabulkaVHlavicce'>
              <tr class='radek zelenyRadek'><td colspan='2'>&nbsp;<b>{$lang['nejnizsiteplota']}</b></td></tr>
              <tr class='radek modryRadek'>
                <td>&nbsp;<b>{$lang['den']}</b></td>
                <td>&nbsp;<b>{$lang['teplota']} &nbsp;(&deg;{$u})</b></td>";
    $tabulka .= "</tr>";

    // Nacteme dny a teploty
    $q = MySQLi_query($GLOBALS["DBC"], "SELECT den, nejnizsi as teplota
                      FROM tme_denni 
                      WHERE nejnizsi IS NOT null
                      ORDER BY nejnizsi ASC 
                      LIMIT 15");

    while($r = MySQLi_fetch_assoc($q))
    {

      // Zjistime presny cas
      $dotaz = MySQLi_query($GLOBALS["DBC"], "SELECT kdy
                            FROM tme 
                            WHERE (kdy >= CAST('{$r['den']} 00:00:00' AS datetime) AND kdy <= CAST('{$r['den']} 23:59:59' AS datetime)) AND 
                                  teplota LIKE {$r['teplota']} LIMIT 1");

      // Nacteme do promenne
      $hod = MySQLi_fetch_assoc($dotaz);
      // zelene = vikend
      $vikend = jeVikend($r['den']);

      // Radek tabulky
      $tabulka .= "<tr class='radekStatModal'>
              <td><b>".($vikend == 1 ? "<font style='color: #009000;'>" : "").formatData($hod['kdy']).($vikend == 1 ? "</font>" : "")."</b></td>
              <td>".jednotkaTeploty($r['teplota'], $u, 0)."</td>";
            $tabulka .=  "</tr>";

    }

    $tabulka .=  "</table>";
    
    //////////////////
    // PRUMER
    $tabulka .= "<br><table width='260' class='tabulkaVHlavicce'>
              <tr class='radek zelenyRadek'><td colspan='2'>&nbsp;<b>{$lang['nejnizsiteplota']} - {$lang['prumer']}</b></td></tr>
              <tr class='radek modryRadek'>
                <td>&nbsp;<b>{$lang['den']}</b></td>
                <td>&nbsp;<b>{$lang['teplota']} &nbsp;(&deg;{$u})</b></td>";
    $tabulka .= "</tr>";

    // Nacteme dny a teploty
    $q = MySQLi_query($GLOBALS["DBC"], "SELECT den, prumer as teplota
                      FROM tme_denni 
                      WHERE prumer IS NOT null
                      ORDER BY prumer ASC 
                      LIMIT 15");

    while($r = MySQLi_fetch_assoc($q))
    {

      // zelene = vikend
      $vikend = jeVikend($r['den']);

      // Radek tabulky
      $tabulka .= "<tr class='radekStatModal'>
              <td><b>".($vikend == 1 ? "<font style='color: #009000;'>" : "").formatDnu($r['den']).($vikend == 1 ? "</font>" : "")."</b></td>
              <td>".jednotkaTeploty($r['teplota'], $u, 0)."</td>";
            $tabulka .=  "</tr>";

    }

  $tabulka .=  "</table>";

  ////////////////////////////////////////////
  // Nejvyssi
  // Tabulka s hodnotami + krmeni dat pro graf
  $tabulka .= "</td><td width='300' class='padding5'>
              <table width='260' class='tabulkaVHlavicce'>
              <tr class='radek zelenyRadek'><td colspan='2'>&nbsp;<b>{$lang['nejvyssiteplota']}</b></td></tr>
              <tr class='radek modryRadek'>
                <td>&nbsp;<b>{$lang['den']}</b></td>
                <td>&nbsp;<b>{$lang['teplota']} &nbsp;(&deg;{$u})</b></td>";
    $tabulka .= "</tr>";

    // Nacteme dny a teploty
    $q = MySQLi_query($GLOBALS["DBC"], "SELECT den, nejvyssi as teplota
                      FROM tme_denni 
                      WHERE nejvyssi IS NOT null 
                      ORDER BY nejvyssi DESC 
                      LIMIT 15");
    while($r = MySQLi_fetch_assoc($q))
    {

      // Zjistime presny cas
      $dotaz = MySQLi_query($GLOBALS["DBC"], "SELECT kdy
                            FROM tme 
                            WHERE (kdy >= CAST('{$r['den']} 00:00:00' AS datetime) AND kdy <= CAST('{$r['den']} 23:59:59' AS datetime)) AND 
                                  teplota LIKE {$r['teplota']} LIMIT 1");
      // Nacteme do promenne
      $hod = MySQLi_fetch_assoc($dotaz);
      // zelene = vikend
      $vikend = jeVikend($r['den']);

      // Radek tabulky
      $tabulka .= "<tr class='radekStatModal'>
              <td><b>".($vikend == 1 ? "<font style='color: #009000;'>" : "").formatData($hod['kdy']).($vikend == 1 ? "</font>" : "")."</b></td>
              <td>".jednotkaTeploty($r['teplota'], $u, 0)."</td>";
            $tabulka .=  "</tr>";

    }

  $tabulka .=  "</table>";
    //////////////////
    // PRUMER
    $tabulka .= "<br><table width='260' class='tabulkaVHlavicce'>
              <tr class='radek zelenyRadek'><td colspan='2'>&nbsp;<b>{$lang['nejvyssiteplota']} - {$lang['prumer']}</b></td></tr>
              <tr class='radek modryRadek'>
                <td>&nbsp;<b>{$lang['den']}</b></td>
                <td>&nbsp;<b>{$lang['teplota']} &nbsp;(&deg;{$u})</b></td>";
    $tabulka .= "</tr>";

    // Nacteme dny a teploty
    $q = MySQLi_query($GLOBALS["DBC"], "SELECT den, prumer as teplota
                      FROM tme_denni 
                      WHERE prumer IS NOT null
                      ORDER BY prumer DESC 
                      LIMIT 15");

    while($r = MySQLi_fetch_assoc($q))
    {

      // zelene = vikend
      $vikend = jeVikend($r['den']);

      // Radek tabulky
      $tabulka .= "<tr class='radekStatModal'>
              <td><b>".($vikend == 1 ? "<font style='color: #009000;'>" : "").formatDnu($r['den']).($vikend == 1 ? "</font>" : "")."</b></td>
              <td>".jednotkaTeploty($r['teplota'], $u, 0)."</td>";
            $tabulka .=  "</tr>";

    }

  $tabulka .=  "</table>";
   
  $tabulka .= "</td></tr></table></center>";

  // Tabulka s hodnotami
  echo $tabulka;

  // Paticka
  require "foot.php";
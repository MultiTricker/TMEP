<?php

  // Hlavicka
  require "head.php";
  // Osetreni vstupu
  if(!isset($_GET['hodina']) OR !is_numeric($_GET['hodina']) OR $_GET['hodina'] < 0 OR $_GET['hodina'] > 23)
  { $_GET['hodina'] = date("H");}
  if(!isset($_GET['minuta']) OR !is_numeric($_GET['minuta']) OR $_GET['minuta'] < 0 OR $_GET['minuta'] > 59)
  { $_GET['minuta'] = date("i");}
    
  echo "<h3>{$lang['drivetoutodobou']} ({$_GET['hodina']}:{$_GET['minuta']})</h3>";

  // formular pro cas
  echo "<form method='GET' action='{$_SERVER['PHP_SELF']}'>
          <fieldset>
          <legend>{$lang['cas']}</legend>
          <input type='hidden' name='ja' value='{$_GET['ja']}'>
          <input type='hidden' name='je' value='{$_GET['je']}'>
          <input type='hidden' name='typ' value='0'>
          <p><input type='text' name='hodina' id='hodina' value='{$_GET['hodina']}' style='width: 22px;'> :
             <input type='text' name='minuta' id='minuta' value='{$_GET['minuta']}' style='width: 22px;'>
             <input type='submit' class='submit' name='odeslani' value='{$lang['zobrazit']}'></p>
          </fieldset>  
        </form>";

  // Tabulka s hodnotami + krmeni dat pro graf
  $tabulka = "<table width='".($vlhkomer == 1 ? "400" : "230")."' class='tabulkaVHlavicceModal'>
              <tr class='radek'>
                <td>&nbsp;<b>{$lang['den']}</b></td>
                <td>&nbsp;<b>{$lang['teplota']}<br />&nbsp;(&deg;{$u})</b></td>";
                if($vlhkomer == 1)
                {
                  $tabulka .= "<td>&nbsp;<b>{$lang['vlhkost']}<br />&nbsp;(%)</b></td>
                  <td>&nbsp;<b>{$lang['rosnybod']}<br />&nbsp;(&deg;{$u})</b></td>";
                }
    $tabulka .= "</tr>";

    // dny do pole
    $dny2 = Array();
    for($a = 1; $a < 31; $a++)
    {
      $dny2[] = date("Y-m-d H:i", mktime($_GET['hodina'], $_GET['minuta'], date("s"), date("m"), date("d")-$a, date("Y")));
    }

    // kvuli grafu
    $dny = Array();
    $teplotaGraf = Array();
    $vlhkostGraf = Array();
    $rosnyBodGraf = Array();

    // projdeme pole, pro kazdy den a podobnou dobu nalezneme teplotu a vypiseme        
    for($a = 0; $a < count($dny2); $a++)
    {

      // Pridame do pole pro graf
      $dnyGraf[] = formatDnu($dny2[$a]);
      // Zjistime hodnoty pro dane desetiminuti
      $dotaz = MySQLi_query($GLOBALS["DBC"], "SELECT kdy, teplota, vlhkost
                            FROM tme 
                            WHERE kdy >= CAST('".substr($dny2[$a], 0, 15)."0' AS datetime)
                                  AND kdy <= CAST('".substr($dny2[$a], 0, 15)."9' AS datetime)
                            LIMIT 1");
      // Nacteme do promenne
      $hod = MySQLi_fetch_assoc($dotaz);
      // Teplota neprazdna
      if($hod['teplota'] == "" OR $hod['teplota'] == null)
      { 
        $hod['teplota'] = "-";
        $teplotaGraf[] = "null";
      }
      else
      {
        $teplotaGraf[] = jednotkaTeploty($hod['teplota'], $u, 0);
      }
      // Vlhkost neni prazdna nebo nula
      if($hod['vlhkost'] == "" OR $hod['vlhkost'] == 0 OR $hod['vlhkost'] == null)
      { 
        $hod['vlhkost'] = "-";
        $vlhkostGraf[] = "null";
        $rosnyBodGraf[] = "null";
        $rosnyBod = "-";
      }
      else
      {
        $vlhkostGraf[] = $hod['vlhkost'];
        $rosnyBodGraf[] = rosnybod($hod['teplota'], $hod['vlhkost']);
        $rosnyBod = jednotkaTeploty(rosnybod(jednotkaTeploty($hod['teplota'], $u, 0), $hod['vlhkost']), $u, 0);
      }
      // zelene = vikend
      $vikend = jeVikend($dny2[$a]);

      // Radek tabulky
      $tabulka .= "<tr class='radekStatModal'>
              <td><b>".($vikend == 1 ? "<font style='color: #009000;'>" : "").formatDnu($dny2[$a]).($vikend == 1 ? "</font>" : "")."</b></td>
              <td>".jednotkaTeploty($hod['teplota'], $u, 0)."</td>";
              if($vlhkomer == 1)
              {
                $tabulka .= "<td>".($hod['vlhkost'] != 0 ? "{$hod['vlhkost']}" : "-")."</td>";
                $tabulka .= "<td>{$rosnyBod}</td>";
              }
            $tabulka .=  "</tr>";

    }

  $tabulka .=  "</table>";

  // Vlozeni grafu
  echo "<div id='driveToutoDobou' class='grafModal'></div>";
  if($vlhkomer == 1)
  { require "../grafy/kombinovane/driveToutoDobou.php"; }
  else
  { require "../grafy/teplota/driveToutoDobou.php"; }

  // Tabulka s hodnotami
  echo $tabulka;

  // Paticka
  require "foot.php";
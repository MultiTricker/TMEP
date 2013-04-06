<?php

  // Hlavicka
  require "head.php";
  // Osetreni vstupu
  if(!isset($_GET['hodina']) OR !is_numeric($_GET['hodina']) OR $_GET['hodina'] < 0 OR $_GET['hodina'] > 23)
  { $_GET['hodina'] = date("H");}
  if(!isset($_GET['minuta']) OR !is_numeric($_GET['minuta']) OR $_GET['minuta'] < 0 OR $_GET['minuta'] > 59)
  { $_GET['minuta'] = date("i");}
    
  $jednotkap = explode(" ", jednotkaTeploty(1, $u, 1));
  $jednotka = str_replace("&deg;", "°", $jednotkap[1]);

  // kvuli grafu
  $dny = Array();
  $minmax = Array();
  $kolik = 0;

  echo "<h3>{$lang['teplotyzaposlednidny']} ({$jednotka})</h3>";

  // nacteme teploty do tabulky pro poslednich dny
  $qStat = MySQL_query("SELECT den, mereni, nejnizsi, nejvyssi, prumer 
                    FROM tme_denni 
                    ORDER BY den DESC 
                    LIMIT 250");

  ///////////////////////////
  // teploty za posledni dny
  $tabulka = "<table class='tabulkaVHlavicce' width='340'>
      <tr class='radek'>
        <td align='center'><b>{$lang['den']}</b></td>
        <td align='center'><b>{$lang['min2']}</b></td>
        <td align='center'><b>{$lang['prumer']}</b></td>
        <td align='center'><b>{$lang['max2']}</b></td>
        <td align='center'><b>{$lang['mereni']}</b></td>
      </tr>";

      while($r = MySQL_fetch_assoc($qStat))
      {

        $vikend = jeVikend($r['den']);

        $tabulka .= "<tr class='radekStat'>
           <td align='center'>".($vikend == 1 ? "<font style='color: #009000;'>" : "").formatDnu($r['den']).($vikend == 1 ? "</font>" : "")."</td>
           <td align='center'>".jednotkaTeploty($r['nejnizsi'], $u, 0)."</td>
           <td align='center'>".jednotkaTeploty(round($r['prumer'], 2), $u, 0)."</td>
           <td align='center'>".jednotkaTeploty($r['nejvyssi'], $u, 0)."</td>
           <td align='center'>".number_format($r['mereni'], 0, "", " ")."</td>
        </tr>";

        if($kolik < 130)
        {
          // kvuli grafu
          $dny[] = formatDnu($r['den']);
          $minmax[] = jednotkaTeploty($r['nejnizsi'], $u, 0).", ".jednotkaTeploty($r['nejvyssi'], $u, 0);
          $kolik++;
        }

      }

      $tabulka .= "</table>";

  // Vlozeni grafu
  echo "<div id='teplotyZaPosledniDny' class='grafModal'></div>";
  require "../grafy/teplota/zaPosledniDny.php";

  // Tabulka s hodnotami
  echo $tabulka;

  // Paticka
  require "foot.php";

?>
<?php

 /*************************************************************************
 ***  Systém pro TME/TH2E - TMEP                                        ***
 ***  (c) Michal Ševčík 2007-2013 - multi@tricker.cz                    ***
 ***  Hlavni vseobjimajici soubor / main file                           ***
 *************************************************************************/

 //////////////////////////////////////////////////////////////////////////
 //// VLOZENI SOUBORU
 //////////////////////////////////////////////////////////////////////////

  require "./config.php";         // skript s nastavenim
  require "./scripts/db.php";        // skript s databazi
  require "./scripts/fce.php";       // skript s nekolika funkcemi

 //////////////////////////////////////////////////////////////////////////
 //// PRESMEROVANI NA MOBILNI VERZI, zaslal Cyrille David
 //////////////////////////////////////////////////////////////////////////

 // Prichazime z mobilni stranky a nechceme presmerovat?
 if($_GET['nemobile'] != 1){ $_GET['nemobile'] == 0; }

 // Vylepsena detekce mobilu (tablety nepresmerovavame)
 if($presmerovavatMobily == 1)
 { 
   require "./scripts/mobileDetect.php";  // skript na detekci mobilnich zarizeni
   $detect = new Mobile_Detect();
   if ($detect->isMobile() AND !$detect->isTablet() AND $_GET['nemobile'] == 0)
   { header('Location: mobile.php') ; exit(); }
 }

 //////////////////////////////////////////////////////////////////////////
 //// ZAPIS DO DATABAZE ANEB VLOZENI HODNOTY Z TME
 //////////////////////////////////////////////////////////////////////////

  // pokud stranku vola teplomer, ulozime hodnotu
  if(isset($_GET['temp']) OR isset($_GET[$GUID]) OR isset($_GET['tempV']))
  {

    // novejsi TME
    if(isset($_GET['temp']) && $_GET['temp'] != ""){ $teplota = $_GET['temp']; }

    // stary TME
    if(isset($_GET[$GUID]) && $_GET[$GUID] != ""){ $teplota = $_GET[$GUID]; }

    // TH2E
    if(isset($_GET['tempV']) AND $_GET['tempV'] != "")
    { $teplota = $_GET['tempV']; if(strlen($_GET['humV']) < 7){ $vlhkost = $_GET['humV']; } }

    // nahrazeni carky teckou
    $teplota = str_replace(",", ".", $teplota);
    $vlhkost = str_replace(",", ".", $vlhkost);

    if(is_numeric($teplota))
    {

      // vlhkost je null?
      if(!is_numeric($vlhkost)){ $vlhkost = "null"; }


      // kontrolujeme IP a sedi
      if(isset($ip) AND $ip != "" AND $ip == $_SERVER['REMOTE_ADDR'])
      {
        MySQL_query("INSERT INTO tme(kdy, teplota, vlhkost) VALUES(now(), '{$teplota}', {$vlhkost})");
      }
      // nekontrolujeme IP
      elseif($ip == "")
      {
        MySQL_query("INSERT INTO tme(kdy, teplota, vlhkost) VALUES(now(), '{$teplota}', {$vlhkost})");
        print mysql_error();
      }
      // problem? zrejme pozadavek z jine nez z povolene IP
      else
      {
        echo "Chyba! Error! Fehler!";
      }

    }
    else
    {
      echo "Teplota musí být číslo...";
    }

  }
  // nezapisujeme, tak zobrazime stranku
  else
  {

 //////////////////////////////////////////////////////////////////////////
 //// DOPOCITANI HODNOT PRO MINULE DNY
 //////////////////////////////////////////////////////////////////////////

  // inicializace promenne, abych vedel jestli zobrazovat info
  // o dopocitanych dnech pri primem zavolani skriptu
  $dopocitat = 1;
  include_once "./scripts/dopocitat.php";

 //////////////////////////////////////////////////////////////////////////
 //// JAZYK A JEDNOTKA
 //////////////////////////////////////////////////////////////////////////

  // pokud je povolene vlastni nastaveni...
  if($zobrazitNastaveni == 1)
  {

    // jazyk
    if(isset($_GET['ja']) AND ($_GET['ja'] == "cz" OR $_GET['ja'] == "en" OR 
       $_GET['ja'] == "de" OR $_GET['ja'] == 'fr' OR $_GET['ja'] == 'pl') OR
      $_GET['ja'] == 'fi' OR $_GET['ja'] == 'sv')
    {
      $l = $_GET['ja'];
    }

    require_once "./scripts/language/".$l.".php";       // skript s jazykovou mutaci    

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
    require_once "./scripts/language/".$l.".php";       // skript s jazykovou mutaci    
  }

 //////////////////////////////////////////////////////////////////////////
 //// NACTENI ZAKLADNICH HODNOT NEJEN PRO HLAVICKU
 //////////////////////////////////////////////////////////////////////////

  include_once "./scripts/initIndex.php";

 //////////////////////////////////////////////////////////////////////////
 //// STRANKA
 //////////////////////////////////////////////////////////////////////////

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>

  <head>
    <title><?php echo $lang['titulekstranky']; ?></title>
    <meta HTTP-EQUIV="content-type" CONTENT="text/html; charset=UTF-8">
    <link rel="stylesheet" href="css/css.css" type="text/css">
    <link rel="stylesheet" href="css/jquery-ui.css" type="text/css">
    <meta NAME="description" CONTENT="<?php echo $lang['popisstranky']; ?>">
<?php if($obnoveniStranky != 0 and  is_numeric($obnoveniStranky)){ echo '    <meta http-equiv="refresh" content="'.$obnoveniStranky.'">'; } ?>
    <meta NAME="author" CONTENT="Michal Ševčík (http://multi.tricker.cz), František Ševčík (f.sevcik@seznam.cz)">
    <script src="scripts/js/jquery.tools.ui.timer.colorbox.tmep.js" type="text/javascript"></script>
    <script src="scripts/js/highcharts.js" type="text/javascript"></script>
    <script type="text/javascript">
    $(document).ready(function(){
     // po urcitem case AJAXove nacteni hodnot
     $.timer(60000, function (timer) {
       $.get('scripts/ajax/teplota.php<?php echo "?ja={$l}&je={$u}"; ?>', function(data) { $('.ajaxrefresh').html(data); });
       $.get('scripts/ajax/pocet-mereni.php', function(data) { $('.pocetmereni').html(data); });
      });
     $.timer(120000, function (timer) {
       $.get('scripts/ajax/drive-touto-dobou.php<?php echo "?ja={$l}&je={$u}"; ?>', function(data) { $('.drivetoutodobouted').html(data); $('a.modal').colorbox({iframe:true, width: "890px", height: "80%"}); });
      });
     // jQuery UI - datepicker
     $("#jenden").datepicker($.datepicker.regional[ "<?php echo $l;  ?>" ]);
     $.datepicker.setDefaults({dateFormat: "yy-mm-dd", maxDate: -1, minDate: new Date(<?php echo substr($pocetMereni['kdy'], 0, 4).", ".(substr($pocetMereni['kdy'], 5, 2)-1).", ".substr($pocetMereni['kdy'], 8, 2); ?>), changeMonth: true, changeYear: true});
    });
    </script>
    <link rel="shortcut icon" href="images/favicon.ico">
  </head>

<body>

<center>

  <div id='hlavni'>

    <?php
    
    // Hlavička
    require_once "./scripts/head.php";
    
    // Záložky
    echo "<p></p>
    <center>
    <div id=\"oblastzalozek\">
    <ul class=\"tabs\">
      <li><a href=\"#aktualne\">{$lang['aktualne']}</a></li>
      <li><a href=\"#denni\">{$lang['dennistatistiky']}</a></li>
      <li><a href=\"#mesicni\">{$lang['mesicnistatistiky']}</a></li>
      <li><a href=\"#rocni\">{$lang['rocnistatistiky']}</a></li>
      <li><a href=\"#historie\">{$lang['historie']}</a></li>
    </ul>

    <div class=\"panely\">";
      echo "<div>"; require "scripts/tabs/aktualne.php"; echo "</div>";
      echo "<div>"; require "scripts/tabs/denni-statistiky.php"; echo "</div>";
      echo "<div>"; require "scripts/tabs/mesicni-statistiky.php"; echo "</div>";
      echo "<div>"; require "scripts/tabs/rocni-statistiky.php"; echo "</div>";
      echo "<div>"; require "scripts/tabs/historie.php"; echo "</div>";
      echo "</div>
    </div>
    </center>";

    // Patička
    echo "<h2>{$lang['paticka']}</h2>";

?>

  </div> <!-- konec hlavni -->

</center>

</body>
</html>
<?php
  } // konec pokud si stranku prohlizi uzivatel
    // a nevola ji teplomer
?>
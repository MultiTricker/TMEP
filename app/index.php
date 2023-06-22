<?php

/*************************************************************************
 ***  Systém pro TME/TH2E - TMEP                                        ***
 ***  (c) Michal Ševčík 2007-2017 - multi@tricker.cz                    ***
 *************************************************************************/

/*
 * VLOZENI SOUBORU
 */

require "./config.php";         // skript s nastavenim
require "./scripts/db.php";        // skript s databazi
require "./scripts/fce.php";       // skript s nekolika funkcemi

/*
 * ZAPIS DO DATABAZE ANEB VLOZENI HODNOTY Z TME
 */

// pokud stranku vola teplomer, ulozime hodnotu
if(isset($_GET['temp']) OR isset($_GET[$GUID]) OR isset($_GET['tempV']))
{
    //vychozi hodnoty
    $teplota = "";
    $vlhkost = "";
    
    // novejsi TME
    if(isset($_GET['temp']) && $_GET['temp'] != "")
    {
        $teplota = $_GET['temp'];
    }

    // stary TME
    if(isset($_GET[$GUID]) && $_GET[$GUID] != "")
    {
        $teplota = $_GET[$GUID];
    }

    // TH2E
    if(isset($_GET['tempV']) AND $_GET['tempV'] != "")
    {
        $teplota = $_GET['tempV'];
    }

    // Vlhkost
    if(isset($_GET['humV']) AND strlen($_GET['humV']) < 7)
    {
        $vlhkost = $_GET['humV'];
    }

    // nahrazeni carky teckou
    $teplota = str_replace(",", ".", $teplota);
    $vlhkost = str_replace(",", ".", $vlhkost);

    if(is_numeric($teplota))
    {
        // Opravdu se muze stat, ze zarizeni posle teplotu -0, ostreni
        if($teplota == -0)
        {
            $teplota = 0;
        }

        // vlhkost je null?
        if(!is_numeric($vlhkost))
        {
            $vlhkost = "null";
        }

        // kontrolujeme IP a sedi
        if(isset($ip) AND $ip != "" AND $ip == $_SERVER['REMOTE_ADDR'])
        {
            MySQLi_query($GLOBALS["DBC"], "INSERT INTO tme(kdy, teplota, vlhkost) VALUES(now(), '{$teplota}', {$vlhkost})");
        }
        // nekontrolujeme IP
        elseif($ip == "")
        {
            MySQLi_query($GLOBALS["DBC"], "INSERT INTO tme(kdy, teplota, vlhkost) VALUES(now(), '{$teplota}', {$vlhkost})");
            print mysqli_error($GLOBALS["DBC"]);
        }
        // problem? zrejme pozadavek z jine nez z povolene IP
        else
        {
            echo "Chyba! Error! Fehler! IP address.";
        }
    }
    else
    {
        echo "Teplota musí být číslo. Temperature must be a number.";
    }
}
// nezapisujeme, tak zobrazime stranku
else
{
    /*
     * DOPOCITANI HODNOT PRO MINULE DNY
     */

    // inicializace promenne, abych vedel jestli zobrazovat info
    // o dopocitanych dnech pri primem zavolani skriptu
    $dopocitat = 1;
    include_once "./scripts/dopocitat.php";

    /*
     * JAZYK A JEDNOTKA
     */

    require_once "scripts/variableCheck.php";

    /*
     * NACTENI ZAKLADNICH HODNOT NEJEN PRO HLAVICKU
     */

    include_once "./scripts/initIndex.php";

    /*
     * STRANKA
     */

    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <title><?php if($vlastniTitulekStranky == "") {
                echo $lang['titulekstranky'];
            } else {
                echo $vlastniTitulekStranky;
            }; ?></title>
        <meta HTTP-EQUIV="content-type" CONTENT="text/html; charset=UTF-8">
        <link rel="stylesheet" href="css/css.css" type="text/css">
        <meta NAME="description" CONTENT="<?php echo $lang['popisstranky']; ?>">
        <?php if($obnoveniStranky != 0 and is_numeric($obnoveniStranky)) {
            echo '    <meta http-equiv="refresh" content="' . $obnoveniStranky . '">';
        } ?>
        <meta NAME="author" CONTENT="Michal Ševčík (http://multi.tricker.cz), František Ševčík (f.sevcik@seznam.cz)">
        <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0">
        <script src="scripts/js/jquery.tools.ui.timer.colorbox.tmep.highcharts.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                // po urcitem case AJAXove nacteni hodnot
                $.timer(60000, function () {
                    $.get('scripts/ajax/aktualne.php<?php echo "?ja={$l}&je={$u}"; ?>', function (data) {
                        $('.ajaxrefresh').html(data);
                    });
                    $.get('scripts/ajax/pocet-mereni.php', function (data) {
                        $('.pocetmereni').html(data);
                    });
                });
                $.timer(120000, function () {
                    $.get('scripts/ajax/drive-touto-dobou.php<?php echo "?ja={$l}&je={$u}"; ?>', function (data) {
                        $('.drivetoutodobouted').html(data);
                        $('a.modal').colorbox({iframe: true, width: "890px", height: "80%"});
                    });
                });
                // jQuery UI - datepicker
                $("#jenden").datepicker($.datepicker.regional["<?php echo $l;  ?>"]);
                <?php
                if(!is_null($pocetMereni['kdy']) AND is_numeric(substr($pocetMereni['kdy'], 5, 2)))
                {
                    $minDate = "minDate: new Date(" . substr($pocetMereni['kdy'], 0, 4) . ", " . (substr($pocetMereni['kdy'], 5, 2) - 1) . ", " . substr($pocetMereni['kdy'], 8, 2) . "), ";
                }
                else
                {
                    $minDate = "";
                }
                ?>
                $.datepicker.setDefaults({dateFormat: "yy-mm-dd", maxDate: -1, <?php echo $minDate; ?>changeMonth: true, changeYear: true});
            });
            var loadingImage = '<p><img src="./images/loading.gif"></p>';

            function loadTab(tab) {
                if ($("#" + tab).html() == "") {
                    $("#" + tab).html(loadingImage);
                    $.get("scripts/tabs/" + tab + ".php<?php echo "?ja={$l}&je={$u}"; ?>", function (data) {
                        $("#" + tab).html(data);
                    });
                }
            }
        </script>
        <link rel="shortcut icon" href="images/favicon.ico">
    </head>

    <body>

    <?php

    echo "<div class='roztahovak-modry'>
        <div class='hlavicka container'>
        <div id='nadpis'><h1>";
    if($vlastniHlavniNadpis == "")
    {
        echo $lang['hlavninadpis'];
    }
    else
    {
        echo $vlastniHlavniNadpis;
    }
    echo "</h1></div>";

    if($zobrazitNastaveni == 1)
    {

        echo "<div id='menu'>
      <nav>
        <ul>
          " . menuJazyky($jazyky, $l) . "
          " . menuJednotky($jednotky, $u) . "
        </ul>
      </nav>
    </div>";

    }

    echo "</div>
      </div>";

    // Tři sloupce
    require_once "./scripts/head.php";

    ?>

    <div id='hlavni' class="container">

        <?php

        // Záložky
        echo "<div id=\"oblastzalozek\">
  <ul class=\"tabs\">
    <li><a href=\"#aktualne\">{$lang['aktualne']}</a></li>
    <li><a href=\"#denni\" onclick=\"loadTab('denni-statistiky');\">{$lang['dennistatistiky']}</a></li>
    <li><a href=\"#mesicni\" onclick=\"loadTab('mesicni-statistiky');\">{$lang['mesicnistatistiky']}</a></li>
    <li><a href=\"#rocni\" onclick=\"loadTab('rocni-statistiky');\">{$lang['rocnistatistiky']}</a></li>
    <li><a href=\"#historie\">{$lang['historie']}</a></li>
  </ul>

  <div class=\"panely\">";
        echo "<div id=\"aktualneTab\">";
        require "scripts/tabs/aktualne.php";
        echo "</div>";
        echo "<div id=\"denni-statistiky\"></div>";
        echo "<div id=\"mesicni-statistiky\"></div>";
        echo "<div id=\"rocni-statistiky\"></div>";
        echo "<div id=\"historieTab\">";
        require "scripts/tabs/historie.php";
        echo "</div>";
        echo "</div>
  </div>

  </div>";

        // Patička
        echo "<div class='roztahovak-modry'>
          <div class='paticka container'><p>{$lang['paticka']}</p></div>
        </div>";

        ?>

    </body>
    </html>
    <?php
} // konec pokud si stranku prohlizi uzivatel a nevola ji teplomer

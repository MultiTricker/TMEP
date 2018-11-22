<?php

// INIT
require_once dirname(__FILE__) . "/../../config.php";
require_once dirname(__FILE__) . "/../db.php";
require_once dirname(__FILE__) . "/../fce.php";
require_once dirname(__FILE__) . "/../variableCheck.php";

// nacteme teploty do tabulky pro poslednich dny
$qStat = MySQLi_query($GLOBALS["DBC"], "SELECT den, mereni, nejnizsi, nejvyssi, prumer
                                          FROM tme_denni
                                          ORDER BY den DESC
                                          LIMIT 47");

// mame dost zaznamu k zobrazeni?
if(MySQLi_num_rows($qStat) > 5)
{

    echo "<div class='graf' id='graf-31-dni-teplota'>";
    require dirname(__FILE__) . '/../grafy/teplota/31-dni.php';
    echo "</div>";

    echo "<div class='container'>
        <div class='row' style='width: 98%;'>
          <div class='col-md-6'>
            <div class='row'>";

    // Iterace
    $b = 0;

    // projedeme postupne casy 0-23
    for($a = 0; $a < 24; $a++)
    {

        echo "<div class='col-md-5'><table class='tabulkaVHlavicce' width='190' style='margin: 0px 40px 0px 0px;'>
                  <tr class='radek zelenyRadek'>
                  <td colspan='3'><a href='./scripts/modals/vDobu.php?je=" . $_GET['je'] . "&amp;ja=" . $_GET['ja'] . "&amp;doba={$a}' class='modal'>{$lang['doba']} {$a}:00 - {$a}:59</a></td>
                </tr>";

        ///////////////////////////
        // nejnizsi
        ///////////////////////////
        $q = MySQLi_query($GLOBALS["DBC"], "SELECT den, {$a}nejnizsi
                                                FROM tme_denni
                                                WHERE {$a}nejnizsi IS NOT NULL
                                                ORDER BY {$a}nejnizsi ASC
                                                LIMIT 1");

        while($r = MySQLi_fetch_assoc($q))
        {
            echo "<tr>
                      <td>{$lang['min2']}</td>
                      <td>" . formatDnu($r['den']) . "</td>
                      <td>" . jednotkaTeploty($r[$a . "nejnizsi"], $u, 1) . "</td>
                    </tr>";
        }

        ///////////////////////////
        // nejvyssi
        ///////////////////////////
        $q = MySQLi_query($GLOBALS["DBC"], "SELECT den, {$a}nejvyssi
                                                FROM tme_denni
                                                ORDER BY {$a}nejvyssi DESC
                                                LIMIT 1");

        while($r = MySQLi_fetch_assoc($q))
        {
            echo "<tr>
                      <td>{$lang['max2']}</td>
                      <td>" . formatDnu($r['den']) . "</td>
                      <td>" . jednotkaTeploty($r[$a . "nejvyssi"], $u, 1) . "</td>
                    </tr>";
        }

        echo "</table><br>
                  </div>";

        // druhy sloupec v ramci prvni tabulky?
        if($b == 1)
        {
            echo "</div><div class='row'>";
            $b = 0;
        }
        else
        {
            $b++;
        }

    }

    ///////////////////////////
    // celkove druhy sloupec
    ///////////////////////////
    echo "</div>
            </div>
        <div class='col-md-5'>";

    ///////////////////////////
    // teploty za posledni dny
    // zjistime jednotku teploty (prasarnicka)
    $jednotkap = explode(" ", jednotkaTeploty(1, $u, 1));
    $jednotka = str_replace("&deg;", "°", $jednotkap[1]);
    echo "<table class='tabulkaVHlavicce nomargin'>
            <tr class='radek zelenyRadek'>
            <td colspan='5'><a href='./scripts/modals/teplotyZaPosledniDny.php?je=" . $_GET['je'] . "&amp;ja=" . $_GET['ja'] . "' class='modal'>{$lang['teplotyzaposlednidny']} ({$jednotka})</a></td>
          </tr>
          <tr class='radek modryRadek'>
            <td>{$lang['den']}</td>
            <td>{$lang['min2']}</td>
            <td>{$lang['prumer']}</td>
            <td>{$lang['max2']}</td>
            <td>{$lang['mereni']}</td>
          </tr>";

    while($r = MySQLi_fetch_assoc($qStat))
    {
        $vikend = jeVikend($r['den']);

        echo "<tr class='radekStat'>
                 <td>" . ($vikend == 1 ? "<font style='color: #009000;'>" : "") . formatDnu($r['den']) . ($vikend == 1 ? "</font>" : "") . "</td>
                 <td>" . jednotkaTeploty($r['nejnizsi'], $u, 0) . "</td>
                 <td>" . jednotkaTeploty(round($r['prumer'], 2), $u, 0) . "</td>
                 <td>" . jednotkaTeploty($r['nejvyssi'], $u, 0) . "</td>
                 <td>" . number_format($r['mereni'], 0, "", " ") . "</td>
              </tr>";
    }

    echo "</table>";

    echo "</div>
      </div>
      </div>";


    // mame vlhkomer?
    if($vlhkomer == 1)
    {
        // nacteme teploty do tabulky pro poslednich dny
        $qStat = MySQLi_query($GLOBALS["DBC"], "SELECT den, mereni, nejnizsi_vlhkost, nejvyssi_vlhkost, prumer_vlhkost
                                              FROM tme_denni
                                              WHERE nejnizsi_vlhkost > 0
                                              ORDER BY den DESC
                                              LIMIT 47");

        ///////////////////////////
        // prvotni tabulkove rozdeleni na dva sloupce
        echo "<div class='graf' id='graf-31-dni-vlhkost'>";
        require dirname(__FILE__) . '/../grafy/vlhkost/31-dni.php';
        echo "</div>";

        echo "<div class='container'>
              <div class='row' style='width: 98%;'>
              <div class='col-md-6'>
              <div class='row'>";

        ///////////////////////////
        // dalsi rozdeleni na dva sloupce
        ///////////////////////////

        // projedeme postupne casy 0-23
        for($a = 0; $a < 24; $a++)
        {
            echo "<div class='col-md-5'><table class='tabulkaVHlavicce' width='190' style='margin: 0px 40px 0px 0px;'>
                    <tr class='radek zelenyRadek'>
                    <td colspan='3'><a href='./scripts/modals/vDobu.php?je=" . $_GET['je'] . "&amp;ja=" . $_GET['ja'] . "&amp;doba={$a}' class='modal'>{$lang['doba']} {$a}:00 - {$a}:59</a></td>
                  </tr>";

            ///////////////////////////
            // nejnizsi
            ///////////////////////////
            $q = MySQLi_query($GLOBALS["DBC"], "SELECT den, {$a}nejnizsi_vlhkost
                                              FROM tme_denni
                                              WHERE {$a}nejnizsi_vlhkost > 0
                                              ORDER BY {$a}nejnizsi_vlhkost ASC
                                              LIMIT 1");

            while($r = MySQLi_fetch_assoc($q))
            {
                echo "<tr>
                        <td>{$lang['min2']}</td>
                        <td>" . formatDnu($r['den']) . "</td>
                        <td>" . ($r[$a . "nejnizsi_vlhkost"]) . "%</td>
                      </tr>";
            }

            ///////////////////////////
            // nejvyssi
            ///////////////////////////
            $q = MySQLi_query($GLOBALS["DBC"], "SELECT den, {$a}nejvyssi_vlhkost
                            FROM tme_denni
                            ORDER BY {$a}nejvyssi_vlhkost DESC
                            LIMIT 1");

            while($r = MySQLi_fetch_assoc($q))
            {
                echo "<tr>
                        <td>{$lang['max2']}</td>
                        <td>" . formatDnu($r['den']) . "</td>
                        <td>" . ($r[$a . "nejvyssi_vlhkost"]) . "%</td>
                      </tr>";
            }

            echo "</table><br>
                      </div>";

            // druhy sloupec v ramci prvni tabulky?
            if($b == 1)
            {
                echo "</div><div class='row'>";
                $b = 0;
            }
            else
            {
                $b++;
            }
        }

        ///////////////////////////
        // celkove druhy sloupec
        ///////////////////////////
        echo "</div>
                </div>
            <div class='col-md-5'>";

        ///////////////////////////
        // teploty za posledni dny
        echo "<table class='tabulkaVHlavicce nomargin'>
                <tr class='radek zelenyRadek'>
                <td colspan='5'><a href='./scripts/modals/vlhkostZaPosledniDny.php?je=" . $_GET['je'] . "&amp;ja=" . $_GET['ja'] . "' class='modal'>{$lang['vlhkostzaposlednidny']} (%)</a></td>
              </tr>
              <tr class='radek modryRadek'>
                <td width='100'>{$lang['den']}</td>
                <td width='80'>{$lang['min2']}</td>
                <td width='80'>{$lang['prumer']}</td>
                <td width='80'>{$lang['max2']}</td>
              </tr>";

        while($r = MySQLi_fetch_assoc($qStat))
        {
            $vikend = jeVikend($r['den']);

            echo "<tr class='radekStat'>
                     <td>" . ($vikend == 1 ? "<font style='color: #009000;'>" : "") . formatDnu($r['den']) . ($vikend == 1 ? "</font>" : "") . "</td>
                     <td>" . ($r['nejnizsi_vlhkost']) . "</td>
                     <td>" . (round($r['prumer_vlhkost'])) . "</td>
                     <td>" . ($r['nejvyssi_vlhkost']) . "</td>
                  </tr>";
        }

        echo "</table>";

        echo "</div>
          </div>
      </div>";
    }
}
else
{
    echo "<p>{$lang['nenidostatecnypocethodnot']}</p>";
}
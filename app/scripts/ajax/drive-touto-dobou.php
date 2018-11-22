<?php

//////////////////////////////////////////////////////////////////////////
//// VLOZENI SOUBORU
//////////////////////////////////////////////////////////////////////////

require_once dirname(__FILE__) . "/../../config.php"; // skript s nastavenim
require_once dirname(__FILE__) . "/../db.php";        // skript s databazi
require_once dirname(__FILE__) . "/../fce.php";       // skript s nekolika funkcemi

// Osetreni vstupu
require_once dirname(__FILE__) . "/../variableCheck.php";

// Stranku vkladame a nevolame AJAXem? Neposleme hlavicku, kdyz existuje v index.php deklarovana hodnota.
if(!isset($dopocitat))
{
    header('Content-type: text/html; charset=UTF-8');
}

echo "<table width='100%' class='tabulkaVHlavicce'>
    <tr class='radek zelenyRadek'>
      <td colspan='3'><a href='./scripts/modals/driveToutoDobou.php?je=" . $_GET['je'] . "&amp;ja=" . $_GET['ja'] . "' class='modal'>{$lang['drivetoutodobou']}</a></td>
    </tr>";

// posledni dny do pole
$dny2 = [];
for($a = 1; $a < 6; $a++)
{
    $dny2[] = date("Y-m-d H:i", mktime(date("H"), date("i"), date("s"), date("m"), date("d") - $a, date("Y")));
}

// projdeme pole, pro kazdy den a podobnou dobu nalezneme teplotu a vypiseme
for($a = 0; $a < count($dny2); $a++)
{
    $dotaz = MySQLi_query($GLOBALS["DBC"], "SELECT kdy, teplota, vlhkost
                            FROM tme 
                            WHERE kdy >= CAST('" . substr($dny2[$a], 0, 15) . "0' AS datetime)
                                  AND kdy <= CAST('" . substr($dny2[$a], 0, 15) . "9' AS datetime)
                            LIMIT 1");
    $hod = MySQLi_fetch_assoc($dotaz);

    echo "<tr>
              <td>" . formatDnu($dny2[$a]) . "</td>
              <td><abbr title='" . substr($hod['kdy'], 11, 5) . "'>" . jednotkaTeploty($hod['teplota'], $u, 1) . "</abbr></td>";
    if($vlhkomer == 1)
    {
        echo "<td>" . ($hod['vlhkost'] != 0 ? "{$hod['vlhkost']}%" : "") . "</td>";
    }
    echo "</tr>";
}

echo "</table>";

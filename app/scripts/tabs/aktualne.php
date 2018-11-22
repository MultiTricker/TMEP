<?php

// Data pro mereni z dneska
// Dnes nejnizsi namerena teplota/vlhkost
$dotaz = MySQLi_query($GLOBALS["DBC"], "SELECT MIN(teplota) as teplota, MIN(vlhkost) as vlhkost
                                        FROM tme
                                        WHERE kdy >= CAST('" . date("Y-m-d") . " 00:00:00' AS datetime)
                                              AND kdy <= CAST('" . date("Y-m-d") . " 23:59:59' AS datetime)");
$nejnizsiDnes = MySQLi_fetch_assoc($dotaz);

// Dnes prumerna teplota/vlhkost
$dotaz = MySQLi_query($GLOBALS["DBC"], "SELECT AVG(teplota) as teplota, AVG(vlhkost) as vlhkost
                                        FROM tme
                                        WHERE kdy >= CAST('" . date("Y-m-d") . " 00:00:00' AS datetime)
                                              AND kdy <= CAST('" . date("Y-m-d") . " 23:59:59' AS datetime)");
$prumernaDnes = MySQLi_fetch_assoc($dotaz);

// Dnes nejvyssi namerena teplota/vlhkost
$dotaz = MySQLi_query($GLOBALS["DBC"], "SELECT MAX(teplota) as teplota, MAX(vlhkost) as vlhkost
                                        FROM tme
                                        WHERE kdy >= CAST('" . date("Y-m-d") . " 00:00:00' AS datetime)
                                              AND kdy <= CAST('" . date("Y-m-d") . " 23:59:59' AS datetime)");
$nejvyssiDnes = MySQLi_fetch_assoc($dotaz);

// MIN/AVG/MAX za dnesni den
$nejnizsiDnes['teplota'] = jednotkaTeploty(round($nejnizsiDnes['teplota'], 2), $u, 1);
$prumernaDnes['teplota'] = jednotkaTeploty(round($prumernaDnes['teplota'], 2), $u, 1);
$nejvyssiDnes['teplota'] = jednotkaTeploty(round($nejvyssiDnes['teplota'], 2), $u, 1);

echo "<table class='tabulkaDnes'>
          <tr>
            <td class='radekDnes'><span class='font25 zelena'>" . strtoupper($lang['dnes']) . "</span></td>
            <td class='radekDnes'>";
if($vlhkomer == 1)
{
    echo "<div class='vpravo'>";
}
echo strtoupper($lang['teplota']) . "<br>
                      <span class='zelena'>{$lang['min2']}:</span> {$nejnizsiDnes['teplota']} |
                      <span class='zelena'>{$lang['prumer']}:</span> {$prumernaDnes['teplota']} |
                      <span class='zelena'>{$lang['max2']}:</span> {$nejvyssiDnes['teplota']}&nbsp;";
if($vlhkomer == 1)
{
    echo "</div>";
}
echo "</td>";
if($vlhkomer == 1)
{
    $nejnizsiDnes['vlhkost'] = round($nejnizsiDnes['vlhkost'], 2);
    $prumernaDnes['vlhkost'] = round($prumernaDnes['vlhkost'], 2);
    $nejvyssiDnes['vlhkost'] = round($nejvyssiDnes['vlhkost'], 2);
    echo "<td class='radekDnes'>
            <div class='vpravo'>" . strtoupper($lang['vlhkost']) . "<br>
              <span class='zelena'>{$lang['min2']}:</span> {$nejnizsiDnes['vlhkost']}% |
              <span class='zelena'>{$lang['prumer']}:</span> {$prumernaDnes['vlhkost']}% |
              <span class='zelena'>{$lang['max2']}:</span> {$nejvyssiDnes['vlhkost']}%&nbsp;
            </div>
          </td>";
}
echo "</tr>
    </table>";

// Grafy
if($vlhkomer == 1)
{
    echo "<div class='graf' id='graf-24-hodin'>";
    require "./scripts/grafy/kombinovane/24-hodin.php";
    echo "</div>";
    if(kolik("id", "tme") > 4400)
    {
        echo "<div class='graf' id='graf-3-dny'>";
        require "./scripts/grafy/kombinovane/3-dny.php";
        echo "</div>";
    }
}
else
{
    echo "<div class='graf' id='graf-24-hodin-teplota'>";
    require './scripts/grafy/teplota/24-hodin.php';
    echo "</div>";
    if(kolik("id", "tme") > 4400)
    {
        echo "<div class='graf' id='graf-3-dny-teplota'>";
        require './scripts/grafy/teplota/3-dny.php';
        echo "</div>";
    }
}
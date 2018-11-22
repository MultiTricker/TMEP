<?php

// Hlavicka
require "head.php";

// Osetreni vstupu
if(!isset($_GET['doba']) OR !is_numeric($_GET['doba']) OR $_GET['doba'] < 0 OR $_GET['doba'] > 23)
{
    $_GET['doba'] = date("H");
}

echo "<h3>{$lang['doba']} {$_GET['doba']}:00 - {$_GET['doba']}:59</h3>";

// formular pro dobu
echo "<br /><form method='GET' action='{$_SERVER['PHP_SELF']}'>
      <fieldset>
      <input type='hidden' name='ja' value='{$_GET['ja']}'>
      <input type='hidden' name='je' value='{$_GET['je']}'>
      <input type='hidden' name='typ' value='0'>
      <p><select name='doba' id='doba' style='width: 110px;'>";
for($a = 0; $a < 24; $a++)
{
    echo "<option value='{$a}' " . ($a == $_GET['doba'] ? " selected" : "") . ">{$a}:00 - {$a}:59</option>\n";
}
echo "</select> <input type='submit' class='submit' name='odeslani' value='{$lang['zobrazit']}'></p>
    </fieldset>  
  </form><br>";

///////////////////////////
// rozdeleni na sloupce
echo "<center>
      <table><tr>
         <td valign='top' class='padding5'>
         <table class='tabulkaVHlavicce' width='190' style='margin: 0px 16px 0px 0px;'>";

///////////////////////////
// nejnizsi
///////////////////////////
$q = MySQLi_query($GLOBALS["DBC"], "SELECT den, {$_GET['doba']}nejnizsi
                      FROM tme_denni 
                      WHERE {$_GET['doba']}nejnizsi IS NOT NULL
                      ORDER BY {$_GET['doba']}nejnizsi ASC 
                      LIMIT 25");

echo "<tr>
        <td colspan='2' class='radek'><b>{$lang['nejnizsiteploty']}</b></td>
      </tr>";

while($r = MySQLi_fetch_assoc($q))
{
    echo "<tr>
            <td>" . formatDnu($r['den']) . "</td>
            <td>" . jednotkaTeploty($r[$_GET['doba'] . "nejnizsi"], $u, 1) . "</td>
          </tr>";
}

///////////////////////////
// nejvyssi
///////////////////////////
$q = MySQLi_query($GLOBALS["DBC"], "SELECT den, {$_GET['doba']}nejvyssi
                      FROM tme_denni 
                      ORDER BY {$_GET['doba']}nejvyssi DESC 
                      LIMIT 25");

echo "</table>
      </td>
      <td valign='top' class='padding5'>
        <table class='tabulkaVHlavicce' width='190' style='margin: 0px 16px 0px 0px;'><tr>
          <td colspan='2' class='radek'><b>{$lang['nejvyssiteploty']}</b></td>
        </tr>";

while($r = MySQLi_fetch_assoc($q))
{
    echo "<tr>
            <td>" . formatDnu($r['den']) . "</td>
            <td>" . jednotkaTeploty($r[$_GET['doba'] . "nejvyssi"], $u, 1) . "</td>
          </tr>";
}

echo "</table>
    </td>";

// mame vlhkomer?
if($vlhkomer == 1)
{
    echo "<td valign='top' class='padding5'><table class='tabulkaVHlavicce' width='190' style='margin: 0px 16px 0px 0px;'>";

    ///////////////////////////
    // nejnizsi
    ///////////////////////////
    $q = MySQLi_query($GLOBALS["DBC"], "SELECT den, {$_GET['doba']}nejnizsi_vlhkost
                        FROM tme_denni 
                        WHERE {$_GET['doba']}nejnizsi_vlhkost > 0 
                        ORDER BY {$_GET['doba']}nejnizsi_vlhkost ASC 
                        LIMIT 25");
    echo "<tr>
              <td colspan='2' class='radek'><b>{$lang['nejnizsivlhkost']}</b></td>
            </tr>";

    while($r = MySQLi_fetch_assoc($q))
    {
        echo "<tr>
                <td>" . formatDnu($r['den']) . "</td>
                <td>" . ($r[$_GET['doba'] . "nejnizsi_vlhkost"]) . "%</td>
              </tr>";
    }

    ///////////////////////////
    // nejvyssi
    ///////////////////////////
    $q = MySQLi_query($GLOBALS["DBC"], "SELECT den, {$_GET['doba']}nejvyssi_vlhkost
                        FROM tme_denni 
                        ORDER BY {$_GET['doba']}nejvyssi_vlhkost DESC 
                        LIMIT 25");

    echo "</table>
          </td>
          <td valign='top' class='padding5'>
          <table class='tabulkaVHlavicce' width='190' style='margin: 0px 16px 0px 0px;'><tr>
              <td colspan='2' class='radek'><b>{$lang['nejvyssivlhkost']}</b></td>
          </tr>";

    while($r = MySQLi_fetch_assoc($q))
    {
        echo "<tr>
                <td>" . formatDnu($r['den']) . "</td>
                <td>" . ($r[$_GET['doba'] . "nejvyssi_vlhkost"]) . "%</td>
              </tr>";
    }

    echo "</table></td>";
}

echo "</tr>
    </table>";

// Paticka
require "foot.php";
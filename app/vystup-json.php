<?php

/* Vystup do JSONu, autor https://github.com/tuxmartin */

////////////////////////////////////////////////////////////////////////
// VLOZENI SOUBORU
////////////////////////////////////////////////////////////////////////

require "./config.php";
require "./scripts/db.php";

header('Expires: ' . gmdate('D, d M Y H:i:s') . '  GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . '  GMT');
header('Content-Type: application/json; charset=utf-8');
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
header("Access-Control-Allow-Origin: *");

////////////////////////////////////////////////////////////////////////
// Nacteni a naformatovani hodnoty
////////////////////////////////////////////////////////////////////////

$q = MySQLi_query($GLOBALS["DBC"], "SELECT teplota, vlhkost, kdy
                                      FROM tme
                                      ORDER BY id DESC
                                      LIMIT 1");

echo mysqli_error($GLOBALS["DBC"]);

$posledni = MySQLi_fetch_assoc($q);

?>{
"teplota": <?php echo $posledni["teplota"] ?>,
"vlhkost": <?php echo($vlhkomer == 1 ? $posledni["vlhkost"] : "null") ?>,
"cas": "<?php echo $posledni["kdy"] ?>",
"umisteni": "<?php echo $umisteni; ?>"
}

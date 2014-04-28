<?php 
require "./config.php";
require "./scripts/db.php";

header('Expires: ' . gmdate('D, d M Y H:i:s') . '  GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . '  GMT');
header('Content-Type: application/json; charset=utf-8');
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
header("Access-Control-Allow-Origin: *");

$dotaz=mysql_query(
		"SELECT teplota, vlhkost, kdy FROM tme ORDER BY id DESC LIMIT 1"
		) or die("CHYBA MySQL: " . mysql_error());

$zaznam=MySQL_Fetch_Array($dotaz);

?>
{
   "teplota": <?php echo $zaznam["teplota"] ?>,
   "vlhkost": <?php echo $zaznam["vlhkost"] ?>,
   "cas": "<?php echo $zaznam["kdy"] ?>",
   "umisteni": "<?php echo $umisteni; ?>",
   "popis": "Teplomer"
}

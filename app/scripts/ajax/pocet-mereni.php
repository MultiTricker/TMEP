<?php

//////////////////////////////////////////////////////////////////////////
//// VLOZENI SOUBORU
//////////////////////////////////////////////////////////////////////////

require_once dirname(__FILE__) . "/../../config.php"; // skript s nastavenim
require_once dirname(__FILE__) . "/../db.php";        // skript s databazi
require_once dirname(__FILE__) . "/../fce.php";       // skript s nekolika funkcemi

// Pocet mereni
$dotaz = MySQLi_query($GLOBALS["DBC"], "SELECT count(id) AS pocet FROM tme");
$pocetMereni = MySQLi_fetch_assoc($dotaz);

header('Content-type: text/html; charset=UTF-8');

echo number_format($pocetMereni['pocet'], 0, "", " ");
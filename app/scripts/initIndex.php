<?php

// Pocet mereni
$dotaz = MySQLi_query($GLOBALS["DBC"], "SELECT count(id) AS pocet, MIN(kdy) AS kdy FROM tme");
$pocetMereni = MySQLi_fetch_assoc($dotaz);

// Nejvyssi namerena teplota
$dotaz = MySQLi_query($GLOBALS["DBC"], "SELECT kdy, teplota FROM tme ORDER BY teplota DESC LIMIT 1");
$nejvyssi = MySQLi_fetch_assoc($dotaz);

// Nejnizsi namerena teplota
$dotaz = MySQLi_query($GLOBALS["DBC"], "SELECT kdy, teplota FROM tme ORDER BY teplota ASC LIMIT 1");
$nejnizsi = MySQLi_fetch_assoc($dotaz);
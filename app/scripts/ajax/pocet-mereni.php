<?php

 /*************************************************************************
 ***  Systém pro TME/TH2E - TMEP                                        ***
 ***  (c) Michal Ševčík 2007-2013 - multi@tricker.cz                    ***
 *************************************************************************/

 //////////////////////////////////////////////////////////////////////////
 //// VLOZENI SOUBORU
 //////////////////////////////////////////////////////////////////////////

  require "../../config.php"; // skript s nastavenim
  require "../db.php";        // skript s databazi
  require "../fce.php";       // skript s nekolika funkcemi

  // Pocet mereni
  $dotaz = MySQLi_query($GLOBALS["DBC"], "SELECT count(id) AS pocet FROM tme");
  $pocetMereni = MySQLi_fetch_assoc($dotaz);

header('Content-type: text/html; charset=UTF-8');

echo number_format($pocetMereni['pocet'], 0, "", " ");

?>
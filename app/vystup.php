<?php

 //////////////////////////////////////////////////////////////////////////
 //// VLOZENI SOUBORU
 //////////////////////////////////////////////////////////////////////////

  require_once "config.php";         // skript s nastavenim
  require_once "scripts/db.php";        // skript s databazi
  require_once "scripts/fce.php";       // skript s nekolika funkcemi

 //////////////////////////////////////////////////////////////////////////
 //// Nacteni a naformatovani hodnoty
 //////////////////////////////////////////////////////////////////////////

  // Posledni mereni
  $dotaz = MySQLi_query($GLOBALS["DBC"], "SELECT kdy, teplota, vlhkost FROM tme ORDER BY id DESC LIMIT 1");
  $posledni = MySQLi_fetch_assoc($dotaz);
  
  $d = explode(" ", formatData($posledni['kdy']));
  echo "|".$d[0]."|".$d[1]."|";
  echo str_replace(".", ",", jednotkaTeploty($posledni['teplota'], $u, 0))."|{$posledni['vlhkost']}|";
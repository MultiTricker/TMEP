<?php

 /*************************************************************************
 ***  Systém pro TME/TH2E - TMEP                                        ***
 ***  (c) Michal Ševčík 2007-2012 - multi@tricker.cz                    ***
 *************************************************************************/

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
  $dotaz = MySQL_query("SELECT kdy, teplota, vlhkost FROM tme ORDER BY id DESC LIMIT 1");
  $posledni = MySQL_fetch_assoc($dotaz);
  
  $d = explode(" ", formatData($posledni['kdy']));
  echo "|".$d[0]."|".$d[1]."|";
  echo str_replace(".", ",", jednotkaTeploty($posledni['teplota'], $u, 0))."|{$posledni['vlhkost']}|";

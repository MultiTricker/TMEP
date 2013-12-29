<?php

 /*************************************************************************
 ***  Systém pro TME/TH2E - TMEP                                        ***
 ***  (c) Michal Ševčík 2007-2013 - multi@tricker.cz                    ***
 ***  Pripojeni k DB / DB connection                                    *** 
 *************************************************************************/

if(!($GLOBALS["DBC"] = MySQLi_connect($dbServer, $dbUzivatel, $dbHeslo)))
  echo "Nepodarilo se spojit s databazovym serverem a prihlasit se. Prosim, zkontrolujte nastaveni.<br>
        Unable to connect to database server and log in. Please, check out your settings.";

if(!((bool)mysqli_query($GLOBALS["DBC"], "USE {$dbDb}")))
  echo "Chyba ve vybrani databaze \"{$dbDb}\". Prosim, zkontrolujte nastaveni.<br>
        Unable to select database \"{$dbDb}\". Please, check out your settings.";

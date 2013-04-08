<?php

 /*************************************************************************
 ***  Systém pro TME/TH2E - TMEP                                        ***
 ***  (c) Michal Ševčík 2007-2013 - multi@tricker.cz                    ***
 ***  Pripojeni k DB / DB connection                                    *** 
 *************************************************************************/

if (!MySQL_connect($dbServer,$dbUzivatel,$dbHeslo))
  echo "Nepodarilo se spojit s databazi. Prosim, zkontrolujte nastaveni.<br>
        Unable to connect into database. Please, check out your settings.";

if (!MySQL_select_db($dbDb))
  echo "Chyba ve vybrani databaze. Prosim, zkontrolujte nastaveni.<br>
        Unable to select database. Please, check out your settings.";

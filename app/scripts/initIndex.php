<?php

 /*************************************************************************
 ***  Systém pro TME/TH2E - TMEP                                        ***
 ***  (c) Michal Ševčík 2007-2012 - multi@tricker.cz                    ***
 *************************************************************************/

  // Pocet mereni
  $dotaz = MySQL_query("SELECT count(id) AS pocet, MIN(kdy) AS kdy FROM tme");
  $pocetMereni = MySQL_fetch_assoc($dotaz);

  // Posledni mereni
  $dotaz = MySQL_query("SELECT kdy, teplota, vlhkost FROM tme ORDER BY kdy DESC LIMIT 1");
  $posledni = MySQL_fetch_assoc($dotaz);

  // Starsi mereni
  $dotaz = MySQL_query("SELECT kdy, teplota FROM tme ORDER BY kdy DESC LIMIT 5, 1");
  $starsi = MySQL_fetch_assoc($dotaz);

  // Nejvyssi namerena teplota
  $dotaz = MySQL_query("SELECT kdy, teplota FROM tme ORDER BY teplota DESC LIMIT 1");
  $nejvyssi = MySQL_fetch_assoc($dotaz);

  // Nejnizsi namerena teplota
  $dotaz = MySQL_query("SELECT kdy, teplota FROM tme ORDER BY teplota ASC LIMIT 1");
  $nejnizsi = MySQL_fetch_assoc($dotaz);

  // vyvoj teploty
  if($posledni['teplota'] > $starsi['teplota'])
  { $vyvoj = "teplejsi"; }
  elseif($posledni['teplota'] < $starsi['teplota'])
  { $vyvoj = "studenejsi"; }
  else
  { $vyvoj = "stejne"; }

  // vyvoj vlhkosti
  if($posledni['vlhkost'] > $starsi['vlhkost'])
  { $vyvojv = "teplejsim"; }
  elseif($posledni['vlhkost'] < $starsi['vlhkost'])
  { $vyvojv = "studenejsim"; }
  else
  { $vyvojv = "stejnem"; }

  // vyvoj rosneho bodu
  if(rosnyBod($posledni['teplota'], $posledni['vlhkost']) > rosnyBod($starsi['teplota'], $starsi['vlhkost']))
  { $vyvojrb = "teplejsim"; }
  elseif(rosnyBod($posledni['teplota'], $posledni['vlhkost']) < rosnyBod($starsi['teplota'], $starsi['vlhkost']))
  { $vyvojrb = "studenejsim"; }
  else
  { $vyvojrb = "stejnem"; }
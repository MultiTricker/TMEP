<?php

  // Pocet mereni
  $dotaz = MySQLi_query($GLOBALS["DBC"], "SELECT count(id) AS pocet, MIN(kdy) AS kdy FROM tme");
  $pocetMereni = MySQLi_fetch_assoc($dotaz);

  // Posledni mereni
  $dotaz = MySQLi_query($GLOBALS["DBC"], "SELECT kdy, teplota, vlhkost FROM tme ORDER BY kdy DESC LIMIT 1");
  $posledni = MySQLi_fetch_assoc($dotaz);

  // Starsi mereni
  $dotaz = MySQLi_query($GLOBALS["DBC"], "SELECT kdy, teplota FROM tme ORDER BY kdy DESC LIMIT 5, 1");
  $starsi = MySQLi_fetch_assoc($dotaz);

  // Nejvyssi namerena teplota
  $dotaz = MySQLi_query($GLOBALS["DBC"], "SELECT kdy, teplota FROM tme ORDER BY teplota DESC LIMIT 1");
  $nejvyssi = MySQLi_fetch_assoc($dotaz);

  // Nejnizsi namerena teplota
  $dotaz = MySQLi_query($GLOBALS["DBC"], "SELECT kdy, teplota FROM tme ORDER BY teplota ASC LIMIT 1");
  $nejnizsi = MySQLi_fetch_assoc($dotaz);

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
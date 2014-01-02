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

 //////////////////////////////////////////////////////////////////////////
 //// JAZYK A JEDNOTKA
 //////////////////////////////////////////////////////////////////////////

  // pokud je povolene vlastni nastaveni...
  if($zobrazitNastaveni == 1)
  {

    // jazyk
    if(isset($_GET['ja']) AND ($_GET['ja'] == "cz" OR $_GET['ja'] == "en" OR 
       $_GET['ja'] == "de"))
    {
      $l = $_GET['ja'];
    }

    require_once "../language/".$l.".php";       // skript s jazykovou mutaci    

    // jednotka
    if(isset($_GET['je']) AND ($_GET['je'] == 'C' OR $_GET['je'] == 'F' OR
     $_GET['je'] == 'K' OR $_GET['je'] == 'R' OR $_GET['je'] == 'D' OR 
     $_GET['je'] == 'N' OR $_GET['je'] == 'Ro' OR $_GET['je'] == 'Re'))
    {
      $u = $_GET['je'];
    }

  }
  else
  {

    require_once "../language/".$l.".php";       // skript s jazykovou mutaci    

  }

  // Vycteni hodnot

  // Posledni mereni
  $dotaz = MySQLi_query($GLOBALS["DBC"], "SELECT kdy, teplota, vlhkost FROM tme ORDER BY kdy DESC LIMIT 1");
  $posledni = MySQLi_fetch_assoc($dotaz);
  // Starsi mereni
  $dotaz = MySQLi_query($GLOBALS["DBC"], "SELECT kdy, teplota, vlhkost FROM tme ORDER BY kdy DESC LIMIT 5, 1");
  $starsi = MySQLi_fetch_assoc($dotaz);

  // vyvoj teploty
  if($posledni['teplota'] > $starsi['teplota'])
  { $vyvoj = "teplejsi"; }
  elseif($posledni['teplota'] < $starsi['teplota'])
  { $vyvoj = "studenejsi"; }
  else
  { $vyvoj = "stejne"; }

if($vlhkomer == 1)
{

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

}

header('Content-type: text/html; charset=UTF-8');

echo "<div class='aktualne".($vlhkomer == 1 ? "" : "jen")." {$vyvoj}'>
            {$lang['aktualniteplota']}<br>
            <font class='aktua'>".jednotkaTeploty($posledni['teplota'], $u, 1)."</font><br>".formatData($posledni['kdy'])."
        </div>";

if($vlhkomer == 1)
{
  echo "<div class='aktualnemensi {$vyvojv}'>
    {$lang['vlhkost']}:<br>
    <font class='aktuamens'>{$posledni['vlhkost']}%</font>
  </div>";

  echo "<div class='aktualnemensi {$vyvojrb}'>
    {$lang['rosnybod']}:<br>
    <font class='aktuamens'>".jednotkaTeploty(rosnyBod($posledni['teplota'], $posledni['vlhkost']), $u, 1)."</font>
  </div>";

}
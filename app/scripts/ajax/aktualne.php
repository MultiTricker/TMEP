<?php

//////////////////////////////////////////////////////////////////////////
//// VLOZENI SOUBORU
//////////////////////////////////////////////////////////////////////////

require_once dirname(__FILE__) . "/../../config.php"; // skript s nastavenim
require_once dirname(__FILE__) . "/../db.php";        // skript s databazi
require_once dirname(__FILE__) . "/../fce.php";       // skript s nekolika funkcemi

// Osetreni vstupu
require_once dirname(__FILE__) . "/../variableCheck.php";

// Vycteni hodnot

// Posledni mereni
$dotaz = MySQLi_query($GLOBALS["DBC"], "SELECT kdy, teplota, vlhkost FROM tme ORDER BY kdy DESC LIMIT 1");
$posledni = MySQLi_fetch_assoc($dotaz);
// Starsi mereni
$dotaz = MySQLi_query($GLOBALS["DBC"], "SELECT kdy, teplota, vlhkost FROM tme ORDER BY kdy DESC LIMIT 5, 1");
$starsi = MySQLi_fetch_assoc($dotaz);

// vyvoj teploty
if($posledni['teplota'] > $starsi['teplota'])
{
    $vyvoj = "teplejsi";
}
elseif($posledni['teplota'] < $starsi['teplota'])
{
    $vyvoj = "studenejsi";
}
else
{
    $vyvoj = "stejne";
}

if($vlhkomer == 1)
{
    // vyvoj vlhkosti
    if($posledni['vlhkost'] > $starsi['vlhkost'])
    {
        $vyvojv = "teplejsiMalyBox";
    }
    elseif($posledni['vlhkost'] < $starsi['vlhkost'])
    {
        $vyvojv = "studenejsiMalyBox";
    }
    else
    {
        $vyvojv = "stejneMalyBox";
    }

    // vyvoj rosneho bodu
    if(rosnyBod($posledni['teplota'], $posledni['vlhkost']) > rosnyBod($starsi['teplota'], $starsi['vlhkost']))
    {
        $vyvojrb = "teplejsiMalyBox";
    }
    elseif(rosnyBod($posledni['teplota'], $posledni['vlhkost']) < rosnyBod($starsi['teplota'], $starsi['vlhkost']))
    {
        $vyvojrb = "studenejsiMalyBox";
    }
    else
    {
        $vyvojrb = "stejneMalyBox";
    }
}

// Stranku vkladame a nevolame AJAXem? Neposleme hlavicku, kdyz existuje v index.php deklarovana hodnota.
if(!isset($dopocitat))
{
    header('Content-type: text/html; charset=UTF-8');
}

echo "<div class='aktualne" . ($vlhkomer == 1 ? "" : "jen") . " {$vyvoj}" . ($vlhkomer == 1 ? "" : "jen") . barvaRamecku($posledni['teplota']) . "'>
        <div class='aktualneOdskok'>
          {$lang['aktualniteplota']}<br>
          <font class='aktua" . ($vlhkomer == 1 ? "" : "jen") . "'>" . jednotkaTeploty($posledni['teplota'], $u, 1) . "</font>
          <br>" . formatData($posledni['kdy']) . "
        </div>
      </div>";

if($vlhkomer == 1)
{
    echo "<div class='aktualneMensi aktualneMensiVlhkost {$vyvojv}'>
            <div class='aktualneOdskok'>
              {$lang['vlhkost']}<br>
              <span class='aktuamens'>{$posledni['vlhkost']}%</span>
            </div>
          </div>

          <div class='aktualneMensi aktualneMensiRosnyBod vpravo {$vyvojrb}'>
            <div class='aktualneOdskok'>
              {$lang['rosnybod']}<br>
              <font class='aktuamens'>" . jednotkaTeploty(rosnyBod($posledni['teplota'], $posledni['vlhkost']), $u, 1) . "</font>
            </div>
          </div>";
}
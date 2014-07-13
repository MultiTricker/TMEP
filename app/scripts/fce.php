<?php

 /*************************************************************************
 ***  Systém pro TME/TH2E - TMEP                                        ***
 ***  (c) Michal Ševčík 2007-2013 - multi@tricker.cz                    ***
 ***  Soubor s funkcemi / File with functions (surprisingly :)          ***
 *************************************************************************/

 //////////////////////////////////////////////////////////////////////////
 //// FUNKCE / FUNCTIONS
 //////////////////////////////////////////////////////////////////////////

/**
 * formatData() vrací datum a čas
 * @param $datum
 * @return string
 */

  function formatData($datum)
  {
  
    if(substr($datum, 8, 1) == 0){ $den = substr($datum, 9, 1); }else{ $den = substr($datum, 8, 2); }
    if(substr($datum, 5, 1) == 0){ $mesic = substr($datum, 6, 1); }else{ $mesic = substr($datum, 5, 2); }

    return $den.".".$mesic.".".substr($datum, 0, 4)." ".substr($datum, 11, 2).":".substr($datum, 14, 2);
  } 

  /**
   * formatDnu() vrací datum
   * @param $datum
   * @return string
   */
  
  function formatDnu($datum)
  {

    if(substr($datum, 8, 1) == 0){ $den = substr($datum, 9, 1); }else{ $den = substr($datum, 8, 2); }
    if(substr($datum, 5, 1) == 0){ $mesic = substr($datum, 6, 1); }else{ $mesic = substr($datum, 5, 2); }

    return $den.". ".$mesic.". ".substr($datum, 0, 4);
  }

  /**
  * fahrenheit();
  * @param $teplota
  * @return float
  */
  function fahrenheit($teplota)
  {
    
    return round((1.8 * $teplota) + 32, 1);

  }

  /**
   * kelvin();
   * @param $teplota
   * @return float
   */
  function kelvin($teplota)
  {
    
    return round($teplota + 273.15, 1);

  }

  /**
   * rankine();
   * @param $teplota
   * @return float
   */
  function rankine($teplota)
  {

    return round(($teplota + 273.15)*(9/5), 1);

  }

  /**
   * delisle();
   * @param $teplota
   * @return float
   */
  function delisle($teplota)
  {
    
    return round((100-$teplota)*(3/2), 1);

  }

  /**
   * newton();
   * @param $teplota
   * @return float
   */
  function newton($teplota)
  {
    
    return round($teplota*(33/100), 1);

  }

  /**
   * reaumur();
   * @param $teplota
   * @return float
   */
  function reaumur($teplota)
  {
    
    return round($teplota*(4/5), 1);

  }

  /**
   * romer();
   * @param $teplota
   * @return float
   */
  function romer($teplota)
  {
    
    return round($teplota*(21/40)+7.5, 1);

  }

/**
 * kolik();
 * @param string $co
 * @param string $kde
 * @param string $podminky
 * @return int
 */

function kolik($co, $kde, $podminky="")
 {

   $k = MySQLi_query($GLOBALS["DBC"], "SELECT COUNT($co) AS pocet
                     FROM $kde $podminky");
   $k = MySQLi_fetch_assoc($k);

   return $k['pocet'];

 } // konec funkce

  /**
   * kolikRadek();
   * @param string $co
   * @param string $kde
   * @param string $podminky
   * @return int
   */

function kolikRadek($co, $kde, $podminky="")
 {

   $k = MySQLi_query($GLOBALS["DBC"], "SELECT $co AS pocet
                     FROM $kde $podminky");

   return MySQLi_num_rows($k);

 } // konec funkce

  /**
   * jednotkaTeploty();
   * @param int|string $teplota
   * @param string $jednotka
   * @param int $znak
   * @return string
   */

  function jednotkaTeploty($teplota="", $jednotka="C", $znak=0)
  {

  // Cerpano z: http://en.wikipedia.org/wiki/Temperature_conversion_formulas

  // namerena teplota... nic se nedeje
  if($teplota == "" && $teplota != 0)
  {
  $teplota = "-";
  }
  if($jednotka == "C" AND $znak == 0)
  {
    return $teplota;
  }
  elseif($jednotka == "C" AND $znak == 1)
  {
    return $teplota." &deg;C";
  }
  elseif($jednotka == "F" AND $znak == 0)
  {
    return fahrenheit($teplota);
  }
  elseif($jednotka == "F" AND $znak == 1)
  {
     return fahrenheit($teplota)." &deg;F";
  }
  elseif($jednotka == "K" AND $znak == 0)
  {
    return kelvin($teplota);
  }
  elseif($jednotka == "K" AND $znak == 1)
  {
     return kelvin($teplota)." &deg;K";
  }
  elseif($jednotka == "R" AND $znak == 0)
  {
    return rankine($teplota);
  }
  elseif($jednotka == "R" AND $znak == 1)
  {
     return rankine($teplota)." &deg;R";
  }
  elseif($jednotka == "D" AND $znak == 0)
  {
    return delisle($teplota);
  }
  elseif($jednotka == "D" AND $znak == 1)
  {
     return delisle($teplota)." &deg;De";
  }
  elseif($jednotka == "N" AND $znak == 0)
  {
    return newton($teplota);
  }
  elseif($jednotka == "N" AND $znak == 1)
  {
     return newton($teplota)." &deg;N";
  }
  elseif($jednotka == "Re" AND $znak == 0)
  {
    return reaumur($teplota);
  }
  elseif($jednotka == "Re" AND $znak == 1)
  {
     return reaumur($teplota)." &deg;Ré";
  }
  elseif($jednotka == "Ro" AND $znak == 0)
  {
    return romer($teplota);
  }
  elseif($jednotka == "Ro" AND $znak == 1)
  {
     return romer($teplota)." &deg;Ro";
  }
  else
  {
    return;
  }


  }

  /**
   * jeVikend() - podle date urci typ dne
   * @param date $datum
   * @return int
   */

  function jeVikend($datum)
  {

    $denVTydnu = date("N", mktime(0, 0, 0, substr($datum, 5, 2), substr($datum, 8, 2), substr($datum, 0, 4)));
    if($denVTydnu == 6 OR $denVTydnu == 7)
    {
      return 1;
    }
    else
    {
      return 0;
    }

  }

  /**
   * rosnyBod();
   * @param float $teplota
   * @param float $vlhkost
   * @return float
   */

  function rosnyBod($teplota, $vlhkost)
  {

    // Temperature    Range      Tn (°C)         m
    // Above water    0 – 50°C    243.12     17.62
    // Above ice     -40 – 0°C    272.62     22.46

    if($teplota > 0)
    {
      return round(243.12*((log($vlhkost/100)+((17.62*$teplota)/(243.12+$teplota)))/(17.62-log($vlhkost/100)-((17.62*$teplota)/(243.12+$teplota)))), 1);
    }
    else
    {
      return round(272.62*((log($vlhkost/100)+((22.46*$teplota)/(272.62+$teplota)))/(22.46-log($vlhkost/100)-((22.46*$teplota)/(272.62+$teplota)))), 1);
    }

    
  }

/**
 * Funkce vrátí datetime z MySQL naformátované do tvaru,
 * který je v vystup-XML.php
 *
 * @param datetime $datetime
 * @return string
 */

function datetimeToPapouch($datetime)
{
 return substr($datetime, 5, 2)."/".substr($datetime, 8, 2)."/".substr($datetime, 0, 4)." ".substr($datetime, 11, 2).":".substr($datetime, 14, 2).":".substr($datetime, 17, 2);
}

/**
 * Vrátí CSS třídu pro obarvení rámečku podle hodnoty teploty.
 *
 * @param $teplota
 * @return string
 */

function barvaRamecku($teplota)
{

  $trida = "teplota-30";

  $skoky = array(-30, -25, -20, -15, -10, -5, 0, 5, 10 , 15, 20, 25, 30, 35);

  foreach($skoky as $skok)
  {
    if($teplota >= $skok){ $trida = "teplota".(string)$skok; }
  }

  return " ".$trida;

}

/**
 * @param $jazyky
 * @param $vybranyJazyk
 * @return string
 */

function menuJazyk($jazyky, $vybranyJazyk)
{

  $menu = "<li><a href='#'><span class=\"vlajka {$vybranyJazyk}\" title='".strtoupper($vybranyJazyk)."'></span></a>";
    $menu .= "<ul class='jazyk'>";

    foreach($jazyky as $jazyk)
    {

      if($jazyk != $vybranyJazyk)
      {
        $menu .= "<li><a href='{$_SERVER['PHP_SELF']}?ja={$jazyk}&amp;je={$_GET['je']}'><span class=\"vlajka {$jazyk}\" title='".strtoupper($jazyk)."'></span></a></li>";
      }

    }

  $menu .= "</ul></li>";


  return $menu;

}

/**
 * @param $jednotky
 * @param $vybranaJednotka
 * @return string
 */

function menuJednotky($jednotky, $vybranaJednotka)
{

  $menu = "<li><a href='#' title='{$jednotky[$vybranaJednotka]}'>{$jednotky[$vybranaJednotka]}</a>";
    $menu .= "<ul class='teplota'>";

    foreach($jednotky as $index => $jednotka)
    {

      if($index != $vybranaJednotka)
      {
        $menu .= "<li><a href='{$_SERVER['PHP_SELF']}?je={$index}&amp;ja={$_GET['ja']}' title='{$jednotka}'>{$jednotka}</a></li>";
      }

    }

  $menu .= "</ul></li>";

  return $menu;

}
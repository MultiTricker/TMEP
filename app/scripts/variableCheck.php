<?php

// Prvotni INIT
if(!isset($_GET['je'])){ $_GET['je'] = $l; }
if(!isset($_GET['ja'])){ $_GET['ja'] = $u; }

$jazyky = array("cz" => "cz",
  "sk" => "sk",
  "en" => "en",
  "de" => "de",
  "ru" => "ru",
  "pl" => "pl",
  "fr" => "fr",
  "fi" => "fi",
  "sv" => "sv");

$jednotky = Array("C" => "Celsius",
  "F" => "Fahrenheit",
  "K" => "Kelvin",
  "R" => "Rankine",
  "D" => "Delisle",
  "N" => "Newton",
  "Re" => "Reaumur",
  "Ro" => "Romer");

// Davame moznost zobrazit nastaveni?
if($zobrazitNastaveni == 1)
{
  // jazyk
  if(isset($_GET['ja']) AND isset($jazyky[$_GET['ja']]))
  {
    $l = $jazyky[$_GET['ja']];
  }
  else
  {
    $_GET['ja'] = $l;
  }

  require_once dirname(__FILE__)."/language/".$l.".php";       // skript s jazykovou mutaci

  // jednotka
  if(isset($_GET['je']) AND isset($jednotky[$_GET['je']]))
  {
    $u = $_GET['je'];
  }
  else
  {
    $_GET['je'] = $u;
  }

}
else
{
  require_once dirname(__FILE__)."/language/".$l.".php";       // skript s jazykovou mutaci
}
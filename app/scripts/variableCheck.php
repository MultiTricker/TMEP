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
    if(isset($_GET['ja']) AND array_key_exists($_GET['ja'], $jazyky))
    {
      $l = $_GET['ja'];
    }

    require_once dirname(__FILE__)."/language/".$l.".php";       // skript s jazykovou mutaci

    // jednotka
    if(isset($_GET['je']) AND array_key_exists($_GET['je'], $jednotky))
    {
      $u = $_GET['je'];
    }

  }
  else
  {
    require_once dirname(__FILE__)."/language/".$l.".php";       // skript s jazykovou mutaci
  }
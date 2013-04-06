<?php

 /*************************************************************************
 ***  Systém pro TME/TH2E - TMEP                                        ***
 ***  (c) Michal Ševčík 2007-2012 - multi@tricker.cz                    ***
 ***  Soubor s funkcemi / File with functions (surprisingly :)          ***
 *************************************************************************/

 //////////////////////////////////////////////////////////////////////////
 //// FUNKCE / FUNCTIONS
 //////////////////////////////////////////////////////////////////////////

  /*
   * formatData();
   * input: timestamp   
   * return: formated date
   */

  function formatData($datum)
  {
  
    if(substr($datum, 8, 1) == 0){ $den = substr($datum, 9, 1); }else{ $den = substr($datum, 8, 2); }
    if(substr($datum, 5, 1) == 0){ $mesic = substr($datum, 6, 1); }else{ $mesic = substr($datum, 5, 2); }

    return $den.".".$mesic.".".substr($datum, 0, 4)." ".substr($datum, 11, 2).":".substr($datum, 14, 2);
  } 

  /*
   * formatDnu();
   * input: timestamp   
   * return: formated date
   */
  
  function formatDnu($datum)
  {

    if(substr($datum, 8, 1) == 0){ $den = substr($datum, 9, 1); }else{ $den = substr($datum, 8, 2); }
    if(substr($datum, 5, 1) == 0){ $mesic = substr($datum, 6, 1); }else{ $mesic = substr($datum, 5, 2); }

    return $den.". ".$mesic.". ".substr($datum, 0, 4);
  } 

  /*
   * fahrenheit();
   * input: float (temp in Celsius)
   */
  function fahrenheit($teplota)
  {
    
    return round((1.8 * $teplota) + 32, 1);

  }

  /*
   * kelvin();
   * input: float (temp in Celsius)
   */
  function kelvin($teplota)
  {
    
    return round($teplota + 273.15, 1);

  }

  /*
   * rankine();
   * input: float (temp in Celsius)
   */
  function rankine($teplota)
  {

    return round(($teplota + 273.15)*(9/5), 1);

  }

  /*
   * delisle();
   * input: float (temp in Celsius)
   */
  function delisle($teplota)
  {
    
    return round((100-$teplota)*(3/2), 1);

  }

  /*
   * newton();
   * input: float (temp in Celsius)
   */
  function newton($teplota)
  {
    
    return round($teplota*(33/100), 1);

  }

  /*
   * reaumur();
   * input: float (temp in Celsius)
   */
  function reaumur($teplota)
  {
    
    return round($teplota*(4/5), 1);

  }

  /*
   * romer();
   * input: float (temp in Celsius)
   */
  function romer($teplota)
  {
    
    return round($teplota*(21/40)+7.5, 1);

  }

  /*
   * kolik();
   * input: string, string, string   
   * return: no. rows
   */

function kolik($co, $kde, $podminky="")
 {

   // nechame pocitat databazi
   $k = MySQL_query("SELECT COUNT($co) AS pocet 
                     FROM $kde $podminky");
   $k = MySQL_fetch_assoc($k);

   return $k['pocet'];

 } // konec funkce

  /*
   * kolikRadek();
   * input: string, string, string   
   * return: no. rows
   */

function kolikRadek($co, $kde, $podminky="")
 {

   // nechame pocitat databazi
   $k = MySQL_query("SELECT $co AS pocet 
                     FROM $kde $podminky");

   return MySQL_num_rows($k);

 } // konec funkce

  /*
   * jednotkaTeploty();
   * input: float, char, int
   * return: temp in fahrenheit
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


  /*
   * jeVikend();
   * input: date(time)
   * return: 1 if weekend, else 0
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


  /*
   * rosnyBod();
   * input: float(teplota), float(vlhkost)
   * return: float(rosny bod)
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

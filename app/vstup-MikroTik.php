<?php

//////////////////////////////////////////////////////////////////////////
//// VLOZENI SOUBORU
//////////////////////////////////////////////////////////////////////////

require "./config.php";         // skript s nastavenim
require "./scripts/db.php";     // skript s databazi

//////////////////////////////////////////////////////////////////////////
//// Zpracovani hodnoty a jeji ulozeni
//////////////////////////////////////////////////////////////////////////

// Skript z MikroTiku vola pres "do" nazev souboru, ktery uploadnul - existuje?
if(is_file("./".$_GET['do']))
{

  // Nacteme obsah souboru
  $radky = file("./".$_GET['do']);

  // Mame vic jak jeden radek?
  if(count($radky) > 0)
  {

    // Potrebujeme posledni (nejaktualnejsi teplotu) pro vlozeni do databaze,
    // projedeme teda posledni tri radky
    for ($i = count($radky)-3; $i < count($radky); $i++)
    {

      // Rozsekneme radek do pole podle stredniku
      $pole = explode(";", trim($radky[$i]));

      // Mame dostatecne dlouhou hodnotu?
      if(strlen($pole[0]) > 3 && strlen($pole[0]) < 8)
      {
        // Nacteme hodnotu bez posledniho znaku stupnu Celsia
        $teplota = floatval(substr($pole[0], 0, strlen($pole[0])-1));
      }

    }

    echo $teplota;
    // Mame posledni teplotu? Sup s ni do databaze
    if(is_numeric($teplota))
    {
      // kontrolujeme IP a sedi
      if(isset($ip) AND $ip != "" AND $ip == $_SERVER['REMOTE_ADDR'])
      {
        MySQL_query("INSERT INTO tme(kdy, teplota) VALUES(now(), '{$teplota}')");
        print mysql_error();
      }
      // nekontrolujeme IP
      elseif($ip == "")
      {
        MySQL_query("INSERT INTO tme(kdy, teplota) VALUES(now(), '{$teplota}')");
        print mysql_error();
      }
      // problem? zrejme pozadavek z jine nez z povolene IP
      else
      {
        echo "Chyba! Error! Fehler! Pristup ze spatne IP adresy! Access from not allowed IP address.";
      }

    }

  }
  else
  {
    echo "Nemame soubor.";
  }

}
else
{
  echo "Stranku nevola teplomer.";
}
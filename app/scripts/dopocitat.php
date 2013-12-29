<?php

 /*************************************************************************
 ***  Systém pro TME/TH2E - TMEP                                        ***
 ***  (c) Michal Ševčík 2007-2013 - multi@tricker.cz                    ***
 ***  Dopočítání dat za minulé dny                                      ***
 *************************************************************************/

 //////////////////////////////////////////////////////////////////////////
 //// VLOZENI SOUBORU
 //////////////////////////////////////////////////////////////////////////

  if(!isset($dopocitat))
  {
    // zkusime nastavit limit provadeni souboru na nekonecno
    set_time_limit(0);
    require_once "../config.php";      // skript s nastavenim
    require_once "db.php";                // skript s databazi
  }

 //////////////////////////////////////////////////////////////////////////
 //// DOPOČÍTÁNÍ
 //////////////////////////////////////////////////////////////////////////

  // vcerejsi den
  $vcera = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")-1, date("Y")));

  // Nejdriv najdeme posledni dopocitany den krome dnesniho
  $q = MySQLi_query($GLOBALS["DBC"], "SELECT MAX(den) AS den FROM tme_denni");
  $h = MySQLi_fetch_assoc($q);

  // je potreba neco dopocitavat?
  if(MySQLi_num_rows($q) == 0 OR $h['den'] != $vcera)
  {

    // takova hloupost...cheme dalsi den :)
    if($h['den'] != ""){ $h['den2'] = $h['den']." 23:59:59"; }

    $q = MySQLi_query($GLOBALS["DBC"], "SELECT kdy
                      FROM tme 
                      WHERE kdy > '{$h['den2']}' AND kdy < '".date("Y-m-d")."' 
                      GROUP BY year(kdy),month(kdy),day(kdy) 
                      ORDER BY kdy ASC");

    // Mame co dopocitavat?
    if(MySQLi_num_rows($q) > 0)
    {

    while($t = MySQLi_fetch_assoc($q))
    {

      // vytahneme den z datetime
      $den = substr($t['kdy'], 0 , 10);
      $hod['den'] = $den;

      // nejdrive naplnime tabulku cache, kde budou radky jen pro dopocitavany den
      // a tu potrapime radou dotazu misto toho, abysme ty dotazy vykonavali nad 
      // tabulkou se vsemi merenimi, ktera mohou jit do milionu zaznamu
      MySQLi_query($GLOBALS["DBC"], "INSERT INTO tme_cache(id, kdy, teplota, vlhkost)
                                     SELECT id, kdy, teplota, vlhkost
                                     FROM tme
                                     WHERE kdy >= CAST('{$den} 00:00:00' AS datetime)
                                       AND kdy <= CAST('{$den} 23:59:59' AS datetime)");
      
      // mereni za den
      $qV = MySQLi_query($GLOBALS["DBC"], "SELECT COUNT(id) AS pocet,
                                                  MIN(teplota) AS minteplota, MAX(teplota) AS maxteplota, AVG(teplota) AS avgteplota,
                                                  MIN(vlhkost) AS minvlh, MAX(vlhkost) AS maxvlh, AVG(vlhkost) AS avgvlh
                                           FROM tme_cache
                                           WHERE kdy >= CAST('{$den} 00:00:00' AS datetime)
                                             AND kdy <= CAST('{$den} 23:59:59' AS datetime)");

      $qVhod = MySQLi_fetch_assoc($qV);

      $hod['mereni'] = $qVhod['pocet'];
      $hod['nejnizsi'] = $qVhod['minteplota'];
      $hod['nejvyssi'] = $qVhod['maxteplota'];
      $hod['prumer'] = $qVhod['avgteplota'];
      $hod['nejnizsivlh'] = $qVhod['minvlh'];
      $hod['nejvyssivlh'] = $qVhod['maxvlh'];
      $hod['prumervlh'] = $qVhod['avgvlh'];
      
      // osetreni null hodnoty
      if($hod['mereni'] ==  ""){ $hod['mereni'] = "null"; };
      if($hod['nejnizsi'] ==  ""){ $hod['nejnizsi'] = "null"; };
      if($hod['nejvyssi'] ==  ""){ $hod['nejvyssi'] = "null"; };
      if($hod['prumer'] ==  ""){ $hod['prumer'] = "null"; };
      if($hod['nejnizsivlh'] ==  ""){ $hod['nejnizsivlh'] = "null"; };
      if($hod['nejvyssivlh'] ==  ""){ $hod['nejvyssivlh'] = "null"; };
      if($hod['prumervlh'] ==  ""){ $hod['prumervlh'] = "null"; };
      
      for($a = 0; $a < 24; $a++)
      {

        // potrebujeme kazdopadne dvojciferne cislo
        (strlen($a) == 1 ? $c = "0".$a : $c = $a);

        // mereni za danou hodinu
        $qV = MySQLi_query($GLOBALS["DBC"], "SELECT COUNT(id) AS pocet,
                                                    MIN(teplota) AS minteplota, MAX(teplota) AS maxteplota, AVG(teplota) AS avgteplota,
                                                    MIN(vlhkost) AS minvlh, MAX(vlhkost) AS maxvlh, AVG(vlhkost) AS avgvlh
                                             FROM tme_cache
                                             WHERE kdy >= CAST('{$den} {$c}:00:00' AS datetime)
                                               AND kdy <= CAST('{$den} {$c}:59:59' AS datetime)");

        $qVhod = MySQLi_fetch_assoc($qV);
        
        // Mame vubec nejaka mereni?
        if($qVhod['pocet'] == 0)
        {
          $hod[$a."mereni"] = "null";
          $hod[$a."nejnizsi"] = "null";
          $hod[$a."nejvyssi"] = "null";
          $hod[$a."prumer"] = "null";
          $hod[$a."nejnizsivlh"] = "null";
          $hod[$a."nejvyssivlh"] = "null";
          $hod[$a."prumervlh"] = "null";
        }
        else
        {
          $hod[$a."mereni"] = $qVhod['pocet'];
          $hod[$a."nejnizsi"] = $qVhod['minteplota'];
          $hod[$a."nejvyssi"] = $qVhod['maxteplota'];
          $hod[$a."prumer"] = $qVhod['avgteplota'];
          $hod[$a."nejnizsivlh"] = $qVhod['minvlh'];
          $hod[$a."nejvyssivlh"] = $qVhod['maxvlh'];
          $hod[$a."prumervlh"] = $qVhod['avgvlh'];
        }

        // osetreni null hodnoty, protoze za dany den nemusime mit vubec zapojeny vlhkomer
        if($hod[$a."nejnizsivlh"] ==  ""){ $hod[$a."nejnizsivlh"] = "null"; };
        if($hod[$a."nejvyssivlh"] ==  ""){ $hod[$a."nejvyssivlh"] = "null"; };
        if($hod[$a."prumervlh"] ==  ""){ $hod[$a."prumervlh"] = "null"; };

      }

      MySQLi_query($GLOBALS["DBC"], "INSERT INTO tme_denni (den, mereni, nejnizsi, nejvyssi, prumer, nejnizsi_vlhkost, nejvyssi_vlhkost, prumer_vlhkost,
                                     0mereni, 0nejnizsi, 0nejvyssi, 0prumer, 0nejnizsi_vlhkost, 0nejvyssi_vlhkost, 0prumer_vlhkost, 
                                     1mereni, 1nejnizsi, 1nejvyssi, 1prumer, 1nejnizsi_vlhkost, 1nejvyssi_vlhkost, 1prumer_vlhkost,
                                     2mereni, 2nejnizsi, 2nejvyssi, 2prumer, 2nejnizsi_vlhkost, 2nejvyssi_vlhkost, 2prumer_vlhkost,
                                     3mereni, 3nejnizsi, 3nejvyssi, 3prumer, 3nejnizsi_vlhkost, 3nejvyssi_vlhkost, 3prumer_vlhkost,
                                     4mereni, 4nejnizsi, 4nejvyssi, 4prumer, 4nejnizsi_vlhkost, 4nejvyssi_vlhkost, 4prumer_vlhkost,
                                     5mereni, 5nejnizsi, 5nejvyssi, 5prumer, 5nejnizsi_vlhkost, 5nejvyssi_vlhkost, 5prumer_vlhkost,
                                     6mereni, 6nejnizsi, 6nejvyssi, 6prumer, 6nejnizsi_vlhkost, 6nejvyssi_vlhkost, 6prumer_vlhkost,
                                     7mereni, 7nejnizsi, 7nejvyssi, 7prumer, 7nejnizsi_vlhkost, 7nejvyssi_vlhkost, 7prumer_vlhkost,
                                     8mereni, 8nejnizsi, 8nejvyssi, 8prumer, 8nejnizsi_vlhkost, 8nejvyssi_vlhkost, 8prumer_vlhkost,
                                     9mereni, 9nejnizsi, 9nejvyssi, 9prumer, 9nejnizsi_vlhkost, 9nejvyssi_vlhkost, 9prumer_vlhkost,
                                     10mereni, 10nejnizsi, 10nejvyssi, 10prumer, 10nejnizsi_vlhkost, 10nejvyssi_vlhkost, 10prumer_vlhkost,
                                     11mereni, 11nejnizsi, 11nejvyssi, 11prumer, 11nejnizsi_vlhkost, 11nejvyssi_vlhkost, 11prumer_vlhkost,
                                     12mereni, 12nejnizsi, 12nejvyssi, 12prumer, 12nejnizsi_vlhkost, 12nejvyssi_vlhkost, 12prumer_vlhkost,
                                     13mereni, 13nejnizsi, 13nejvyssi, 13prumer, 13nejnizsi_vlhkost, 13nejvyssi_vlhkost, 13prumer_vlhkost,
                                     14mereni, 14nejnizsi, 14nejvyssi, 14prumer, 14nejnizsi_vlhkost, 14nejvyssi_vlhkost, 14prumer_vlhkost,
                                     15mereni, 15nejnizsi, 15nejvyssi, 15prumer, 15nejnizsi_vlhkost, 15nejvyssi_vlhkost, 15prumer_vlhkost,
                                     16mereni, 16nejnizsi, 16nejvyssi, 16prumer, 16nejnizsi_vlhkost, 16nejvyssi_vlhkost, 16prumer_vlhkost,
                                     17mereni, 17nejnizsi, 17nejvyssi, 17prumer, 17nejnizsi_vlhkost, 17nejvyssi_vlhkost, 17prumer_vlhkost,
                                     18mereni, 18nejnizsi, 18nejvyssi, 18prumer, 18nejnizsi_vlhkost, 18nejvyssi_vlhkost, 18prumer_vlhkost,
                                     19mereni, 19nejnizsi, 19nejvyssi, 19prumer, 19nejnizsi_vlhkost, 19nejvyssi_vlhkost, 19prumer_vlhkost,
                                     20mereni, 20nejnizsi, 20nejvyssi, 20prumer, 20nejnizsi_vlhkost, 20nejvyssi_vlhkost, 20prumer_vlhkost,
                                     21mereni, 21nejnizsi, 21nejvyssi, 21prumer, 21nejnizsi_vlhkost, 21nejvyssi_vlhkost, 21prumer_vlhkost,
                                     22mereni, 22nejnizsi, 22nejvyssi, 22prumer, 22nejnizsi_vlhkost, 22nejvyssi_vlhkost, 22prumer_vlhkost,
                                     23mereni, 23nejnizsi, 23nejvyssi, 23prumer, 23nejnizsi_vlhkost, 23nejvyssi_vlhkost, 23prumer_vlhkost)
              VALUES('{$hod['den']}', {$hod['mereni']}, {$hod['nejnizsi']}, {$hod['nejvyssi']}, {$hod['prumer']}, {$hod['nejnizsivlh']}, {$hod['nejvyssivlh']}, {$hod['prumervlh']}, 
                     {$hod['0mereni']}, {$hod['0nejnizsi']}, {$hod['0nejvyssi']}, {$hod['0prumer']}, {$hod['0nejnizsivlh']}, {$hod['0nejvyssivlh']}, {$hod['0prumervlh']},
                     {$hod['1mereni']}, {$hod['1nejnizsi']}, {$hod['1nejvyssi']}, {$hod['1prumer']}, {$hod['1nejnizsivlh']}, {$hod['1nejvyssivlh']}, {$hod['1prumervlh']},
                     {$hod['2mereni']}, {$hod['2nejnizsi']}, {$hod['2nejvyssi']}, {$hod['2prumer']}, {$hod['2nejnizsivlh']}, {$hod['2nejvyssivlh']}, {$hod['2prumervlh']},
                     {$hod['3mereni']}, {$hod['3nejnizsi']}, {$hod['3nejvyssi']}, {$hod['3prumer']}, {$hod['3nejnizsivlh']}, {$hod['3nejvyssivlh']}, {$hod['3prumervlh']},
                     {$hod['4mereni']}, {$hod['4nejnizsi']}, {$hod['4nejvyssi']}, {$hod['4prumer']}, {$hod['4nejnizsivlh']}, {$hod['4nejvyssivlh']}, {$hod['4prumervlh']},
                     {$hod['5mereni']}, {$hod['5nejnizsi']}, {$hod['5nejvyssi']}, {$hod['5prumer']}, {$hod['5nejnizsivlh']}, {$hod['5nejvyssivlh']}, {$hod['5prumervlh']},
                     {$hod['6mereni']}, {$hod['6nejnizsi']}, {$hod['6nejvyssi']}, {$hod['6prumer']}, {$hod['6nejnizsivlh']}, {$hod['6nejvyssivlh']}, {$hod['6prumervlh']},
                     {$hod['7mereni']}, {$hod['7nejnizsi']}, {$hod['7nejvyssi']}, {$hod['7prumer']}, {$hod['7nejnizsivlh']}, {$hod['7nejvyssivlh']}, {$hod['7prumervlh']},
                     {$hod['8mereni']}, {$hod['8nejnizsi']}, {$hod['8nejvyssi']}, {$hod['8prumer']}, {$hod['8nejnizsivlh']}, {$hod['8nejvyssivlh']}, {$hod['8prumervlh']},
                     {$hod['9mereni']}, {$hod['9nejnizsi']}, {$hod['9nejvyssi']}, {$hod['9prumer']}, {$hod['9nejnizsivlh']}, {$hod['9nejvyssivlh']}, {$hod['9prumervlh']},
                     {$hod['10mereni']}, {$hod['10nejnizsi']}, {$hod['10nejvyssi']}, {$hod['10prumer']}, {$hod['10nejnizsivlh']}, {$hod['10nejvyssivlh']}, {$hod['10prumervlh']},
                     {$hod['11mereni']}, {$hod['11nejnizsi']}, {$hod['11nejvyssi']}, {$hod['11prumer']}, {$hod['11nejnizsivlh']}, {$hod['11nejvyssivlh']}, {$hod['11prumervlh']},
                     {$hod['12mereni']}, {$hod['12nejnizsi']}, {$hod['12nejvyssi']}, {$hod['12prumer']}, {$hod['12nejnizsivlh']}, {$hod['12nejvyssivlh']}, {$hod['12prumervlh']},
                     {$hod['13mereni']}, {$hod['13nejnizsi']}, {$hod['13nejvyssi']}, {$hod['13prumer']}, {$hod['13nejnizsivlh']}, {$hod['13nejvyssivlh']}, {$hod['13prumervlh']},
                     {$hod['14mereni']}, {$hod['14nejnizsi']}, {$hod['14nejvyssi']}, {$hod['14prumer']}, {$hod['14nejnizsivlh']}, {$hod['14nejvyssivlh']}, {$hod['14prumervlh']},
                     {$hod['15mereni']}, {$hod['15nejnizsi']}, {$hod['15nejvyssi']}, {$hod['15prumer']}, {$hod['15nejnizsivlh']}, {$hod['15nejvyssivlh']}, {$hod['15prumervlh']},
                     {$hod['16mereni']}, {$hod['16nejnizsi']}, {$hod['16nejvyssi']}, {$hod['16prumer']}, {$hod['16nejnizsivlh']}, {$hod['16nejvyssivlh']}, {$hod['16prumervlh']},
                     {$hod['17mereni']}, {$hod['17nejnizsi']}, {$hod['17nejvyssi']}, {$hod['17prumer']}, {$hod['17nejnizsivlh']}, {$hod['17nejvyssivlh']}, {$hod['17prumervlh']},
                     {$hod['18mereni']}, {$hod['18nejnizsi']}, {$hod['18nejvyssi']}, {$hod['18prumer']}, {$hod['18nejnizsivlh']}, {$hod['18nejvyssivlh']}, {$hod['18prumervlh']},
                     {$hod['19mereni']}, {$hod['19nejnizsi']}, {$hod['19nejvyssi']}, {$hod['19prumer']}, {$hod['19nejnizsivlh']}, {$hod['19nejvyssivlh']}, {$hod['19prumervlh']},
                     {$hod['20mereni']}, {$hod['20nejnizsi']}, {$hod['20nejvyssi']}, {$hod['20prumer']}, {$hod['20nejnizsivlh']}, {$hod['20nejvyssivlh']}, {$hod['20prumervlh']},
                     {$hod['21mereni']}, {$hod['21nejnizsi']}, {$hod['21nejvyssi']}, {$hod['21prumer']}, {$hod['21nejnizsivlh']}, {$hod['21nejvyssivlh']}, {$hod['21prumervlh']},
                     {$hod['22mereni']}, {$hod['22nejnizsi']}, {$hod['22nejvyssi']}, {$hod['22prumer']}, {$hod['22nejnizsivlh']}, {$hod['22nejvyssivlh']}, {$hod['22prumervlh']},
                     {$hod['23mereni']}, {$hod['23nejnizsi']}, {$hod['23nejvyssi']}, {$hod['23prumer']}, {$hod['23nejnizsivlh']}, {$hod['23nejvyssivlh']}, {$hod['23prumervlh']})");

      echo mysqli_error($GLOBALS["DBC"]);

      // smazeme docasne zaznamy
      MySQLi_query($GLOBALS["DBC"], "TRUNCATE tme_cache;");

      // mame stale pripojeni na MySQL server?
      if (!mysqli_ping($GLOBALS["DBC"])) {
        echo "<p style='font-weight; color: darkred;'>Skript skončil předčasně. Spusťte jej znovu pro dopočítání dalších dní.";
        echo "Script ended early. Run it again to calculate more data for past days.</p>";
        exit;
      }

      // muzeme vypsat co bylo dopocitano?
      if(!isset($dopocitat))
      {
        echo "Byl dopočítán den/day calculated: <b>{$den}</b><br>";
      }

      }
     
    }

    // konec?
    if(!isset($dopocitat))
    {
      echo "<b>Hotovo/Finish.</b><br>";
    }

  }

<?php

  // Hlavicka
  require "head.php";
    
  echo "<h3>{$lang['mesicnistatistiky']}</h3>";

  //////////////////////////
  // GRAF
  // Hodnoty pro graf

 $dny = Array();
 $minmax = Array();

 $dotaz = MySQLi_query($GLOBALS["DBC"], "SELECT den as mesic, MIN(nejnizsi) as nejnizsi, MAX(nejvyssi) as nejvyssi
                       FROM tme_denni 
                       GROUP BY year(den), month(den) 
                       ORDER BY den DESC
                       LIMIT 1, 60");

 // hodime do pole
 while($data = MySQLi_fetch_assoc($dotaz))
 {

   if(round($data['nejvyssi'], 2) == 0){ $vysoka = "0"; }
   else{ $vysoka = jednotkaTeploty(round($data['nejvyssi'], 2), $u, 0); }
   
   if(round($data['nejnizsi'], 2) == 0){ $nizka = "0"; }
   else{ $nizka = jednotkaTeploty(round($data['nejnizsi'], 2), $u, 0); }

   $dny[] = substr($data['mesic'], 0, 4)."/".substr($data['mesic'], 5, 2);
   $minmax[] = $nizka.", ".$vysoka;

 }
  
  // Vlozeni grafu
  echo "<div id='mesicniRozptyl' class='grafModal'></div>";
  require "../grafy/teplota/mesicniRozptyl.php";

   // nacteme
  $qStat = MySQLi_query($GLOBALS["DBC"], "SELECT den, AVG(prumer) as prumer
                        FROM tme_denni 
                        GROUP BY year(den),month(den)
                        ORDER BY prumer DESC
                        LIMIT 50");

  if(MySQLi_num_rows($qStat) > 2)
  {

  ///////////////////////////
  // rozdeleni na sloupce

        echo "<table class='tabulkaVHlavicceModalMensi'>
          <tr class='radek zelenyRadek'>
            <td colspan='2'><b>{$lang['nejteplejsimesice']}</b></td>
          </tr>
          <tr class='radek modryRadek'>
            <td><b>{$lang['mesic']}</b></td>
            <td><b>{$lang['prumernateplota']}</b></td>
          </tr>";

    while($r = MySQLi_fetch_assoc($qStat))
    {
      echo "<tr>
              <td><b>".substr($r['den'], 0, 4)."/".substr($r['den'], 5, 2)."</b></td>
              <td>".jednotkaTeploty(round($r['prumer'], 2), $u, 1)."</td>
            </tr>";
    }

    echo "</table>";

        ///////////////////////////
        // Nejstudenejsi mesice
        ///////////////////////////
        echo "<table class='tabulkaVHlavicceModalMensi'>
          <tr class='radek zelenyRadek'>
            <td colspan='2'><b>{$lang['nejstudenejsimesice']}</b></td>
          </tr>
          <tr class='radek modryRadek'>
            <td><b>{$lang['mesic']}</b></td>
            <td><b>{$lang['prumernateplota']}</b></td>
          </tr>";

  // nacteme
  $qStat = MySQLi_query($GLOBALS["DBC"], "SELECT den, AVG(prumer) as prumer
                        FROM tme_denni 
                        GROUP BY year(den),month(den)
                        ORDER BY prumer ASC
                        LIMIT 50");

    while($r = MySQLi_fetch_assoc($qStat))
    {
      echo "<tr>
              <td><b>".substr($r['den'], 0, 4)."/".substr($r['den'], 5, 2)."</b></td>
              <td>".jednotkaTeploty(round($r['prumer'], 2), $u, 1)."</td>
            </tr>";
    }

  echo "</table>";

  // mame vlhkomer?
  if($vlhkomer == 1)
  {

  $qStat = MySQLi_query($GLOBALS["DBC"], "SELECT den, AVG(prumer_vlhkost) as prumer
                        FROM tme_denni 
                        WHERE prumer_vlhkost > 0
                        GROUP BY year(den),month(den)
                        ORDER BY prumer DESC
                        LIMIT 50");

        echo "<table class='tabulkaVHlavicceModalMensi'>
          <tr class='radek zelenyRadek'>
            <td colspan='2'><b>{$lang['nejvlhcimesice']}</b></td>
          </tr>
          <tr class='radek modryRadek'>
            <td><b>{$lang['mesic']}</b></td>
            <td><b>{$lang['prumernavlhkost']}</b></td>
          </tr>";

    while($r = MySQLi_fetch_assoc($qStat))
    {
      echo "<tr>
              <td><b>".substr($r['den'], 0, 4)."/".substr($r['den'], 5, 2)."</b></td>
              <td>".round($r['prumer'], 2)."%</td>
            </tr>";
    }

    echo "</table>";

        ///////////////////////////
        // Nejstudenejsi mesice
        ///////////////////////////
        echo "<table class='tabulkaVHlavicceModalMensi'>
          <tr class='radek zelenyRadek'>
            <td colspan='2'><b>{$lang['nejsussimesice']}</b></td>
          </tr>
          <tr class='radek modryRadek'>
            <td><b>{$lang['mesic']}</b></td>
            <td><b>{$lang['prumernavlhkost']}</b></td>
          </tr>";

  // nacteme
  $qStat = MySQLi_query($GLOBALS["DBC"], "SELECT den, AVG(prumer_vlhkost) as prumer
                        FROM tme_denni 
                        WHERE prumer_vlhkost > 0
                        GROUP BY year(den),month(den)
                        ORDER BY prumer ASC
                        LIMIT 50");

    while($r = MySQLi_fetch_assoc($qStat))
    {
      echo "<tr>
              <td><b>".substr($r['den'], 0, 4)."/".substr($r['den'], 5, 2)."</b></td>
              <td>".round($r['prumer'], 2)."%</td>
            </tr>";
    }

  echo "</table>";

  }
  else
  {

        echo "<table class='tabulkaVHlavicceModalMensi'>
          <tr class='radek zelenyRadek'>
            <td colspan='2'><b>{$lang['nejvicemereni']}</b></td>
          </tr>
          <tr class='radek modryRadek'>
            <td><b>{$lang['mesic']}</b></td>
            <td><b>{$lang['mereni']}</b></td>
          </tr>";

  ///////////////////////////
  // nacteme nejvice mereni
  ///////////////////////////
  $qStat = MySQLi_query($GLOBALS["DBC"], "SELECT den, mereni
                        FROM tme_denni 
                        GROUP BY year(den),month(den)
                        ORDER BY mereni DESC
                        LIMIT 50");

    while($r = MySQLi_fetch_assoc($qStat))
    {
      echo "<tr>
              <td><b>".substr($r['den'], 0, 4)."/".substr($r['den'], 5, 2)."</b></td>
              <td>".number_format($r['mereni'], 0, "", " ")."</td>
            </tr>";
    }

  echo "</tr></table>";


        echo "<table class='tabulkaVHlavicceModalMensi'>
          <tr class='radek zelenyRadek'>
            <td colspan='2'><b>{$lang['nejmenemereni']}</b></td>
          </tr>
          <tr class='radek modryRadek'>
            <td><b>{$lang['mesic']}</b></td>
            <td><b>{$lang['mereni']}</b></td>
          </tr>";

  ///////////////////////////
  // nacteme nejmene mereni
  ///////////////////////////
  $qStat = MySQLi_query($GLOBALS["DBC"], "SELECT den, mereni
                        FROM tme_denni 
                        GROUP BY year(den),month(den)
                        ORDER BY mereni ASC
                        LIMIT 50");

    while($r = MySQLi_fetch_assoc($qStat))
    {
      echo "<tr>
              <td><b>".substr($r['den'], 0, 4)."/".substr($r['den'], 5, 2)."</b></td>
              <td>".number_format($r['mereni'], 0, "", " ")."</td>
            </tr>";
    }

  echo "</tr></table>";

  }

}

  // Paticka
  require "foot.php";
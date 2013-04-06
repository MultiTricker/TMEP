<?php

 /*************************************************************************
 ***  Systém pro TME/TH2E - TMEP                                        ***
 ***  (c) Michal Ševčík 2007-2012 - multi@tricker.cz                    ***
 *************************************************************************/

  // nacteme teploty do tabulky pro poslednich dny
  $qStat = MySQL_query("SELECT den, mereni, nejnizsi, nejvyssi, prumer 
                    FROM tme_denni 
                    ORDER BY den DESC 
                    LIMIT 50");

  // mame dost zaznamu k zobrazeni?
  if(MySQL_num_rows($qStat) > 5)
  {

  echo "<div class='graf' id='graf-31-dni-teplota'>"; require './scripts/grafy/teplota/31-dni.php'; echo "</div>";

  ///////////////////////////
  // prvotni tabulkove rozdeleni na dva sloupce
  echo "<table width='780'>
        <tr>
          <td width='440' valign='top'>";
  
    ///////////////////////////
    // dalsi rozdeleni na dva sloupce
    ///////////////////////////
    echo "<table><tr>";
  
    // projedeme postupne casy 0-23
    for($a = 0; $a < 24; $a++)
    {
  
          echo "<td>
                <table class='tabulkaVHlavicce' width='190' style='margin: 0px 40px 0px 0px;'>
                <tr class='radek'>
                <td colspan='3' align='center'><a href='./scripts/modals/vDobu.php?je=".$_GET['je']."&amp;ja=".$_GET['ja']."&amp;doba={$a}' class='modal'><b>{$lang['doba']} <font style='color: black;'>{$a}:00 - {$a}:59</font></b> <img src='./images/nw.png' title='{$lang['dennistatistiky']}'></a></td>
              </tr>";

      ///////////////////////////
      // nejnizsi
      ///////////////////////////
      $q = MySQL_query("SELECT den, {$a}nejnizsi 
                        FROM tme_denni 
                        WHERE {$a}nejnizsi IS NOT NULL
                        ORDER BY {$a}nejnizsi ASC 
                        LIMIT 1");
  /*
      echo "<tr>
              <td colspan='2' class='radek' align='center'><b>{$lang['nejnizsiteploty']}</b></td>
            </tr>";
  */
      while($r = MySQL_fetch_assoc($q))
      {
        echo "<tr>
                <td align='center'><b>{$lang['min2']}</b></td>
                <td align='center'>".formatDnu($r['den'])."</td>
                <td align='center'>".jednotkaTeploty($r[$a."nejnizsi"], $u, 1)."</td>
              </tr>";
      }
  
      ///////////////////////////
      // nejvyssi
      ///////////////////////////
      $q = MySQL_query("SELECT den, {$a}nejvyssi 
                        FROM tme_denni 
                        ORDER BY {$a}nejvyssi DESC 
                        LIMIT 1");
  /*
      echo "<tr>
              <td colspan='2' class='radek' align='center'><b>{$lang['nejvyssiteploty']}</b></td>
            </tr>";
  */
      while($r = MySQL_fetch_assoc($q))
      {
        echo "<tr>
                <td align='center'><b>{$lang['max2']}</b></td>
                <td align='center'>".formatDnu($r['den'])."</td>
                <td align='center'>".jednotkaTeploty($r[$a."nejvyssi"], $u, 1)."</td>
              </tr>";
      }
  
      echo "</table><br>
      </td>";
  
      // druhy sloupec v ramci prvni tabulky?
      if(($a % 2) == 1 && $a != 23){ echo "</tr><tr>"; }
    
    }
    
    echo "</tr></table>";


  ///////////////////////////
  // celkove druhy sloupec
  ///////////////////////////
  echo "</td>
        <td width='340' valign='top'>";

      ///////////////////////////
      // teploty za posledni dny
      // zjistime jednotku teploty (prasarnicka)
      $jednotkap = explode(" ", jednotkaTeploty(1, $u, 1));
      $jednotka = str_replace("&deg;", "°", $jednotkap[1]);
      echo "<table class='tabulkaVHlavicce' width='340'>
            <tr class='radek'>
            <td colspan='5' align='center'><a href='./scripts/modals/teplotyZaPosledniDny.php?je=".$_GET['je']."&amp;ja=".$_GET['ja']."' class='modal'><b>{$lang['teplotyzaposlednidny']}</b> ({$jednotka}) <img src='./images/nw.png' title='{$lang['teplotyzaposlednidny']}'></a></td>
          </tr>
          <tr class='radek'>
            <td align='center'><b>{$lang['den']}</b></td>
            <td align='center'><b>{$lang['min2']}</b></td>
            <td align='center'><b>{$lang['prumer']}</b></td>
            <td align='center'><b>{$lang['max2']}</b></td>
            <td align='center'><b>{$lang['mereni']}</b></td>
          </tr>";

          while($r = MySQL_fetch_assoc($qStat))
          {

            $vikend = jeVikend($r['den']);

            echo "<tr class='radekStat'>
               <td align='center'>".($vikend == 1 ? "<font style='color: #009000;'>" : "").formatDnu($r['den']).($vikend == 1 ? "</font>" : "")."</td>
               <td align='center'>".jednotkaTeploty($r['nejnizsi'], $u, 0)."</td>
               <td align='center'>".jednotkaTeploty(round($r['prumer'], 2), $u, 0)."</td>
               <td align='center'>".jednotkaTeploty($r['nejvyssi'], $u, 0)."</td>
               <td align='center'>".number_format($r['mereni'], 0, "", " ")."</td>
            </tr>";

          }

          echo "</table>";
      
      echo "</td>
        </tr>
      </table>";


    // mame vlhkomer?
    if($vlhkomer == 1)
    {

  // nacteme teploty do tabulky pro poslednich dny
  $qStat = MySQL_query("SELECT den, mereni, nejnizsi_vlhkost, nejvyssi_vlhkost, prumer_vlhkost 
                    FROM tme_denni 
                    WHERE nejnizsi_vlhkost > 0
                    ORDER BY den DESC 
                    LIMIT 50");

  ///////////////////////////
  // prvotni tabulkove rozdeleni na dva sloupce
  echo "<hr>";
  
  echo "<div class='graf' id='graf-31-dni-vlhkost'>"; require './scripts/grafy/vlhkost/31-dni.php'; echo "</div>";

  
        echo "<table width='780'>
        <tr>
          <td width='440' valign='top'>";
  
    ///////////////////////////
    // dalsi rozdeleni na dva sloupce
    ///////////////////////////
    echo "<table><tr>";
  
    // projedeme postupne casy 0-23
    for($a = 0; $a < 24; $a++)
    {
  
          echo "<td>
                <table class='tabulkaVHlavicce' width='190' style='margin: 0px 40px 0px 0px;'>
                <tr class='radek'>
                <td colspan='3' align='center'><a href='./scripts/modals/vDobu.php?je=".$_GET['je']."&amp;ja=".$_GET['ja']."&amp;doba={$a}' class='modal'><b>{$lang['doba']} <font style='color: black;'>{$a}:00 - {$a}:59</font></b> <img src='./images/nw.png' title='{$lang['dennistatistiky']}'></a></td>
              </tr>";

      ///////////////////////////
      // nejnizsi
      ///////////////////////////
      $q = MySQL_query("SELECT den, {$a}nejnizsi_vlhkost 
                        FROM tme_denni 
                        WHERE {$a}nejnizsi_vlhkost > 0 
                        ORDER BY {$a}nejnizsi_vlhkost ASC 
                        LIMIT 1");
 /* 
      echo "<tr>
              <td colspan='2' class='radek' align='center'><b>{$lang['nejnizsivlhkost']}</b></td>
            </tr>";
  */
      while($r = MySQL_fetch_assoc($q))
      {
        echo "<tr>
                <td align='center'><b>{$lang['min2']}</b></td>
                <td align='center'>".formatDnu($r['den'])."</td>
                <td align='center'>".($r[$a."nejnizsi_vlhkost"])."%</td>
              </tr>";
      }
  
      ///////////////////////////
      // nejvyssi
      ///////////////////////////
      $q = MySQL_query("SELECT den, {$a}nejvyssi_vlhkost 
                        FROM tme_denni 
                        ORDER BY {$a}nejvyssi_vlhkost DESC 
                        LIMIT 1");
  /*
      echo "<tr>
              <td colspan='3' class='radek' align='center'><b>{$lang['nejvyssivlhkost']}</b></td>
            </tr>";
  */
      while($r = MySQL_fetch_assoc($q))
      {
        echo "<tr>
                <td align='center'><b>{$lang['max2']}</b></td>
                <td align='center'>".formatDnu($r['den'])."</td>
                <td align='center'>".($r[$a."nejvyssi_vlhkost"])."%</td>
              </tr>";
      }
  
      echo "</table><br>
      </td>";
  
      // druhy sloupec v ramci prvni tabulky?
      if(($a % 2 && $a != 23) == 1){ echo "</tr><tr>"; }
    
    }
    
    echo "</tr></table>";


  ///////////////////////////
  // celkove druhy sloupec
  ///////////////////////////
  echo "</td>
        <td width='340' valign='top'>";

      ///////////////////////////
      // teploty za posledni dny
      echo "<table class='tabulkaVHlavicce' width='340'>
            <tr class='radek'>
            <td colspan='5' align='center'><a href='./scripts/modals/vlhkostZaPosledniDny.php?je=".$_GET['je']."&amp;ja=".$_GET['ja']."' class='modal'><b>{$lang['vlhkostzaposlednidny']}</b> (%) <img src='./images/nw.png' title='{$lang['vlhkostzaposlednidny']}'></a></td>
          </tr>
          <tr class='radek'>
            <td align='center' width='100'><b>{$lang['den']}</b></td>
            <td align='center' width='80'><b>{$lang['min2']}</b></td>
            <td align='center' width='80'><b>{$lang['prumer']}</b></td>
            <td align='center' width='80'><b>{$lang['max2']}</b></td>
          </tr>";

          while($r = MySQL_fetch_assoc($qStat))
          {

            $vikend = jeVikend($r['den']);

            echo "<tr class='radekStat'>
               <td align='center'>".($vikend == 1 ? "<font style='color: #009000;'>" : "").formatDnu($r['den']).($vikend == 1 ? "</font>" : "")."</td>
               <td align='center'>".($r['nejnizsi_vlhkost'])."</td>
               <td align='center'>".(round($r['prumer_vlhkost']))."</td>
               <td align='center'>".($r['nejvyssi_vlhkost'])."</td>
            </tr>";

          }

          echo "</table>";
      
      echo "</td>
        </tr>
      </table>";
    
    }



  }
  else
  {
    echo "<p>{$lang['nenidostatecnypocethodnot']}</p>";
  }

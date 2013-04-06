<?php

 /*************************************************************************
 ***  Systém pro TME/TH2E - TMEP                                        ***
 ***  (c) Michal Ševčík 2007-2012 - multi@tricker.cz                    ***
 *************************************************************************/

  // nacteme
  $qStat = MySQL_query("SELECT den, AVG(prumer) as prumer
                        FROM tme_denni 
                        GROUP BY year(den),month(den)
                        ORDER BY prumer DESC
                        LIMIT 10");

  if(MySQL_num_rows($qStat) > 2)
  {

  ///////////////////////////
  // rozdeleni na dva sloupce
  echo "<center>";

  if(kolikRadek("den", "tme_denni", "GROUP BY year(den), month(den)") > 2) { echo "<div class='graf' id='graf-mesicni-teplota'>"; require './scripts/grafy/teplota/mesicni.php'; echo "</div>"; }

  if($vlhkomer == 1)
  {
    if(kolikRadek("den", "tme_denni", "GROUP BY year(den), month(den)") > 2) { echo "<div class='graf' id='graf-mesicni-vlhkost'>"; require './scripts/grafy/vlhkost/mesicni.php'; echo "</div>"; }
  }

  echo "<table><tr>";

        echo "<td>
              <table class='tabulkaVHlavicce' width='180' style='margin: 0px 40px 0px 0px;'>
          <tr>
            <td colspan='2' class='radek' align='center'><a href='./scripts/modals/mesicniStatistiky.php?je=".$_GET['je']."&amp;ja=".$_GET['ja']."' class='modal'><b>{$lang['nejteplejsimesice']}</b> <img src='./images/nw.png' title='{$lang['mesicnistatistiky']}'></a></td>
          </tr>
          <tr>
            <td class='radek' align='center'><b>{$lang['mesic']}</b></td>
            <td class='radek' align='center'><b>{$lang['prumernateplota']}</b></td>
          </tr>";

    while($r = MySQL_fetch_assoc($qStat))
    {
      echo "<tr>
              <td align='center'><b>".substr($r['den'], 0, 4)."/".substr($r['den'], 5, 2)."</b></td>
              <td align='center'>".jednotkaTeploty(round($r['prumer'], 2), $u, 1)."</td>
            </tr>";
    }

    echo "</table>
    </td>";

        ///////////////////////////
        // Nejchladnejsi mesice
        ///////////////////////////
        echo "<td>
              <table class='tabulkaVHlavicce' width='190' style='margin: 0px 40px 0px 0px;'>
          <tr>
            <td colspan='2' class='radek' align='center'><a href='./scripts/modals/mesicniStatistiky.php?je=".$_GET['je']."&amp;ja=".$_GET['ja']."' class='modal'><b>{$lang['nejstudenejsimesice']}</b> <img src='./images/nw.png' title='{$lang['mesicnistatistiky']}'></a></td>
          </tr>
          <tr>
            <td class='radek' align='center'><b>{$lang['mesic']}</b></td>
            <td class='radek' align='center'><b>{$lang['prumernateplota']}</b></td>
          </tr>";

  // nacteme
  $qStat = MySQL_query("SELECT den, AVG(prumer) as prumer
                        FROM tme_denni 
                        GROUP BY year(den),month(den)
                        ORDER BY prumer ASC
                        LIMIT 10");

    while($r = MySQL_fetch_assoc($qStat))
    {
      echo "<tr>
              <td align='center'><b>".substr($r['den'], 0, 4)."/".substr($r['den'], 5, 2)."</b></td>
              <td align='center'>".jednotkaTeploty(round($r['prumer'], 2), $u, 1)."</td>
            </tr>";
    }

  echo "</table>
  
          </td>";

  // mame vlhkomer?
  if($vlhkomer == 1)
  {

  $qStat = MySQL_query("SELECT den, AVG(prumer_vlhkost) as prumer
                        FROM tme_denni 
                        WHERE prumer_vlhkost > 0
                        GROUP BY year(den),month(den)
                        ORDER BY prumer DESC

                        LIMIT 10");

        echo "<td>
              <table class='tabulkaVHlavicce' width='180' style='margin: 0px 40px 0px 0px;'>
          <tr>
            <td colspan='2' class='radek' align='center'><a href='./scripts/modals/mesicniStatistiky.php?je=".$_GET['je']."&amp;ja=".$_GET['ja']."' class='modal'><b>{$lang['nejvlhcimesice']}</b> <img src='./images/nw.png' title='{$lang['mesicnistatistiky']}'></a></td>
          </tr>
          <tr>
            <td class='radek' align='center'><b>{$lang['mesic']}</b></td>
            <td class='radek' align='center'><b>{$lang['prumernavlhkost']}</b></td>
          </tr>";

    while($r = MySQL_fetch_assoc($qStat))
    {
      echo "<tr>
              <td align='center'><b>".substr($r['den'], 0, 4)."/".substr($r['den'], 5, 2)."</b></td>
              <td align='center'>".round($r['prumer'], 2)."%</td>
            </tr>";
    }

    echo "</table>
    </td>";

        ///////////////////////////
        // Nejchladnejsi mesice
        ///////////////////////////
        echo "<td>
              <table class='tabulkaVHlavicce' width='180' style='margin: 0px 40px 0px 0px;'>
          <tr>
            <td colspan='2' class='radek' align='center'><a href='./scripts/modals/mesicniStatistiky.php?je=".$_GET['je']."&amp;ja=".$_GET['ja']."' class='modal'><b>{$lang['nejsussimesice']}</b> <img src='./images/nw.png' title='{$lang['mesicnistatistiky']}'></a></td>
          </tr>
          <tr>
            <td class='radek' align='center'><b>{$lang['mesic']}</b></td>
            <td class='radek' align='center'><b>{$lang['prumernavlhkost']}</b></td>
          </tr>";

  // nacteme
  $qStat = MySQL_query("SELECT den, AVG(prumer_vlhkost) as prumer
                        FROM tme_denni 
                        WHERE prumer_vlhkost > 0
                        GROUP BY year(den),month(den)
                        ORDER BY prumer ASC
                        LIMIT 10");

    while($r = MySQL_fetch_assoc($qStat))
    {
      echo "<tr>
              <td align='center'><b>".substr($r['den'], 0, 4)."/".substr($r['den'], 5, 2)."</b></td>
              <td align='center'>".round($r['prumer'], 2)."%</td>
            </tr>";
    }

  echo "</table>
  
          </td>";

  }
  else
  {

        echo "<td>
              <table class='tabulkaVHlavicce' width='180' style='margin: 0px 40px 0px 0px;'>
          <tr>
            <td colspan='2' class='radek' align='center'><a href='./scripts/modals/mesicniStatistiky.php?je=".$_GET['je']."&amp;ja=".$_GET['ja']."' class='modal'><b>{$lang['nejvicemereni']}</b> <img src='./images/nw.png' title='{$lang['mesicnistatistiky']}'></a></td>
          </tr>
          <tr>
            <td class='radek' align='center'><b>{$lang['mesic']}</b></td>
            <td class='radek' align='center'><b>{$lang['mereni']}</b></td>
          </tr>";

  ///////////////////////////
  // nacteme nejvice mereni
  ///////////////////////////
  $qStat = MySQL_query("SELECT den, AVG(mereni) as mereni 
                        FROM tme_denni 
                        GROUP BY year(den),month(den)
                        ORDER BY mereni DESC
                        LIMIT 11");

    while($r = MySQL_fetch_assoc($qStat))
    {
      echo "<tr>
              <td align='center'><b>".substr($r['den'], 0, 4)."/".substr($r['den'], 5, 2)."</b></td>
              <td align='center'>".number_format($r['mereni'], 0, "", " ")."</td>
            </tr>";
    }

  echo "</tr></table>
  
          </td>";


        echo "<td>
              <table class='tabulkaVHlavicce' width='180' style='margin: 0px 40px 0px 0px;'>
          <tr>
            <td colspan='2' class='radek' align='center'><a href='./scripts/modals/mesicniStatistiky.php?je=".$_GET['je']."&amp;ja=".$_GET['ja']."' class='modal'><b>{$lang['nejmenemereni']}</b> <img src='./images/nw.png' title='{$lang['mesicnistatistiky']}'></a></td>
          </tr>
          <tr>
            <td class='radek' align='center'><b>{$lang['mesic']}</b></td>
            <td class='radek' align='center'><b>{$lang['mereni']}</b></td>
          </tr>";

  ///////////////////////////
  // nacteme nejmene mereni
  ///////////////////////////
  $qStat = MySQL_query("SELECT den, AVG(mereni) as mereni 
                        FROM tme_denni 
                        GROUP BY year(den),month(den)
                        ORDER BY mereni ASC
                        LIMIT 11");

    while($r = MySQL_fetch_assoc($qStat))
    {
      echo "<tr>
              <td align='center'><b>".substr($r['den'], 0, 4)."/".substr($r['den'], 5, 2)."</b></td>
              <td align='center'>".number_format($r['mereni'], 0, "", " ")."</td>
            </tr>";
    }

  echo "</tr></table>
  
          </td>";

  }

         echo "</tr>
        </table>";

  //////////////////////////////////////////////////////
  // Statistiky 0-24h pro az 12 mesicu dozadu
  // do pole si nacteme poslednich 12 mesicu
  //////////////////////////////////////////////////////
  $qStat = MySQL_query("SELECT den, mereni, MIN(nejnizsi), MAX(nejvyssi), AVG(prumer), 
                           MIN(nejnizsi_vlhkost), MAX(nejvyssi_vlhkost), AVG(prumer_vlhkost), 
                           MIN(0nejnizsi), MAX(0nejvyssi), AVG(0prumer),
                           MIN(1nejnizsi), MAX(1nejvyssi), AVG(1prumer),
                           MIN(2nejnizsi), MAX(2nejvyssi), AVG(2prumer),
                           MIN(3nejnizsi), MAX(3nejvyssi), AVG(3prumer),
                           MIN(4nejnizsi), MAX(4nejvyssi), AVG(4prumer),
                           MIN(5nejnizsi), MAX(5nejvyssi), AVG(5prumer),
                           MIN(6nejnizsi), MAX(6nejvyssi), AVG(6prumer),
                           MIN(7nejnizsi), MAX(7nejvyssi), AVG(7prumer),
                           MIN(8nejnizsi), MAX(8nejvyssi), AVG(8prumer),
                           MIN(9nejnizsi), MAX(9nejvyssi), AVG(9prumer),
                           MIN(10nejnizsi), MAX(10nejvyssi), AVG(10prumer),
                           MIN(11nejnizsi), MAX(11nejvyssi), AVG(11prumer),
                           MIN(12nejnizsi), MAX(12nejvyssi), AVG(12prumer),
                           MIN(13nejnizsi), MAX(13nejvyssi), AVG(13prumer),
                           MIN(14nejnizsi), MAX(14nejvyssi), AVG(14prumer),
                           MIN(15nejnizsi), MAX(15nejvyssi), AVG(15prumer),
                           MIN(16nejnizsi), MAX(16nejvyssi), AVG(16prumer),
                           MIN(17nejnizsi), MAX(17nejvyssi), AVG(17prumer),
                           MIN(18nejnizsi), MAX(18nejvyssi), AVG(18prumer),
                           MIN(19nejnizsi), MAX(19nejvyssi), AVG(19prumer),
                           MIN(20nejnizsi), MAX(20nejvyssi), AVG(20prumer),
                           MIN(21nejnizsi), MAX(21nejvyssi), AVG(21prumer),
                           MIN(22nejnizsi), MAX(22nejvyssi), AVG(22prumer),
                           MIN(23nejnizsi), MAX(23nejvyssi), AVG(23prumer), 
                           MIN(0nejnizsi_vlhkost), MAX(0nejvyssi_vlhkost), AVG(0prumer_vlhkost),
                           MIN(1nejnizsi_vlhkost), MAX(1nejvyssi_vlhkost), AVG(1prumer_vlhkost),
                           MIN(2nejnizsi_vlhkost), MAX(2nejvyssi_vlhkost), AVG(2prumer_vlhkost),
                           MIN(3nejnizsi_vlhkost), MAX(3nejvyssi_vlhkost), AVG(3prumer_vlhkost),
                           MIN(4nejnizsi_vlhkost), MAX(4nejvyssi_vlhkost), AVG(4prumer_vlhkost),
                           MIN(5nejnizsi_vlhkost), MAX(5nejvyssi_vlhkost), AVG(5prumer_vlhkost),
                           MIN(6nejnizsi_vlhkost), MAX(6nejvyssi_vlhkost), AVG(6prumer_vlhkost),
                           MIN(7nejnizsi_vlhkost), MAX(7nejvyssi_vlhkost), AVG(7prumer_vlhkost),
                           MIN(8nejnizsi_vlhkost), MAX(8nejvyssi_vlhkost), AVG(8prumer_vlhkost),
                           MIN(9nejnizsi_vlhkost), MAX(9nejvyssi_vlhkost), AVG(9prumer_vlhkost),
                           MIN(10nejnizsi_vlhkost), MAX(10nejvyssi_vlhkost), AVG(10prumer_vlhkost),
                           MIN(11nejnizsi_vlhkost), MAX(11nejvyssi_vlhkost), AVG(11prumer_vlhkost),
                           MIN(12nejnizsi_vlhkost), MAX(12nejvyssi_vlhkost), AVG(12prumer_vlhkost),
                           MIN(13nejnizsi_vlhkost), MAX(13nejvyssi_vlhkost), AVG(13prumer_vlhkost),
                           MIN(14nejnizsi_vlhkost), MAX(14nejvyssi_vlhkost), AVG(14prumer_vlhkost),
                           MIN(15nejnizsi_vlhkost), MAX(15nejvyssi_vlhkost), AVG(15prumer_vlhkost),
                           MIN(16nejnizsi_vlhkost), MAX(16nejvyssi_vlhkost), AVG(16prumer_vlhkost),
                           MIN(17nejnizsi_vlhkost), MAX(17nejvyssi_vlhkost), AVG(17prumer_vlhkost),
                           MIN(18nejnizsi_vlhkost), MAX(18nejvyssi_vlhkost), AVG(18prumer_vlhkost),
                           MIN(19nejnizsi_vlhkost), MAX(19nejvyssi_vlhkost), AVG(19prumer_vlhkost),
                           MIN(20nejnizsi_vlhkost), MAX(20nejvyssi_vlhkost), AVG(20prumer_vlhkost),
                           MIN(21nejnizsi_vlhkost), MAX(21nejvyssi_vlhkost), AVG(21prumer_vlhkost),
                           MIN(22nejnizsi_vlhkost), MAX(22nejvyssi_vlhkost), AVG(22prumer_vlhkost),
                           MIN(23nejnizsi_vlhkost), MAX(23nejvyssi_vlhkost), AVG(23prumer_vlhkost)
                      FROM tme_denni 
                      GROUP BY year(den),month(den)
                      ORDER BY den DESC
                      LIMIT 3"); 

    if(MySQL_num_rows($q) > 0)
    {

      while($r = MySQL_fetch_assoc($qStat))
      {

        echo "<table class='tabulkaVHlavicce' width='900' style='margin: 15px 0px 15px 0px;'>
              <tr>
                <td class='radekVelky' align='center' colspan='12'><b>".$lang['mesic'.substr($r['den'], 5, 2)]." ".substr($r['den'], 0, 4)."</b><br>
                    <font class='mensi'>(<b>{$lang['teplota']}:</b> <b>MIN:</b> ".jednotkaTeploty(round($r['MIN(nejnizsi)'], 2), $u, 1).", 
                    <b>AVG:</b> ".jednotkaTeploty(round($r['AVG(prumer)'], 2), $u, 1).", 
                    <b>MAX:</b> ".jednotkaTeploty(round($r['MAX(nejvyssi)'], 2), $u, 1);
                    if($vlhkomer == 1 && $r['MIN(nejnizsi_vlhkost)'] != 0)
                    {
                    echo " | <b>{$lang['vlhkost']}:</b> <b>MIN:</b> ".round($r['MIN(nejnizsi_vlhkost)'], 2)."%, 
                    <b>AVG:</b> ".round($r['AVG(prumer_vlhkost)'], 2)."%, 
                    <b>MAX:</b> ".round($r['MAX(nejvyssi_vlhkost)'], 2)."%";
                    }
                    echo ")</font></td>
              </tr>
              <tr>
                <td class='radekVetsi' align='center' style='border-right: 1px solid grey;' colspan='3'><b>0:00 - 0:59</b></td>
                <td class='radekVetsi' align='center' style='border-right: 1px solid grey;' colspan='3'><b>1:00 - 1:59</b></td>
                <td class='radekVetsi' align='center' style='border-right: 1px solid grey;' colspan='3'><b>2:00 - 2:59</b></td>
                <td class='radekVetsi' align='center' style='border-right: 1px solid grey;' colspan='3'><b>3:00 - 3:59</b></td>
              </tr>
              <tr>
                <td class='radek' align='center'>MIN</td>
                <td class='radek' align='center'>AVG</td>
                <td class='radek' style='border-right: 1px solid grey;' align='center'>MAX</td>
                <td class='radek' align='center'>MIN</td>
                <td class='radek' align='center'>AVG</td>
                <td class='radek' style='border-right: 1px solid grey;' align='center'>MAX</td>
                <td class='radek' align='center'>MIN</td>
                <td class='radek' align='center'>AVG</td>
                <td class='radek' style='border-right: 1px solid grey;' align='center'>MAX</td>
                <td class='radek' align='center'>MIN</td>
                <td class='radek' align='center'>AVG</td>
                <td class='radek' style='border-right: 1px solid grey;' align='center'>MAX</td>
              </tr>
              <tr>";
              for($a = 0; $a < 4; $a++)
              {
                echo "<td align='center'>".jednotkaTeploty(round($r['MIN('.$a.'nejnizsi)'], 2), $u, 1).(round($r['MIN('.$a.'nejnizsi_vlhkost)'], 2) > 0 ? "<br>".round($r['MIN('.$a.'nejnizsi_vlhkost)'], 2)."%" : "")."</td>
                <td align='center'>".jednotkaTeploty(round($r['AVG('.$a.'prumer)'], 2), $u, 1).(round($r['AVG('.$a.'prumer_vlhkost)'], 2) > 0 ? "<br>".round($r['AVG('.$a.'prumer_vlhkost)'], 2)."%" : "")."</td>
                <td align='center' style='border-right: 1px solid grey;'>".jednotkaTeploty(round($r['MAX('.$a.'nejvyssi)'], 2), $u, 1).(round($r['MAX('.$a.'nejvyssi_vlhkost)'], 2) > 0 ? "<br>".round($r['MAX('.$a.'nejvyssi_vlhkost)'], 2)."%" : "")."</td>";
              }
              echo "</tr>";
              // NOVY RADEK
              for($b = 4; $b < 23; $b++)
              {

                $del = $b;
                echo "<tr>";
                for($a = $del; $a < ($del+4); $a++)
                {
                  echo "<td class='radekVetsi' style='border-right: 1px solid grey;' align='center' colspan='3'><b>{$a}:00 - {$a}:59</b></td>";
                }
                echo "</tr>
                <tr>
                  <td class='radek' align='center'>MIN</td>
                  <td class='radek' align='center'>AVG</td>
                  <td class='radek' style='border-right: 1px solid grey;' align='center'>MAX</td>
                  <td class='radek' align='center'>MIN</td>
                  <td class='radek' align='center'>AVG</td>
                  <td class='radek' style='border-right: 1px solid grey;' align='center'>MAX</td>
                  <td class='radek' align='center'>MIN</td>
                  <td class='radek' align='center'>AVG</td>
                  <td class='radek' style='border-right: 1px solid grey;' align='center'>MAX</td>
                  <td class='radek' align='center'>MIN</td>
                  <td class='radek' align='center'>AVG</td>
                  <td class='radek' style='border-right: 1px solid grey;' align='center'>MAX</td>
                </tr>
                <tr>";
                for($a = $del; $a < ($del+4); $a++)
                {
                echo "<td align='center'>".jednotkaTeploty(round($r['MIN('.$a.'nejnizsi)'], 2), $u, 1).(round($r['MIN('.$a.'nejnizsi_vlhkost)'], 2) > 0 ? "<br>".round($r['MIN('.$a.'nejnizsi_vlhkost)'], 2)."%" : "")."</td>
                <td align='center'>".jednotkaTeploty(round($r['AVG('.$a.'prumer)'], 2), $u, 1).(round($r['AVG('.$a.'prumer_vlhkost)'], 2) > 0 ? "<br>".round($r['AVG('.$a.'prumer_vlhkost)'], 2)."%" : "")."</td>
                <td align='center' style='border-right: 1px solid grey;'>".jednotkaTeploty(round($r['MAX('.$a.'nejvyssi)'], 2), $u, 1).(round($r['MAX('.$a.'nejvyssi_vlhkost)'], 2) > 0 ? "<br>".round($r['MAX('.$a.'nejvyssi_vlhkost)'], 2)."%" : "")."</td>";
                }
              
              $b = $b+3;
              
              }

              echo "</tr>
          
          </table>";

      }

    }


     echo "</center>";

  }
  else
  {
    echo "<p>{$lang['nenidostatecnypocethodnot']}</p>";
  }

<?php

 /*************************************************************************
 ***  Systém pro TME/TH2E - TMEP                                        ***
 ***  (c) Michal Ševčík 2007-2012 - multi@tricker.cz                    ***
 *************************************************************************/

  $q = MySQL_query("SELECT den 
                    FROM tme_denni 
                    GROUP BY year(den) 
                    ORDER BY den DESC");

  if(MySQL_num_rows($q) > 1)
  {

    while($t = MySQL_fetch_assoc($q))
    {

      $rok = substr($t['den'], 0, 4);

      $qStat = MySQL_query("SELECT MIN(nejnizsi), MAX(nejvyssi), AVG(prumer), 
                                   MIN(nejnizsi_vlhkost), MAX(nejvyssi_vlhkost), AVG(prumer_vlhkost)
                            FROM tme_denni 
                            WHERE den LIKE '{$rok}-%'
                            LIMIT 1");
      $r = MySQL_fetch_assoc($qStat);

      echo "<center>
            <table class='tabulkaVHlavicce'>
              <tr>
                <td class='radekVelky' align='center' colspan='12'><a href='./scripts/modals/rocniGrafy.php?je=".$_GET['je']."&amp;ja=".$_GET['ja']."&amp;rok={$rok}' class='modal'><b>{$rok}</b> <img src='./images/nw.png' title='{$rok}'></a><br>
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
            <td>
            
           <table><tr>";


      /////////////////////////////////
      // SLOUPEK
      ////////////////////////////////

        echo"<td><table class='tabulkaVHlavicce' width='200' style='margin: 0px 20px 0px 0px;'>
              <tr>
                <td colspan='2' class='radek' align='center'><b>{$lang['nejvyssiteplota']}</b></td>
              </tr>
              <tr>
                <td class='radek' align='center'><b>{$lang['den']}</b></td>
                <td class='radek' align='center'><b>{$lang['teplota']}</b></td>
              </tr>";
    
      // nacteme
      $qStat = MySQL_query("SELECT den, nejvyssi
                            FROM tme_denni 
                            WHERE den LIKE '{$rok}-%' 
                            ORDER BY nejvyssi DESC
                            LIMIT 6");
    
        while($r = MySQL_fetch_assoc($qStat))
        {
          echo "<tr>
                  <td align='center'><b>".formatDnu($r['den'])."</b></td>
                  <td align='center'>".jednotkaTeploty(round($r['nejvyssi'], 2), $u, 1)."</td>
                </tr>";
        }
    
        echo "</table></td>";

      /////////////////////////////////
      // SLOUPEK
      ////////////////////////////////

        echo"<td><table class='tabulkaVHlavicce' width='200' style='margin: 0px 20px 0px 0px;'>
              <tr>
                <td colspan='2' class='radek' align='center'><b>{$lang['nejnizsiteplota']}</b></td>
              </tr>
              <tr>
                <td class='radek' align='center'><b>{$lang['den']}</b></td>
                <td class='radek' align='center'><b>{$lang['teplota']}</b></td>
              </tr>";

      // nacteme
      $qStat = MySQL_query("SELECT den, nejnizsi
                            FROM tme_denni 
                            WHERE den LIKE '{$rok}-%' 
                            ORDER BY nejnizsi ASC
                            LIMIT 6");

        while($r = MySQL_fetch_assoc($qStat))
        {
          echo "<tr>
                  <td align='center'><b>".formatDnu($r['den'])."</b></td>
                  <td align='center'>".jednotkaTeploty(round($r['nejnizsi'], 2), $u, 1)."</td>
                </tr>";
        }

        echo "</table></td>";

      /////////////////////////////////
      // SLOUPEK
      ////////////////////////////////

        echo"<td><table class='tabulkaVHlavicce' width='200' style='margin: 0px 20px 0px 0px;'>
              <tr>
                <td colspan='2' class='radek' align='center'><b>{$lang['nejteplejsimesice']}</b></td>
              </tr>
              <tr>
                <td class='radek' align='center'><b>{$lang['mesic']}</b></td>
                <td class='radek' align='center'><b>{$lang['prumer']}</b></td>
              </tr>";
    
      // nacteme
      $qStat = MySQL_query("SELECT den, AVG(prumer) as prumer
                            FROM tme_denni 
                            WHERE den LIKE '{$rok}-%' 
                            GROUP BY year(den),month(den)
                            ORDER BY prumer DESC
                            LIMIT 6");
    
        while($r = MySQL_fetch_assoc($qStat))
        {
          echo "<tr>
                  <td align='center'><b>".$lang['mesic'.substr($r['den'], 5, 2)]."</b></td>
                  <td align='center'>".jednotkaTeploty(round($r['prumer'], 2), $u, 1)."</td>
                </tr>";
        }
    
        echo "</table></td>";

      /////////////////////////////////
      // SLOUPEK
      ////////////////////////////////

        echo"<td><table class='tabulkaVHlavicce' width='200' style='margin: 0px 20px 0px 0px;'>
              <tr>
                <td colspan='2' class='radek' align='center'><b>{$lang['nejstudenejsimesice']}</b></td>
              </tr>
              <tr>
                <td class='radek' align='center'><b>{$lang['mesic']}</b></td>
                <td class='radek' align='center'><b>{$lang['prumer']}</b></td>
              </tr>";
    
      // nacteme
      $qStat = MySQL_query("SELECT den, AVG(prumer) as prumer
                            FROM tme_denni 
                            WHERE den LIKE '{$rok}-%' 
                            GROUP BY year(den),month(den)
                            ORDER BY prumer ASC
                            LIMIT 6");
    
        while($r = MySQL_fetch_assoc($qStat))
        {
          echo "<tr>
                  <td align='center'><b>".$lang['mesic'.substr($r['den'], 5, 2)]."</b></td>
                  <td align='center'>".jednotkaTeploty(round($r['prumer'], 2), $u, 1)."</td>
                </tr>";
        }
    
        echo "</table></td>";


        echo "
        </tr>
        </table>";



        // mame vlhkomer?
        if($vlhkomer == 1)
        {

          echo "<table><tr>";
    
          /////////////////////////////////
          // SLOUPEK
          ////////////////////////////////

          // nacteme
          $qStat = MySQL_query("SELECT den, nejvyssi_vlhkost
                                FROM tme_denni 
                                WHERE den LIKE '{$rok}-%' AND nejvyssi_vlhkost > 0
                                ORDER BY nejvyssi_vlhkost DESC
                                LIMIT 6");
    
          if(MySQL_num_rows($qStat) > 0)
          {
    
            echo"<td><table class='tabulkaVHlavicce' width='200' style='margin: 0px 20px 0px 0px;'>
                  <tr>
                    <td colspan='2' class='radek' align='center'><b>{$lang['nejvyssivlhkost']}</b></td>
                  </tr>
                  <tr>
                    <td class='radek' align='center'><b>{$lang['den']}</b></td>
                    <td class='radek' align='center'><b>{$lang['vlhkost']}</b></td>
                  </tr>";
        
            while($r = MySQL_fetch_assoc($qStat))
            {
              echo "<tr>
                      <td align='center'><b>".formatDnu($r['den'])."</b></td>
                      <td align='center'>".round($r['nejvyssi_vlhkost'], 2)."%</td>
                    </tr>";
            }
        
            echo "</table></td>";

          }

          /////////////////////////////////
          // SLOUPEK
          ////////////////////////////////

          // nacteme
          $qStat = MySQL_query("SELECT den, nejnizsi_vlhkost
                                FROM tme_denni 
                                WHERE den LIKE '{$rok}-%' AND nejnizsi_vlhkost > 0
                                ORDER BY nejnizsi_vlhkost ASC
                                LIMIT 6");

          if(MySQL_num_rows($qStat) > 0)
          {

            echo"<td><table class='tabulkaVHlavicce' width='200' style='margin: 0px 20px 0px 0px;'>
                  <tr>
                    <td colspan='2' class='radek' align='center'><b>{$lang['nejnizsivlhkost']}</b></td>
                  </tr>
                  <tr>
                    <td class='radek' align='center'><b>{$lang['den']}</b></td>
                    <td class='radek' align='center'><b>{$lang['vlhkost']}</b></td>
                  </tr>";
    
        
            while($r = MySQL_fetch_assoc($qStat))
            {
              echo "<tr>
                      <td align='center'><b>".formatDnu($r['den'])."</b></td>
                      <td align='center'>".round($r['nejnizsi_vlhkost'], 2)."%</td>
                    </tr>";
            }
        
            echo "</table></td>";
          
          }
    
          /////////////////////////////////
          // SLOUPEK
          ////////////////////////////////
        
          // nacteme
          $qStat = MySQL_query("SELECT den, AVG(prumer_vlhkost) as prumer
                                FROM tme_denni 
                                WHERE den LIKE '{$rok}-%' AND prumer_vlhkost > 0
                                GROUP BY year(den),month(den)
                                ORDER BY prumer DESC
                                LIMIT 6");
    
          if(MySQL_num_rows($qStat) > 0)
          {

    
            echo"<td><table class='tabulkaVHlavicce' width='200' style='margin: 0px 20px 0px 0px;'>
                  <tr>
                    <td colspan='2' class='radek' align='center'><b>{$lang['nejvlhcimesice']}</b></td>
                  </tr>
                  <tr>
                    <td class='radek' align='center'><b>{$lang['mesic']}</b></td>
                    <td class='radek' align='center'><b>{$lang['prumer']}</b></td>
                  </tr>";
        
            while($r = MySQL_fetch_assoc($qStat))
            {
              echo "<tr>
                      <td align='center'><b>".$lang['mesic'.substr($r['den'], 5, 2)]."</b></td>
                      <td align='center'>".round($r['prumer'], 2)."%</td>
                    </tr>";
            }
        
            echo "</table></td>";
          
          }
    
          /////////////////////////////////
          // SLOUPEK
          ////////////////////////////////
    
        
          // nacteme
          $qStat = MySQL_query("SELECT den, AVG(prumer_vlhkost) as prumer
                                FROM tme_denni 
                                WHERE den LIKE '{$rok}-%'  AND prumer_vlhkost > 0
                                GROUP BY year(den),month(den)
                                ORDER BY prumer ASC
                                LIMIT 6");

          if(MySQL_num_rows($qStat) > 0)
          {

            echo"<td><table class='tabulkaVHlavicce' width='200' style='margin: 0px 20px 0px 0px;'>
                  <tr>
                    <td colspan='2' class='radek' align='center'><b>{$lang['nejsussimesice']}</b></td>
                  </tr>
                  <tr>
                    <td class='radek' align='center'><b>{$lang['mesic']}</b></td>
                    <td class='radek' align='center'><b>{$lang['prumer']}</b></td>
                  </tr>";


            while($r = MySQL_fetch_assoc($qStat))
            {
              echo "<tr>
                      <td align='center'><b>".$lang['mesic'.substr($r['den'], 5, 2)]."</b></td>
                      <td align='center'>".round($r['prumer'], 2)."%</td>
                    </tr>";
            }

            echo "</table></td>";

          }

          // konec sloupku

          echo "
          </tr>
          </table>";

        }


        echo "</td>
        </tr>
        </table><br>
        </center>";

    } // konec while

  }
  else
  {
    echo "<p>{$lang['nenidostatecnypocethodnot']}</p>";
  }

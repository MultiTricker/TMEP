<?php

  // INIT
  require_once dirname(__FILE__)."/../../config.php";
  require_once dirname(__FILE__)."/../db.php";
  require_once dirname(__FILE__)."/../fce.php";
  require_once dirname(__FILE__)."/../variableCheck.php";

  $q = MySQLi_query($GLOBALS["DBC"], "SELECT den
                    FROM tme_denni 
                    GROUP BY year(den) 
                    ORDER BY den DESC");

  if(MySQLi_num_rows($q) > 1)
  {

    while($t = MySQLi_fetch_assoc($q))
    {

      $rok = substr($t['den'], 0, 4);

      $qStat = MySQLi_query($GLOBALS["DBC"], "SELECT MIN(nejnizsi), MAX(nejvyssi), AVG(prumer),
                                   MIN(nejnizsi_vlhkost), MAX(nejvyssi_vlhkost), AVG(prumer_vlhkost)
                            FROM tme_denni 
                            WHERE den LIKE '{$rok}-%'
                            LIMIT 1");
      $r = MySQLi_fetch_assoc($qStat);

      // MIN/AVG/MAX za dnesni den
      $nejnizsiDnes['teplota'] = jednotkaTeploty(round($nejnizsiDnes['teplota'],2), $u, 1);
      $prumernaDnes['teplota'] = jednotkaTeploty(round($prumernaDnes['teplota'],2), $u, 1);
      $nejvyssiDnes['teplota'] = jednotkaTeploty(round($nejvyssiDnes['teplota'],2), $u, 1);
      echo "<table class='tabulkaDnes'>
          <tr>
            <td class='radekDnes'><a href='./scripts/modals/rocniGrafy.php?je=".$_GET['je']."&amp;ja=".$_GET['ja']."&amp;rok={$rok}' class='modal bilyOdkaz'><span class='font25 zelena'>{$rok}</a></span></td>
            <td class='radekDnes'>";
      if($vlhkomer == 1 && $r['MIN(nejnizsi_vlhkost)'] != 0){ echo "<div class='vpravo'>"; }
      echo strtoupper($lang['teplota'])."<br>
                      <span class='zelena'>{$lang['min2']}:</span> ".jednotkaTeploty(round($r['MIN(nejnizsi)'], 2), $u, 1)." |
                      <span class='zelena'>{$lang['prumer']}:</span> ".jednotkaTeploty(round($r['AVG(prumer)'], 2), $u, 1)." |
                      <span class='zelena'>{$lang['max2']}:</span> ".jednotkaTeploty(round($r['MAX(nejvyssi)'], 2), $u, 1);
      if($vlhkomer == 1 && $r['MIN(nejnizsi_vlhkost)'] != 0){ echo "</div>"; }
      echo "</td>";
      if($vlhkomer == 1 && $r['MIN(nejnizsi_vlhkost)'] != 0)
      {
        $nejnizsiDnes['vlhkost'] = round($nejnizsiDnes['vlhkost'],2);
        $prumernaDnes['vlhkost'] = round($prumernaDnes['vlhkost'],2);
        $nejvyssiDnes['vlhkost'] = round($nejvyssiDnes['vlhkost'],2);
        echo "<td class='radekDnes'>
                      <div class='vpravo'>".strtoupper($lang['vlhkost'])."<br>
                        <span class='zelena'>{$lang['min2']}:</span> ".round($r['MIN(nejnizsi_vlhkost)'], 2)."% |
                        <span class='zelena'>{$lang['prumer']}:</span> ".round($r['AVG(prumer_vlhkost)'], 2)."% |
                        <span class='zelena'>{$lang['max2']}:</span> ".round($r['MAX(nejvyssi_vlhkost)'], 2)."%&nbsp;
                      </div>
                    </td>";
      }
      echo "</tr>
        </table>";

      echo "<table class='tabulkaVHlavicce'>
              <tr>
                <td class='radekVelky' colspan='12'><a href='./scripts/modals/rocniGrafy.php?je=".$_GET['je']."&amp;ja=".$_GET['ja']."&amp;rok={$rok}' class='modal bilyOdkaz'>{$rok}</a><br>
                    <font class='mensi'>({$lang['teplota']}: MIN: ".jednotkaTeploty(round($r['MIN(nejnizsi)'], 2), $u, 1).", 
                    AVG: ".jednotkaTeploty(round($r['AVG(prumer)'], 2), $u, 1).", 
                    MAX: ".jednotkaTeploty(round($r['MAX(nejvyssi)'], 2), $u, 1);
                    if($vlhkomer == 1 && $r['MIN(nejnizsi_vlhkost)'] != 0)
                    {
                    echo " | {$lang['vlhkost']}: MIN: ".round($r['MIN(nejnizsi_vlhkost)'], 2)."%, 
                    AVG: ".round($r['AVG(prumer_vlhkost)'], 2)."%, 
                    MAX: ".round($r['MAX(nejvyssi_vlhkost)'], 2)."%";
                    }
                    echo ")</font></td>
              </tr>
            <tr>
            <td>";


      /////////////////////////////////
      // SLOUPEK
      ////////////////////////////////

        echo"<table class='rokVDobe'>
              <tr>
                <td colspan='2' class='radek'>{$lang['nejvyssiteplota']}</td>
              </tr>
              <tr>
                <td class='radek'>{$lang['den']}</td>
                <td class='radek'>{$lang['teplota']}</td>
              </tr>";
    
      // nacteme
      $qStat = MySQLi_query($GLOBALS["DBC"], "SELECT den, nejvyssi
                            FROM tme_denni 
                            WHERE den LIKE '{$rok}-%' 
                            ORDER BY nejvyssi DESC
                            LIMIT 6");
    
        while($r = MySQLi_fetch_assoc($qStat))
        {
          echo "<tr>
                  <td>".formatDnu($r['den'])."</td>
                  <td>".jednotkaTeploty(round($r['nejvyssi'], 2), $u, 1)."</td>
                </tr>";
        }
    
        echo "</table>";

      /////////////////////////////////
      // SLOUPEK
      ////////////////////////////////

        echo"<table class='rokVDobe'>
              <tr>
                <td colspan='2' class='radek'>{$lang['nejnizsiteplota']}</td>
              </tr>
              <tr>
                <td class='radek'>{$lang['den']}</td>
                <td class='radek'>{$lang['teplota']}</td>
              </tr>";

      // nacteme
      $qStat = MySQLi_query($GLOBALS["DBC"], "SELECT den, nejnizsi
                            FROM tme_denni 
                            WHERE den LIKE '{$rok}-%' 
                            ORDER BY nejnizsi ASC
                            LIMIT 6");

        while($r = MySQLi_fetch_assoc($qStat))
        {
          echo "<tr>
                  <td>".formatDnu($r['den'])."</td>
                  <td>".jednotkaTeploty(round($r['nejnizsi'], 2), $u, 1)."</td>
                </tr>";
        }

        echo "</table>";

      /////////////////////////////////
      // SLOUPEK
      ////////////////////////////////

        echo"<table class='rokVDobe'>
              <tr>
                <td colspan='2' class='radek'>{$lang['nejteplejsimesice']}</td>
              </tr>
              <tr>
                <td class='radek'>{$lang['mesic']}</td>
                <td class='radek'>{$lang['prumer']}</td>
              </tr>";
    
      // nacteme
      $qStat = MySQLi_query($GLOBALS["DBC"], "SELECT den, AVG(prumer) as prumer
                            FROM tme_denni 
                            WHERE den LIKE '{$rok}-%' 
                            GROUP BY year(den),month(den)
                            ORDER BY prumer DESC
                            LIMIT 6");
    
        while($r = MySQLi_fetch_assoc($qStat))
        {
          echo "<tr>
                  <td>".$lang['mesic'.substr($r['den'], 5, 2)]."</td>
                  <td>".jednotkaTeploty(round($r['prumer'], 2), $u, 1)."</td>
                </tr>";
        }
    
        echo "</table>";

      /////////////////////////////////
      // SLOUPEK
      ////////////////////////////////

        echo"<table class='rokVDobe'>
              <tr class='zelenyRadek'>
                <td colspan='2' class='radek'>{$lang['nejchladnejsimesice']}</td>
              </tr>
              <tr class='modryRadek'>
                <td class='radek'>{$lang['mesic']}</td>
                <td class='radek'>{$lang['prumer']}</td>
              </tr>";
    
      // nacteme
      $qStat = MySQLi_query($GLOBALS["DBC"], "SELECT den, AVG(prumer) as prumer
                            FROM tme_denni 
                            WHERE den LIKE '{$rok}-%' 
                            GROUP BY year(den),month(den)
                            ORDER BY prumer ASC
                            LIMIT 6");
    
        while($r = MySQLi_fetch_assoc($qStat))
        {
          echo "<tr>
                  <td>".$lang['mesic'.substr($r['den'], 5, 2)]."</td>
                  <td>".jednotkaTeploty(round($r['prumer'], 2), $u, 1)."</td>
                </tr>";
        }
    
        echo "</table>";


        echo "</td>
        </tr>";



        // mame vlhkomer?
        if($vlhkomer == 1)
        {

          echo "<tr><td>";
    
          /////////////////////////////////
          // SLOUPEK
          ////////////////////////////////

          // nacteme
          $qStat = MySQLi_query($GLOBALS["DBC"], "SELECT den, nejvyssi_vlhkost
                                FROM tme_denni 
                                WHERE den LIKE '{$rok}-%' AND nejvyssi_vlhkost > 0
                                ORDER BY nejvyssi_vlhkost DESC
                                LIMIT 6");
    
          if(MySQLi_num_rows($qStat) > 0)
          {
    
            echo"<table class='rokVDobe'>
                  <tr class='zelenyRadek'>
                    <td colspan='2' class='radek'>{$lang['nejvyssivlhkost']}</td>
                  </tr>
                  <tr class='modry'>
                    <td class='radek'>{$lang['den']}</td>
                    <td class='radek'>{$lang['vlhkost']}</td>
                  </tr>";
        
            while($r = MySQLi_fetch_assoc($qStat))
            {
              echo "<tr>
                      <td>".formatDnu($r['den'])."</td>
                      <td>".round($r['nejvyssi_vlhkost'], 2)."%</td>
                    </tr>";
            }
        
            echo "</table>";

          }

          /////////////////////////////////
          // SLOUPEK
          ////////////////////////////////

          // nacteme
          $qStat = MySQLi_query($GLOBALS["DBC"], "SELECT den, nejnizsi_vlhkost
                                FROM tme_denni 
                                WHERE den LIKE '{$rok}-%' AND nejnizsi_vlhkost > 0
                                ORDER BY nejnizsi_vlhkost ASC
                                LIMIT 6");

          if(MySQLi_num_rows($qStat) > 0)
          {

            echo"<table class='rokVDobe'>
                  <tr>
                    <td colspan='2' class='radek'>{$lang['nejnizsivlhkost']}</td>
                  </tr>
                  <tr>
                    <td class='radek'>{$lang['den']}</td>
                    <td class='radek'>{$lang['vlhkost']}</td>
                  </tr>";
    
        
            while($r = MySQLi_fetch_assoc($qStat))
            {
              echo "<tr>
                      <td>".formatDnu($r['den'])."</td>
                      <td>".round($r['nejnizsi_vlhkost'], 2)."%</td>
                    </tr>";
            }
        
            echo "</table>";
          
          }
    
          /////////////////////////////////
          // SLOUPEK
          ////////////////////////////////
        
          // nacteme
          $qStat = MySQLi_query($GLOBALS["DBC"], "SELECT den, AVG(prumer_vlhkost) as prumer
                                FROM tme_denni 
                                WHERE den LIKE '{$rok}-%' AND prumer_vlhkost > 0
                                GROUP BY year(den),month(den)
                                ORDER BY prumer DESC
                                LIMIT 6");
    
          if(MySQLi_num_rows($qStat) > 0)
          {

    
            echo"<table class='rokVDobe'>
                  <tr>
                    <td colspan='2' class='radek'>{$lang['nejvlhcimesice']}</td>
                  </tr>
                  <tr>
                    <td class='radek'>{$lang['mesic']}</td>
                    <td class='radek'>{$lang['prumer']}</td>
                  </tr>";
        
            while($r = MySQLi_fetch_assoc($qStat))
            {
              echo "<tr>
                      <td>".$lang['mesic'.substr($r['den'], 5, 2)]."</td>
                      <td>".round($r['prumer'], 2)."%</td>
                    </tr>";
            }
        
            echo "</table>";
          
          }
    
          /////////////////////////////////
          // SLOUPEK
          ////////////////////////////////
    
        
          // nacteme
          $qStat = MySQLi_query($GLOBALS["DBC"], "SELECT den, AVG(prumer_vlhkost) as prumer
                                FROM tme_denni 
                                WHERE den LIKE '{$rok}-%'  AND prumer_vlhkost > 0
                                GROUP BY year(den),month(den)
                                ORDER BY prumer ASC
                                LIMIT 6");

          if(MySQLi_num_rows($qStat) > 0)
          {

            echo"<table class='rokVDobe'>
                  <tr>
                    <td colspan='2' class='radek'>{$lang['nejsussimesice']}</td>
                  </tr>
                  <tr>
                    <td class='radek'>{$lang['mesic']}</td>
                    <td class='radek'>{$lang['prumer']}</td>
                  </tr>";


            while($r = MySQLi_fetch_assoc($qStat))
            {
              echo "<tr>
                      <td>".$lang['mesic'.substr($r['den'], 5, 2)]."</td>
                      <td>".round($r['prumer'], 2)."%</td>
                    </tr>";
            }

            echo "</table>";

          }

          // konec sloupku

        }


        echo "</td>
        </tr>
        </table>";

    } // konec while

  }
  else
  {
    echo "<p>{$lang['nenidostatecnypocethodnot']}</p>";
  }
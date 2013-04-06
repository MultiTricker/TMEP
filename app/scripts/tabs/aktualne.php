<?php

  // Data pro mereni z dneska
  // Dnes nejnizsi namerena teplota/vlhkost
  $dotaz = MySQL_query("SELECT MIN(teplota) as teplota, MIN(vlhkost) as vlhkost 
                        FROM tme 
                        WHERE kdy >= CAST('".date("Y-m-d")." 00:00:00' AS datetime)
                              AND kdy <= CAST('".date("Y-m-d")." 23:59:59' AS datetime)");
  $nejnizsiDnes = MySQL_fetch_assoc($dotaz);
  // Dnes prumerna teplota/vlhkost
  $dotaz = MySQL_query("SELECT AVG(teplota) as teplota, AVG(vlhkost) as vlhkost 
                        FROM tme 
                        WHERE kdy >= CAST('".date("Y-m-d")." 00:00:00' AS datetime)
                              AND kdy <= CAST('".date("Y-m-d")." 23:59:59' AS datetime)");
  $prumernaDnes = MySQL_fetch_assoc($dotaz);
  // Dnes nejvyssi namerena teplota/vlhkost
  $dotaz = MySQL_query("SELECT MAX(teplota) as teplota, MAX(vlhkost) as vlhkost 
                        FROM tme 
                        WHERE kdy >= CAST('".date("Y-m-d")." 00:00:00' AS datetime)
                              AND kdy <= CAST('".date("Y-m-d")." 23:59:59' AS datetime)");
  $nejvyssiDnes = MySQL_fetch_assoc($dotaz);

  // MIN/AVG/MAX za dnesni den
  echo "<br /><table class='tabulkaVHlavicce'>
          <tr>
            <td class='radekVelky'>&nbsp;<strong>{$lang['dnes']}</strong>&nbsp;</td>";
            $nejnizsiDnes['teplota'] = jednotkaTeploty(round($nejnizsiDnes['teplota'],2), $u, 1);
            $prumernaDnes['teplota'] = jednotkaTeploty(round($prumernaDnes['teplota'],2), $u, 1);
            $nejvyssiDnes['teplota'] = jednotkaTeploty(round($nejvyssiDnes['teplota'],2), $u, 1);
            echo "<td class='radekVetsi'>&nbsp;<strong>{$lang['teplota']}:</strong> {$lang['min2']}: {$nejnizsiDnes['teplota']} | {$lang['prumer']}: {$prumernaDnes['teplota']} | {$lang['max2']}: {$nejvyssiDnes['teplota']}&nbsp;</td>";
            if($vlhkomer == 1)
            {
              $nejnizsiDnes['vlhkost'] = round($nejnizsiDnes['vlhkost'],2);
              $prumernaDnes['vlhkost'] = round($prumernaDnes['vlhkost'],2);
              $nejvyssiDnes['vlhkost'] = round($nejvyssiDnes['vlhkost'],2);
              echo "<td class='radekVetsi'>&nbsp;<strong>{$lang['vlhkost']}:</strong> {$lang['min2']}: {$nejnizsiDnes['vlhkost']}% | {$lang['prumer']}: {$prumernaDnes['vlhkost']}% | {$lang['max2']}: {$nejvyssiDnes['vlhkost']}%&nbsp;</td>"; 
            }
           echo "</tr>
        </table>";

  // Grafy
  if($vlhkomer == 1)
  {

      echo "<div class='graf' id='graf-24-hodin'>"; require "./scripts/grafy/kombinovane/24-hodin.php"; echo "</div>";
      if(kolik("id", "tme") > 4400) { echo "<div class='graf' id='graf-3-dny'>"; require "./scripts/grafy/kombinovane/3-dny.php"; echo "</div>"; }

  }
  else
  {

    echo "<div class='graf' id='graf-4-hodiny-teplota'>"; require './scripts/grafy/teplota/4-hodiny.php'; echo "</div>";
    echo "<div class='graf' id='graf-24-hodin-teplota'>"; require './scripts/grafy/teplota/24-hodin.php'; echo "</div>";
    if(kolik("id", "tme") > 4400) { echo "<div class='graf' id='graf-3-dny-teplota'>"; require './scripts/grafy/teplota/3-dny.php'; echo "</div>"; }

  }

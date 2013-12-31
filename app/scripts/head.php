<?php

  echo "<h1"; if($zobrazitNastaveni == 0){ echo " style='height: 30px;'"; } echo ">".$lang['hlavninadpis'];

  if($zobrazitNastaveni == 1)
  {

  echo "<br>
        <font>
          ".$lang['jazyk'].":
            <a href='".$_SERVER['PHP_SELF']."?ja=cz&amp;je=".$_GET['je']."&amp;nemobile=".$_GET['nemobile']."'><img class=\"vlajka\" title='CZ' alt='CZ'></a>
            <a href='".$_SERVER['PHP_SELF']."?ja=sk&amp;je=".$_GET['je']."&amp;nemobile=".$_GET['nemobile']."'><img class=\"vlajka sk\" title='SK' alt='SK'></a>
            <a href='".$_SERVER['PHP_SELF']."?ja=en&amp;je=".$_GET['je']."&amp;nemobile=".$_GET['nemobile']."'><img class=\"vlajka en\" title='EN' alt='EN'></a>
            <a href='".$_SERVER['PHP_SELF']."?ja=de&amp;je=".$_GET['je']."&amp;nemobile=".$_GET['nemobile']."'><img class=\"vlajka de\" title='DE' alt='DE'></a>
            <a href='".$_SERVER['PHP_SELF']."?ja=ru&amp;je=".$_GET['je']."&amp;nemobile=".$_GET['nemobile']."'><img class=\"vlajka ru\" title='RU' alt='RU'></a>
            <a href='".$_SERVER['PHP_SELF']."?ja=pl&amp;je=".$_GET['je']."&amp;nemobile=".$_GET['nemobile']."'><img class=\"vlajka fl\" title='PL' alt='PL'></a>
            <a href='".$_SERVER['PHP_SELF']."?ja=fr&amp;je=".$_GET['je']."&amp;nemobile=".$_GET['nemobile']."'><img class=\"vlajka fr\" title='FR' alt='FR'></a>
            <a href='".$_SERVER['PHP_SELF']."?ja=fi&amp;je=".$_GET['je']."&amp;nemobile=".$_GET['nemobile']."'><img class=\"vlajka fi\" title='FI' alt='FI'></a>
            <a href='".$_SERVER['PHP_SELF']."?ja=sv&amp;je=".$_GET['je']."&amp;nemobile=".$_GET['nemobile']."'><img class=\"vlajka sv\" title='SV' alt='SV'></a> |
          ".$lang['jednotka'].":
            <a href='".$_SERVER['PHP_SELF']."?je=C&amp;ja=".$_GET['ja']."&amp;nemobile=".$_GET['nemobile']."' title='Celsius'>Celsius</a>,
            <a href='".$_SERVER['PHP_SELF']."?je=F&amp;ja=".$_GET['ja']."&amp;nemobile=".$_GET['nemobile']."' title='Fahrenheit'>Fahrenheit</a>, 
            <a href='".$_SERVER['PHP_SELF']."?je=K&amp;ja=".$_GET['ja']."&amp;nemobile=".$_GET['nemobile']."' title='Kelvin'>Kelvin</a>, 
            <a href='".$_SERVER['PHP_SELF']."?je=R&amp;ja=".$_GET['ja']."&amp;nemobile=".$_GET['nemobile']."' title='Rankine'>Rankine</a>, 
            <a href='".$_SERVER['PHP_SELF']."?je=D&amp;ja=".$_GET['ja']."&amp;nemobile=".$_GET['nemobile']."' title='Delisle'>Delisle</a>, 
            <a href='".$_SERVER['PHP_SELF']."?je=N&amp;ja=".$_GET['ja']."&amp;nemobile=".$_GET['nemobile']."' title='Newton'>Newton</a>, 
            <a href='".$_SERVER['PHP_SELF']."?je=Re&amp;ja=".$_GET['ja']."&amp;nemobile=".$_GET['nemobile']."' title='Reaumur'>Reaumur</a>, 
            <a href='".$_SERVER['PHP_SELF']."?je=Ro&amp;ja=".$_GET['ja']."&amp;nemobile=".$_GET['nemobile']."' title='Romer'>Romer</a> |
            <a href='mobile.php'><img src='images/mobilni-verze.png' border='0' alt='Mobile' title='Mobile' width='16' height='16' class='mobilniIkona'></a>
          </font>";

  }

  echo "</h1>
  
        <div id='tri'>

        <div id='levej'>

          <table width='390' class='tabulkaVHlavicce'>
            <tr class='radek'>
              <td colspan='2' align='center'><b>{$lang['statistika']}</b></td>
            </tr>
            <tr>
              <td align='right'><b>{$lang['umisteni']}</b></td>
              <td>{$umisteni}</td>
            </tr>
            <tr>
              <td align='right'><a href='./scripts/modals/pocetMereni.php?je=".$_GET['je']."&amp;ja=".$_GET['ja']."' class='modal'><b>{$lang['pocetmereni']}</b> <img src='./images/nw.png' title='{$lang['pocetmereni']}'></a></td>
              <td><div class='pocetmereni'>".number_format($pocetMereni['pocet'], 0, "", " ")."</div></td>
            </tr>
            <tr>
              <td align='right'><b>{$lang['merenood']}:</b></td>
              <td>".formatData($pocetMereni['kdy'])."</td>
            </tr>
            <tr>
              <td align='right'><a href='./scripts/modals/nejTeploty.php?je=".$_GET['je']."&amp;ja=".$_GET['ja']."' class='modal'><b>{$lang['nejvyssiteplota']}: <img src='./images/nw.png' title='{$lang['nejvyssiteplota']}'></a></b></td>
              <td>".jednotkaTeploty($nejvyssi['teplota'], $u, 1)." - ".formatData($nejvyssi['kdy'])."</td>
            </tr>
            <tr>
              <td align='right'><a href='./scripts/modals/nejTeploty.php?je=".$_GET['je']."&amp;ja=".$_GET['ja']."' class='modal'><b>{$lang['nejnizsiteplota']}: <img src='./images/nw.png' title='{$lang['nejnizsiteplota']}'></a></b></td>
              <td>".jednotkaTeploty($nejnizsi['teplota'], $u, 1)." - ".formatData($nejnizsi['kdy'])."</td>
            </tr>
          </table>

        </div><!-- konec levejj -->

        <div id='pravejsi'>

          <div class='drivetoutodobouted'>
          <table width='250' class='tabulkaVHlavicce'>
            <tr class='radek'>
              <td colspan='3' align='center'><a href='./scripts/modals/driveToutoDobou.php?je=".$_GET['je']."&amp;ja=".$_GET['ja']."' class='modal'><b>{$lang['drivetoutodobou']}</b> <img src='./images/nw.png' title='{$lang['historie']}'></a></td>
            </tr>";

            // posledni dny do pole
            $dny2 = Array();
            for($a = 1; $a < 6; $a++)
            {
              $dny2[] = date("Y-m-d H:i", mktime(date("H"), date("i"), date("s"), date("m"), date("d")-$a, date("Y")));
            }
  
            // projdeme pole, pro kazdy den a podobnou dobu nalezneme teplotu a vypiseme        
            for($a = 0; $a < count($dny2); $a++)
            {
  
              $dotaz = MySQLi_query($GLOBALS["DBC"], "SELECT kdy, teplota, vlhkost
                                    FROM tme 
                                    WHERE kdy >= CAST('".substr($dny2[$a], 0, 14)."0' AS datetime)
                                          AND kdy <= CAST('".substr($dny2[$a], 0, 14)."9' AS datetime)
                                    LIMIT 1");
              $hod = MySQLi_fetch_assoc($dotaz);
  
              echo "<tr>
                      <td align='center'>".formatDnu($dny2[$a])."</td>
                      <td align='center'><abbr title='".substr($hod['kdy'], 11, 5)."'>".jednotkaTeploty($hod['teplota'], $u, 1)."</abbr></td>";
                      if($vlhkomer == 1){ echo "<td align='center'>".($hod['vlhkost'] != 0 ? "{$hod['vlhkost']}%" : "-")."</td>"; }
                    echo "</tr>";

            }

         echo "</table>
          </div>
         
        </div>

        <div id='pravej'>

        <div class='ajaxrefresh'>
          <div class='aktualne".($vlhkomer == 1 ? "" : "jen")." {$vyvoj}".($vlhkomer == 1 ? "" : "jen")."'>
            {$lang['aktualniteplota']}<br>
            <font class='aktua'>".jednotkaTeploty($posledni['teplota'], $u, 1)."</font><br>".formatData($posledni['kdy'])."
          </div>";
          if($vlhkomer == 1)
          {
            echo "<div class='aktualnemensi {$vyvojv}'>
              {$lang['vlhkost']}:<br>
              <font class='aktuamens'>{$posledni['vlhkost']}%</font>
            </div>";

            echo "<div class='aktualnemensi {$vyvojrb}'>
              {$lang['rosnybod']}:<br>
              <font class='aktuamens'>".jednotkaTeploty(rosnyBod($posledni['teplota'], $posledni['vlhkost']), $u, 1)."</font>
            </div>";

          }
        echo "</div>
        
              </div><!-- konec pravejj -->

        </div><!-- konec tri -->";
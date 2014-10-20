<?php

  // jednoduche osetreni vstupu
  if(strlen($_GET['jenden']) > 10 OR !is_numeric(substr($_GET['jenden'], 0 , 4)) OR !is_numeric(substr($_GET['jenden'], 5 , 2)))
  {$_GET['jenden'] = date("Y-m-d", mktime(date("H"), date("i"), date("s"), date("m"), date("d")-1, date("Y"))); }
  if(strlen($_GET['rozsahod']) > 10 OR !is_numeric(substr($_GET['rozsahod'], 0 , 4)) OR !is_numeric(substr($_GET['rozsahod'], 5 , 2)))
  { $_GET['rozsahod'] = date("Y-m-d", mktime(date("H"), date("i"), date("s"), date("m"), date("d")-2, date("Y"))); }
  if(strlen($_GET['rozsahdo']) > 10 OR !is_numeric(substr($_GET['rozsahdo'], 0 , 4)) OR !is_numeric(substr($_GET['rozsahdo'], 5 , 2)))
  { $_GET['rozsahdo'] = date("Y-m-d", mktime(date("H"), date("i"), date("s"), date("m"), date("d")-1, date("Y"))); }

  // formular pro den
  echo "<form method='GET' action='{$_SERVER['PHP_SELF']}#historie'>
          <fieldset>
          <legend>{$lang['zobrazitden']}</legend>
          <input type='hidden' name='ja' value='{$_GET['ja']}'>
          <input type='hidden' name='je' value='{$_GET['je']}'>
          <input type='hidden' name='typ' value='0'>
          <p>
            <label for='jenden'>{$lang['den']}:</label> <input type='text' name='jenden' id='jenden' value='{$_GET['jenden']}'>
            <input type='submit' class='submit' name='odeslani' value='{$lang['zobrazit']}'>
          </p>
          </fieldset>
        </form>";

  // odesilame a chceme zobrazit den
  if(isset($_GET['odeslani']) && $_GET['typ'] == 0)
  {

    $q = MySQLi_query($GLOBALS["DBC"], "SELECT den, mereni, MIN(nejnizsi), MAX(nejvyssi), AVG(prumer),
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
                                        WHERE den = '{$_GET['jenden']}'
                                        GROUP BY den;");

    if(MySQLi_num_rows($q) == 0)
    {
      echo "<p>{$lang['nenalezenyzaznam']}</p>";
    }
    else
    {

      $r = MySQLi_fetch_assoc($q);

      echo "<table class='tabulkaVHlavicce'>
            <tr>
              <td class='radekVelky' colspan='4'>".formatDnu($_GET['jenden'])." <font class='mensi'>({$lang['mereni']}: {$r['mereni']})</font></td>
            </tr>
            </table>
            <center>";

        // Grafy
        echo "<div class='graf' id='graf-historie-teplota'>"; require './scripts/grafy/teplota/historie.php'; echo "</div>";

        if($vlhkomer == 1 && $r['MIN(nejnizsi_vlhkost)'] != 0)
        {
          echo "<div class='graf' id='graf-historie-vlhkost'>"; require './scripts/grafy/vlhkost/historie.php'; echo "</div>";
        }

        // Hodinovky
        echo "<table class='tabulkaVHlavicce'>
              <tr class='radekVelky zelenyRadek'>
                <td colspan='5'>{$lang['hodnotynamerenevjednotlivychdobach']}</td>
              </tr>";

        for($a = 0; $a < 24; $a++)
        {

          $min = "MIN({$a}nejnizsi)";
          $avg = "AVG({$a}prumer)";
          $max = "MAX({$a}nejvyssi)";

          echo "<tr>
                  <td style='border-bottom: 1px solid darkgrey';"; if($vlhkomer == 1 && $r['MIN(nejnizsi_vlhkost)'] != 0){ echo " rowspan='2'"; } echo ">{$lang['doba']} {$a}:00 - {$a}:59</td>
                  <td width='100' style='border-bottom: 1px solid darkgrey'>{$lang['teplota']}:</td>
                  <td style='border-bottom: 1px solid darkgrey'>MIN: ".jednotkaTeploty(round($r[$min], 2), $u, 1)."</td>
                  <td style='border-bottom: 1px solid darkgrey'>AVG: ".jednotkaTeploty(round($r[$avg], 2), $u, 1)."</td>
                  <td style='border-bottom: 1px solid darkgrey'>MAX: ".jednotkaTeploty(round($r[$max], 2), $u, 1)."</td>
                </tr>";

          if($vlhkomer == 1 && $r['MIN(nejnizsi_vlhkost)'] != 0)
          {

            $min = "MIN({$a}nejnizsi_vlhkost)";
            $avg = "AVG({$a}prumer_vlhkost)";
            $max = "MAX({$a}nejvyssi_vlhkost)";

            echo "<tr>
                    <td style='border-bottom: 1px solid darkgrey'>{$lang['vlhkost']}:</td>
                    <td style='border-bottom: 1px solid darkgrey'>MIN: ".round($r[$min], 2)."%</td>
                    <td style='border-bottom: 1px solid darkgrey'>AVG: ".round($r[$avg], 2)."%</td>
                    <td style='border-bottom: 1px solid darkgrey'>MAX: ".round($r[$max], 2)."%</td>
                  </tr>";

          }

        }

        echo "</table>";

      // V prubehu let
      echo "<table class='tabulkaVHlavicce'>
              <tr>
                <td class='radekVelky' colspan='5'>{$lang['namerenehodnotyvprubehulet']}</td>
              </tr>";

      $qL = MySQLi_query($GLOBALS["DBC"], "SELECT den, mereni, MIN(nejnizsi), MAX(nejvyssi), AVG(prumer),
                                                    MIN(nejnizsi_vlhkost), MAX(nejvyssi_vlhkost), AVG(prumer_vlhkost)
                                             FROM tme_denni
                                             WHERE den LIKE '%-".substr($_GET['jenden'], 5, 6)."'
                                             GROUP BY den;");

      while($t = MySQLi_fetch_assoc($qL))
      {

        echo "<tr class='modryRadek'>
          <td class='radek' colspan='5'>&nbsp;&nbsp;".formatDnu($t['den'])."</td>
        </tr>";


        echo "<tr'>
          <td style='border-bottom: 1px solid darkgrey' width='100'><b>{$lang['teplota']}:</b></td>
          <td style='border-bottom: 1px solid darkgrey'><b>MIN:</b> ".jednotkaTeploty(round($t['MIN(nejnizsi)'], 2), $u, 1)."</td>
          <td style='border-bottom: 1px solid darkgrey'><b>AVG:</b> ".jednotkaTeploty(round($t['AVG(prumer)'], 2), $u, 1)."</td>
          <td style='border-bottom: 1px solid darkgrey'><b>MAX:</b> ".jednotkaTeploty(round($t['MAX(nejvyssi)'], 2), $u, 1)."</td>
        </tr>";

        if($vlhkomer == 1 && $r['MIN(nejnizsi_vlhkost)'] != 0)
        {

          echo "<tr>
                    <td>{$lang['vlhkost']}:</td>
                    <td>MIN: ".round($t['MIN(nejnizsi_vlhkost)'], 2)."%</td>
                    <td>AVG: ".round($t['AVG(prumer_vlhkost)'], 2)."%</td>
                    <td>MAX: ".round($t['MAX(nejvyssi_vlhkost)'], 2)."%</td>
                  </tr>";

        }

      }

      echo "</table>";

      echo "</center>";

    }

  }
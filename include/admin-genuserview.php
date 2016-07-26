<?php
include_once('function.php');
include_once('bdd.php');
include_once('admin-function.php');
user::check_admin();
$userid    = $_REQUEST['user'];
$cachem    = explode("-", $_REQUEST['begindate']);
$cachem2   = explode("-", $_REQUEST['enddate']);
$month     = array(
    $cachem[1],
    $cachem2[1]
);
$year      = array(
    $cachem[0],
    $cachem2[0]
);
$begindate = $cachem[1] . '-' . $cachem[0];
$enddate   = $cachem2[1] . '-' . $cachem2[0];
$bdd       = new bdd();
$array     = array(
    $begindate,
    $enddate,
    $userid
);
$array2    = array(
    $userid
);
$bdd->cache("select sum(a.nb) as nb, a.id_cat, b.nom from heure a, categorie b where DATE_FORMAT(a.date, '%m-%Y')>=? and DATE_FORMAT(a.date, '%m-%Y')<=? and a.id_user=? and b.id=a.id_cat group by a.id_cat ", $array);
$result    = $bdd->exec();
$bdd->cache("select sum(a.nb) as nb, a.id_cat, c.nom from heure a, categorie b , domaine c where DATE_FORMAT(a.date, '%m-%Y')>=? and DATE_FORMAT(a.date, '%m-%Y')<=? and a.id_user=? and b.id=a.id_cat and b.id_domaine=c.id group by c.id", $array);
$domaine   = $bdd->exec();
$user      = list_user($userid);
if(!empty($user[0][0])){
    $user      = $user[0][0];
    $bdd->cache('select * from heure_sup where id_user=?', $array2);
    $hs        = $bdd->exec();

    ?>

    <div id="container"  class="col-md-4" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>

    <script>
    $(function () {

        $(document).ready(function () {

            // Build the chart
            $('#container').highcharts({
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: 'Export des catégories pour l\'utilisateur <?php
    echo $user['prenom'] . " " . $user['nom'] . " du " . $begindate . " au " . $enddate;
    ?> '
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: false
                        },
                        showInLegend: true
                    }
                },
                series: [{
                    name: 'Brands',
                    colorByPoint: true,

                    data: [

    <?php
    $result = $result[0];
    $all    = 0;
    for ($i = 0; $i < count($result); $i++) {
        $all = $all + $result[$i]['nb'];
    }

    for ($i = 0; $i < count($result); $i++) {
        $percent = 0;
        $percent = ($result[$i]['nb'] * 100) / $all;
        echo "
        {   
                        name: '" . $result[$i]['nom'] . "',
                        y: " . $percent . "
                    },";
    }

    ?>
                     ]
                }]
            });
        });
    });
        </script>
        
         <div class="col-md-8">
            <div id="chart3" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
            
        </div>
        <div id="chart2" class="col-md-4" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>

    <script>
    $(function () {

        $(document).ready(function () {

            // Build the chart
            $('#chart2').highcharts({
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: 'Export des domaines pour l\'utilisateur <?php
    echo $user['prenom'] . " " . $user['nom'] . " du " . $begindate . " au " . $enddate;
    ?> '
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: false
                        },
                        showInLegend: true
                    }
                },
                series: [{
                    name: 'Brands',
                    colorByPoint: true,

                    data: [

    <?php
    $domaine = $domaine[0];
    $all     = 0;
    for ($i = 0; $i < count($result); $i++) {
        $all = $all + $result[$i]['nb'];
    }

    for ($i = 0; $i < count($domaine); $i++) {
        $percent = 0;
        $percent = ($domaine[$i]['nb'] * 100) / $all;
        echo "
        {   
                        name: '" . $domaine[$i]['nom'] . "',
                        y: " . $percent . "
                    },";
    }

    ?>
                     ]
                }]
            });
        });
    });
        </script>
        <?php

    $bdd->cache("select sum(nb) as nb from heure where DATE_FORMAT(date, '%m-%Y')>=? and DATE_FORMAT(date, '%m-%Y')<=? and id_user=?", $array);
    $result    = $bdd->exec();
    $nbj       = number_day($month, $year, 'a');
    $bm        = $cachem[1];
    $by        = $cachem[0];
    $em        = $cachem2[1];
    $ey        = $cachem2[0];
    $mm        = array(
        $em,
        $em
    );
    $yy        = array(
        $ey,
        $ey
    );
    $nbem      = number_day($mm, $yy, 'a');
    $mm        = "";
    $yy        = "";
    $mm        = array(
        $bm,
        $bm
    );
    $yy        = array(
        $by,
        $by
    );
    $nbjtm     = number_day($mm, $yy, 'a');
    $nbweekmem = "";
    $compt     = 0;
    $enddate   = new DateTime($ey . '-' . $em . '-' . addzero($nbem));
    $datebm    = new DateTime($by . '-' . $bm . '-01');

    for ($y = $by; $y <= $ey; $y++) {
        
        $yy = array(
            $y,
            $y
        );
        for ($e = 1; $e <= $nbj; $e++) {
            $o = addzero($e - 1);
            if ($e > $nbjtm) {
                if ($enddate >= $datebm) { //si e est superieur au nombre de jour dans le mois alor on passe au mois suivant
                    if (intval($bm) < 12) { //si mois inferieur a 12
                        $bm++;
                        $mm    = array(
                            $bm,
                            $bm
                        );
                        $nbjtm = number_day($mm, $yy, 'a');
                        
                        $datebm = new DateTime($y . '-' . $bm . '-' . addzero($e));
                        $e      = 1;
                    } else { //changement d'anné
                        $bm = '01';
                        $by++;
                        $y++;
                        $yy     = array(
                            $y,
                            $y
                        );
                        $mm     = array(
                            $bm,
                            $bm
                        );
                        $nbjtm  = number_day($mm, $yy, 'a');
                        $e      = 1;
                        $o      = $e;
                        $datebm = new DateTime($y . '-' . $bm . '-' . addzero($e));
                    }
                } else {
                    $week[$compt - 1]['end'] = $y . '-' . $bm . '-' . addzero($e);
                    break;
                }
            }
            $dd     = $by . '-' . $bm . '-' . addzero($e);
            $nbweek = date("W", strtotime($dd));
            if ($nbweek != $nbweekmem) {
                $nbweekmem               = $nbweek;
                $week[$compt - 1]['end'] = $y . '-' . $bm . '-' . addzero($o);
                $week[$compt]['begin']   = $dd;
                $week[$compt]['number']  = $nbweek;
                $compt++;
            }
        }
    }
    $y = $y - 1;
    //echo $dd;
    if ($_REQUEST['begindate'] == $_REQUEST['enddate']) {
        $week[$compt - 1]['end'] = $dd;
    } else {
        $week[$compt - 1]['end'] = $y . '-' . $bm . '-' . addzero($e);
    }
    if(isset($hs[0][0]['heure']) and $hs[0][0]['heure']!=''){
    $hs = $hs[0][0]['heure'];
    } else {
        $hs=0; 
    }

    $hs = sectohour($hs);
    ?>
       
        <div class="col-md-8">
        <?php
    $hourcontrat = contrat2hour($user['pourcent']);

    $seccontrat = hourtosec($hourcontrat . ':00');
    echo '<h4> Cet utilisateur à un contrat de ' . $hourcontrat . ' heures et dispose de ' . $hs['h'] . 'h' . $hs['m'] . 'heure d\'heure suplémentaire</h4>';
    ?>
        </div>
    <div class="col-md-8">
      <table class="table">
        <thead>
          <tr>
            <th>Numero de la semaine</th>
            <th>Nombre de jours ouvrés dans la semaine</th>
            <th>debut de la semaine</th>
            <th>fin de la semaine</th>
            <th>nombre d'heure</th>
            <th>heure(s) suplémentaire(s)</th>
          </tr>
        </thead>
        <tbody>
        <?php
    for ($e = 0; $e <= count($week) - 2; $e++) {
        $nbnonferie  = datediff($week[$e]['begin'], $week[$e]['end']); //nombre de jour non ferié dans la semaien traitée
        $hourcontrat = contrat2hour($user['pourcent']);
        //echo $nbnonferie.'-----'.$hourcontrat.'-----------------'.hourtosec($hourcontrat.':00');
        
        // $seccontrat=$seccontrat*$nbnonferie;
        
        $hourcontrat = ((7 * $nbnonferie) * $user['pourcent']) / 100;
        $seccontrat  = hourtosec($hourcontrat . ':00');
        $array       = array(
            $userid,
            $week[$e]['begin'],
            $week[$e]['end']
        );
        //print_r($array).'<br>';
        $bdd->cache("select sum(nb) as nb from heure where id_user=? and date between ? and ?", $array);
        $week_hour   = $bdd->exec();
        
        
        $hour    = sectohour($week_hour[0][0]['nb']);
        //echo $week_hour[0][0]['nb'];
        $heure_s = sectohour($week_hour[0][0]['nb'] - $seccontrat);
        //echo $week_hour[0][0]['nb'].'-'.$seccontrat.'='.$heure_s.'<br>';
        //echo intval($heure_s / 3600);
        
        
        $h1 = $hour['h'] . 'h' . $hour['m'] . 'min' . $hour['s'];
        $h2 = $heure_s['h'] . 'h' . $heure_s['m'] . 'min' . $heure_s['s'];
        if (date('Y-W') < date('Y-W', strtotime($week[$e]['begin']))) {
            $h1 = "à venir";
            $h2 = "à venir";
            
        }
        if (date('Y-W') == date('Y-W', strtotime($week[$e]['begin']))) {
            $h1 = "en cour";
            $h2 = "en cour";
            
        }
        
        if ($hourcontrat >= $hour['h'] - 5 and $hourcontrat <= $hour['h'] + 5) {
            $s = 'class="success"';
        }
        if ($hour['h'] >= ($hourcontrat + 5)) {
            $s = 'class="danger"';
        }
        if ($hour['h'] <= ($hourcontrat - 5)) {
            $s = 'class="danger"';
        }
        if ($h1 == "à venir" or $h1 == "en cour") {
            $s = 'class="success"';
        }
        echo '<tr ' . $s . ' >
                        <td>' . $week[$e]['number'] . '</td>
                        <td>' . $nbnonferie . '</td>
                        <td>' . $week[$e]['begin'] . '</td>
                        <td>' . $week[$e]['end'] . '</td>
                        <td>' . $h1 . '</td>
                        <td>' . $h2 . '</td>
                      </tr>';
        
        $hour_seq2[$e] = $hour['h'] . '.' . mintodec($hour['m']);
        $hour_seq[$e]  = $hour['h'];
        
    }

    $t       = array(
        $userid
    );
    $bdd->cache("select avg(nb) as nb from heure where id_user=? ", $t);
    $all_moy = $bdd->exec();
    $z       = 0;
    for ($n = 0; $n < $e; $n++) {
        $z += $hour_seq2[$n];
    }
    $z = $z / $n;

    ?>



        </tbody>
      </table>
    </div>
    <script type="text/javascript">
                $(function () {
        $('#chart3').highcharts({
            title: {
                text: '',
                x: -20 //center
            },
            subtitle: {
                text: '',
                x: -20
            },
            xAxis: {
                categories: [<?php
    for ($e = 0; $e <= count($week) - 2; $e++) {
        echo "'semaine" . $week[$e]['number'] . "',";
    }
    ?>]
            },
            yAxis: {
                title: {
                    text: 'Heures'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: 'heures'
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series: [{
                name: 'Moyenne sur  la <br>periode demander',
                data: [<?php
    echo $z;
    for ($n = 1; $n < $e; $n++) {
        echo ',' . $z;
    }
    ?>]
            }, {
                name: 'Moyenne utilisateur',
                data: [<?php
    $oo = sectohour($all_moy[0][0]['nb']);
    echo $oo['h'] . '.' . mintodec($oo['m']);
    for ($n = 1; $n < $e; $n++) {
        $oo = sectohour($all_moy[0][0]['nb']);
        echo ',' . $oo['h'] . '.' . mintodec($oo['m']);
    }
    ?>]
            }, {
                name: 'Periode demandée',
                data: [ <?php
    echo $hour_seq2[0];
    for ($n = 1; $n < $e; $n++) {
        echo ',' . $hour_seq2[$n];
    }
    ?>]
            }]
        });
    });
            </script>
    <?php
} else {
    echo 'pas de données pour cet utilisateur';
}
?>
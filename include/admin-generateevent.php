<?php
include_once('./function.php');
include_once('./autoload.php');
include_once('./admin-function.php');
user::check_admin();
    $bdd = new bdd();
    $bdd->cache('select a.id as id,a.begin as begin, a.end as end, b.nom as nom, b.prenom as prenom, c.nom as type from conge a, users b, motif c where a.id_user=b.id and a.id_motif=c.id and a.state!=0 and a.state!=10', '');
    $result = $bdd->exec();
    echo '<?xml version="1.0"?>
            <monthly>';
    for ($i = 0; $i < count($result); $i++) {
        $begin = explode(" ", $result[$i]['begin']);
        $end   = explode(" ", $result[$i]['end']);
        $o     = $i + 1;
        $p     = random_color();
        echo '<event>
                <id>' . $o . '</id>
                <name>' . $result[$i]['prenom'] . ' ' . $result[$i]['nom'] . ' ' . $result[$i]['type'] . '</name>
                <startdate>' . $begin[0] . '</startdate>
                <enddate>' . $end[0] . '</enddate>
                <starttime>' . $begin[1] . '</starttime>
                <endtime>' . $end[1] . '</endtime>
                <color>#' . $p . '</color>
                <url></url>
            </event>';
        
    }
    echo '</monthly>';

<?php
function sendmail($to,$subject,$messagetxt,$messagehtml){
  $mail = $to; // D?claration de l'adresse de destination.
if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
{
	$passage_ligne = "\r\n";
}
else
{
	$passage_ligne = "\n";
}
//=====D?claration des messages au format texte et au format HTML.
$message_txt = $messagetxt;
$message_html = '<html><head></head><body>'.$messagehtml.'</body></html>';
//==========

//=====Cr?ation de la boundary
$boundary = "-----=".md5(rand());
//==========

//=====D?finition du sujet.
$sujet = $subject;
//=========

//=====Cr?ation du header de l'e-mail.
$header = "From: \"TRISKEM - Gestion du temps\"<time@triskem.fr>".$passage_ligne;
$header.= "Reply-to: \"TRISKEM - Gestion du temps\" <time@triskem.fr>".$passage_ligne;
$header.= "MIME-Version: 1.0".$passage_ligne;
$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
//==========

//=====Cr?ation du message.
$message = $passage_ligne."--".$boundary.$passage_ligne;
//=====Ajout du message au format texte.
$message.= "Content-Type: text/plain; charset=\"utf-8\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_txt.$passage_ligne;
//==========
$message.= $passage_ligne."--".$boundary.$passage_ligne;
//=====Ajout du message au format HTML
$message.= "Content-Type: text/html; charset=\"utf-8\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_html.$passage_ligne;
//==========
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
//==========

//=====Envoi de l'e-mail.
mail($mail,$sujet,$message,$header);

//==========
}
function last_time($id, $date)
{
    $bdd    = new bdd;
    $data   = array(
        $id
    );
     $bdd->cache("SELECT id, es, DATE_FORMAT(`temps`, '%d %M %Y') AS date, DATE_FORMAT(temps, '%H:%i') AS time, temps FROM `es` WHERE cast(temps as date)='" . $date . "' and id_user=? order by temps asc", $data);
     $result = $bdd->exec();
    return $result;
}
function current_semaine($n, $o, $y=0)
{
    date_default_timezone_set('Europe/Paris');
    $jour = array(
        "Dimanche",
        "Lundi",
        "Mardi",
        "Mercredi",
        "Jeudi",
        "Vendredi",
        "Samedi"
    );
    if (!empty($i)) {
    } else {
        $w = date('W');
    }
    $w    = date('W'); // Pour la 7 ème semaine à rechercher
    if($y!=0){
    $year=$y;
    } else {
      $year = date('Y');
    }
    for ($i = 1; $i <= 365; $i++) {
        $week = date("W", mktime(0, 0, 0, 1, $i, $year));
        if (isset($o) and $o != 0) {
            $w = $o;
        }
        
        $semaine['n'] = $w;
        if ($week == $w) {
            // Ensuite pour afficher tous les (jour)s de la semaine
            for ($d = 0; $d < 7; $d++) {
                //echo $i+$d;
                $semaine['jour'][$d]   = jour($i + $d, $year);
                $semaine['numero'][$d] = date("d", mktime(0, 0, 0, 1, $i + $d, $year));
                $semaine['mois'][$d]   = month(date("n", mktime(0, 0, 0, 1, $i + $d, $year)));
                $semaine['mois2'][$d]  = date("m", mktime(0, 0, 0, 1, $i + $d, $year));
                $semaine['annee'][$d]  = $year;
                $date                  = $semaine['annee'][$d] . '-' . $semaine['mois2'][$d] . '-' . $semaine['numero'][$d];
                $semaine['date'][$d]   = $semaine['numero'][$d] . '-' . $semaine['mois2'][$d] . '-' . $year;
                $semaine['date2'][$d]  = $year . '-' . $semaine['mois2'][$d] . '-' . $semaine['numero'][$d];
                $result                = last_time($n, $date);
                $semaine[$d]           = $result[0];
            }
            return $semaine;
            break;
        }
    }
}
function transfere($date, $id, $provenance)
{
    $bdd    = new bdd();
    $array  = array(
        $id,
        $date
    );
    $bdd->cache("select a.nb as nb, b.nom as cat, a.id as id from heure a, categorie b where a.id_cat=b.id and id_user=? and DATE_FORMAT(`date`, '%Y-%m-%d')=?  ", $array);
    $result = $bdd->exec();
    $result = $result[0];
    if (isset($result[0]['nb'])) {
        echo '<div class="col-md-6"></div><div class="col-md-6"><input type="time" class="form-control" id="nb_transf"/></div><br><br>';
        echo '<div class="col-md-6"><select id="de" class="form-control">';
        $compteur = count($result);
        for ($i = 0; $i < $compteur; $i++) {
            $nb = sectohour($result[$i]['nb']);
            echo '<option value="' . $result[$i]['id'] . '" max="' . $nb['h'] . ':' . $nb['m'] . '">de ' . $result[$i]['cat'] . ' ( ' . $nb['h'] . 'h' . $nb['m'] . ' disponible ) </option>';
        }
        echo '</select></div>';
        $bdd->cache('select * from categorie', '');
        $cat = $bdd->exec();
        echo '<div class="col-md-6"><select id="vers" class="form-control">';
        $compteur2 = count($cat);
        for ($i = 0; $i < $compteur2; $i++) {
            echo '<option value="' . $cat[$i]['id'] . '">vers ' . $cat[$i]['nom'] . '</option>';
        }
        echo '</select></div><br><br>';
        if ($provenance == 1) {
            $v = 'onclick="valid_transfere_user();"';
        }
        if ($provenance == 10) {
            $v = 'onclick="valid_transfere();"';
        }
        echo '<input id="valid_transfere" ' . $v . ' type="button" value="valider le changement" class="col-md-offset-4 col-md-4 btn btn-primary">';
    } else {
        echo '<br>pas de temps sur ce jour la avec cet utilisateur';
    }
}
function transfere_v($id, $date, $user, $time, $vers, $de)
{
    $bdd    = new bdd();
    $array  = array(
        $de
    );
    $bdd->cache("select nb from heure where id=?", $array);
    $result = $bdd->exec();
    $time   = hourtosec($time);
    if ($time <= $result[0][0]['nb']) {
        $futur  = $result[0][0]['nb'] - $time;
        $array2 = array(
            $user,
            $time,
            $vers,
            $date
        );
        if ($futur > 0) {
            $array1 = array(
                $futur,
                $de
            );
            $bdd->cache('update heure set nb=? where id=?', $array1);
        } else {
            $array1 = array(
                $de
            );
            $bdd->cache('delete from heure where id=?', $array1);
        }
        $bdd->cache("INSERT INTO `heure`( `id_user`, `nb`, `id_cat`, `date`) VALUES (?,?,?,?)", $array2);
        $bdd->exec();
        echo '<div style="border:solid 2px green;background:lightgreen;color:green;padding:1em;display:inline-block" class="droid"> '.$futur.'heure modifié avec succès</div>';
    } else {
        echo '<div style="border:solid 2px red; background:pink;color:red;padding:1em;display:inline-block" class="droid">le temps est sans doute trop élevé</div>';
    }
}
function month($i)
{
    $mois = array(
        "",
        "Janvier",
        "Février",
        "Mars",
        "Avril",
        "Mai",
        "Juin",
        "Juillet",
        "Août",
        "Septembre",
        "Octobre",
        "Novembre",
        "Décembre"
    );
    return $mois[$i];
}
function jour($m, $year)
{
    $i    = date("w", mktime(0, 0, 0, 1, $m, $year));
    $jour = array(
        "Dimanche",
        "Lundi",
        "Mardi",
        "Mercredi",
        "Jeudi",
        "Vendredi",
        "Samedi"
    );
    return $jour[$i];
}
function arriver($id, $time)
{
    date_default_timezone_set('Europe/Paris');
    $bdd    = new bdd;
    $data   = array(
        'e',
        $id,
        $time
    );
    $bdd->cache('insert into `es`( `es`, `id_user`, `temps`) VALUES(  ?, ?, ?) ', $data);
    $result = $bdd->exec();
}
function partir($id, $time)
{
    date_default_timezone_set('Europe/Paris');
    $bdd    = new bdd;
    $data   = array(
        's',
        $id,
        $time
    );
    $bdd->cache('insert into `es`( `es`, `id_user`, `temps`) VALUES(  ?, ?, ?) ', $data);
    $result = $bdd->exec();
}
function calcul_time($h1)
{
    $spend = 0;
    $table = array();
    for ($p = 1; $p < count($h1); $p++) {
        $i                = $p - 1;
        $spend            = $spend + ($h1[$p] - $h1[$i]);
        $table['heure']   = intval($spend / 3600);
        $table['minutes'] = intval(($spend % 3600) / 60);
        $table['second']  = intval((($spend % 3600) % 60));
        $p++;
    }
    return $table;
}
function contrat2hour($pourcent)
{
    $a = $pourcent / 100;
    $a = $a * 35;
    return $a;
}
function number_day($month, $year, $a)
{
    date_default_timezone_set('Europe/Paris');
    $number = 'error';
    if (!is_array($month) and !is_array($year)) {
        $number = cal_days_in_month(CAL_GREGORIAN, $month, $year); // 3
    }
    if (is_array($month) and is_array($year) and count($month) == count($year)) {
        $r         = cal_days_in_month(CAL_GREGORIAN, $month[1], $year[1]); // 3
        $datetime0 = new DateTime($year[0] . '/' . $month[0] . '/01');
        $datetime1 = new DateTime($year[1] . '/' . $month[1] . '/' . $r);
        $interval  = $datetime0->diff($datetime1);
        $number    = $interval->format('%' . $a);
            if($month[0] == $month[1] and $year[0] == $year[1]){
            $number    = $r;
        }
    }
    return $number;
}
function add_mouvement($id, $sens, $heure, $url)
{
    $mouv    = last_mouvement($id, $heure); //recuperation du dernier mouvement
    $bdd     = new bdd(); //check que le dernier mouvement passer n'était pas identique
    $array   = array(
        $_SESSION['userid']
    );
    $bdd->cache('select es, temps from es where id_user=? ORDER BY id DESC  limit 1', $array);
    $verif   = $bdd->exec();
    $verif   = $verif[0];
    $invalid = false;
    if(isset($verif[0]['es']) and isset($verif[0]['temps'])){
        if ($verif[0]['es'] == $sens and strtotime($verif[0]['temps']) == strtotime($heure)) {
            $invalid = true;
        }
    }
    if (!$invalid) { //check identique
        if ($sens == "e" and ($mouv == 's' or empty($mouv))) { //check coérence du mouvement
            arriver($_SESSION['userid'], $heure);
            echo '<div style="border:solid 2px green;background:lightgreen;color:green;padding:1em;display:inline-block" class="droid"> horaires mis à jour avec succès' . $url . '</div><meta http-equiv="refresh" content="2; URL=' . $url . '"><SCRIPT LANGUAGE="JavaScript">document.location.href="' . $url . '"</SCRIPT>';
        } elseif ($sens == "s" and $mouv == 'e') {
            partir($_SESSION['userid'], $heure);
            echo '<div style="border:solid 2px green;background:lightgreen;color:green;padding:1em;display:inline-block" class="droid"> horaires mis à jour avec succès</div><meta http-equiv="refresh" content="2; URL=' . $url . '"><SCRIPT LANGUAGE="JavaScript">document.location.href="' . $url . '"</SCRIPT>';
        } else {
            echo '<div style="border:solid 2px red; background:pink;color:red;padding:1em;display:inline-block" class="droid">erreur : il est possible que le sens ne soit pas correct</div>';
        }
    }
}
function last_mouvement($id, $date)
{
    $bdd    = new bdd();
    $array  = array(
        $id,
        $date,
        $date,
        $date
    );
    $bdd->cache("select es from es where id_user=? and cast(temps as date)<? and DATE_FORMAT(temps, '%d-%m-%Y')=DATE_FORMAT(?, '%d-%m-%Y') and DATE_FORMAT(temps, '%d-%m-%Y %H:%i:%s')<DATE_FORMAT(?, '%d-%m-%Y %H:%i:%s') order by temps desc limit 0, 1", $array);
    $result = $bdd->exec();
    if (isset($result[0][0]['es'])) {
        $resultat = $result[0][0]['es'];
    } else {
        $resultat = '';
    }
    return $resultat;
}
function del_mouvement($id_mouv, $id_user, $url)
{
    $bdd   = new bdd();
    $array = array(
        $id_mouv,
        $id_user
    );
    $bdd->cache('delete from es where id=? and id_user=?', $array);
    $bdd->exec();
    echo '<div style="border:solid 2px green;background:lightgreen;color:green;padding:1em;display:inline-block" class="droid"> horaires mis à jour avec succès</div><meta http-equiv="refresh" content="2; URL=' . $url . '"><SCRIPT LANGUAGE="JavaScript">document.location.href="' . $url . '"</SCRIPT>';
}
function check_exist($o)
{
    $bdd   = new bdd();
    $array = array(
        $o
    );
    $bdd->cache('select * from users where username=?', $array);
    $p     = $bdd->exec();
    if (count($p[0]) >= 1) {
        $resultat = true;
    }
    if (count($p[0]) < 1) {
        $resultat = false;
    }
    return $resultat;
}
function list_cat($v = 1, $user = NULL)
{
    $bdd = new bdd();
    if ($v == 1) {
        $bdd->cache('select * from categorie', '');
        $resultat = $bdd->exec();
    }
    if ($v == 2) {
        $bdd->cache('SELECT * FROM categorie a left outer join (SELECT a.id_cat as id_cat, count(a.id_cat)*100/(select count(id_cat) from heure where id_user=? and now() > (NOW() - INTERVAL 2 WEEK)) as val FROM `heure` a, categorie b WHERE id_user=? and a.id_cat=b.id group by id_cat order by val desc) b on a.id=b.id_cat where 1 order by val desc', array(
            $user,
            $user
        ));
        $result = $bdd->exec();
        $resultat = $result[0];
    }
    return $resultat;


}
function count_hour($date, $version)
{
    $resultat='';
    $bdd   = new bdd();
    $array = array(
        $_SESSION['userid'],
        $date
    );
    if($version==2 or $version==4 or $version==3){
       //  $bdd->cache("select * from heure h where not exists ( select * from motif m where m.id_cat = h.id_cat) and id_user=? and DATE_FORMAT(`date`, '%Y-%m-%d')=? ", $array);
      $bdd->cache("select * from heure h where  id_user=? and DATE_FORMAT(`date`, '%Y-%m-%d')=? ", $array);
         if($version==4){
            $version=1;
         }
     } else {
         $bdd->cache("select * from heure where  id_user=?  and DATE_FORMAT(`date`, '%Y-%m-%d')=? ", $array);
     }
   
    $hour  = $bdd->exec();
    for ($i = 0; $i < count($hour[0]); $i++) {
        $time[] = $hour[0][$i]['nb'];
        $time[] = 0;
    }
    $bdd->cache("select temps from es where id_user=? and DATE_FORMAT(`temps`, '%Y-%m-%d')=? order by temps asc", $array);
    $result = $bdd->exec();
    for ($i = 0; $i < count($result[0]); $i++) {
        $time[] = strtotime($result[0][$i]['temps']);
    }
    if (!empty($time)) {
        $tempspasser = calcul_time($time);
        if (!isset($tempspasser['heure'])) {
            $tempspasser['heure'] = "00";
        }
        if (!isset($tempspasser['minutes'])) {
            $tempspasser['minutes'] = "00";
        }
        if (!isset($tempspasser['second'])) {
            $tempspasser['second'] = "00";
        }
        if ($version == 0) {
            echo 'vous avez ' . $tempspasser['heure'] . 'h' . $tempspasser['minutes'] . 'min' . $tempspasser['second'] . ' à catégoriser pour ce jour';
        }
        if ($version == 1) {
            $return = hourtosec($tempspasser['heure'] . ':' . $tempspasser['minutes']);
            $resultat = $return;
        }
        if ($version == 2) {
            $resultat = $tempspasser;
        }
        if ($version == 3) {
            if (strlen($tempspasser['heure']) < 2) {
                $tempspasser['heure'] = '0' . $tempspasser['heure'];
            }
            if (strlen($tempspasser['minutes']) < 2) {
                $tempspasser['minutes'] = '0' . $tempspasser['minutes'];
            }
            echo json_encode(array(
                'hs' => $tempspasser['heure'] . ':' . $tempspasser['minutes']
            ));
        }
    } else {
        $resultat='';
        if ($version == 0) {
            echo 'il n\'y a pas de temps a catégoriser pour ce jour';
        }
        if ($version == 1) {
            $resultat = 0;
        }
        if ($version == 2) {
            $resultat = 0;
        }
        if ($version == 3) {
            echo json_encode(array(
                'hs' => "00:00"
            ));
        }
    }
    return $resultat;
}
function hourtosec($hour)
{
    $tab    = explode(":", $hour);
    $result = $tab[0] * 3600;
    $result = $tab[1] * 60 + $result;
    return $result;
}
function sectohour($init)
{
    $result['h'] = intval($init / 3600);
    $result['m'] = intval(($init / 60) % 60);
    $result['s'] = $init % 60;
    return $result;
}
function cat_hour($date, $cathour, $nb, $url, $comment)
{
    $nb = hourtosec($nb);
    $i  = count_hour($date, '4');
    $a  = $i - $nb;
    if ($i > 0 and $a >= 0) {
        $bdd = new bdd();
        if ($comment == '') {
            $comment = NULL;
        }
        $array   = array(
            $_SESSION['userid'],
            $nb,
            $cathour,
            $date,
            antixss($comment)
        );
        $bdd->cache('insert into heure set  id_user=?, nb=?, id_cat=?, date=? ,comment=?', $array);
        $bdd->exec();
        echo '<div style="border:solid 2px green;background:lightgreen;color:green;padding:1em;display:inline-block" class="droid"> modification effectuée avec succès</div><meta http-equiv="refresh" content="2; URL=' . $url . '"><SCRIPT LANGUAGE="JavaScript">document.location.href="' . $url . '"</SCRIPT>';
    } else {
        echo '<div style="border:solid 2px red; background:pink;color:red;padding:1em;display:inline-block" class="droid">erreur : le nombre d\'heure entré est probablement trop grand</div>';
    }
}
function getHolidays($year = null)
{
    if ($year === null) {
        $year = intval(strftime('%Y'));
    }
    $easterDate  = easter_date($year);
    $easterDay   = date('j', $easterDate);
    $easterMonth = date('n', $easterDate);
    $easterYear  = date('Y', $easterDate);
    $holidays    = array(
        // Jours feries fixes
        mktime(0, 0, 0, 1, 1, $year), // 1er janvier
        mktime(0, 0, 0, 5, 1, $year), // Fete du travail
        mktime(0, 0, 0, 5, 8, $year), // Victoire des allies
        mktime(0, 0, 0, 7, 14, $year), // Fete nationale
        mktime(0, 0, 0, 8, 15, $year), // Assomption
        mktime(0, 0, 0, 11, 1, $year), // Toussaint
        mktime(0, 0, 0, 11, 11, $year), // Armistice
        mktime(0, 0, 0, 12, 25, $year), // Noel
        // Jour feries qui dependent de paques
        mktime(0, 0, 0, $easterMonth, $easterDay + 1, $easterYear), // Lundi de paques
        mktime(0, 0, 0, $easterMonth, $easterDay + 39, $easterYear) // Ascension
        //mktime(0, 0, 0, $easterMonth, $easterDay + 50, $easterYear), // Pentecote
    );
    sort($holidays);

    return $holidays;
}
function isHoliday($timestamp)
{
    $iDayNum   = date('N', $timestamp);
    $iYear     = strftime('%Y', $timestamp);
    $aHolidays = getHolidays($iYear);
    /*
     * On est oblige de convertir les timestamps en string a cause des decalages horaires.
     */
    $aHolidaysString = array_map(function($value)
    {
        return strftime('%Y-%m-%d', $value);
    }, $aHolidays);

    if (in_array(strftime('%Y-%m-%d', $timestamp), $aHolidaysString) OR $iDayNum == 6 OR $iDayNum == 7) {
        return true;
    }
    return false;
}
function datediff($date1, $date2)
{
    $now       = new DateTime($date2);
    $dateBdd   = new DateTime($date1); //Date de début du type YYYY-MM-DD (date("Y-m-d");
    $Nbrejours = $dateBdd->diff($now)->days;
    $compteur  = 0;
    for ($i = 0; $i <= $Nbrejours; $i++) {
        if (!isHoliday(strtotime($date1 . ' + ' . $i . ' days'))) {
            $compteur++;
        }
    }
    return $compteur;
}
function mintodec($min)
{
    return intval(($min * 100) / 60);
}
function check_conge($id, $idmotif, $raison = 1)
{

    $bdd  = new bdd;
    $bdd->cache('select type from motif where id=? ', array(
        $idmotif
    ));
    $type = $bdd->exec();
    if (isset($type[0][0]['type'])) {
        if ($type[0][0]['type'] == 1) {
            $bdd->cache('select nb_jour from credit_conge where id_user=?', array(
                $id
            ));
            $solde = $bdd->exec();
             if(isset($solde[0][0]['nb_jour'])){
                if ($raison == 0) {
                    return $solde[0][0]['nb_jour'];
                }
                if ($raison == 1) {
                    $a = $solde[0][0]['nb_jour'];
                    if ($a != 0) {
                        $a = $a / 12;
                    }
                    return $a;
                }
            }
        } elseif ($type[0][0]['type'] == 0) {
            $bdd->cache('select heure from heure_sup where id_user=?', array(
                $id
            ));
            $solde = $bdd->exec();
            return $solde[0][0]['heure'] * 3600 * 7;
        }
    }
}
function fnl_of_week($annee, $num)
{
    $dernier_jour = 31;
    do {
        $nb_semaine   = date("W", mktime(0, 0, 0, 12, $dernier_jour, $annee));
        $dernier_jour = $dernier_jour - 1;
    } while ($nb_semaine == '01');
    //La première semaine officielle est celle qui comprend le 4 janvier.
    $semaine                 = mktime(0, 0, 0, 1, 4, $annee);
    //On cherche quel jour est le 4 janvier pour trouver le lundi et le dimanche
    $num_jour_quatre_janvier = date("w", mktime(0, 0, 0, 1, 4, $annee));
    //Correction, si le jour est un dimanche, on dit qu'il vaut 7
    if ($num_jour_quatre_janvier == '0') {
        $num_jour_quatre_janvier = 7;
    }
    $ecart_lundi    = $num_jour_quatre_janvier - 1;
    $ecart_dimanche = 7 - $num_jour_quatre_janvier;
    for ($i = 1; $i <= $nb_semaine; $i++) {
        $lundi    = $semaine - ($ecart_lundi * 86400);
        $dimanche = $semaine + ($ecart_dimanche * 86400);
        if ($num == $i) {
            return array(
                strftime("%d-%m-%Y", $lundi),
                strftime("%d-%m-%Y", $dimanche)
            );
        }
        $semaine = $semaine + 604800;
    }
}

function majhs($id)
{
    //partie heure sup
    $date       = strtotime("now");
    $dateformat = date('Y-m-d', strtotime('now'));
    $date       = $date - (604800 * 50);
    $moins      = '604800'; //une semaine en seconde
    $daywork    = '25200';
    //echo strtotime('50W');
    $bdd        = new bdd();
    $user       = list_user_u($id);
    $user       = $user[0];
    if (isset($user[0]['begin'])) {
        $o       = date('W-Y', $date);
        $contrat = hourtosec((($user[0]['pourcent'] / 100) * 35) . ':0');
        $total   = 0;
        $all     = 0;
        for ($a = 1; $a <= 50; $a++) {
            $o   = date('YW', $date);
            $ooo = date('Y-W', $date);
            $oo  = date('Y-m-d', $date);
            $Yo  = date('Y', $date);
            $Wo  = date('W', $date);
            if ($Wo == 53) {
                $Yo--; //gestion des anné bixextile
            }
            $dfweek = fnl_of_week($Yo, $Wo);
            $Yo++;
            $nbnonferie  = datediff($dfweek[0], $dfweek[1]);
            $ui          = ((7 * $nbnonferie) * $user[0]['pourcent']) / 100;
            $contrat     = hourtosec(($ui) . ':0');
            $nbnonferie  = datediff($dfweek[0], $dfweek[1]); //nombre de jour non ferié dans la semaien traitée
            $hourcontrat = $ui;
            $now         = new DateTime($oo);
            $now         = $now->format('Ymd');
            $next        = new DateTime($user[0]['begin']);
            $next        = $next->format('Ymd');
            if ($now > $next) {
                $tab0  = "";
                $tab0  = array(
                    date('YW', $date),
                    $id
                );
                $bdd->cache("select sum(nb) as nb from heure where yearweek(date)=? and id_user=?", $tab0);
                $dates = $bdd->exec();
                $total = $dates[0][0]['nb'] - $contrat;
                $all   = $all + $total;
            }
            $date = $date + $moins;
        }
        $tab4 = array(
            $id
        );
        $bdd->cache('select * from heure_sup where id_user=?', $tab4);
        $test = $bdd->exec();
        echo '<br><br>';
        if (!isset($test[0][0]['id']) or ($test[0][0]['id']=='') ) {
            $tab3 = array(
                $id,
                $all,
                $dateformat
            );
            $bdd->cache('insert into heure_sup ( `id_user`, `heure`, `date_refresh`) VALUES ( ?, ?, ?)', $tab3);
            $bdd->exec();
        } else {
            $tab2 = array(
                $all,
                $dateformat,
                $id
            );
            $bdd->cache('update heure_sup set heure=?, date_refresh=? where id_user=?', $tab2);
            $bdd->exec();
        }
        //partie congé
        $conge_mensuel = 25; // toute les entré seront avec des fraction sur 12 sous entendu ici 25/12
        $bdd->cache('select nb_jour,maj from credit_conge where id_user=?', array(
            $id
        ));
        $result        = $bdd->exec();
        if(isset($result[0][0])){
            $result        = $result[0][0];
        } else {
            $result=0;
        }

        $now           = new DateTime(date('Ym'));
        $nowM          = $now->format('m');
        $nowY          = $now->format('Y');
        $next          = new DateTime($result['maj']);
        $nextM         = $next->format('m');
        $nextY         = $next->format('Y');
        ///-------------------------------------------------------------->if($nextY.$nextM<$nowY.$nowM){ check si un mois est passer depyuis la de'rnière réactualisation ou alor l'utilisteur n'est pas connu
        if ($nextY . $nextM < $nowY . $nowM or empty($result['maj'])) {
            if (isset($result['nb_jour'])) {
                $solde  = check_conge($id, '1', '0');
                $nbmois = (($nowY - $nextY) * 12) + ($nowM - $nextM); //calcul du nombre de mois sans mise ajour du compteur
                if ($nbmois > 0) {
                    $solde = $solde + ($conge_mensuel * $nbmois);
                } else {
                    $solde = $solde + $conge_mensuel;
                }
                $bdd->cache('UPDATE `credit_conge` SET `nb_jour`=?, maj=? where `id_user`=?', array(
                    $solde,
                    date('Y-m-d'),
                    $id
                ));
                $bdd->exec();
            } else { //si c'est un nouvel employé qui n'a pas encore d'entré en base pour ces congé on check son contrat pour savoir
                $solde    = 0;
                $bdd->cache('select begin from users where id=?', array(
                    $id
                ));
                $contrat  = $bdd->exec();
                $contrat  = new DateTime($contrat[0][0]['begin']);
                $contratD = $contrat->format('d');
                $contratY = $contrat->format('Y');
                $contratM = $contrat->format('m');
                $solde    = (($nowY - $contratY) * 12) + ($nowM - $contratM);
                $solde    = $solde * $conge_mensuel;
                if ($contratD > 15 and $solde > 0) {
                    $solde = $solde - $conge_mensuel; /// si le solde est supérieure a 0 et que la personne est arrivé après le 15 on enlève 2.083 jour
                }
                $bdd->cache('INSERT INTO `credit_conge`(nb_jour, id_user, maj) VALUES (?,?,?) ', array(
                    $solde,
                    $id,
                    date('Y-m-d')
                ));
                $i = $bdd->exec();
            }
        }
    }
}
function addzero($month)
{
    if (strlen($month) < 2) {
        $month = '0' . $month;
    }
    return $month;
}
function list_user_u($id = '')
{
    $bdd = new bdd();
    if ($id == '') {
        $bdd->cache("select a.begin as begin, a.id as id, a.username as username, a.nom as nom, a.prenom as prenom, a.acl as acl, a.mail as mail, b.nom as contrat , b.pourcent as pourcent, a.state as state from users a, contrat b where a.id_contrat=b.id", '');
        $result = $bdd->exec();
    }
    if ($id != '') {
        $array  = array(
            $id
        );
        $bdd->cache("select a.begin as begin, a.id as id, a.username as username, a.nom as nom, a.prenom as prenom, a.acl as acl, a.mail as mail, b.nom as contrat , b.pourcent as pourcent , a.state as state from users a, contrat b where a.id_contrat=b.id and a.id=?", $array);
        $result = $bdd->exec();
    }
    return $result;
}
function half_day($hday, $debut)
{
    if ($debut == "d") {
        if ($hday == "matin") {
            $resultat = "8:30:00";
        }
        if ($hday == "amidi") {
            $resultat = "13:00:00";
        }
        if ($hday == "day") {
            $resultat = "8:30:00";
        }
    }
    if ($debut == "f") {
        if ($hday == "matin") {
            $resultat = "12:00:00";
        }
        if ($hday == "amidi") {
            $resultat = "16:30:00";
        }
        if ($hday == "day") {
            $resultat = "16:30:00";
        }
    }
    return $resultat;
}
function compte_day_conge($debut, $fin)
{
    $jour     = '86400'; //jour en seconde
    $end      = explode(" ", $fin);
    $begin    = explode(" ", $debut);
    $begins   = strtotime($begin[0]);
    $ends     = strtotime($end[0]);
    $nb       = sectohour($ends - $begins);
    $nbj      = intval($nb['h'] / 24);
    $compteur = $begins;
    $nbjt     = 0;
    for ($i = 0; $i < $nbj + 1; $i++) {
        if (isHoliday($compteur) != 1) { //check si c'est un jour de cong
            if(isset($conge[0])){
                $conge = $conge[0];
            } else {
                $conge= 0;
            }
            if ($begins == $ends) { //si la personne a pris une demie journé
                if ($begin[1] == '8:30:00') {
                    $begin[1] = '9:30';
                }
                if ($begin[1] == '08:30:00') {
                    $begin[1] = '9:30';
                }
                if ($begin[1] == '13:00:00') {
                    $begin[1] = '13:30';
                }
                $nbh       = hourtosec($end[1]) - hourtosec($begin[1]); //nombre de seconde
                $nbjt      = $nbjt + $nbh;
                $aftersous = $conge[0]['nb_jour'];
            } else {
                if ($begins == $compteur or $ends == $compteur) { //si on arrive au debut ou la fin de la periode demandée
                    if ($begins == $compteur) {
                        $n = $begin[1];
                        if ($begin[1] == '8:30:00') {
                            $n = '9:30'; //on enleve 1h le soir pour compenser la pause dejeuner
                        }
                        if ($begin[1] == '08:30:00') {
                            $n = '9:30';
                        }
                        if ($begin[1] == '13:00:00') {
                            $n = '13:30';
                        }
                        $nbh  = hourtosec('16:30') - hourtosec($n);
                        $nbjt = $nbjt + $nbh;
                    } else {
                        $n = $end[1];
                        if ($end[1] == '12:00:00') {
                            $n = '12:00'; //on enleve 1h le soir pour compenser la pause dejeuner
                        }
                        if ($end[1] == '16:30:00') {
                            $n = '15:30';
                        }
                        $nbh  = hourtosec($n) - hourtosec('08:30');
                        $nbjt = $nbjt + $nbh;
                    }
                } else { //sinon
                    $nbjt = $nbjt + '25200';
                }
            }
        } //fin check jour de congé
        $compteur = $compteur + $jour;
    } //fin boucle for
    return $nbjt / 25200;
}
function get_take_conge($id)
{
    $bdd      = new bdd();
    $bdd->cache('SELECT begin, end FROM conge WHERE id_user=? and state=0 and `begin` >=CURDATE()', array(
        $id
    ));
    $holi     = $bdd->exec();
    $compteur = 0;
    $compt=count($holi[0]);
    for ($i = 0; $i < $compt; $i++) {
        $compteur = $compteur + compte_day_conge($holi[0][0]['begin'], $holi[0][0]['end']);
    }
    return $compteur;
}

function addconge($id_motif, $id_user, $begin, $end, $jbegin, $jend)
{
    $bdd                = new bdd();
    $array              = array(
        $id_motif
    );
    $bdd->cache('select * from motif where id=?', $array);
    $result             = $bdd->exec();
    $bdd->cache('select a.id_user as id_user, b.mail as mail from hierachie_liaison a,users b where a.id_user_sup=b.id and id_user=?', array(
      $id_user
    ));
    $manager            = $bdd->exec();
    //var_dump($manager);
    if(isset($manager[0][0]['id_user'])){
      $id_validator="-1";
      $send_mail=true;

    } else {
      $send_mail=false;
      $id_validator=$id_user;
    }
    $type               = $result[0][0]['type'];
    $jend               = half_day($jend, 'f');
    $jbegin             = half_day($jbegin, 'd');
    $debut              = $begin . ' ' . $jbegin;
    $fin                = $end . ' ' . $jend;
    $array2             = array(
        $id_motif,
        $id_user,
        $debut,
        $fin,
        $id_validator
    );
    $nbjc               = compte_day_conge($debut, $fin);
    $nbjrc              = check_conge($id_user, $id_motif);
    $conge_deja_demande = get_take_conge($id_user);
    $nbjc               = $nbjc + $conge_deja_demande;
    if ($nbjc <= $nbjrc or $type == 2) {
        //print_r($array2);
        $bdd->cache("INSERT INTO `conge`( `id_motif`, `id_user`, `state`, `begin`, `end`,id_validator) VALUES ( ?, ?, '0', ? ,?,?)", $array2);
        $bdd->exec();
        if($send_mail){
        echo $manager[0][0]['mail'];
          sendmail($manager[0][0]['mail'], 'Demande de congé','Une nouvelle demande de congé vient de vous être envoyée','<p>Une nouvelle demande de congé vient de vous être demndée</p><br> <a href="https://temps.triskem.fr/index.php?action=user-modo"> Cliquez ici pour y acceder</a><br><br><p>Cordialement,<br>Votre gestion du temps</p>' );
        }
        echo '<div style="border:solid 2px green;background:lightgreen;color:green;padding:1em;display:inline-block" class="droid"> conge ajouté avec succès</div><meta http-equiv="refresh" content="2; URL=index.php"><SCRIPT LANGUAGE="JavaScript">document.location.href="index.php"</SCRIPT>';
    } else {
        echo '<div style="border:solid 2px red; background:pink;color:red;padding:1em;display:inline-block" class="droid">vous n\'avez sans doute pas assez de congé pour faire sa</div>';
    }
}
function delconge($id, $user_id)
{
    $bdd    = new bdd();
    $array  = array(
        $id,
        $user_id
    );
    $bdd->cache('select b.type as type , a.begin as begin, a.end as end from conge a, motif b where a.id_motif=b.id and a.id=? and a.id_user=?', $array);
    $result = $bdd->exec();
    if ($result[0][0]['type'] == 1 or $result[0][0]['type'] == 2) {
        del_heure_conge($id, $user_id);
        $bdd->cache('DELETE FROM `conge` WHERE id=? and id_user=?', $array);
        $bdd->exec();
    } else {
        $bdd->cache('DELETE FROM `conge` WHERE id=? and id_user=?', $array);
        $bdd->exec();
        echo '<div style="border:solid 2px green;background:lightgreen;color:green;padding:1em;display:inline-block" class="droid"> conge supprimé avec succès</div><meta http-equiv="refresh" content="2; URL=index.php"><SCRIPT LANGUAGE="JavaScript">document.location.href="index.php"</SCRIPT>';
    }
}
function random_color_part()
{
    return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
}

function random_color()
{
    return random_color_part() . random_color_part() . random_color_part();
}
function antixss($input) {
strip_tags($input);
$new = htmlspecialchars($input, ENT_QUOTES);
return $new;
}
function del_heure_conge($id, $id_user)
{
    $bdd      = new bdd();
    $bdd->cache('select a.state as state, b.type as type, a.end as end, a.begin as begin, a.id_user as id_user from conge a , motif b where b.id=a.id_motif and a.id=?', array(
        $id
    ));
    $type     = $bdd->exec();
    $bdd->cache('SELECT b.id as id FROM conge a, categorie b, motif c WHERE a.id_motif=c.id and c.id_cat=b.id and a.id=?',array(
        $id
    ));
    $id_cat   = $bdd->exec();
    $id_cat   = $id_cat[0][0];
    $type     = $type[0];
    $jour     = '86400'; //jour en seconde
    $end      = explode(" ", $type[0]['end']);
    $begin    = explode(" ", $type[0]['begin']);
    $begins   = strtotime($begin[0]);
    $ends     = strtotime($end[0]);
    $nb       = sectohour($ends - $begins);
    $nbj      = intval($nb['h'] / 24);
    $compteur = $begins;
    if ($type[0]['type'] == 2) { // dans le cas d'un deplacement on recrédite les heures sur le compte
        for ($i = 0; $i < $nbj + 1; $i++) {
            if (isHoliday($compteur) != 1) { //check si c'est un jour de congé
                if ($begins == $ends) { //si la personne a pris une demie journé
                    $nbh = hourtosec($end[1]) - hourtosec($begin[1]); //nombre de seconde
                    $bdd->cache("delete from `heure` where id_cat=? and id_user=? and nb=? and DATE_FORMAT(`date`, '%Y-%m-%d')=? ", array(
                        $id_cat['id'],
                        $type[0]['id_user'],
                        $nbh,
                        $begin[0]
                    ));
                    $bdd->exec();
                } else {
                    if ($begins == $compteur or $ends == $compteur) { //si on arrive au debut ou la fin de la periode demandée
                        if ($begins == $compteur) {
                            if ($begin[1] == '08:30:00') {
                                $n = '9:30'; //on enleve 1h le soir pour compenser la pause dejeuner
                            }
                            if ($begin[1] == '13:00:00') {
                                $n = '13:30';
                            }
                            $nbh = hourtosec('16:30') - (hourtosec($n));
                            $bdd->cache("delete from `heure` where id_cat=? and id_user=? and nb=? and DATE_FORMAT(`date`, '%Y-%m-%d')=?", array(
                                $id_cat['id'],
                                $type[0]['id_user'],
                                $nbh,
                                $begin[0]
                            ));
                            $bdd->exec();
                        } else {
                            if ($end[1] == '12:00:00') {
                                $n = '12:00'; //on enleve 1h le soir pour compenser la pause dejeuner
                            }
                            if ($end[1] == '16:30:00') {
                                $n = '15:30';
                            }
                            $nbh = hourtosec($n) - hourtosec('08:30');
                            $bdd->cache("delete from `heure` where id_cat=? and id_user=? and nb=? and DATE_FORMAT(`date`, '%Y-%m-%d')=?", array(
                                $id_cat['id'],
                                $type[0]['id_user'],
                                $nbh,
                                $end[0]
                            ));
                            $bdd->exec();
                        }
                    } else { //sinon
                        $bdd->cache("delete from `heure` where id_cat=? and id_user=? and nb=? and DATE_FORMAT(`date`, '%Y-%m-%d')=?", array(
                            $id_cat['id'],
                            $type[0]['id_user'],
                            '25200',
                            date('Y-m-d', $compteur)
                        ));
                        $bdd->exec();
                    }
                }
            } //fin check jour de congé
            $compteur = $compteur + $jour;
        } //fin boucle for
    } //fin du type deplacement
    if ($type[0]['type'] == 1) { // dans le cas d'un conge paye
        $nbjt = 0;
        for ($i = 0; $i < $nbj + 1; $i++) {
            if (isHoliday($compteur) != 1) { //check si c'est un jour de congé
                $bdd->cache('select nb_jour from credit_conge where id_user=?', array(
                    $type[0]['id_user']
                ));
                $conge = $bdd->exec();
                $conge = $conge[0];
                if ($begins == $ends) { //si la personne a pris une demie journé
                    $nbh       = hourtosec($end[1]) - hourtosec($begin[1]); //nombre de seconde
                    //$nbh       = ($nbh * 3600) / 7;
                    $aftersous = $conge[0]['nb_jour'];
                    $nbjt=$nbh;
                    if($nbh=="28800"){
                            $nbh=$nbh-3600;
                          }
                     $bdd->cache("delete from `heure` where id_cat=? and id_user=? and nb=? and DATE_FORMAT(`date`, '%Y-%m-%d')=?", array(
                                $id_cat['id'],
                                $type[0]['id_user'],
                                $nbh,
                                $end[0]
                            ));

                } else {
                    if ($begins == $compteur or $ends == $compteur) { //si on arrive au debut ou la fin de la periode demandée
                        if ($begins == $compteur) {
                            if ($begin[1] == '08:30:00') {
                                $n = '9:30'; //on enleve 1h le soir pour compenser la pause dejeuner
                            }
                            if ($begin[1] == '13:00:00') {
                                $n = '13:30';
                            }
                            $nbh  = hourtosec('16:30') - hourtosec($n);
                            $nbjt = $nbjt + $nbh;
                            $bdd->cache("delete from `heure` where id_cat=? and id_user=? and nb=? and DATE_FORMAT(`date`, '%Y-%m-%d')=?", array(
                                $id_cat['id'],
                                $type[0]['id_user'],
                                $nbh,
                                $begin[0]
                            ));
                            $bdd->exec();
                        } else {
                            if ($end[1] == '12:00:00') {
                                $n = '12:00'; //on enleve 1h le soir pour compenser la pause dejeuner
                            }
                            if ($end[1] == '16:30:00') {
                                $n = '15:30';
                            }
                            $nbh  = hourtosec($n) - hourtosec('08:30');
                            $nbjt = $nbjt + $nbh;
                            $bdd->cache("delete from `heure` where id_cat=? and id_user=? and nb=? and DATE_FORMAT(`date`, '%Y-%m-%d')=?", array(
                                $id_cat['id'],
                                $type[0]['id_user'],
                                $nbh,
                                $end[0]
                            ));
                            $bdd->exec();
                        }
                    } else { //sinon
                        $nbjt = $nbjt + $nbh;
                        $bdd->cache("delete from `heure` where id_cat=? and id_user=? and nb=? and DATE_FORMAT(`date`, '%Y-%m-%d')=?", array(
                            $id_cat['id'],
                            $type[0]['id_user'],
                            '25200',
                            date('Y-m-d', $compteur)
                        ));
                        $bdd->exec();

                    }
                }
            } //fin check jour de congé
            $compteur = $compteur + $jour;
        } //fin boucle for
        if ($type[0]['state'] == 1) { //si il a déja été valider on recredite le solde de congé de l'utilisateur
            echo $nbjt;
            $nbjt = ($nbjt / 3600) / 7;
            $nbjt = $conge[0]['nb_jour'] + $nbjt * 12;
            $bdd->cache('update credit_conge set nb_jour=? where id_user=?', array(
                $nbjt,
                $type[0]['id_user']
            ));
            $bdd->exec();
        }
    } //fin du type congé paye
    echo '<div style="border:solid 2px green;background:lightgreen;color:green;padding:1em;display:inline-block" class="droid"> conge mis à jour avec succès</div>';
} //fin fonction


?>

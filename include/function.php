<?php
function secureAccess(){                                                                                         
                                                                                               
    if (!checkaccess()){                                                                                         
        header('location: auth.php'); // on redirige vers index.php                                                 
    exit;                                                                                                       
    }                                                                                                            
} 
                                                                                                           
function checkAccess(){
	$bdd=new bdd;
	$username=array('serizao');
	$result=$bdd->tab('select * from user where username=?', $username );                                                                                      
    return ($_SESSION['username']);                                                                     
}   
function check_admin(){
	if(isset($_SESSION['acl']) and $_SESSION['acl']==10){
		return true;
	}
	else{
	 return false;
	 }
}
function last_time($id, $date){
	$bdd=new bdd;
	$data=array($id);
	$result=$bdd->tab("SELECT id, es, DATE_FORMAT(`temps`, '%d %M %Y') AS date, DATE_FORMAT(temps, '%H:%i') AS time, temps FROM `es` WHERE cast(temps as date)='".$date."' and id_user=? order by temps asc", $data);
	return $result;
}

function current_semaine($n, $o){
	date_default_timezone_set('Europe/Paris');
	$jour = array("Dimanche","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi"); 
	
	if(!empty($i)){
	}
	else{
		$w = date('W');
	}
	  
	 $w = date('W'); // Pour la 7 ème semaine à rechercher
	 $year = date('Y');
		 for($i = 1; $i <= 365; $i++) {
		  	$week = date("W", mktime(0, 0, 0, 1, $i, $year));
		  	if(isset($o) and $o!=0) $w = $o;
		  	
		  	$semaine['n']=$w;
			  if($week == $w) {
			    
			    // Ensuite pour afficher tous les (jour)s de la semaine
					
				    for($d = 0; $d < 7; $d++) {
				    	//echo $i+$d;
				    	$semaine['jour'][$d]=jour($i+$d, $year);
				    	$semaine['numero'][$d]=date("d", mktime(0, 0, 0, 1, $i+$d, $year)); 
						$semaine['mois'][$d]=month(date("n", mktime(0, 0, 0, 1, $i+$d, $year))) ;
						$semaine['mois2'][$d]=date("m", mktime(0, 0, 0, 1, $i+$d, $year)) ;
						$semaine['annee'][$d]=$year;
						$date=$semaine['annee'][$d].'-'.$semaine['mois2'][$d].'-'.$semaine['numero'][$d];
						$semaine['date'][$d]=$semaine['numero'][$d].'-'.$semaine['mois2'][$d].'-'.$year;
						$semaine['date2'][$d]=$year.'-'.$semaine['mois2'][$d].'-'.$semaine['numero'][$d];
						
						$result=last_time($n, $date );
						$semaine[$d]=$result[0];

				    }

			   return $semaine;
			   break;
			  }
		 }
	
	
}
function month($i){
	$mois = array("","Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");
	return $mois[$i];
}
function jour($m, $year){
	$i = date("w", mktime(0, 0, 0, 1, $m, $year));
	$jour = array("Dimanche","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi"); 
	return $jour[$i];
}
function arriver($id,$time){
	date_default_timezone_set('Europe/Paris');
	$bdd=new bdd;
	$data=array('e',$id,$time);
	$result=$bdd->tab('insert into `es`( `es`, `id_user`, `temps`) VALUES(  ?, ?, ?) ', $data);
 
	

}
function partir($id,$time){
	date_default_timezone_set('Europe/Paris');
	$bdd=new bdd;
	$data=array('s',$id,$time);
	$result=$bdd->tab('insert into `es`( `es`, `id_user`, `temps`) VALUES(  ?, ?, ?) ', $data);

}


function calcul_time($h1){
	$spend=0;
	$table=array();
	for($p=1;$p<count($h1);$p++){
		$i=$p-1;
		$spend=$spend+($h1[$p]-$h1[$i]);
		$table['heure']=intval($spend / 3600);
		$table['minutes']=intval(($spend % 3600) / 60);
		$table['second']=intval((($spend% 3600) % 60));
		
		$p++;


	}
	return $table;
}
function contrat2hour($pourcent){

	$a=$pourcent/100;
	$a=$a*35;
	return $a;
}
function number_day($month,$year,$a){
	date_default_timezone_set('Europe/Paris');
	$number='error';
	if(!is_array($month) and !is_array($year)){
	$number = cal_days_in_month(CAL_GREGORIAN, $month, $year); // 3
	}
	if(is_array($month) and is_array($year) and count($month)==count($year)  ){
			
			$r = cal_days_in_month(CAL_GREGORIAN, $month[1], $year[1]); // 3
			$datetime0 = new DateTime($year[0].'/'.$month[0].'/01');
			$datetime1 = new DateTime($year[1].'/'.$month[1].'/'.$r);
			$interval = $datetime0->diff($datetime1);
			$number= $interval->format('%'.$a);
		
	}
	return $number;
}

function add_mouvement($id,$sens,$heure,$url){
	$mouv=last_mouvement($id, $heure);

	if($sens=="e" and ($mouv=='s' or empty($mouv))){
		arriver($_SESSION['userid'],$heure);
   
  	echo '<div style="border:solid 2px green;background:lightgreen;color:green;padding:1em;display:inline-block" class="droid"> horaires mis à jour avec succès</div><meta http-equiv="refresh" content="2; URL='.$url.'">';
	}
	elseif($sens=="s"and $mouv=='e') {
		partir($_SESSION['userid'],$heure);
		echo '<div style="border:solid 2px green;background:lightgreen;color:green;padding:1em;display:inline-block" class="droid"> horaires mis à jour avec succès</div><meta http-equiv="refresh" content="2; URL='.$url.'">';
	} else {
		echo '<div style="border:solid 2px red; background:pink;color:red;padding:1em;display:inline-block" class="droid">erreur : il est possible que le sens ne soit pas correct</div>';
	}
}
function last_mouvement($id, $date){
	$bdd=new bdd();
	$array=array($id);
	$result=$bdd->tab("select es from es where id_user=? and cast(temps as date)<'".$date."' and DATE_FORMAT(temps, '%d-%m-%Y')=DATE_FORMAT('".$date."', '%d-%m-%Y') and DATE_FORMAT(temps, '%d-%m-%Y %H:%i:%s')<DATE_FORMAT('".$date."', '%d-%m-%Y %H:%i:%s') order by temps desc limit 0, 1", $array);
	if(isset( $result[0][0]['es']))return $result[0][0]['es'];
	else return '';
	
}
function del_mouvement($id_mouv,$id_user,$url){
  $bdd=new bdd();
  $array=array($id_mouv,$id_user);
  $bdd->tab('delete from es where id=? and id_user=?',$array);
 	echo '<div style="border:solid 2px green;background:lightgreen;color:green;padding:1em;display:inline-block" class="droid"> horaires mis à jour avec succès</div><meta http-equiv="refresh" content="2; URL='.$url.'">';

}
function check_exist($o){
	$bdd=new bdd();
	$array=array($o);
	$p=$bdd->tab('select * from users where username=?', $array);
	if(count($p[0])>=1) return true;
	if(count($p[0])<1) return false;
}
function list_cat(){
	$bdd=new bdd();
	$result=$bdd->tab('select * from categorie','');
	return $result;
}
function count_hour($date,$version){
	$bdd=new bdd();
	$array=array($_SESSION['userid'],$date);
	$hour=$bdd->tab("select * from heure where  id_user=? and DATE_FORMAT(`date`, '%Y-%m-%d')=? ",$array);
	for($i=0;$i<count($hour[0]);$i++){
		
		$time[]=$hour[0][$i]['nb'];
		$time[]=0;
	
	}
	$result=$bdd->tab("select temps from es where id_user=? and DATE_FORMAT(`temps`, '%Y-%m-%d')=? order by temps asc", $array);
	for($i=0;$i<count($result[0]);$i++){
	
		$time[]=strtotime($result[0][$i]['temps']);
	}
	if(!empty($time)){
		$tempspasser=calcul_time($time);
		if(!isset($tempspasser['heure']))$tempspasser['heure']="00";
		if(!isset($tempspasser['minutes']))$tempspasser['minutes']="00";
		if(!isset($tempspasser['second']))$tempspasser['second']="00";
		if($version==0){
			echo 'vous avez '.$tempspasser['heure'].'h'.$tempspasser['minutes'].'min'.$tempspasser['second'].' à catégoriser pour ce jour';
		}
		if($version==1){
			$return=hourtosec($tempspasser['heure'].':'.$tempspasser['minutes']);
			return $return;
		}
		if($version==2){
			return $tempspasser;
		}
	}
	else{
		if($version==0){
		echo 'il n\'y a pas de temps a catégoriser pour ce jour';
		}
		if($version==1){
			return 0;
		}
		if($version==2){
			return 0;
		}
	}
}
function hourtosec($hour){
	$tab=explode(":",$hour);
	$result=$tab[0]*3600;
	$result=$tab[1]*60+$result;
	return $result;
}
function sectohour($init){
	$result['h'] = intval($init / 3600);
	$result['m'] = intval(($init / 60) % 60);
	$result['s'] = $init % 60;
	return $result;
}
function cat_hour($date,$cathour,$nb,$url){
	$nb=hourtosec($nb);
	$i=count_hour($date,'1');
	$a=$i-$nb;
	if($i>0 and $a>=0){
		$bdd=new bdd();
		$array=array($_SESSION['userid'],$nb, $cathour,$date);
		$bdd->tab('insert into heure set  id_user=?, nb=?, id_cat=?, date=?',$array);
		echo '<div style="border:solid 2px green;background:lightgreen;color:green;padding:1em;display:inline-block" class="droid"> modification effectuée avec succès</div><meta http-equiv="refresh" content="2; URL='.$url.'">';
	}
	
	else{
				echo '<div style="border:solid 2px red; background:pink;color:red;padding:1em;display:inline-block" class="droid">erreur : le nombre d\'heure entré est probablement trop grand</div>';
	}
}
function getHolidays($year = null)
{
        if ($year === null)
        {
                $year = intval(strftime('%Y'));
        }

        $easterDate = easter_date($year);
        $easterDay = date('j', $easterDate);
        $easterMonth = date('n', $easterDate);
        $easterYear = date('Y', $easterDate);

        $holidays = array(
                // Jours feries fixes
                mktime(0, 0, 0, 1, 1, $year),// 1er janvier
                mktime(0, 0, 0, 5, 1, $year),// Fete du travail
                mktime(0, 0, 0, 5, 8, $year),// Victoire des allies
                mktime(0, 0, 0, 7, 14, $year),// Fete nationale
                mktime(0, 0, 0, 8, 15, $year),// Assomption
                mktime(0, 0, 0, 11, 1, $year),// Toussaint
                mktime(0, 0, 0, 11, 11, $year),// Armistice
                mktime(0, 0, 0, 12, 25, $year),// Noel

                // Jour feries qui dependent de paques
                mktime(0, 0, 0, $easterMonth, $easterDay + 1, $easterYear),// Lundi de paques
                mktime(0, 0, 0, $easterMonth, $easterDay + 39, $easterYear),// Ascension
                mktime(0, 0, 0, $easterMonth, $easterDay + 50, $easterYear), // Pentecote
        );

        sort($holidays);

        return $holidays;
}
function isHoliday($timestamp)
{
        $iDayNum = date('N', $timestamp);
        $iYear = strftime('%Y', $timestamp);

        $aHolidays = getHolidays($iYear);

        /*
        * On est oblige de convertir les timestamps en string a cause des decalages horaires.
        */
        $aHolidaysString = array_map(function ($value)
        {
                return strftime('%Y-%m-%d', $value);
        }, $aHolidays);

        if (in_array(strftime('%Y-%m-%d', $timestamp), $aHolidaysString) OR $iDayNum == 6 OR $iDayNum == 7)
        {
                return true;
        }

        return false;
}
function mintodec($min){
	return intval(($min*100)/60);
}
function majhs($id){
	$date=strtotime("now");
	$dateformat=date('Y-m-d',$date);
	
	$date=$date-(604800*50);
	$moins= '604800'; //une semaine en seconde
	//echo strtotime('50W');
	$bdd=new bdd();
	$user=list_user_u($id);
	$user=$user[0];
	$o=date('W-Y',$date);
	$contrat=hourtosec((($user[0]['pourcent']/100)*35).':0');
	$total=0;
	$all=0;
	for($a=1;$a<=50;$a++){
		$o=date('YW',$date);
		$oo=date('Y-m-d',$date);
		if(($date)>=strtotime($user[0]['begin'])){
			$tab0="";
			//echo '<br>';
			$tab0=array($o,$id);
			$dates=$bdd->tab("select sum(nb) as nb from heure where yearweek(date)=? and id_user=?",$tab0);
			//print_r(sectohour($dates[0][0]['nb'])).'<br>';
			$total=$dates[0][0]['nb']-$contrat;
			//echo $dates[0][0]['nb'].'<br>';
			//echo $dates[0][0]['nb']-$contrat.'<br>';
			
			$all=$all+$total;
		}
		$date=$date+$moins;
		
	}
	//echo $all;
	$tab4=array($id);
	$test=$bdd->tab('select * from heure_sup where id_user=?', $tab4);
	echo'<br><br>';
	//print_r($test);
	if(!isset($test[0][0]['id'])){

		$tab3=array($id, $all, $dateformat);
		$bdd->tab('insert into heure_sup ( `id_user`, `heure`, `date_refresh`) VALUES ( ?, ?, ?)',$tab3 );
	}else{
		$tab2=array($all, $dateformat, $id);
		$bdd->tab('update heure_sup set heure=?, date_refresh=? where id_user=?',$tab2);
	}
	

}
function addzero($month){
	if(strlen($month)<2){
		$month='0'.$month;
	}
	return $month;
}
function list_user_u($id=''){
			$bdd=new bdd();
			if($id==''){
				$result=$bdd->tab("select a.begin as begin, a.id as id, a.username as username, a.nom as nom, a.prenom as prenom, a.acl as acl, a.mail as mail, b.nom as contrat , b.pourcent as pourcent, a.state as state from users a, contrat b where a.id_contrat=b.id", '');
			}
			if($id!=''){
				$array=array($id);
				$result=$bdd->tab("select a.begin as begin, a.id as id, a.username as username, a.nom as nom, a.prenom as prenom, a.acl as acl, a.mail as mail, b.nom as contrat , b.pourcent as pourcent , a.state as state from users a, contrat b where a.id_contrat=b.id and a.id=?", $array);
			}
			
			return $result;
		}
function half_day($hday,$debut){
	if($debut=="d"){
		if($hday=="matin") return "8:30:00";
		if($hday=="amidi") return "13:00:00";
		if($hday=="day") return "8:30:00";
	}
	if($debut=="f"){
		if($hday=="matin") return "12:00:00";
		if($hday=="amidi") return "16:30:00";
		if($hday=="day") return "16:30:00";
	}
	

}
function addconge($id_motif,$id_user,$begin,$end,$jbegin,$jend){
	$bdd=new bdd();
	$array=array($id_motif);
	$result=$bdd->tab('select * from motif where id=?', $array);
	$type=$result[0][0]['type'];
	$jend=half_day($jend,'f');
	$jbegin=half_day($jbegin,'d');
	$debut=$begin.' '.$jbegin;
	$fin=$end.' '.$jend;
	$array2=array($id_motif,$id_user,$debut,$fin);
	//print_r($array2);
	$bdd->tab("INSERT INTO `conge`( `id_motif`, `id_user`, `state`, `begin`, `end`) VALUES ( ?, ?, '0', ? ,?)",$array2);
	echo '<div style="border:solid 2px green;background:lightgreen;color:green;padding:1em;display:inline-block" class="droid"> conge ajouté avec succès</div><meta http-equiv="refresh" content="2; URL=index.php">';
}
function delconge($id, $user_id){
	$bdd=new bdd();
	$array=array($id,$user_id);
	$result=$bdd->tab('select b.type as type , a.begin as begin, a.end as end from conge a, motif b where a.id_motif=b.id and a.id=? and a.id_user=?',$array);
	if($result[0][0]['type']==1 or $result[0][0]['type']==2){
		
		del_heure_conge($id, $user_id);
		$bdd->tab('DELETE FROM `conge` WHERE id=? and id_user=?',$array);
	}else{
		$bdd->tab('DELETE FROM `conge` WHERE id=? and id_user=?',$array);
		echo '<div style="border:solid 2px green;background:lightgreen;color:green;padding:1em;display:inline-block" class="droid"> conge supprimé avec succès</div><meta http-equiv="refresh" content="2; URL=index.php">';
	}
	
}
function random_color_part() {
    return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
}

function random_color() {
    return random_color_part() . random_color_part() . random_color_part();
}
function del_heure_conge($id, $id_user){
			$bdd=new bdd();
			$type=$bdd->tab('select a.state as state, b.type as type, a.end as end, a.begin as begin, a.id_user as id_user from conge a , motif b where b.id=a.id_motif and a.id=?',array($id));
			$type=$type[0];
			
			
			$jour='86400'; //jour en seconde
			$end=explode(" ",$type[0]['end']);
			$begin=explode(" ",$type[0]['begin']);
			$begins=strtotime($begin[0]);
			$ends=strtotime($end[0]);
			$nb=sectohour($ends-$begins);
			$nbj=intval($nb['h']/24);
			$compteur=$begins;
			if($type[0]['type']==2){  // dans le cas d'un deplacement on recrédite les heures sur le compte
				for($i=0;$i<$nbj+1;$i++){
					if(isHoliday($compteur)!=1){  //check si c'est un jour de congé
						if($begins==$ends){  //si la personne a pris une demie journé
							$nbh=hourtosec($end[1])-hourtosec($begin[1]); //nombre de seconde
							 $bdd->tab("delete from `heure` where id_cat=34 and id_user=? and nb=? and DATE_FORMAT(`date`, '%Y-%m-%d')=? ",array($type[0]['id_user'], $nbh,$begin[0]));
						}else{
							
							if($begins==$compteur or $ends==$compteur){ //si on arrive au debut ou la fin de la periode demandée
								
								if($begins==$compteur){
									if($begin[1]=='08:30:00')$n='9:30';//on enleve 1h le soir pour compenser la pause dejeuner
									if($begin[1]=='13:00:00')$n='13:30';
									$nbh=hourtosec('16:30')-(hourtosec($n)); 
									
									$bdd->tab("delete from `heure` where id_cat=34 and id_user=? and nb=? and DATE_FORMAT(`date`, '%Y-%m-%d')=?",array($type[0]['id_user'], $nbh,$begin[0]));
								}else{
									if($end[1]=='12:00')$n='12:00';//on enleve 1h le soir pour compenser la pause dejeuner
									if($end[1]=='16:30')$n='15:30';
									$nbh=hourtosec($n)-hourtosec('09:30'); 
									
									 $bdd->tab("delete from `heure` where id_cat=34 and id_user=? and nb=? and DATE_FORMAT(`date`, '%Y-%m-%d')=?",array($type[0]['id_user'], $nbh,$end[0]));
								}
							}else{//sinon
							
								$bdd->tab("delete from `heure` where id_cat=34 and id_user=? and nb=? and DATE_FORMAT(`date`, '%Y-%m-%d')=?",array($type[0]['id_user'], '25200',date('Y-m-d',$compteur)));
							}

						}
					}//fin check jour de congé

					$compteur=$compteur+$jour;
				}//fin boucle for
		}//fin du type deplacement
		if($type[0]['type']==1){  // dans le cas d'un conge paye
			$nbjt=0;
				for($i=0;$i<$nbj+1;$i++){
					if(isHoliday($compteur)!=1){  //check si c'est un jour de congé
						$conge=$bdd->tab('select nb_jour from credit_conge where id_user=?',array($type[0]['id_user']));
						$conge=$conge[0];
						
						if($begins==$ends){  //si la personne a pris une demie journé
							$nbh=hourtosec($end[1])-hourtosec($begin[1]); //nombre de seconde
							$nbh=($nbh*3600)/7;
							$aftersous=$conge[0]['nb_jour'];
							
						}else{
							if($begins==$compteur or $ends==$compteur){ //si on arrive au debut ou la fin de la periode demandée
								if($begins==$compteur){
									
									if($begin[1]=='08:30:00')$n='9:30';//on enleve 1h le soir pour compenser la pause dejeuner
									if($begin[1]=='13:00:00')$n='13:30';
									//echo $n;
									$nbh=hourtosec('16:30')-hourtosec($n); 
									$nbjt=$nbjt+$nbh;
									$bdd->tab("delete from `heure` where id_cat=33 and id_user=? and nb=? and DATE_FORMAT(`date`, '%Y-%m-%d')=?",array($type[0]['id_user'], $nbh,$begin[0]));
								}else{
									
									if($end[1]=='12:00:00')$n='12:00';//on enleve 1h le soir pour compenser la pause dejeuner
									if($end[1]=='16:30:00')$n='15:30';
									$nbh=hourtosec($n)-hourtosec('08:30');
									$nbjt=$nbjt+$nbh;
									$bdd->tab("delete from `heure` where id_cat=33 and id_user=? and nb=? and DATE_FORMAT(`date`, '%Y-%m-%d')=?",array($type[0]['id_user'], $nbh,$end[0]));
								}
							}else{//sinon
								$nbjt=$nbjt+$nbh;
								$bdd->tab("delete from `heure` where id_cat=33 and id_user=? and nb=? and DATE_FORMAT(`date`, '%Y-%m-%d')=?",array($type[0]['id_user'], '25200',date('Y-m-d',$compteur)));
							}

						}
					}//fin check jour de congé

					$compteur=$compteur+$jour;
				}//fin boucle for
				
				if($type[0]['state']==1){ //si il a déja été valider on recredite le solde de congé de l'utilisateur
				$nbjt=($nbjt/3600)/7;
				$nbjt=$conge[0]['nb_jour']+$nbjt;
				$bdd->tab('update credit_conge set nb_jour=? where id_user=?',array($nbjt,$type[0]['id_user']));

				}
				
		}//fin du type congé paye
		echo '<div style="border:solid 2px green;background:lightgreen;color:green;padding:1em;display:inline-block" class="droid"> conge mis à jour avec succès</div>';
	}//fin fonction
?>
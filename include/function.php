<?php


function secureAccess(){                                                                                         
    session_start();                                                                                             
    if (!checkaccess()){                                                                                         
        header('location: auth.php'); // on redirige vers index.php                                                 
    exit;                                                                                                       
    }                                                                                                            
}                                                                                                            
function checkAccess(){
	$bdd=new bdd;
	$username=array('serizao');
	$result=$bdd->tab('select * from user where username=?', $username );                                                                                      
    return ($result);                                                                     
}   

function last_time($id, $date){
	$bdd=new bdd;
	$data=array($id);
	$result=$bdd->tab("SELECT es, DATE_FORMAT(`temps`, '%d %M %Y') AS date, DATE_FORMAT(temps, '%H:%i') AS time, temps FROM `es` WHERE cast(temps as date)='".$date."' and id_user=? order by temps asc", $data);
	return $result;
}

function current_semaine($i, $o){
	date_default_timezone_set('Europe/Paris');
	$jour = array("Dimanche","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi"); 
	$mois = array("","Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");
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
			    
			    // Ensuite pour afficher tous les jours de la semaine
					
				    for($d = 0; $d < 7; $d++) {
				    	$semaine['jour'][$d]=$jour[date("w", mktime(0, 0, 0, 1, $i+$d, $year))] ;
				    	$semaine['numero'][$d]=date("d", mktime(0, 0, 0, 1, $i+$d, $year)); 
						$semaine['mois'][$d]=$mois[date("n", mktime(0, 0, 0, 1, $i+$d, $year))] ;
						$semaine['mois2'][$d]=date("m", mktime(0, 0, 0, 1, $i+$d, $year)) ;
						$semaine['annee'][$d]=$year;
						$date=$semaine['annee'][$d].'-'.$semaine['mois2'][$d].'-'.$semaine['numero'][$d];
						
						$result=last_time('0', $date );
						$semaine[$d]=$result[0];

				    }
			   return $semaine;
			   break;
			  }
		 }
	
	
}

function arriver(){
	date_default_timezone_set('Europe/Paris');
	$bdd=new bdd;
	$data=array('','e','',date('Y-m-d H:i:s'));
	$result=$bdd->tab('insert into `es`(`id`, `es`, `id_user`, `temps`) VALUES( ?, ?, ?, ?) ', $data);
	

}
function partir(){
	date_default_timezone_set('Europe/Paris');
	$bdd=new bdd;
	$data=array('','s','',date('Y-m-d H:i:s'));
	$result=$bdd->tab('insert into `es`(`id`, `es`, `id_user`, `temps`) VALUES( ?, ?, ?, ?) ', $data);
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
?>
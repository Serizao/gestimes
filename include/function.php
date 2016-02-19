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
	$username=array($_SESSION['username']);
	$result=$bdd->tab('select * from user where username=?', $username );                                                                                      
    return ($result);                                                                     
}   



function current_semaine($i){
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
			  if($week == $w) {
			    
			    // Ensuite pour afficher tous les jours de la semaine
					
				    for($d = 0; $d < 7; $d++) {
				    	$semaine['jour'][]=$jour[date("w", mktime(0, 0, 0, 1, $i+$d, $year))] ;
				    	$semaine['numero'][]=date("d", mktime(0, 0, 0, 1, $i+$d, $year)); 
						$semaine['mois'][]=$mois[date("n", mktime(0, 0, 0, 1, $i+$d, $year))] ;
						$semaine['annee'][]=$year;
				    }
			   return $semaine;
			   break;
			  }
		 }
	
	
}

function arriver(){
	$bdd=new bdd;
	$data=array('','e','',date('Y-m-d H:m:s'));
	$result=$bdd->tab('insert into `es`(`id`, `es`, `id_user`, `temps`) VALUES( ?, ?, ?, ?) ', $data);
	

}
function partir(){
	date_default_timezone_set('Europe/Paris');
	$bdd=new bdd;
	$data=array('','s','',date('Y-m-d H:m:s'));
	$result=$bdd->tab('insert into `es`(`id`, `es`, `id_user`, `temps`) VALUES( ?, ?, ?, ?) ', $data);
}
?>
<?php
	if(check_admin()){
		function list_user($id=''){
			$bdd=new bdd();
			if($id==''){
				$result=$bdd->tab("select a.begin as begin, a.id as id, a.username as username, a.nom as nom, a.prenom as prenom, a.acl as acl, a.mail as mail, b.nom as contrat , b.pourcent as pourcent, a.state as state  from users a, contrat b where a.id_contrat=b.id", '');
			}
			if($id!=''){
				$array=array($id);
				$result=$bdd->tab("select  a.begin as begin, a.id as id, a.username as username, a.nom as nom, a.prenom as prenom, a.acl as acl, a.mail as mail, b.nom as contrat , b.pourcent as pourcent, a.state as state  from users a, contrat b where a.id_contrat=b.id and a.id=?", $array);
			}
			
			return $result;
		}
		function add_user($nom,$prenom,$password,$acl, $mail, $contrat,$begin){
				$password=hash('sha512', $password);
				$username=strtolower(substr($prenom,0).$nom);
				if(!check_exist($username)){
					$bdd=new bdd();
					$array=array($username,$nom,$prenom,$password,$acl, $mail, $contrat,$begin);
					$bdd->tab("insert into users set username=?, nom=?, prenom=?, password=?, acl=?, mail=?, id_contrat=?, begin=?,state='1'", $array);
					echo '<div style="border:solid 2px green;background:lightgreen;color:green;padding:1em;display:inline-block" class="droid"> utilisateur ajouté avec succès</div><meta http-equiv="refresh" content="2; URL=admin.php?action=user">';
				}
				else{
					echo '<div style="border:solid 2px red; background:pink;color:red;padding:1em;display:inline-block" class="droid">erreur : utilisateur déja existant</div>';
				}
				
		}
		function gentimeline($id){
			$content='';
			$mem='';
			$mem2='';
			$mem3=array();
			$mem4=array();
			$mem5=0;
			$c=0;
			$class='timeline';
			$bdd=new bdd;
			$result=$bdd->tab('SELECT a.id as id, a.nom, a.prenom,b.date, b.nb, b.comment FROM users a,heure b WHERE a.id=b.id_user and b.id_cat=? order by b.date desc',array($id));
			$result=$result[0];
			$content= '<div class="col-md-6"><div class="page-header">
				        <h1 id="timeline">Timeline</h1>
				    </div>
				    <ul class="timeline">';
			for($i=0;$i<count($result);$i++){
				if($i==0 or end($mem2)!=date('Y-m',strtotime($result[$i]['date']))) $mem2[]=date('Y-m',strtotime($result[$i]['date']));
				$user=$result[$i]['nom'].' '.$result[$i]['prenom'];
				if(!in_array($user, $mem3)){
					$mem3[]=$user;
					$mem4[]=$result[$i]['id'];
				}
				$time=sectohour($result[$i]['nb']);
				if(!isset($time['heure']))$time['heure']="00";
				if(!isset($time['minutes']))$time['minutes']="00";
				if(!isset($time['second']))$time['second']="00";
				if($mem==$result[$i]['date']){ //on complete avec les evenement de la date
					$content.='<hr><small class="text-muted">
								<i class="glyphicon glyphicon-user"></i> '.$result[$i]['nom'].' '.$result[$i]['prenom'].' </small>
								         	<small class="text-muted"> <i class="glyphicon glyphicon-chevron-right"></i> <i class="glyphicon glyphicon-time"></i> '.$time['h'].' h '.$time['m'].'
								         	</small>
								        </p>
								       	<p>'.$result[$i]['comment'].'</p>';
			 	}else{
			 		if($i!=0){ //nouvelle date nouveau contener
			 			$content.= '</div></div>
					        </li>';
			 		}
			 			$c++;
						$mem=$result[$i]['date'];	
						if($c%2==0) $class='timeline-inverted';
						else $class='timeline';
						$content.='<li class="'.$class.'">
								<div class="timeline-badge success">
									<i class="glyphicon glyphicon-check"></i>
								</div>
								<div class="timeline-panel">
								    <div class="timeline-heading">
								        <h4 class="timeline-title"><i class="glyphicon glyphicon-calendar"></i> '.$result[$i]['date'].'</h4>
								    </div>
								    <div class="timeline-body">
								    	 <p>
								         	<small class="text-muted">
								         	  <i class="glyphicon glyphicon-user"></i> '.$result[$i]['nom'].' '.$result[$i]['prenom'].' </small>
								         	<small class="text-muted"> <i class="glyphicon glyphicon-chevron-right"></i> <i class="glyphicon glyphicon-time"></i> '.$time['h'].' h '.$time['m'].'
								         	</small>
								        </p>
								       	<p>'.$result[$i]['comment'].'</p>';
			  	}
			}
			$content.= '</div></div>
					        </li></ul></div>';
			$content.='<div class="col-md-6"><br>
						<table class="table table-hover">
						    <thead>
						      <tr> 
						      <th>Date</th>';
						      foreach ($mem3 as $users) {
						      	$content.=" <th>".$users."</th>";
						      }
						       $content.=' <th>total</th>
						      </tr>
						    </thead>
						    <tbody>';
						    foreach ($mem2 as $date) {
						    	$content.= '<tr>
								        <td>'.$date.'</td>';
								$mem5=0;
								        foreach ($mem4 as $id_user) {
								        	$result2=$bdd->tab("SELECT sum(nb) as nb FROM heure WHERE DATE_FORMAT(date,'%Y-%m')=? and id_user=? and id_cat=?;",array($date,$id_user,$id));
								        	$mem5+=$result2[0][0]['nb'];
								        	$t=sectohour($result2[0][0]['nb']);
								        	$content.='<td>'.$t['h'].' H '.$t['m'].'</td>';
								        }
								        $tt=sectohour($mem5);
								        $content.='<td>'.$tt['h'].' H '.$tt['m'].'</td>';
								     $content.=' </tr>';
								   
						    }
			$content.='</table>
								</div>';
						      
			echo $content;


		}
		function delete_user($id){
			$bdd=new bdd();
			$array=array($id);
			$bdd->tab("DELETE FROM `users` WHERE id=?", $array);
			echo '<div style="border:solid 2px green;background:lightgreen;color:green;padding:1em;display:inline-block" class="droid"> utilisateur supprimé avec succès</div><meta http-equiv="refresh" content="2; URL=admin.php?action=user">';
		}
		function update_user($nom,$prenom,$password,$acl, $mail, $contrat,$id,$begin){
			$array=array();
			$req='UPDATE `users` SET ';	
			if(!empty($password)){$req.="password=?,";$array[]=hash('sha512', $password);}
			if(!empty($nom)){$req.="nom= ?, ";$array[]=$nom;}
			if(!empty($prenom)){$req.="prenom= ?, ";$array[]=$prenom;}
			if(!empty($mail)){$req.="mail= ?, ";$array[]=$mail;}
			$req.= "id_contrat=?, acl=? ,begin=?,state='1' where id=?";
      if(!empty($contrat) and !empty($acl) and !empty($begin) and !empty($id)){
  			$array[]=$contrat;
  			$array[]=$acl;
  			$array[]=$begin;
  			$array[]=$id;
  			$bdd=new bdd();

  			$bdd->tab($req, $array);
  			echo '<div style="border:solid 2px green;background:lightgreen;color:green;padding:1em;display:inline-block" class="droid"> utilisateur mis à jour avec succès</div><meta http-equiv="refresh" content="2; URL=admin.php?action=user">';	
      }else{
        	echo '<div style="border:solid 2px red; background:pink;color:red;padding:1em;display:inline-block" class="droid">erreur : vous n\'avez probablement pas remplity les champs obligatoire : -contrat<br>-niveau de droit<br>-date de debut</div>';
      }		
		}
		//gestion des catégories
		function add_cat($cat, $catdom, $intern=0){
			$bdd=new bdd();
			$array=array($cat,$catdom);
			$bdd->tab('insert into categorie set  nom=?, id_domaine=?, cir=0',$array);
			if($intern==0){
				echo '<div style="border:solid 2px green;background:lightgreen;color:green;padding:1em;display:inline-block" class="droid"> catégorie ajoutée avec succès</div><meta http-equiv="refresh" content="2; URL=admin.php?action=categorie">';
			}else{
				return $bdd->lastid();
			}
			
		}
		function rename_cat($cat,$name, $catdom, $cir){
			$bdd=new bdd();
			if($cir=='on') $cir=1;
			else $cir=0;
			$array=array($name,$catdom,$cir,$cat);
			$bdd->tab('UPDATE categorie SET nom=?, id_domaine=? , cir=? where id=?',$array);
			echo '<div style="border:solid 2px green;background:lightgreen;color:green;padding:1em;display:inline-block" class="droid"> catégorie ajoutée avec succès</div><meta http-equiv="refresh" content="2; URL=admin.php?action=categorie">';
		}
		function delete_cat($id){
			$bdd=new bdd();
			$result=$bdd->tab('select id_domaine from categorie where id=?',array($id));

			$array=array($id);
			if($result[0][0]['id_domaine']!=7){
				$bdd->tab("DELETE FROM `categorie` WHERE id=?", $array);
			echo '<div style="border:solid 2px green;background:lightgreen;color:green;padding:1em;display:inline-block" class="droid"> catégorie supprimé avec succès</div><meta http-equiv="refresh" content="2; URL=admin.php?action=categorie">';
			}
			else{
				echo '<div style="border:solid 2px red; background:pink;color:red;padding:1em;display:inline-block" class="droid">Catégorie nessessaire au fonctionnement de l\'application</div>';
			}
			
		}
		//gestion des domaine
		function add_dom($dom){
			$bdd=new bdd();
			$array=array($dom);
			$bdd->tab('insert into domaine set  nom=?',$array);
			echo '<div style="border:solid 2px green;background:lightgreen;color:green;padding:1em;display:inline-block" class="droid"> domaine ajoutée avec succès</div><meta http-equiv="refresh" content="2; URL=admin.php?action=domaine">';
		}
		function rename_dom($dom,$name){
			$bdd=new bdd();
			$array=array($name,$dom);
			$bdd->tab('UPDATE domaine SET nom=? where id=?',$array);
			echo '<div style="border:solid 2px green;background:lightgreen;color:green;padding:1em;display:inline-block" class="droid"> domaine ajoutée avec succès</div><meta http-equiv="refresh" content="2; URL=admin.php?action=domaine">';
		}
		function delete_dom($id){
			$bdd=new bdd();
			$array=array($id);
			if($id!=7){
				$bdd->tab("DELETE FROM `domaine` WHERE id=?", $array);
			echo '<div style="border:solid 2px green;background:lightgreen;color:green;padding:1em;display:inline-block" class="droid"> domaine supprimé avec succès</div><meta http-equiv="refresh" content="2; URL=admin.php?action=domaine">';
			}else{
				echo '<div style="border:solid 2px red; background:pink;color:red;padding:1em;display:inline-block" class="droid">Domaine nessessaire au fonctionnement de l\'application</div>';
			}
			
		}
		function delcontrat($id){
			$bdd=new bdd();
			$array=array($id);
			$user=$bdd->tab('select * from users where id_contrat=?',$array);
			$user=$user[0];
			if(empty($user)){
				$bdd->tab("DELETE FROM `contrat` WHERE id=?", $array);
				echo '<div style="border:solid 2px green;background:lightgreen;color:green;padding:1em;display:inline-block" class="droid"> contrat supprimé avec succès</div><meta http-equiv="refresh" content="2; URL=admin.php?action=contrat">';
			}
			else{
					echo '<div style="border:solid 2px red; background:pink;color:red;padding:1em;display:inline-block" class="droid">erreur : un/des utilisateur(s) utilise(nt) ce contrat : <br>
					';
					for($i=0;$i<count($user);$i++){
						echo '- '.$user[$i]['nom'].' '.$user[$i]['prenom'];
					}

					echo '</div>';
				}

		}
		function updatecontrat($array){
			$bdd=new bdd();
			$bdd->tab("UPDATE `contrat` SET `nom`=?,`pourcent`=?,`conge`=? WHERE id=?",$array);
			echo '<div style="border:solid 2px green;background:lightgreen;color:green;padding:1em;display:inline-block" class="droid"> contrat mis à jour avec succès</div><meta http-equiv="refresh" content="2; URL=admin.php?action=contrat">';
		}
		function addcontrat($array){
			$bdd=new bdd();
			$bdd->tab("INSERT INTO `contrat`( `nom`, `pourcent`, `conge`) VALUES ( ?, ?, ?)",$array);
			echo '<div style="border:solid 2px green;background:lightgreen;color:green;padding:1em;display:inline-block" class="droid"> contrat ajouter avec succès</div><meta http-equiv="refresh" content="2; URL=admin.php?action=contrat">';
		}
		function modifmotif($nom,$type,$id){
			$bdd=new bdd();
			$array=array($nom,$type,$id);
			$bdd->tab('update motif set nom = ?, type=? where id=?',$array);
			echo '<div style="border:solid 2px green;background:lightgreen;color:green;padding:1em;display:inline-block" class="droid"> motif mis à jour avec succès</div><meta http-equiv="refresh" content="2; URL=admin.php?action=motif">';
		}
		function delmotif($id){
			$bdd=new bdd();
			$a=$bdd->tab('select id_cat from motif where id=?',array($id));
			$array=array($a[0][0]['id_cat']);
			$bdd->tab('DELETE FROM `categorie` WHERE id=?',$array);
			$array=array($id);
			$bdd->tab("DELETE FROM `motif` WHERE id=?", $array);
			echo '<div style="border:solid 2px green;background:lightgreen;color:green;padding:1em;display:inline-block" class="droid"> motif supprimé avec succès</div><meta http-equiv="refresh" content="2; URL=admin.php?action=motif">';

		}
		function addmotif($nom,$type){
			$bdd=new bdd();
			$idcat=add_cat($nom,'7','1');
			$array=array($type,$nom,$idcat);
			$bdd->tab("INSERT INTO `motif`( `type`, `nom`, `id_cat`) VALUES (?,?,?)", $array);
			echo '<div style="border:solid 2px green;background:lightgreen;color:green;padding:1em;display:inline-block" class="droid"> motif ajouté avec succès</div><meta http-equiv="refresh" content="2; URL=admin.php?action=motif">';
			
		}
		
		function credit_conge(){
			$bdd=new bdd();
			$user=$bdd->tab('select a.id as id, b.conge as conge, a.begin as begin from users a, contrat b where a.id_contrat=b.id ','');
			for($i=0;$i<count($user);$i++){
				$datetime1 = strtotime($user[$i]['begin']);
				$datetime2 = strtotime('now');
				$nbs=$datetime2-$datetime1;
				$nbs=intval($nbs/86400);
				$test=$bdd->tab('select * from credit_conge where id_user=?',array($user[$i]['id']));
				$test=$test[0];
				if(isset($test[0])){
					if($nbs<=363){ //si moins d\'un ans d'ancieneté calcul au prorata
						$hj=$user[$i]['conge']/365;
						$conge=ceil($nbs*$hj);
						$array2=array($conge,$user[$i]['id']);
						$bdd->tab("UPDATE `credit_conge` SET `nb_jour`=? WHERE id_user=?",$array2);

					}else{
						$array=array($user[$i]['conge'],$user[$i]['id']);
						$bdd->tab("UPDATE `credit_conge` SET `nb_jour`=? WHERE id_user=?",$array);
					}
				}else{
					if($nbs<=363){ //si moins d\'un ans d'ancieneté calcul au prorata
						$hj=$user[$i]['conge']/365;
						$conge=ceil($nbs*$hj);
						$array2=array($conge,$user[$i]['id']);
						$bdd->tab("insert into credit_conge ( `nb_jour`, `id_user`) VALUES (?,?)",$array2);

					}else{
						$array=array($user[$i]['conge'],$user[$i]['id']);
						$bdd->tab("insert into credit_conge ( `nb_jour`, `id_user`) VALUES (?,?)",$array);
					}
				}
			}
		}
		function admconge($id, $state){
			$bdd=new bdd();
			$bdd->tab("update conge set state= ? where id=?",array($state,$id));
			$type=$bdd->tab('select a.state as state, a.id_motif as motif, b.type as type,b.id_cat as id_cat, a.end as end, a.begin as begin, a.id_user as id_user from conge a , motif b where b.id=a.id_motif and a.id=?',array($id));
			$type=$type[0];
			
			
			$jour='86400'; //jour en seconde
			$end=explode(" ",$type[0]['end']);
			$begin=explode(" ",$type[0]['begin']);
			$begins=strtotime($begin[0]);
			$ends=strtotime($end[0]);
			$nb=sectohour($ends-$begins);
			$nbj=intval($nb['h']/24);
			$compteur=$begins;
			$nbjt=0;
			if($type[0]['type']==2){  // dans le cas d'un deplacement on recrédite les heures sur le compte
				for($i=0;$i<$nbj+1;$i++){
					if(isHoliday($compteur)!=1){  //check si c'est un jour de congé
						if($begins==$ends){  //si la personne a pris une demie journé
							$nbh=hourtosec($end[1])-hourtosec($begin[1]); //nombre de seconde
							 $bdd->tab("insert into `heure`( `id_user`, `nb`, `id_cat`, `date`) VALUES (?,?,?,?)",array($type[0]['id_user'], $nbh,$type[0]['id_cat'],$begin[0]));
						}else{
							
							if($begins==$compteur or $ends==$compteur){ //si on arrive au debut ou la fin de la periode demandée
								if($begins==$compteur){
									if($begin[1]=='08:30:00')$n='9:30';//on enleve 1h le soir pour compenser la pause dejeuner
									if($begin[1]=='13:00:00')$n='13:30';
									$nbh=hourtosec('16:30')-(hourtosec($n)); 
									$bdd->tab("insert into `heure`( `id_user`, `nb`, `id_cat`, `date`) VALUES (?,?,?,?)",array($type[0]['id_user'], $nbh,$type[0]['id_cat'],$begin[0]));
								}else{

									if($end[1]=='12:00:00')$n='12:00';//on enleve 1h le soir pour compenser la pause dejeuner
									if($end[1]=='16:30:00')$n='15:30';
									$nbh=hourtosec($n)-hourtosec('08:30'); 

									$bdd->tab("insert into `heure`( `id_user`, `nb`, `id_cat`, `date`) VALUES (?,?,?,?)",array($type[0]['id_user'], $nbh,$type[0]['id_cat'],$end[0]));
								
								}
							}else{//sinon
								
								$bdd->tab("insert into `heure`( `id_user`, `nb`, `id_cat`, `date`) VALUES (?,?,?,?)",array($type[0]['id_user'], '25200',$type[0]['id_cat'],date('Y-m-d',$compteur)));
							}

						}
					}//fin check jour de congé

					$compteur=$compteur+$jour;
				}//fin boucle for
		}//fin du type deplacement
		if($type[0]['type']==1){  // dans le cas d'un conge paye
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
									$bdd->tab("insert into `heure`( `id_user`, `nb`, `id_cat`, `date`) VALUES (?,?,?,?)",array($type[0]['id_user'], $nbh,$type[0]['id_cat'],$begin[0]));
								}else{
									
									if($end[1]=='12:00:00')$n='12:00';//on enleve 1h le soir pour compenser la pause dejeuner
									if($end[1]=='16:30:00')$n='15:30';
									$nbh=hourtosec($n)-hourtosec('08:30');
									$nbjt=$nbjt+$nbh;
									$bdd->tab("insert into `heure`( `id_user`, `nb`, `id_cat`, `date`) VALUES (?,?,?,?)",array($type[0]['id_user'], $nbh,$type[0]['id_cat'],$end[0]));
								}
							}else{//sinon
								$nbjt=$nbjt+$nbh;
								$bdd->tab("insert into `heure`( `id_user`, `nb`, `id_cat`, `date`) VALUES (?,?,?,?)",array($type[0]['id_user'], '25200',$type[0]['id_cat'],date('Y-m-d',$compteur)));
							}

						}
					}//fin check jour de congé

					$compteur=$compteur+$jour;
				}//fin boucle for
					
				if($type[0]['state']==1){ //si il a déja été valider on recredite le solde de congé de l'utilisateur
				$nbjt=($nbjt/3600)/7;
				//echo $nbjt."<br>".$conge[0]['nb_jour']."<br>";
				$nbjt=$conge[0]['nb_jour']-$nbjt*12;
				//echo $nbjt;
				$bdd->tab('update credit_conge set nb_jour=? where id_user=?',array($nbjt,$type[0]['id_user']));

				}
		}//fin du type congé paye
		echo '<div style="border:solid 2px green;background:lightgreen;color:green;padding:1em;display:inline-block" class="droid"> conge mis à jour avec succès</div>';
	}//fin fonction
		//<meta http-equiv="refresh" content="2; URL=admin.php?action=conge">

	}//fin de la verif admin
	
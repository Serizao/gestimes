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
<<<<<<< HEAD
					$bdd->tab("insert into users set username=?, nom=?, prenom=?, password=?, acl=?, mail=?, id_contrat=?, begin=?,state='1'", $array);
=======
					$bdd->tab("insert into users set id='', username=?, nom=?, prenom=?, password=?, acl=?, mail=?, id_contrat=?, begin=?,state='1'", $array);
>>>>>>> origin/master
					echo '<div style="border:solid 2px green;background:lightgreen;color:green;padding:1em;display:inline-block" class="droid"> utilisateur ajouté avec succès</div><meta http-equiv="refresh" content="2; URL=admin.php?action=user">';
				}
				else{
					echo '<div style="border:solid 2px red; background:pink;color:red;padding:1em;display:inline-block" class="droid">erreur : utilisateur déja existant</div>';
				}
				
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
<<<<<<< HEAD
      if(!empty($contrat) and !empty($acl) and !empty($begin) and !empty(id)){
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
=======
			$array[]=$contrat;
			$array[]=$acl;
			$array[]=$begin;
			$array[]=$id;
			$bdd=new bdd();
			$bdd->tab($req, $array);
			echo '<div style="border:solid 2px green;background:lightgreen;color:green;padding:1em;display:inline-block" class="droid"> utilisateur mis à jour avec succès</div><meta http-equiv="refresh" content="2; URL=admin.php?action=user">';			
>>>>>>> origin/master
		}
		//gestion des catégories
		function add_cat($cat, $catdom){
			$bdd=new bdd();
			$array=array($cat,$catdom);
<<<<<<< HEAD
			$bdd->tab('insert into categorie set  nom=?, id_domaine=?',$array);
=======
			$bdd->tab('insert into categorie set id="", nom=?, id_domaine=?',$array);
>>>>>>> origin/master
			echo '<div style="border:solid 2px green;background:lightgreen;color:green;padding:1em;display:inline-block" class="droid"> catégorie ajoutée avec succès</div><meta http-equiv="refresh" content="2; URL=admin.php?action=categorie">';
		}
		function rename_cat($cat,$name, $catdom){
			$bdd=new bdd();
			$array=array($name,$catdom,$cat);
			$bdd->tab('UPDATE categorie SET nom=?, id_domaine=? where id=?',$array);
			echo '<div style="border:solid 2px green;background:lightgreen;color:green;padding:1em;display:inline-block" class="droid"> catégorie ajoutée avec succès</div><meta http-equiv="refresh" content="2; URL=admin.php?action=categorie">';
		}
		function delete_cat($id){
			$bdd=new bdd();
			$array=array($id);
			if($id!=33 and $id!=34){
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
<<<<<<< HEAD
			$bdd->tab('insert into domaine set  nom=?',$array);
=======
			$bdd->tab('insert into domaine set id="", nom=?',$array);
>>>>>>> origin/master
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
<<<<<<< HEAD
			$bdd->tab("INSERT INTO `contrat`( `nom`, `pourcent`, `conge`) VALUES ( ?, ?, ?)",$array);
=======
			$bdd->tab("INSERT INTO `contrat`(`id`, `nom`, `pourcent`, `conge`) VALUES ('', ?, ?, ?)",$array);
>>>>>>> origin/master
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
			$array=array($id);
			$bdd->tab("DELETE FROM `motif` WHERE id=?", $array);
			echo '<div style="border:solid 2px green;background:lightgreen;color:green;padding:1em;display:inline-block" class="droid"> motif supprimé avec succès</div><meta http-equiv="refresh" content="2; URL=admin.php?action=motif">';

		}
		function addmotif($nom,$type){
			$bdd=new bdd();
			$array=array($type,$nom);
<<<<<<< HEAD
			$bdd->tab("INSERT INTO `motif`( `type`, `nom`) VALUES (?,?)", $array);
=======
			$bdd->tab("INSERT INTO `motif`(`id`, `type`, `nom`) VALUES ('',?,?)", $array);
>>>>>>> origin/master
			echo '<div style="border:solid 2px green;background:lightgreen;color:green;padding:1em;display:inline-block" class="droid"> motif ajouté avec succès</div><meta http-equiv="refresh" content="2; URL=admin.php?action=motif">';
			
		}
		function transfere($date,$id){
			$bdd=new bdd();
			$array=array($id,$date);
			$result=$bdd->tab("select a.nb as nb, b.nom as cat, a.id as id from heure a, categorie b where a.id_cat=b.id and id_user=? and DATE_FORMAT(`date`, '%Y-%m-%d')=?  ", $array);
			$result=$result[0];
			if(isset($result[0]['nb'])){
				echo '<select id="de" class="col-md-4">';
				for($i=0;$i<count($result);$i++){
						$nb=sectohour($result[$i]['nb']);
						echo '<option value="'.$result[$i]['id'].'" max="'.$nb['h'].':'.$nb['m'].'">de '.$result[$i]['cat'].' ( '.$nb['h'].'h'.$nb['m'].' disponible ) </option>';
				}
				echo '</select>';
				echo '<input type="time" id="nb_transf"/>';
				$cat=$bdd->tab('select * from categorie','');
				echo '<br>';

				echo '<select id="vers" class="col-md-4">';
				for($i=0;$i<count($cat);$i++){
						echo '<option value="'.$cat[$i]['id'].'">vers '.$cat[$i]['nom'].'</option>';

				}
				echo '</select>';
				echo '<input id="valid_transfere" onclick="valid_transfere();" type="button" value="valider le changement" class="col-md-4">';
			}else{
				echo 'pas de temps sur ce jour la avec cet utilisateur';
			}
			
		}
		function transfere_v($id,$date,$user,$time,$vers,$de){
			$bdd= new bdd();
			$array=array($de);
			$result=$bdd->tab("select nb from heure where id=?", $array);
			$time=hourtosec($time);
			if($time<=$result[0][0]['nb']){
				$futur=$result[0][0]['nb']-$time;
				$array1=array($futur,$de);
				$array2=array($user,$time,$vers,$date);
				if($futur>0){
					$bdd->tab('update heure set nb=? where id=?',$array1);
				}
<<<<<<< HEAD
				$bdd->tab("INSERT INTO `heure`( `id_user`, `nb`, `id_cat`, `date`) VALUES (?,?,?,?)",$array2);
=======
				$bdd->tab("INSERT INTO `heure`(`id`, `id_user`, `nb`, `id_cat`, `date`) VALUES ('',?,?,?,?)",$array2);
>>>>>>> origin/master
				echo '<div style="border:solid 2px green;background:lightgreen;color:green;padding:1em;display:inline-block" class="droid"> heure modifié avec succès</div><meta http-equiv="refresh" content="2; URL=admin.php?action=geshour">';

			}else{
				echo '<div style="border:solid 2px red; background:pink;color:red;padding:1em;display:inline-block" class="droid">le temps est sans doute trop élevé</div>';
			}

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
<<<<<<< HEAD
						$bdd->tab("insert into credit_conge ( `nb_jour`, `id_user`) VALUES (?,?)",$array2);

					}else{
						$array=array($user[$i]['conge'],$user[$i]['id']);
						$bdd->tab("insert into credit_conge ( `nb_jour`, `id_user`) VALUES (?,?)",$array);
=======
						$bdd->tab("insert into credit_conge (`id`, `nb_jour`, `id_user`) VALUES ('',?,?)",$array2);

					}else{
						$array=array($user[$i]['conge'],$user[$i]['id']);
						$bdd->tab("insert into credit_conge (`id`, `nb_jour`, `id_user`) VALUES ('',?,?)",$array);
>>>>>>> origin/master
					}
				}
			}
		}
		function admconge($id, $state){
			$bdd=new bdd();
<<<<<<< HEAD
			$bdd->tab("update conge set state= ? where id=?",array($state,$id));
			$type=$bdd->tab('select a.state as state, b.type as type, a.end as end, a.begin as begin, a.id_user as id_user from conge a , motif b where b.id=a.id_motif and a.id=?',array($id));
			$type=$type[0];
			
=======
			$type=$bdd->tab('select b.type as type, a.end as end, a.begin as begin, a.id_user as id_user from conge a , motif b where b.id=a.id_motif and a.id=?',array($id));
			$type=$type[0];
			$bdd->tab("update conge set state= ? where id=?",array($state,$id));
>>>>>>> origin/master
			
			$jour='86400'; //jour en seconde
			$end=explode(" ",$type[0]['end']);
			$begin=explode(" ",$type[0]['begin']);
			$begins=strtotime($begin[0]);
			$ends=strtotime($end[0]);
			$nb=sectohour($ends-$begins);
			$nbj=intval($nb['h']/24);
			$compteur=$begins;
<<<<<<< HEAD
			$nbjt=0;
=======
>>>>>>> origin/master
			if($type[0]['type']==2){  // dans le cas d'un deplacement on recrédite les heures sur le compte
				for($i=0;$i<$nbj+1;$i++){
					if(isHoliday($compteur)!=1){  //check si c'est un jour de congé
						if($begins==$ends){  //si la personne a pris une demie journé
							$nbh=hourtosec($end[1])-hourtosec($begin[1]); //nombre de seconde
<<<<<<< HEAD
							 $bdd->tab("insert into `heure`( `id_user`, `nb`, `id_cat`, `date`) VALUES (?,?,'34',?)",array($type[0]['id_user'], $nbh,$begin[0]));
						}else{
							
							if($begins==$compteur or $ends==$compteur){ //si on arrive au debut ou la fin de la periode demandée
								if($begins==$compteur){
									if($begin[1]=='08:30:00')$n='9:30';//on enleve 1h le soir pour compenser la pause dejeuner
									if($begin[1]=='13:00:00')$n='13:30';
									$nbh=hourtosec('16:30')-(hourtosec($n)); 
									$bdd->tab("insert into `heure`( `id_user`, `nb`, `id_cat`, `date`) VALUES (?,?,'34',?)",array($type[0]['id_user'], $nbh,$begin[0]));
								}else{

									if($end[1]=='12:00')$n='12:00';//on enleve 1h le soir pour compenser la pause dejeuner
									if($end[1]=='16:30')$n='15:30';
									$nbh=hourtosec($n)-hourtosec('09:30'); 
									 $bdd->tab("insert into `heure`( `id_user`, `nb`, `id_cat`, `date`) VALUES (?,?,'34',?)",array($type[0]['id_user'], $nbh,$end[0]));
								}
							}else{//sinon
								
								$bdd->tab("insert into `heure`( `id_user`, `nb`, `id_cat`, `date`) VALUES (?,?,'34',?)",array($type[0]['id_user'], '25200',date('Y-m-d',$compteur)));
=======
							 $bdd->tab("insert into `heure`(`id`, `id_user`, `nb`, `id_cat`, `date`) VALUES ('',?,?,'34',?)",array($type[0]['id_user'], $nbh,$begin[0]));
						}else{
							
							if($begins==$compteur or $ends==$compteur){ //si on arrive au debut ou la fin de la periode demandée
								
								if($begins=$compteur){
									if($begin[1]=='08:30:00')$n='9:30';//on enleve 1h le soir pour compenser la pause dejeuner
									if($begin[1]=='13:00:00')$n='13:30';
									$nbh=hourtosec('16:30')-(hourtosec($n)); 
									$bdd->tab("insert into `heure`(`id`, `id_user`, `nb`, `id_cat`, `date`) VALUES ('',?,?,'34',?)",array($type[0]['id_user'], $nbh,$begin[0]));
								}else{
									if($end[1]=='12:00')$n='12:00';//on enleve 1h le soir pour compenser la pause dejeuner
									if($end[1]=='16:30')$n='15:30';
									$nbh=hourtosec($n)-hourtosec('09:30'); 
									 $bdd->tab("insert into `heure`(`id`, `id_user`, `nb`, `id_cat`, `date`) VALUES ('',?,?,'34',?)",array($type[0]['id_user'], $nbh,$end[0]));
								}
							}else{//sinon
								
								$bdd->tab("insert into `heure`(`id`, `id_user`, `nb`, `id_cat`, `date`) VALUES ('',?,?,'34',?)",array($type[0]['id_user'], '25200',date('Y-m-d',$compteur)));
>>>>>>> origin/master
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
<<<<<<< HEAD
									$nbjt=$nbjt+$nbh;
									$bdd->tab("insert into `heure`( `id_user`, `nb`, `id_cat`, `date`) VALUES (?,?,'33',?)",array($type[0]['id_user'], $nbh,$begin[0]));
=======
									$bdd->tab("insert into `heure`(`id`, `id_user`, `nb`, `id_cat`, `date`) VALUES ('',?,?,'33',?)",array($type[0]['id_user'], $nbh,$begin[0]));
>>>>>>> origin/master
								}else{
									
									if($end[1]=='12:00:00')$n='12:00';//on enleve 1h le soir pour compenser la pause dejeuner
									if($end[1]=='16:30:00')$n='15:30';
									$nbh=hourtosec($n)-hourtosec('08:30');
<<<<<<< HEAD
									$nbjt=$nbjt+$nbh;
									$bdd->tab("insert into `heure`( `id_user`, `nb`, `id_cat`, `date`) VALUES (?,?,'33',?)",array($type[0]['id_user'], $nbh,$end[0]));
								}
							}else{//sinon
								$nbjt=$nbjt+$nbh;
								$bdd->tab("insert into `heure`( `id_user`, `nb`, `id_cat`, `date`) VALUES (?,?,'33',?)",array($type[0]['id_user'], '25200',date('Y-m-d',$compteur)));
=======
									
									$bdd->tab("insert into `heure`(`id`, `id_user`, `nb`, `id_cat`, `date`) VALUES ('',?,?,'33',?)",array($type[0]['id_user'], $nbh,$end[0]));
								}
							}else{//sinon
								
								$bdd->tab("insert into `heure`(`id`, `id_user`, `nb`, `id_cat`, `date`) VALUES ('',?,?,'33',?)",array($type[0]['id_user'], '25200',date('Y-m-d',$compteur)));
>>>>>>> origin/master
							}

						}
					}//fin check jour de congé

					$compteur=$compteur+$jour;
				}//fin boucle for
<<<<<<< HEAD
					
				if($type[0]['state']==1){ //si il a déja été valider on recredite le solde de congé de l'utilisateur
				$nbjt=($nbjt/3600)/7;
				$nbjt=$conge[0]['nb_jour']-$nbjt;
				$bdd->tab('update credit_conge set nb_jour=? where id_user=?',array($nbjt,$type[0]['id_user']));

				}
=======
>>>>>>> origin/master
		}//fin du type congé paye
		echo '<div style="border:solid 2px green;background:lightgreen;color:green;padding:1em;display:inline-block" class="droid"> conge mis à jour avec succès</div>';
	}//fin fonction
		//<meta http-equiv="refresh" content="2; URL=admin.php?action=conge">

	}//fin de la verif admin
<<<<<<< HEAD
	
=======
	else{
		echo 'error';
	}
>>>>>>> origin/master

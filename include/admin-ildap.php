<?php
	include 'config/config.php';
	if(isset($_REQUEST['admin']))$ad_admin=$_REQUEST['admin'];
	if(isset($_REQUEST['password']))$ad_password=$_REQUEST['password'];

	if(isset($ad_admin) and isset($ad_password) and !empty($ad_admin) and !empty($ad_password)){
		if(isset($_REQUEST["user"])){
				$user=unserialize($_REQUEST['user']);
				echo '<h3>import de utilisateur suivent:</h3>';
				for($z=0;$z<count($user);$z++){
					if(isset($_REQUEST[$user[$z]['samaccountname']])){
						$bdd= new bdd();
						$array=array($user[$z]['samaccountname'],$user[$z]['last_name'],$user[$z]['first_name'],'','1', $user[$z]['email'], '','0000-00-00','0');                                                                                            
    		    $bdd->tab("insert into users set  username=?, nom=?, prenom=?, password=?, acl=?, mail=?, id_contrat=?, begin=?,state=?", $array);
        		echo '-'.$user[$z]['samaccountname'];
					}
				}
				echo '<br><br><div style="border:solid 2px green;background:lightgreen;color:green;padding:1em;display:inline-block" class="droid"> imort effectuer avec succès</div>';
		}else{
			$ad=new ad();
			$user=$ad->get_all_user($ad_admin,$ad_password);
			
			echo '<div class="panel panel-default">
					<div class="panel-heading">Liste des utilisateur de l\'active directory<br><form method="POST"><input type="submit" id="addselected" value="ajouter les utilisateur cochés à la base utilisateur"></div>
					<input type="hidden" placeholder="administrateur du ldap" name="admin" value="'.$ad_admin.'">
					<input type="hidden" name="password" placeholder="password" value="'.$ad_password.'">
					<input type="hidden" name="user" placeholder="password" value=\''.serialize($user).'\'>
					<table class="table">
						<thead>
							<tr>
								<th>#</th>
								<th>nom de connexion</th>
								<th>nom</th>
								<th>prenom</th>
								<th>mail</th>
								<th><input type="checkbox" /></th>
							</tr>
						</thead>
						<tbody>';

						for($z=0;$z<count($user);$z++){
							$show='<input class="user" name="'.$user[$z]['samaccountname'].'" type="checkbox" id="'.$user[$z]['samaccountname'].'" />';
							$bdd=new bdd();
							$array=array($user[$z]['samaccountname'], $user[$z]['last_name'],$user[$z]['first_name']);
							$ifexist=$bdd->tab('select * from users where username=? and nom=? and prenom=?', $array);
							if(isset($ifexist[0][0]['id']))$show='<span class="label label-danger">Utilisateur déja existant</span>';
							echo '<tr> <th scope="row">'.$z.'</th> <td>'.$user[$z]['samaccountname'].'</td> <td>'.$user[$z]['last_name'].'</td> <td>'.$user[$z]['first_name'].'</td><td>'.$user[$z]['email'].'</td><td>'.$show.'</td> </tr>';
						}
				echo    '</tbody>
					</table></form>
				</div>';



		}
		
	}else{
		echo '<H2>Authentification sur le serveur d\'annuaire</h2><form method="POST">
				<input type="text" placeholder="administrateur du ldap" name="admin">
				<input type="password" name="password" placeholder="password">
				<input type="submit" value="envoyer">
			</form>';
	}
	

?>
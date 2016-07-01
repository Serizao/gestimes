<div id="topdiv" class="row" style="margin-top:40px;">
	<div class="col-md-3">
		<?php
		$bdd=new bdd();
		$domaines=$bdd->tab('select * from domaine','');
		echo '<select onchange="change(\'choosedom\');" id="choosedom" class="col-md-12">';
		echo '<option></option>';
		for($i=0;$i<count($domaines);$i++){
			echo '<option value='.$domaines[$i]['id'].'>'.$domaines[$i]['nom'].'</option>';
		}
		echo'</select>';
		echo '<p>ou</p>';
		$cat=$bdd->tab('select * from categorie','');
		echo '<select onchange="change(\'choosecat\');" id="choosecat" class="col-md-12">';
		echo '<option></option>';
		for($i=0;$i<count($cat);$i++){
			echo '<option value='.$cat[$i]['id'].'>'.$cat[$i]['nom'].'</option>';
		}
		echo'</select>';
		echo '<p>ou</p>';
		$user=$bdd->tab('select * from users','');
		echo '<select onchange="change(\'chooseuser\');" id="chooseuser" class="col-md-12">';
		echo '<option></option>';
		for($i=0;$i<count($user);$i++){
			echo '<option value='.$user[$i]['id'].'>'.$user[$i]['prenom'].' '.$user[$i]['nom'].'</option>';
		}
		echo'</select>';



		?>
	</div>
	<div class="col-md-3">
		<div class="col-md-12">date de début
			<input type="month" id="begindate">
					</div>

		<div class="col-md-12"><br>date de fin
			<input type="month" id="enddate">
		</div>
		<div class="col-md-12">
			<br>

			<a id="export" href="#"><button class="col-md-12 btn btn-primary">exporter sur exel</button></a>
		</div>
	</div>
</div>
<div class="col-md-12" id="retour"><div>
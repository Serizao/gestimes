<?php
	$bdd=new bdd();
	$motif=$bdd->tab('select * from motif where 1','');
	echo '<div class="col-md-12">
			<div class="col-md-6">
				<h4 style="text-align:left">Les type:<br>
					1 -> congé qui ne sera pas deduit des heure suplémentaire et retournera un abcence de l\'utilisateur.<br>
					2 -> congé qui indiquera que l\'utilisateur est present (exemple deplacement).<br>
					3 -> congé qui sera deduit des heure suplémentaire et retournera une abcence <br>
				</h4>
			</div>
			<div class="col-md-6">
				<a href="#" data-width="500" data-rel="popup" class="poplight" style="color:black">
					<button >ajouter un motif</button>
				</a>
			</div>
			<div id="retour"></div>
			<table class="table table-bordered">
				<thead> <tr> <th>nom</th> <th>type</th> <th>action</th> </tr> </thead>
				<tbody>';
	for($i=0;$i<count($motif);$i++){
		echo '	<tr>
					<th id="nom'.$motif[$i]['id'].'">'.$motif[$i]['nom'].'</th>
					<th>'.$motif[$i]['type'].'</th>
					<th>
						<a href="#" data-width="500" data-rel="popup'.$motif[$i]['id'].'" class="poplight" style="color:black">
							<button >modifier le profil</button>
						</a>
						<input type="button" value="supprimer" class="delmotif" alt="'.$motif[$i]['id'].'"/>
					</th>
				</tr>';
	}


	echo '</tbody></div>';
	for($i=0;$i<count($motif);$i++){
		echo'
							        <div id="popup'.$motif[$i]['id'].'" alt="" class="popup_block">
							        	<form action="test.html"  method="POST" class="modifmotif" id="'.$motif[$i]['id'].'" alt="'.$motif[$i]['id'].'">
										  <input name="nom" id="nom'.$motif[$i]['id'].'" placeholder="nom" value='.$motif[$i]['nom'].' type="text"><br>
										  <input name="type" id="type'.$motif[$i]['id'].'" value="'.$motif[$i]['type'].'" type="text"><br>
										  <input type="submit" class="modifmotif" id="'.$motif[$i]['id'].'" value="envoyer"/>
										</form>
										<div id="retour'.$motif[$i]['id'].'"></div>
									</div>
									  ';
	}
	echo'
							        <div id="popup" alt="" class="popup_block">
							        	<form action="test.html"  method="POST" class="addmotif" id="motif" alt="">
										  <input name="nom" id="nom" placeholder="nom"  type="text"><br>
										  <input name="type" id="type" value="" type="text"><br>
										  <input type="submit" class="modifmotif" id="" value="envoyer"/>
										</form>
										<div id="retouradd"></div>
									</div>
									  ';
	?>
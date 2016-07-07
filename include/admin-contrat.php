<?php
user::check_admin();
echo '<h1> gestion des contrats</h1>';
$bdd    = new bdd();
$bdd->cache('select * from contrat', '');
$result = $bdd->exec();
echo '<div id="retour"></div>';
echo '<a href="#" data-width="500" data-rel="addcontrat" class="poplight" style="color:black">
			    <button>ajouter un contrat</button>
			</a><br><br>';
//echo '<input type="button" id="creditconge" value="crediter les contrat de leur congé annuel"/>';
echo '<table class="table table-striped">
		    <thead>
		      <tr>
		        <th>nom</th>
		        <th>pourcentage</th>
		        <th>congé/an</th>
		        <th>supprimer/modifier</th>
		      </tr>
		    </thead>
		    <tbody>';
for ($i = 0; $i < count($result); $i++) {
    echo '	<tr>
			        <td>' . $result[$i]['nom'] . '</td>
			        <td>' . $result[$i]['pourcent'] . '</td>
			        <td>' . $result[$i]['conge'] . '</td>
			        <td><input type="button" id="' . $result[$i]['id'] . '" class="delcontrat btn btn-danger" value="effacer">
			        	<a href="#" data-width="500" data-rel="popup' . $result[$i]['id'] . '" class="poplight" style="color:black"> 
			        		<button class="btn btn-primary">modifier le contrat</button>
			        	</a>
			        </td>
		    	</tr>';
}
echo '	</tbody>
    	</table>';
for ($i = 0; $i < count($result); $i++) {
    echo '	<div id="popup' . $result[$i]['id'] . '" alt="' . $result[$i]['id'] . '" class="popup_block updatecontrat">
					<form action="test.html"  method="POST" id="' . $result[$i]['id'] . '" >
						nom du contrat<br>
						<input name="nom" class="nom' . $result[$i]['id'] . '" placeholder="nom" type="text" value="' . $result[$i]['nom'] . '"><br><br>
						pourcentage de temps de travail<br>
						<input name="pourcentage" class="pourcentage' . $result[$i]['id'] . '" placeholder="poucentage" type="text" value="' . $result[$i]['pourcent'] . '"><br><br>
						nombre des congé annuel<br>
						<input name="conge" class="conge' . $result[$i]['id'] . '" placeholder="Nombre des congés annuel" type="text" value="' . $result[$i]['conge'] . '"><br>
						<br>

						<input class="input-btn in btn btn-primary" type="submit" value="Valider">
					</form>      
				    <div id="retour' . $result[$i]['id'] . '"></div>
				</div>';
    
}
echo '	<div id="addcontrat" alt="-1" class="popup_block addcontrat">
					<form action="test.html"  method="POST" id="addcontrat" class="-1">
						nom du contrat<br>
						<input name="nom" class="nom-1" placeholder="nom" type="text" ><br><br>
						pourcentage de temps de travail<br>
						<input name="pourcentage" class="pourcentage-1" placeholder="poucentage" type="text"><br><br>
						nombre des congé annuel<br>
						<input name="conge" class="conge-1" placeholder="Nombre des congés annuel" type="text"><br>
						<br>

						<input class="input-btn in btn btn-primary" type="submit" value="Valider">
					</form>      
				    <div id="retour-1"></div>
				</div>';

?>
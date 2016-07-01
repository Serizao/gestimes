<?php
//recuperation des infos
$bdd=new bdd();
$domaines=$bdd->tab('select * from domaine','');
echo '<div id="topdiv" style="margin-top:40px;"><input type="text" style="width:200px;" id="newcat" placeholder="nom de la nouvelle catégorie"/>';
echo '<select id="catdom">';
for($i=0;$i<count($domaines);$i++){
	echo '<option value='.$domaines[$i]['id'].'>'.$domaines[$i]['nom'].'</option>';
}
echo'</select><button class="btn btn-primary" id="subnewcat">ajouter la nouvelle catégorie</button></div><div id="retour"></div>';


$categories=$bdd->tab('select a.id as id, a.nom as nom, b.nom as domname , a.cir as cir from categorie a, domaine b where a.id_domaine=b.id ','');

//mise en forme sous forme de tableau
echo '<table style="width:100%;margin-top:40px;"><tr><th>domaine</th><th>nom</th><th>Eligible au CIR</th><th>action</th></tr>';
for($i=0;$i<count($categories);$i++){
	if($categories[$i]['cir']==0)$categories[$i]['cir']="non";
	else $categories[$i]['cir']="oui";
	echo '<tr><td>'.$categories[$i]['domname'].'</td><td id="catname'.$categories[$i]['id'].'">'.$categories[$i]['nom'].'</td><td id="cir'.$categories[$i]['id'].'">'.$categories[$i]['cir'].'</td><td><button class="delcat btn btn-danger" alt="'.$categories[$i]['id'].'">suprimer</button><button  alt="'.$categories[$i]['id'].'" class="renamecat btn btn-primary">renomer</button><div id="retour'.$categories[$i]['id'].'"></div></td></tr>';	
}
echo '</table>'
?>
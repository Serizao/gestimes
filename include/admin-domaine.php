<?php
//recuperation des infos

echo '<div id="topdiv" style="margin-top:40px;"><input type="text" style="width:200px;" id="newdom" placeholder="nom du nouveau domaine"/><button id="subnewdom" class="btn btn-primary">ajouter le nouveau domaine</button></div><div id="retour"></div>';

$bdd=new bdd();
$domaine=$bdd->tab('select * from domaine','');

//mise en forme sous forme de tableau
echo '<table style="width:100%;margin-top:40px;"><tr><th>nom</th><th>action</th></tr>';
for($i=0;$i<count($domaine);$i++){
	echo '<tr><td id="domname'.$domaine[$i]['id'].'">'.$domaine[$i]['nom'].'</td><td><button class="deldom btn btn-danger" alt="'.$domaine[$i]['id'].'">suprimer</button><button  alt="'.$domaine[$i]['id'].'" class="renamedom btn btn-primary">renomer</button><div id="retour'.$domaine[$i]['id'].'"></div></td></tr>';	
}
echo '</table>';

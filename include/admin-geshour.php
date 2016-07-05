<h1>transfère d'heure</h1>
<div class="col-md-6 col-md-offset-3">
	<div class="row">
<?php
echo '<input type="date" id="changetime" class="col-md-4">';
$bdd    = new bdd();
$user   = list_user();
$result = $bdd->tab("select id, nom from categorie", '');
echo '<select id="user" class="col-md-4" style="height: 24px">';
for ($i = 0; $i < count($user); $i++) {
    echo '<option value="' . $user[$i]['id'] . '">' . $user[$i]['nom'] . ' ' . $user[$i]['prenom'] . '</option>';
}
echo '</select>';
?>
<input type="button" class="btn btn-primary" value="voir les heures" id="okchangetime" >
<div id="transfretour"></div>
</div>


<meta charset="utf-8">
<script src="./js/jquery-1.12.0.min.js"></script>
<script src="./js/jquery-migrate-1.2.1.min.js"></script>
<script src="./js/highcharts.js"></script>
<script src="./js/modules/exporting.js"></script>
<?php
user::check_admin();
$bdd = new bdd();
$bdd->cache('select * from users', '');
$user = $bdd->exec();
echo '<div class="col-md-12" style=margin-top:40px;"><select class="col-md-6"  id="chooseuser" >';
echo '<option></option>';
for ($i = 0; $i < count($user); $i++) {
    echo '<option value=' . $user[$i]['id'] . '>' . $user[$i]['prenom'] . ' ' . $user[$i]['nom'] . '</option>';
}
?>
</select>
<div class="row">
		date de début
		<input type="month" id="begindate">
		date de fin
		<input type="month" id="enddate">	
		<button class="col-md-6 btn btn-primary" id="userview">envoyer</button>
	</div>
</div>
<br>
<div id="retour" class="col-md-12" ></div>
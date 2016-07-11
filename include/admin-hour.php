<?php
user::check_admin();
?>
<div id="topdiv" class="row" style="margin-top:40px;">
    <div class="col-md-3">
        <?php
$bdd      = new bdd();
$bdd->cache('select * from domaine', '');
$domaines = $bdd->exec();
echo '<select onchange="change(\'choosedom\');" id="choosedom" class="col-md-12">';
echo '<option></option>';
for ($i = 0; $i < count($domaines); $i++) {
    echo '<option value=' . $domaines[$i]['id'] . '>' . $domaines[$i]['nom'] . '</option>';
}
echo '</select>';
echo '<p>ou</p>';
$bdd->cache('select * from categorie', '');
$cat = $bdd->exec();
echo '<select onchange="change(\'choosecat\');" id="choosecat" class="col-md-12">';
echo '<option></option>';
for ($i = 0; $i < count($cat); $i++) {
    echo '<option value=' . $cat[$i]['id'] . '>' . $cat[$i]['nom'] . '</option>';
}
echo '</select>';
echo '<p>ou</p>';
$bdd->cache('select * from users', '');
$user = $bdd->exec();
echo '<select onchange="change(\'chooseuser\');" id="chooseuser" class="col-md-12">';
echo '<option></option>';
for ($i = 0; $i < count($user); $i++) {
    echo '<option value=' . $user[$i]['id'] . '>' . $user[$i]['prenom'] . ' ' . $user[$i]['nom'] . '</option>';
}
echo '</select>';
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
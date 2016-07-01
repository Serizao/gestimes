<?php
$bdd=new bdd;
$projet=$bdd->tab('select * from categorie where cir=1','');
echo '<dic class="col-md-4 col-md-offset-4"><select id="cir-proj-select" class="form-control" name="cir-proj">';
foreach ($projet as $key) {
  echo '<option value='.$key['id'].'>'.$key['nom'].'</option>';
}
echo '</select><br>';
echo '<button id="valid-proj-cir" class="btn btn-primary"> envoyer</button></div>';
?>


<div id="time-line">
   
</div>
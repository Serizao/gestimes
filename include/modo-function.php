<?php
if(user::check_modo()){

  function modoconge($id, $state, $id_valid)
  {
      $bdd = new bdd();
      $bdd->cache("update conge set state= ?, id_validator=? where id=?", array(
          $state,
          $id_valid,
          $id
      ));
      $bdd->exec();
      $bdd->cache('select a.id_user as id_user, b.mail as mail from hierachie_liaison a,users b where a.id_user_sup=b.id and id_user=?', array(
        $id_valid
      ));
      $manager            = $bdd->exec();
      if(isset($manager[0][0]['id_user'])){
        $send_mail=true;
      } else {
        $send_mail=false;
      }
      echo '<div style="border:solid 2px green;background:lightgreen;color:green;padding:1em;display:inline-block" class="droid"> conge mis à jour avec succès</div>';
      echo '<meta http-equiv="refresh" content="1; URL=http://time.triskem.fr/index.php?action=user-modo">';
      if($send_mail){
        sendmail($manager[0][0]['mail'], 'Demande de congé','Une nouvelle demande de congé vient de vous être envoyée','<p>Une nouvelle demande de congé vient de vous être demndée</p><br> <a href="https://temps.triskem.fr/admin.php?action=conge"> Cliquez ici pour y acceder</a><br><br><p>Cordialement,<br>Votre gestion du temps</p>' );
      }
    }
}

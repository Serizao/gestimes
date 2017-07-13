<?php
if(user::check_modo()){
  echo '<script src="js/modo.js"></script>';
  $valuebtn="modoconge";
if(user::check_admin()){
  echo '<script src="js/admin.js"></script>';
  include('include/admin-function.php');
  $valuebtn="admconge";
}
  echo '<div id="retour"></div>';
  $bdd = new bdd();
  $bdd->cache('select * from hierachie_liaison where id_user_sup=?',array(
    $_SESSION['id']
  ));
  $soususer=$bdd->exec();
  echo '<table class="table table-bordered">
                  <thead>
                      <tr>
                        <th>Heure(s) à récuperer</th>
                        <th>Congé(s) Payé(s)</th>
                        <th>date debut</th>
                        <th>date de fin</th>
                        <th>type de conge</th>
                        <th>user</th>
                        <th>action</th>
                      </tr>
                  </thead>
                  <tbody>';
          
  for($j=0;$j<count($soususer[0]);$j++){

    $bdd->cache("SELECT a.id as id, a.begin as begin, a.end as end,d.heure as hs, c.nom as nom,c.prenom as prenom, b.nom as type , c.username as user, e.nb_jour as nbj FROM conge a, motif b , users c,heure_sup d, credit_conge e where a.id_motif=b.id and  a.id_user=c.id and d.id_user=c.id and e.id_user=c.id and a.state=0 and a.id_validator='-1' and a.id_user=?",array(
      $soususer[0][$j]['id_user']
    ));

    $result = $bdd->exec();
    $result=$result[0];
    echo '<br>';
    for ($i = 0; $i < count($result); $i++) {
      echo $j;
      if (isset($result[$i]['hs'])) {
         $heure_sup = sectohour($result[$i]['hs']);
      } else {
          $heure_sup = array(
              'h' => '0',
              'm' => '0'
        );
      }

        if (isset($result[$i]['nbj'])) {
           $nbjc = $result[$i]['nbj']/12;
        }

        echo '  <tr>
                              <td>' . $heure_sup['h'] . ' heure(s)'.$heure_sup['h'] .' minute(s)</td>
                              <td>' . $nbjc . ' jour (s)</td>
                              <td>' . $result[$i]['begin'] . '</td>
                              <td>' . $result[$i]['end'] . '</td>
                              <td>' . $result[$i]['type'] . '</td>
                              <th>' . $result[$i]['nom'] . ' ' . $result[$i]['prenom'] . '</th>
                              <td><input type="button" class="'.$valuebtn.' btn btn-primary" alt="' . $result[$i]['id'] . '" value="accepter"/>
                                <input type="button" class="'.$valuebtn.' btn btn-danger" alt="' . $result[$i]['id'] . '" value="refuser"/>
                              </td>
                            </tr>';
    }
    
  }
  echo '     </tbody>
                </table>';
} else { echo 'vous n\'avez pas les droit'; }

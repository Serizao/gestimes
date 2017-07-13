<?php
user::check_admin();
echo '<div id="retour"></div>';
$bdd = new bdd();
$bdd->cache("SELECT a.id as id,c.id as id_user, a.begin as begin, a.end as end,d.heure as hs, c.nom as nom,c.prenom as prenom, b.nom as type , c.username as user, e.nb_jour as nbj, a.id_validator as manager FROM conge a, motif b , users c,heure_sup d, credit_conge e where a.id_motif=b.id and  a.id_user=c.id and d.id_user=c.id and e.id_user=c.id and a.id_validator!='-1' and a.state=0", '');
$result = $bdd->exec();
echo '<table class="table table-bordered">
                <thead>
                    <tr>
                      <th>Heure(s) à récuperer</th>
                      <th>Congé(s) Payé(s)</th>
                      <th>date debut</th>
                      <th>date de fin</th>
                      <th>type de conge</th>
                      <th>validé par</th>
                      <th>user</th>
                      <th>action</th>
                    </tr>
                </thead>
                <tbody>';
for ($i = 0; $i < count($result); $i++) {
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
if($result[$i]['manager']=="NULL" or $result[$i]['manager']==$result[$i]['id_user']){
  $valid="-------";
} else {
  $bdd->cache('select * from users where id=?', array(
      $result[$i]['manager']
  ));
  $req=$bdd->exec();
$valid=$req[0][0]['prenom'].' '.$req[0][0]['nom'];
}
    echo '  <tr>
                          <td>' . $heure_sup['h'] . ' heure(s)'.$heure_sup['h'] .' minute(s)</td>
                          <td>' . $nbjc . ' jour (s)</td>
                          <td>' . $result[$i]['begin'] . '</td>
                          <td>' . $result[$i]['end'] . '</td>
                          <td>' . $result[$i]['type'] . '</td>
                          <td>' . $valid . '</td>
                          <th>' . $result[$i]['nom'] . ' ' . $result[$i]['prenom'] . '</th>
                          <td><input type="button" class="admconge btn btn-primary" alt="' . $result[$i]['id'] . '" value="accepter"/>
                            <input type="button" class="admconge btn btn-danger" alt="' . $result[$i]['id'] . '" value="refuser"/>
                          </td>
                        </tr>';
}
echo '     </tbody>
            </table>';

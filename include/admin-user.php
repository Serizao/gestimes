<?php
user::check_admin();
echo '<br><br><br><br><a href="#" data-width="500" data-rel="popup" class="poplight" style="color:black"> <button class="btn btn-primary ">ajouter un utilisateur</button></a>'; //bouton pour faire apparaitre le popup
echo '
                                <div id="popup" alt="" class="popup_block popup">
                                  <form action="test.html"  method="POST" id="popup">
                                  <input name="nom" class="nom" placeholder="nom" type="text"><br>
                                  <input name="prenom" class="prenom" placeholder="prenom" type="text"><br>
                                  <input name="mail" class="mail" placeholder="mail" type="text"><br>
                                  <input name="password" class="password" placeholder="password" type="password"><br>
                                  <p>niveau de droit de cette utilisateur</p>
                                    <select class="acl">
                                        <option value="1" selected>user</option> 
                                        <option value="10">administrateur</option>
                                    </select>
                                    <br>
                                    <p>date debut du contrat</p>
                                    <input type="date" class="begin"><br>
                                    <p>Nombre de jour de congé</p>
                                    <input type="number" min="0" step="0.0000000000001" class="nbconge"><br>
                                    <p>nombre d\'heures du contrat de cet utilisateur</p>
                                    <select class="hour">';
$bdd    = new bdd();
$bdd->cache('select * from contrat', '');
$contra = $bdd->exec();
for ($p = 0; $p < count($contra); $p++) {
    
    echo '<option  value="' . $contra[$p]['id'] . '" selected>' . $contra[$p]['nom'] . '</option> ';
}
echo '
                                    </select><br><br>
                                    <input class="input-btn in" type="submit" value="Valider">
                                  </form>
                                  
                                  <div id="retour"></div>
                                </div>'; //popu qui apparaitra au clique pour le add user

$result = list_user();

$bdd->cache('select a.begin as begin, a.id as id, a.username as username, a.nom as nom, a.prenom as prenom, a.acl as acl, a.mail as mail , a.state as state  from users a where a.state=1', '');
$result2 = $bdd->exec();
echo '<div id="exTab2" class="container"> 
            <ul class="nav nav-tabs">
                <li class="active">
                    <a  href="#1" data-toggle="tab">Utilisateurs actifs</a>
                </li>
                <li>
                    <a href="#2" data-toggle="tab">Utilisateurs desactivés</a>
                </li>
            </ul>
            <div class="tab-content ">
                <div class="tab-pane active" id="1">';
echo '<table style="width:100%;margin-top:40px;"><tr><th>login</th><th>nom</th><th>prenom</th><th>fiche utilisateur<s/th><tr>'; //header du tableau
for ($i = 0; $i < count($result2); $i++) { //liste de utilisateur pour cr�� la table et les popup
    //var_dump($result);

    $result = list_user($result2[$i]['id']);
    $result = $result[0];
    if (!isset($result[0]['contrat'])) {
        $plein = "";
        $semi  = "";
    }
    if (isset($result[0]['contrat']) and $result[0]['contrat'] == '35') {
        $plein = "selected";
        $semi  = "";
    }
    if (isset($result[0]['contrat']) and $result[0]['contrat'] == '28') {
        $semi  = "selected";
        $plein = "";
    }
    if (!isset($result[0]['acl'])) {
        $user  = "";
        $admin = "";
    }
    if (isset($result[0]['acl']) and $result[0]['acl'] == '1') {
        $user  = "selected";
        $admin = "";
    }
    if (isset($result[0]['acl']) and $result[0]['acl'] == '10') {
        $admin = "selected";
        $user  = "";
    }
    echo '<tr><th>' . $result2[$i]['username'] . '</th><th>' . $result2[$i]['nom'] . '</th><th>' . $result2[$i]['prenom'] . '</th><th><h4><a href="#" data-width="500" data-rel="popup' . $result2[$i]['id'] . '" class="poplight" style="color:black"> <button class="btn btn-primary " >fiche de ' . $result2[$i]['prenom'] . '</button></a>';
    if (!isset($result[0]['contrat']) or $result[0]['state']!=1)
        echo '  <span class="label label-danger">Utilisateur desactivé</span></h4>';
    echo '</th></tr>';
    
    echo '
                                <div id="popup' . $result2[$i]['id'] . '" alt="' . $result2[$i]['id'] . '" class="popup_block popup">
                                  <form action="test.html"  method="POST" id="popup">
                                  <input name="nom" class="nom' . $result2[$i]['id'] . '" placeholder="' . $result2[$i]['nom'] . '" value="' . $result2[$i]['nom'] . '" type="text"><br>
                                  <input name="prenom" class="prenom' . $result2[$i]['id'] . '" placeholder="' . $result2[$i]['prenom'] . '" value="' . $result2[$i]['prenom'] . '" type="text"><br>
                                  <input name="mail" class="mail' . $result2[$i]['id'] . '" placeholder="' . $result2[$i]['mail'] . '" value="' . $result2[$i]['mail'] . '" type="text"><br>
                                  <input name="password" class="password' . $result2[$i]['id'] . '" placeholder="password" type="password"><br>
                                  <p>niveau de droit de cette utilisateur</p>
                                    <select class="acl' . $result2[$i]['id'] . '">
                                        <option ' . $user . ' value="1" selected>user</option> 
                                        <option ' . $admin . ' value="10">administrateur</option>
                                    </select>
                                    <br>';
    if (isset($result[0]['begin'])) {
        $pp = $result[0]['begin'];
    } else {
        $pp = "";
    }
    $bdd->cache('select nb_jour from credit_conge where id_user=?',array(
        $result2[$i]['id']
    ));
    $jourc  = $bdd->exec();
    if (isset($jourc[0][0]['nb_jour'])) {
        $jc = $jourc[0][0]['nb_jour']/12;
    } else {
        $jc = "";
    } 
    echo '
                                    <p>date debut du contrat</p>
                                    <input type="date" class="begin' . $result2[$i]['id'] . '" value="' . $pp . '"><br>
                                    <p>Nombre de jour de congé</p>
                                    <input type="number" min="0" step="0.0000000000001" class="nbconge' . $result2[$i]['id'] . '" value="' . $jc . '" ><br>
                                     <p>nombre d\'heures du contrat de cet utilisateur</p>
                                    <select class="hour' . $result2[$i]['id'] . '">';
    $bdd    = new bdd();
    $bdd->cache('select * from contrat', '');
    $contra = $bdd->exec();
    for ($p = 0; $p < count($contra); $p++) {
        $state = "";
        if (isset($result[0]['contrat']) and $result[0]['contrat'] == $contra[$p]['nom']) {
            $state = "selected";
        }
        echo '<option ' . $state . ' value="' . $contra[$p]['id'] . '" >' . $contra[$p]['nom'] . '</option> ';
        
        
    }
    
    
    echo '
                                    </select><br>
                                    <input class="input-btn in btn btn-primary" type="submit" value="Valider">
                                    <input class="input-btn in deluser btn btn-danger" alt="' . $result2[$i]['id'] . '" type="button"  value="Desactiver cet utilisateur">
                                  </form>
                                  
                                  <div id="retour' . $result2[$i]['id'] . '"></div>
                                </div>'; //edition d'un popup pour chaque user
}
echo '</table>'; //on ferme la balise table

?>

        </div>
        <div class="tab-pane" id="2">
<?php             
$bdd->cache('select a.begin as begin, a.id as id, a.username as username, a.nom as nom, a.prenom as prenom, a.acl as acl, a.mail as mail , a.state as state  from users a where a.state!=1', '');
$result2 = $bdd->exec();
echo '<table style="width:100%;margin-top:40px;"><tr><th>login</th><th>nom</th><th>prenom</th><th>fiche utilisateur<s/th><tr>'; //header du tableau
for ($i = 0; $i < count($result2); $i++) { //liste de utilisateur pour cr�� la table et les popup
    //var_dump($result);

    $result = list_user($result2[$i]['id']);
    $result = $result[0];
    if (!isset($result[0]['contrat'])) {
        $plein = "";
        $semi  = "";
    }
    if (isset($result[0]['contrat']) and $result[0]['contrat'] == '35') {
        $plein = "selected";
        $semi  = "";
    }
    if (isset($result[0]['contrat']) and $result[0]['contrat'] == '28') {
        $semi  = "selected";
        $plein = "";
    }
    if (!isset($result[0]['acl'])) {
        $user  = "";
        $admin = "";
    }
    if (isset($result[0]['acl']) and $result[0]['acl'] == '1') {
        $user  = "selected";
        $admin = "";
    }
    if (isset($result[0]['acl']) and $result[0]['acl'] == '10') {
        $admin = "selected";
        $user  = "";
    }
    echo '<tr><th>' . $result2[$i]['username'] . '</th><th>' . $result2[$i]['nom'] . '</th><th>' . $result2[$i]['prenom'] . '</th><th><h4><a href="#" data-width="500" data-rel="popup' . $result2[$i]['id'] . '" class="poplight" style="color:black"> <button class="btn btn-primary " >fiche de ' . $result2[$i]['prenom'] . '</button></a>';
    if (!isset($result[0]['contrat']) or $result[0]['state']!=1)
        echo '  <span class="label label-danger">Utilisateur desactivé</span></h4>';
    echo '</th></tr>';
    
    echo '
                                <div id="popup' . $result2[$i]['id'] . '" alt="' . $result2[$i]['id'] . '" class="popup_block popup">
                                  <form action="test.html"  method="POST" id="popup">
                                  <input name="nom" class="nom' . $result2[$i]['id'] . '" placeholder="' . $result2[$i]['nom'] . '" value="' . $result2[$i]['nom'] . '" type="text"><br>
                                  <input name="prenom" class="prenom' . $result2[$i]['id'] . '" placeholder="' . $result2[$i]['prenom'] . '" value="' . $result2[$i]['prenom'] . '" type="text"><br>
                                  <input name="mail" class="mail' . $result2[$i]['id'] . '" placeholder="' . $result2[$i]['mail'] . '" value="' . $result2[$i]['mail'] . '" type="text"><br>
                                  <input name="password" class="password' . $result2[$i]['id'] . '" placeholder="password" type="password"><br>
                                  <p>niveau de droit de cette utilisateur</p>
                                    <select class="acl' . $result2[$i]['id'] . '">
                                        <option ' . $user . ' value="1" selected>user</option> 
                                        <option ' . $admin . ' value="10">administrateur</option>
                                    </select>
                                    <br>';
    if (isset($result[0]['begin'])) {
        $pp = $result[0]['begin'];
    } else {
        $pp = "";
    }
    $bdd->cache('select nb_jour from credit_conge where id_user=?',array(
        $result2[$i]['id']
    ));
    $jourc  = $bdd->exec();
    if (isset($jourc[0][0]['nb_jour'])) {
        $jc = $jourc[0][0]['nb_jour']/12;
    } else {
        $jc = "";
    } 
    echo '
                                    <p>date debut du contrat</p>
                                    <input type="date" class="begin' . $result2[$i]['id'] . '" value="' . $pp . '"><br>
                                    <p>Nombre de jour de congé</p>
                                    <input type="number" min="0" step="0.0000000000001" class="nbconge' . $result2[$i]['id'] . '" value="' . $jc . '" ><br>
                                     <p>nombre d\'heures du contrat de cet utilisateur</p>
                                    <select class="hour' . $result2[$i]['id'] . '">';
    $bdd    = new bdd();
    $bdd->cache('select * from contrat', '');
    $contra = $bdd->exec();
    for ($p = 0; $p < count($contra); $p++) {
        $state = "";
        if (isset($result[0]['contrat']) and $result[0]['contrat'] == $contra[$p]['nom']) {
            $state = "selected";
        }
        echo '<option ' . $state . ' value="' . $contra[$p]['id'] . '" >' . $contra[$p]['nom'] . '</option> ';
        
        
    }
    
    
    echo '
                                    </select><br>
                                    <input class="input-btn in btn btn-primary" type="submit" value="Valider">
                                    <input class="input-btn in deluser btn btn-danger" alt="' . $result2[$i]['id'] . '" type="button"  value="Desactiver cet utilisateur">
                                  </form>
                                  
                                  <div id="retour' . $result2[$i]['id'] . '"></div>
                                </div>'; //edition d'un popup pour chaque user
}
echo '</table>'; //on ferme la balise table
?>
        </div>
    </div>
</div>


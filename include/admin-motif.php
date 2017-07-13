<?php
user::check_admin();
$bdd      = new bdd();
$bdd->cache('select * from motif where 1', '');
$motif    = $bdd->exec();
if(isset($motif[0]['id'])){
    $compteur = count($motif);
} else {
    $compteur = 0;
}
echo '<div class="col-md-12">
            <div class="col-md-6">
                <h4 style="text-align:left">Les type:<br>
                    1 <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span> congé qui ne sera pas deduit des heure suplémentaire et retournera un abcence de l\'utilisateur.<br>
                    2 <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span> congé qui indiquera que l\'utilisateur est present (exemple deplacement).<br>
                    3 <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span> congé qui sera deduit des heure suplémentaire et retournera une abcence <br>
                    4 <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span> déduit les heures supplémentaire payées<br>
                </h4>
            </div>
            <div class="col-md-6">
                <a href="#" data-width="500" data-rel="popup" class="poplight" style="color:black">
                    <button class="btn btn-primary">ajouter un motif</button>
                </a>
            </div>
            <div id="retour"></div>
            <table class="table table-bordered">
                <thead> <tr> <th>nom</th> <th>type</th> <th>action</th> </tr> </thead>
                <tbody>';
for ($i = 0; $i < $compteur ; $i++) {
    echo '    <tr>
                    <th id="nom' . $motif[$i]['id'] . '">' . $motif[$i]['nom'] . '</th>
                    <th>' . $motif[$i]['type'] . '</th>
                    <th>
                        <a href="#" data-width="500" data-rel="popup' . $motif[$i]['id'] . '" class="poplight" style="color:black">
                            <button class="btn btn-primary">modifier le profil</button>
                        </a>
                        <input type="button" value="supprimer" class="delmotif btn btn btn-danger" alt="' . $motif[$i]['id'] . '"/>
                    </th>
                </tr>';
}


echo '</tbody></div>';
for ($i = 0; $i < $compteur; $i++) {
    echo '
                                    <div id="popup' . $motif[$i]['id'] . '" alt="" class="popup_block">
                                        <form action="test.html"  method="POST" class="modifmotif" id="' . $motif[$i]['id'] . '" alt="' . $motif[$i]['id'] . '">
                                          <input name="nom" id="nom' . $motif[$i]['id'] . '" placeholder="nom" value=' . $motif[$i]['nom'] . ' type="text"><br>
                                          <input name="type" id="type' . $motif[$i]['id'] . '" value="' . $motif[$i]['type'] . '" type="text"><br>
                                          <input type="submit" class="modifmotif btn btn-primary" id="' . $motif[$i]['id'] . '" value="envoyer"/>
                                        </form>
                                        <div id="retour' . $motif[$i]['id'] . '"></div>
                                    </div>
                                      ';
}
echo '
                                    <div id="popup" alt="" class="popup_block">
                                        <form action="test.html"  method="POST" class="addmotif" id="motif" alt="">
                                          <input name="nom" id="nom" placeholder="nom"  type="text"><br>
                                          <input name="type" id="type" value="" type="text"><br>
                                          <input type="submit" class="modifmotif btn btn-primary" id="" value="envoyer"/>
                                        </form>
                                        <div id="retouradd"></div>
                                    </div>
                                      ';
?>
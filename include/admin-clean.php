<?php
    $bdd=new bdd();
    $bdd->cache('delete from heure where nb=0','');
    $bdd->exec();
    echo '<div style="border:solid 2px green;background:lightgreen;color:green;padding:1em;display:inline-block" class="droid"> base de donnée nettoyée avec succès</div><meta http-equiv="refresh" content="2; URL=admin.php">'
?>
<?php
    include_once('include/function.php');
    include_once('include/autoload.php');
    include_once('include/admin-function.php');
    if(user::check_admin($_SERVER['HTTP_REFERER'])){
    	$list_user=list_user('','1');
    	$date=new DateTime('NOW');

    	 echo '<table class="table table-striped">
				    <thead>
				      <tr>
				        <th>Nom</th>
				        <th>Prénom</th>
				        <th>Solde à récupérer</th>
				        <th>Solde de congé</th>
				      </tr>
				   </thead>';
    	for($i=0;$i<count($list_user);$i++){
    		$bdd->cache('SELECT sum(nb) as nb FROM heure WHERE id_user=? and DATE_FORMAT(date, "%Y-%m")=?', array(
	   		 	$list_user[$i]['id'],
	   		 	$date->format('Y-m')
	   		 	));

    		 $bdd->cache('select * from heure_sup where id_user=?', array(
		        $list_user[$i]['id']
		    ));
    		 $bdd->cache('SELECT * FROM credit_conge where id_user=?', array(
		        $list_user[$i]['id']
		    ));
	    	$heure = $bdd->exec();
		    // if (isset($heure[0][0]['nb'])) {
		    //     $heure_gen = sectohour($heure[0][0]['nb']);
		    // } else {
		    //     $heure_gen = array(
		    //         'h' => '0',
		    //         'm' => '0'
		    //     );
        //
	   		if (isset($heure[1][0]['heure'])) {
		       $heure_sup = sectohour($heure[1][0]['heure']);
		    } else {
		        $heure_sup = array(
		           	'h' => '0',
		           	'm' => '0'
			    );
			 }
			 $conge=round(check_conge($list_user[$i]['id'], '1'),2);
	    		 echo '<tbody>
					      <tr>
					        <td>'.$list_user[$i]['nom'].'</td>
					        <td>'.$list_user[$i]['prenom'].'</td>
					        <td>' . $heure_sup['h'] . 'h' . $heure_sup['m'] . '</td>
					        <td>' . $conge . '</td>
					      </tr>
					    <tbody>';
	    	}
    	echo '</table>';


    	}

?>

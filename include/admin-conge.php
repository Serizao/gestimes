<?php
echo '<div id="retour"></div>';
	$bdd=new bdd();
	$result=$bdd->tab("SELECT a.id as id, a.begin as begin, a.end as end, c.nom as nom,c.prenom as prenom, b.nom as type , username as user FROM conge a, motif b , users c where a.id_motif=b.id and  a.id_user=c.id and  a.state=0",'');
	echo '<table class="table table-bordered">
                <thead>
                    <tr>
                      <th>date debut</th>
                      <th>date de fin</th>
                      <th>type de conge</th>
                      <th>user</th>
                      <th>action</th>
                    </tr>
                </thead> 
                <tbody>';
     for($i=0;$i<count($result);$i++){
                echo '	<tr>
	                        <td>'.$result[$i]['begin'].'</td>
	                        <td>'.$result[$i]['end'].'</td>
	                        <td>'.$result[$i]['type'].'</td>
	                        <th>'.$result[$i]['nom'].' '.$result[$i]['prenom'].'</th>
	                        <td><input type="button" class="admconge btn btn-primary" alt="'.$result[$i]['id'].'" value="accepter"/>
	                        	<input type="button" class="admconge btn btn-danger" alt="'.$result[$i]['id'].'" value="refuser"/>
	                        </td>
                      	</tr>';
      }       
     echo '     </tbody> 
            </table>';


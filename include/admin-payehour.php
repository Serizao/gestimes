<?php 
    include_once('include/function.php');
    include_once('include/autoload.php'); 
    include_once('include/admin-function.php');
    if(user::check_admin($_SERVER['HTTP_REFERER'])){
    	$list_user=list_user('','1');
    	echo '<div class="container">
    			<div class="col-md-3">
    				<select class="form-control col-md-3" id="user_hour_paye">';
    	for($i;$i<count($list_user);$i++){
    		echo '		<option value="'.$list_user[$i]['id'].'">'.$list_user[$i]['nom'].' '.$list_user[$i]['prenom'].'</option>';
	    			

    	}
    	echo '		</select>
        			</div>
        			<div class="col-md-3">
        				<input type="time" name="time" id="time" class="form-control">
        			</div>
                    <div class="col-md-2">
                        <input type="date" name="date" id="date" class="form-control">
                        </div>
                    <div class="col-md-2">
                        <input type="submit" id="valid_paye_heure_sup" value="envoyer" class="form-control"/>
                    </div>
                     <div class="return"></div>
    		</div><br>
           ';


    }
 ?>


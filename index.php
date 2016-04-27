 <?php
 session_start();  

 ?>
<<<<<<< HEAD
 <html class="no-js" lang="">
=======
>>>>>>> origin/master
 <head>
            <title>Auth</title>
            <meta charset="utf-8">
            <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
            <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" type="text/css" href="css/global.css">
            <link rel="stylesheet" type="text/css" href="css/popup.css"> 
<<<<<<< HEAD
            <script src="//code.jquery.com/jquery-2.0.2.js" type="text/javascript">
<link rel="stylesheet" href="http://cdn.jsdelivr.net/webshim/1.14.5/shims/styles/shim-ext.css">
<link rel="stylesheet" href="http://cdn.jsdelivr.net/webshim/1.14.5/shims/styles/forms-picker.css">
			
      <script src="js/jquery-migrate-1.2.1.min.js"></script>
      <script src="//cdn.jsdelivr.net/webshim/1.14.5/polyfiller.js"></script>
<script>
    webshims.setOptions('forms-ext', {types: 'date'});

webshims.polyfill('forms forms-ext');
</script>
      
</head>
<body>
<?php
 $current_week_time=0;


=======
            <script src="js/jquery-1.12.0.min.js"></script>
			<script src="js/jquery-migrate-1.2.1.min.js"></script>
</head>
<body>
<?php
<<<<<<< HEAD
 $current_week_time=0;


=======
>>>>>>> origin/master
>>>>>>> origin/master
date_default_timezone_set('Europe/Paris');
    include_once('include/bdd.php');
    include_once('include/function.php');

    secureAccess();
    include_once ('include/top-barre.php');
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> origin/master
    //include_once ('include/ajax.php');
    $nav=0;
    $bdd=new bdd;
    $data=array($_SESSION['userid']);


    majhs($_SESSION['userid']);
    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    echo '<input type="hidden" value="'.$actual_link.'" id="url"/>';
    $result=$bdd->tab('select * from es where id_user=? order by temps asc ', $data);
    if(count($result[0])>0){
      for($w=0;$w<count($result[0]);$w++){
       $yeartime[]=strtotime($result[0][$w]['temps']);
      }

     $yeartime=calcul_time($yeartime);
     $semaine_time=0;
    }
 if(isset($_REQUEST['semaine']))$nav=$_REQUEST['semaine'];
	$result=current_semaine($_SESSION['userid'], $nav);
<<<<<<< HEAD

	$nbj=count($result['jour']);
  $semaine=$result['n']-1;
  $semaine2=$result['n']+1;
  echo "<a href='index.php?semaine=".$semaine2."' style='float:right'> semaine suivante ></a>";
  echo "<a href='index.php?semaine=".$semaine."' style='float:left'>< semaine precedente </a>";
   echo "<a href='index.php' style='text-align:center'> NOW </a>";
	echo '<table class="table table-bordered" style="width:100%">
=======
	$nbj=count($result['jour']);
  $semaine=$result['n']-1;
  $semaine2=$result['n']+1;
  echo "<a href='index.php?semaine=".$semaine2."' style='float:right'> semaine suivante ></a>";
  echo "<a href='index.php?semaine=".$semaine."' style='float:left'>< semaine precedente </a>";
   echo "<a href='index.php' style='text-align:center'> NOW </a>";
	echo '<table class="table table-bordered" style="width:100%">
=======
    include_once ('include/ajax.php');
    $nav=0;
    $bdd=new bdd;
    $data=array('0');
    $result=$bdd->tab('select * from es where id_user=? ', $data);
    for($w=0;$w<count($result[0]);$w++){
       $yeartime[]=strtotime($result[0][$w]['temps']);
    }

   $yeartime=calcul_time($yeartime);


 if(isset($_REQUEST['semaine']))$nav=$_REQUEST['semaine'];
	$result=current_semaine('', $nav);
	$nbj=count($result['jour']);
  $semaine=$result['n']-1;
  $semaine2=$result['n']+1;
  echo "<a href='index.php?semaine=".$semaine."' style='float:right'> semaine precedente ></a>";
  echo "<a href='index.php?semaine=".$semaine2."' style='float:left'>< semaine suivante </a>";
	echo '<table style="width:100%">
>>>>>>> origin/master
>>>>>>> origin/master
  			<tr>' ;
  	for($i=0;$i<$nbj;$i++){
  		$now1='';
  		$now2='';
		  $color='';
      $time='';
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> origin/master
      $date1=new datetime($result['date'][$i]);
      $date2=new datetime();
		$past[$i]="0";
      $total=array();
      $date = new DateTime($result['date'][$i]);
      
  		if($result['jour'][$i]=='Samedi' or $result['jour'][$i]=='Dimanche' or $date1 < $date2 or isHoliday($date->getTimestamp())) $color= "style='background-color:#67809F'";
		if($result['jour'][$i]!='Samedi' and $result['jour'][$i]!='Dimanche' and $date1 < $date2 and !isHoliday($date->getTimestamp())) $past[$i]= true;		
<<<<<<< HEAD
=======
=======
      $total=array();
  		if($result['jour'][$i]=='Samedi' or $result['jour'][$i]=='Dimanche' or $result['numero'][$i] < date('j')) $color= "style='background-color:#67809F'";
>>>>>>> origin/master
>>>>>>> origin/master
  		if ($result['numero'][$i]==date('j') and $result['mois2'][$i]==date('n')){
  			$now1='class="now-ar"';
  			$now2='class="now-par"';
  			$color= "style='background-color:#87D37C'";
		}  		
<<<<<<< HEAD

<<<<<<< HEAD
   for($o=0;$o<count($result[$i]);$o++){
      if(isset($result[$i][$o]) and !empty($result[$i][$o])){
        if($result[$i][$o]['es']=="e"){
          $time=$time.'<div class="col-md-offset-1 hour"><a href="#"  class="delmouv" alt="'.$result[$i][$o]['id'].'"><span class="glyphicon glyphicon-remove" aria-hidden="true"> </span></a> Arrivé à '.$result[$i][$o]['time'].'</div>';
          $total[]=strtotime($result[$i][$o]['temps']);
        }
        if($result[$i][$o]['es']=="s"){
          $time=$time.'<div class="col-md-offset-1 hour" ><a href="#" class="delmouv" alt="'.$result[$i][$o]['id'].'"><span class="glyphicon glyphicon-remove" aria-hidden="true"> </span></a> Parti à '.$result[$i][$o]['time'].'</div>';
=======
=======
>>>>>>> origin/master
   for($o=0;$o<count($result[$i]);$o++){
      if(isset($result[$i][$o]) and !empty($result[$i][$o])){
        if($result[$i][$o]['es']=="e"){
          $time=$time.'<br>Arrivé à '.$result[$i][$o]['time'];
          $total[]=strtotime($result[$i][$o]['temps']);
        }
        if($result[$i][$o]['es']=="s"){
          $time=$time.'<br>Parti à '.$result[$i][$o]['time'];
>>>>>>> origin/master
          $total[]=strtotime($result[$i][$o]['temps']);
        }
      }
    }
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> origin/master

    $tempspasser=calcul_time($total);
	if(!isset($tempspasser['heure']))$tempspasser['heure']="00";
	if(!isset($tempspasser['minutes']))$tempspasser['minutes']="00";
	if(!isset($tempspasser['second']))$tempspasser['second']="00";
    $finaltime='';
    $current_week_time=$current_week_time+hourtosec($tempspasser['heure'].':'.$tempspasser['minutes']);
    $current_week_time=$current_week_time+$tempspasser['second'];
<<<<<<< HEAD

    if(isset($tempspasser)  and $tempspasser['heure']>=7) $finaltime=$tempspasser['heure'].'h'.$tempspasser['minutes'].'min'.$tempspasser['second'];
    if(isset($tempspasser)  and $tempspasser['heure']<7) $finaltime='<b style="color:red">'.$tempspasser['heure'].'h'.$tempspasser['minutes'].'min'.$tempspasser['second'].'</b>';
    //affichage des case du tableau et de leur contenu
  		echo'<td '.$color.'>';
        if($past[$i]){echo '<br><a href="#" data-width="300" data-rel="popup'.$i.'" class="poplight" style="color:black">ajouter un mouvement</a>';}
        echo'<br><br>'. $result['jour'][$i].' '.$result['numero'][$i].' '.$result['mois'][$i].'<br>('.$result['annee'][$i].')<br><br>'.$time.'<div '.$now1.' id="arrive"></div><br><div '.$now2.' id="depart"></div><br><div  id="total">';
        if($past[$i]) {echo $finaltime;}

=======

    if(isset($tempspasser)  and $tempspasser['heure']>=7) $finaltime=$tempspasser['heure'].'h'.$tempspasser['minutes'].'min'.$tempspasser['second'];
    if(isset($tempspasser)  and $tempspasser['heure']<7) $finaltime='<b style="color:red">'.$tempspasser['heure'].'h'.$tempspasser['minutes'].'min'.$tempspasser['second'].'</b>';
    //affichage des case du tableau et de leur contenu
  		echo'<td '.$color.'>';
        if($past[$i]){echo '<br><a href="#" data-width="300" data-rel="popup'.$i.'" class="poplight" style="color:black">ajouter un mouvement</a>';}
        echo'<br><br>'. $result['jour'][$i].' '.$result['numero'][$i].' '.$result['mois'][$i].'<br>('.$result['annee'][$i].')<br>'.$time.'<div '.$now1.' id="arrive"></div><br><div '.$now2.' id="depart"></div><br><div  id="total">';
        if($past[$i]) {echo $finaltime;}

>>>>>>> origin/master
        $aoaa=count_hour($result['date2'][$i], '2');

        if($aoaa and ($aoaa['heure']>0 or $aoaa['minutes']>0))echo '<br><br>il reste à categoriser '.$aoaa['heure'].'h'.$aoaa['minutes'];
     
      echo'</div></td>';
      //popup
      echo'
        <div id="popup'.$i.'" alt="'.$i.'" class="popup_block popup">
          <form action="test.html" method="POST" id="popup">
          <input class="input-btn in date'.$i.'" type="hidden" value="'.$date1->format('Y-m-d').'">
          <input class="input-btn in id'.$i.'" type="hidden" value="'.$_SESSION['userid'].'">
            <select class="sens'.$i.'">
                <option value="e">Entrée</option> 
                <option value="s" selected>Sortie</option>
            </select>
            <input type="time" class="time'.$i.'" name="time"><br>
            <input class="input-btn in" type="submit" value="Valider">
          </form>
          
          <div id="retour'.$i.'"></div>
        </div>';
    
    }
<<<<<<< HEAD
=======
=======
    $tempspasser=calcul_time($total);
    $finaltime='';
    if(isset($tempspasser) and !empty($tempspasser['second'])) $finaltime=$tempspasser['heure'].'h'.$tempspasser['minutes'].'min'.$tempspasser['second'];
  		echo'<td '.$color.'>'. $result['jour'][$i].' '.$result['numero'][$i].' '.$result['mois'][$i].'<br>('.$result['annee'][$i].')<br>'.$time.'<div '.$now1.' id="arrive"></div><br><div '.$now2.' id="depart"></div><br><div  id="total">'.$finaltime.'</div></td>';
    
    }
  	
  	echo '</tr></table>';
echo $yeartime['heure'].'h'.$yeartime['minutes'].'min'.$yeartime['second'] .'au total';
>>>>>>> origin/master
>>>>>>> origin/master
  	
  	echo '</tr></table>';

    $current_week_time=sectohour($current_week_time);
    if(isset($current_week_time['m'])){
      echo $current_week_time['h'].'h'.$current_week_time['m'].'min'.$current_week_time['s'] .'au total sur la semaine affichée';
    }

  
?>

<hr style="width:100%; height:1px;" />
<div class="col-md-4">
<H2>Categoriser ces heures</H2> 
  <?php

  echo '<input type="date" name="date" id="datecathour"/><br>'; //selection de la date
  echo '<div id="nbhour"></div>';
  echo '<input type="time" name="time" id="timecathour"/>';
  //on liste les catégorie dans un select
  	echo '<select id="cathour">';
  	$cat=list_cat();
  	for($i=0;$i<count($cat);$i++){
  		echo '<option value="'.$cat[$i]['id'].'">'.$cat[$i]['nom'].'</option>';
  	}
  	echo '</select><button id="okhour">valider</button>';
  	echo '<div id="catretour"></div>';
    
   
  ?>
</div>
<div class="col-md-4">
  <h2>Congé / Récupération</h2><br>
  <form id="addconge" method="POST">
    <?php
    $userid=array($_SESSION['userid']);
      $hs=$bdd->tab('select * from heure_sup where id_user=?',$userid);
       $hs=sectohour($hs[0][0]['heure']);
      echo ' <h4>Vous disposez actuellement de '.$hs['h'].'h'.$hs['m'].'heure suplémentaire(s)</h4>';
      $motif=$bdd->tab('select * from motif where 1','');
      echo '<select name="typeconge" id="typeconge" class="col-md-6 col-md-offset-3">';
      for($i=0;$i<count($motif);$i++){
        echo '<option value="'.$motif[$i]['id'].'">'.$motif[$i]['nom'].'</option>';
      }
      echo '</select><br><br>';
     
    ?><div class="row">
        <div class=" col-md-6" >
          <h5> DU</h5>
          <input type="date" style="text-align:left" id="beginholliday"/><br>
          <input type="radio" style="text-align:left" name="bh" value="matin" checked> matin<br>
          <input type="radio" style="text-align:left" name="bh" value="amidi"> après-midi<br>
          <input type="radio" style="text-align:left"  name="bh" value="day"> la journée  
        </div>
        
        <div class="col-md-6 " >
          <h5>AU</h5>
          <input type="date" id="endholliday"/><br>
          matin <input style="text-align:right" type="radio" name="eh" value="matin" checked> <br>
          après-midi <input style="text-align:right" type="radio" name="eh" value="amidi"> <br>
          la journée <input style="text-align:right" type="radio" name="eh" value="day">   <br>
        </div>
      </div>
      <div class="col-md-offset-3 col-md-6">
         <input type="submit" id="validh" value="valider"/>
      </div>
  </form>
  <div id="congestate"></div>

</div>
<div class="col-md-4">
  <?php
  $datenow=date('Y-m-d',strtotime('now'));
  echo $datenow;
    $vac=$bdd->tab("SELECT a.id as id, a.begin as begin, a.end as end, b.nom as nom, a.state as statut FROM conge a, motif b  where a.id_motif=b.id and id_user=? and DATE_FORMAT(a.begin, '%Y-%m-%d')>='".$datenow."' ORDER BY a.begin ASC limit 0, 10",array($_SESSION['userid']));
     echo '<table class="table table-bordered">
                <thead>
                    <tr>
                      <th>date debut</th>
                      <th>date de fin</th>
                      <th>type de conge</th>
                      <th>status</th>
                      <th>action</th>
                    </tr>
                </thead> 
                <tbody>';
              $vac=$vac[0];
              for($i=0;$i<count($vac);$i++){
                if($vac[$i]['statut']==0)$u="en cour de traitement";
                if($vac[$i]['statut']==1)$u="Accepter";
                if($vac[$i]['statut']==10)$u="Refuser";
                echo '<tr>
                        <td>'.$vac[$i]['begin'].'</td>
                        <td>'.$vac[$i]['end'].'</td>
                        <td>'.$vac[$i]['nom'].'</td>
                        <th>'.$u.'</th>
                        <td><input type="button" class="delconge" alt="'.$vac[$i]['id'].'" value="supprimer"/></td>
                      </tr>';
              }


                
     echo '     </tbody> 
            </table>';
  ?>
</div>

<script src="./js/user.js"></script>
<script src="./js/popup.js"></script>
<<<<<<< HEAD

</body>
</html>
=======
</body>
>>>>>>> origin/master

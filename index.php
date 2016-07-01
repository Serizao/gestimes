 <?php
 session_start();  
 ?>
 <html class="no-js" lang="">
 <head>
            <title>Auth</title>
            <meta charset="utf-8">
            <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
            <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" type="text/css" href="css/global.css">
            <link rel="stylesheet" type="text/css" href="css/popup.css"> 
            <script src="js/jquery-2.0.2.js" type="text/javascript"></script>
            <!--style retro compatibilité html5-->
            <link rel="stylesheet" href="css/shim-ext.css">
            <link rel="stylesheet" href="css/forms-picker.css">
            <script src="js/jquery-migrate-1.2.1.min.js"></script>
            <script src="js/polyfiller.js"></script>
<script>
    webshims.setOptions('forms-ext', {types: 'date'});
    webshims.polyfill('forms forms-ext');
    var timer = null;
    function goAway() {
        clearTimeout(timer);
        timer = setTimeout(function() {
            window.location.reload();
        }, 60000);
    }
    window.addEventListener('mousemove', goAway, true);
    goAway(); 
</script>
</head>
<body>
<?php
 $current_week_time=0;
date_default_timezone_set('Europe/Paris');
    include_once('include/bdd.php');
    include_once('include/function.php');
    secureAccess();
    include_once ('include/top-barre.php');
    //include_once ('include/ajax.php');
    if(empty($_GET["function"])){ //si pas de post on affiche la page normal
    $nav=0;
    $bdd=new bdd;
    $data=array($_SESSION['userid']);
    majhs($_SESSION['userid']);
    $actual_link ="$_SERVER[REQUEST_URI]";
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

  $nbj=count($result['jour']);
  $semaine=$result['n']-1;
  $semaine2=$result['n']+1;
  echo "<a href='index.php?semaine=".$semaine2."' style='float:right'> semaine suivante ></a>";
  echo "<a href='index.php?semaine=".$semaine."' style='float:left'>< semaine precedente </a>";
   echo "<a href='index.php' style='text-align:center'> NOW </a>";
  echo '<table class="table table-bordered" style="width:100%">
        <tr>' ;
    for($i=0;$i<$nbj;$i++){
      $now1='';
      $now2='';
      $color='';
      $time='';
      $date1=new datetime($result['date'][$i]);
      $date2=new datetime();
    $past[$i]="0";
      $total=array();
      $date = new DateTime($result['date'][$i]);
      if($result['jour'][$i]=='Samedi' or $result['jour'][$i]=='Dimanche' or $date1 < $date2 or isHoliday($date->getTimestamp())) $color= "style='background-color:#81CFE0'";
    if($result['jour'][$i]!='Samedi' and $result['jour'][$i]!='Dimanche' and $date1 < $date2 and !isHoliday($date->getTimestamp())) $past[$i]= true;    
      if ($result['numero'][$i]==date('j') and $result['mois2'][$i]==date('n')){
        $now1='class="now-ar"';
        $now2='class="now-par"';
        $color= "style='background-color:#87D37C'";
    }     
   for($o=0;$o<count($result[$i]);$o++){
      if(isset($result[$i][$o]) and !empty($result[$i][$o])){
        if($result[$i][$o]['es']=="e"){
          $time=$time.'<div class="col-md-offset-1 hour"><a href="#"  class="delmouv" alt="'.$result[$i][$o]['id'].'"><span class="glyphicon glyphicon-remove" aria-hidden="true"> </span></a> Arrivé à '.$result[$i][$o]['time'].'</div>';
          $total[]=strtotime($result[$i][$o]['temps']);
        }
        if($result[$i][$o]['es']=="s"){
          $time=$time.'<div class="col-md-offset-1 hour" ><a href="#" class="delmouv" alt="'.$result[$i][$o]['id'].'"><span class="glyphicon glyphicon-remove" aria-hidden="true"> </span></a> Parti à '.$result[$i][$o]['time'].'</div>';
          $total[]=strtotime($result[$i][$o]['temps']);
        }
      }
    }
    $tempspasser=calcul_time($total);
  if(!isset($tempspasser['heure']))$tempspasser['heure']="00";
  if(!isset($tempspasser['minutes']))$tempspasser['minutes']="00";
  if(!isset($tempspasser['second']))$tempspasser['second']="00";
    $finaltime='';
    $current_week_time=$current_week_time+hourtosec($tempspasser['heure'].':'.$tempspasser['minutes']);
    $current_week_time=$current_week_time+$tempspasser['second'];

    if(isset($tempspasser)  and $tempspasser['heure']>=7) $finaltime=$tempspasser['heure'].'h'.$tempspasser['minutes'].'min'.$tempspasser['second'];
    if(isset($tempspasser)  and $tempspasser['heure']<7) $finaltime='<b style="color:red">'.$tempspasser['heure'].'h'.$tempspasser['minutes'].'min'.$tempspasser['second'].'</b>';
    //affichage des case du tableau et de leur contenu
      echo'<td '.$color.' onclick=" auto_complete_hs(\''.$result['date2'][$i].'\')">';
<<<<<<< HEAD
        if($past[$i]){echo '<br><a href="#" data-width="450" data-rel="popup'.$i.'" class="poplight" style="color:black">ajouter un mouvement</a>';}
=======
        if($past[$i]){echo '<br><a href="#" data-width="300" data-rel="popup'.$i.'" class="poplight" style="color:black">ajouter un mouvement</a>';}
>>>>>>> origin/master
        echo'<br><br>'. $result['jour'][$i].' '.$result['numero'][$i].' '.$result['mois'][$i].'<br>('.$result['annee'][$i].')<br><br>'.$time.'<div '.$now1.' id="arrive"></div><br><div '.$now2.' id="depart"></div><div  id="total">';
        if($past[$i]) {echo $finaltime;}
        $aoaa=count_hour($result['date2'][$i], '2');
        $bdd_cat=new bdd();
        $array_cat=array($_SESSION['userid'],$result['date2'][$i]);
        $result_cat=$bdd_cat->tab("select a.nb as nb, b.nom as cat, a.id as id from heure a, categorie b where a.id_cat=b.id and id_user=? and DATE_FORMAT(`date`, '%Y-%m-%d')=?  ", $array_cat);
        $result_cat=$result_cat[0];
        if(isset($result_cat[0]['nb'])){
            echo '<br><br><ul>';
          for($uu=0;$uu<count($result_cat);$uu++){
              $nb=sectohour($result_cat[$uu]['nb']);
              echo '<li>'.$result_cat[$uu]['cat'].'  '.$nb['h'].'h'.$nb['m'].'</li>';
          }
          echo '</ul>';
        }
        if($aoaa and ($aoaa['heure']>0 or $aoaa['minutes']>0))echo '<br><br>il reste à catégoriser '.$aoaa['heure'].'h'.$aoaa['minutes'];
     
      echo'</div></td>';
      //popup
      echo'
        <div id="popup'.$i.'" alt="'.$i.'" class="popup_block popup">
          <form action="test.html" method="POST" id="popup">
          <input class="input-btn in date'.$i.'" type="hidden" value="'.$date1->format('Y-m-d').'">
          <input class="input-btn in id'.$i.'" type="hidden" value="'.$_SESSION['userid'].'">
            <div class="col-md-6"><select class="sens'.$i.' form-control ">
                <option value="e">Entrée</option> 
                <option value="s" selected>Sortie</option>
            </select></div>
            <div class="row"><input  type="time" class="time'.$i.' form-control" name="time"></div><br>
            <input class="input-btn in btn btn-primary" type="submit" value="Valider">
          </form>
          
          <div id="retour'.$i.'"></div>
        </div>';
    }
    echo '</tr></table>';
<<<<<<< HEAD
     $hs=$bdd->tab('select * from heure_sup where id_user=?',array($_SESSION['userid']));
=======
     $hs=$bdd->tab('select * from heure_sup where id_user=?',$userid);
>>>>>>> origin/master
       $hs=sectohour($hs[0][0]['heure']);
       $cong=check_conge($_SESSION['userid'],'1');
      echo ' <div class="col-md-4"><h4> '.$hs['h'].'h'.$hs['m'].' heure à récupérer</h4></div><div class="col-md-4"><h4> '.round($cong,2).' jour(s) de congé(s)</h4></div>';
    $current_week_time=sectohour($current_week_time);
    if(isset($current_week_time['m'])){
      echo '<div class="col-md-4"><h4>'.$current_week_time['h'].' h '.$current_week_time['m'].' min '.$current_week_time['s'] .' au total sur la semaine affichée</h4></div>';
    }
?>
<hr  class="col-md-10 col-md-offset-1" style="height: 100%; height:2px; background-color:black;margin-top:10px;" />
<div class="col-md-4">
<div class="row">
<<<<<<< HEAD
<H4>Catégoriser ces heures</H4> 
  <?php
  echo '<div class="col-md-4"><input type="date" name="date" class="form-control" id="datecathour"/></div>'; //selection de la date
 
  echo '<div class="col-md-3"><input type="time" name="time" class="form-control" id="timecathour"/></div>';
  //on liste les catégorie dans un select
  
    echo '<div class="col-md-5"><select id="cathour" class="form-control">';
    $cat=list_cat('2',$_SESSION['userid']);
    for($i=0;$i<count($cat);$i++){
      echo '<option alt='.$cat[$i]['cir'].' value="'.$cat[$i]['id'].'">'.$cat[$i]['nom'].'</option>';
    }
    echo '</select><br></div><div id="cir-detail"></div><div class="col-md-12" id="nbhour"></div><button class="btn btn-primary" id="okhour">valider</button>';
    echo '<div id="catretour"></div>';
  ?>
</div>
<div class="row"><br>
<h4>Transfert d'heure</h4>
<?php
echo '';
?>
<div id="transfretour"><div class="col-md-6"><input type="date" class="form-control" id="changetimeuser" ></div></div>
=======
<H2>Catégoriser ces heures</H2> 
  <?php
  echo '<input type="date" name="date" id="datecathour"/><br>'; //selection de la date
  echo '<div id="nbhour"></div>';
  echo '<input type="time" name="time" id="timecathour"/>';
  //on liste les catégorie dans un select
    echo '<select id="cathour">';
    $cat=list_cat('2',$_SESSION['userid']);
    for($i=0;$i<count($cat);$i++){
      echo '<option value="'.$cat[$i]['id'].'">'.$cat[$i]['nom'].'</option>';
    }
    echo '</select><button id="okhour">valider</button>';
    echo '<div id="catretour"></div>';
  ?>
</div>
<div class="row">
<h2>Transfert d'heure</h2>
<?php
echo '<input type="date" id="changetimeuser" >';
?>
<div id="transfretour"></div>
>>>>>>> origin/master
</div>

</div>
</div>
<<<<<<< HEAD
<div class="col-md-3 col-md-offset-1">
  <h4>Congé / Récupération</h4><br>
=======
<div class="col-md-4">
  <h2>Congé / Récupération</h2><br>
>>>>>>> origin/master
  <form id="addconge" method="POST">
    <?php
    $userid=array($_SESSION['userid']);
      /*$hs=$bdd->tab('select * from heure_sup where id_user=?',$userid);
       $hs=sectohour($hs[0][0]['heure']);
       $cong=check_conge($_SESSION['userid'],'1');
      echo ' <h4>Vous disposez actuellement :<br> - de '.$hs['h'].'h'.$hs['m'].'heure à récupérer <br> - de '.round($cong,2).' jour(s) de congé(s)</h4>';*/
      $motif=$bdd->tab('select * from motif where 1','');
      echo '<select name="typeconge" id="typeconge" class="col-md-3  form-control">';
      for($i=0;$i<count($motif);$i++){
        echo '<option value="'.$motif[$i]['id'].'">'.$motif[$i]['nom'].'</option>';
      }
      echo '</select><br><br>';
    ?><div class="row">
        <div class=" col-md-6" style="float:left;" >
          <h5> DU</h5>
          <input type="date"  class="form-control" id="beginholliday"/><br>
          <div style="text-align: left;"><input type="radio"  name="bh" value="matin" checked><label> matin</label></div>
          <div style="text-align: left;"><input type="radio"  name="bh" value="amidi"><label> après-midi</label></div>
          <div style="text-align: left;"><input type="radio"  name="bh" value="day"><label> la journée</label> </div>  
        </div>
        <div class="col-md-6 " >
          <h5>AU</h5>
          <input type="date" class="form-control" id="endholliday"/><br>
          <div style="text-align: right;"><label>matin</label> <input  type="radio" name="eh" value="matin" checked> </div>
          <div style="text-align: right;"><label>après-midi</label> <input type="radio" name="eh" value="amidi"></div>
          <div style="text-align: right;"><label>la journée</label> <input type="radio" name="eh" value="day"> </div>
        </div>
      </div>
      <div class="col-md-offset-3 col-md-6">
         <input type="submit" class="btn btn-primary" id="validh" value="valider"/>
      </div>
  </form>
  <div id="congestate"></div>
</div>
<div class="col-md-4 ">
  <?php
  $datenow=date('Y-m-d',strtotime('now'));
  echo $datenow;
    $vac=$bdd->tab("SELECT a.id as id, a.begin as begin, a.end as end, b.nom as nom, a.state as statut FROM conge a, motif b  where a.id_motif=b.id and id_user=? and DATE_FORMAT(a.begin, '%Y-%m-%d')>='".$datenow."' ORDER BY a.begin ASC limit 0, 10",array($_SESSION['userid']));
     echo '<table class="table table-bordered">
                <thead>
                    <tr>
                      <th>Date debut</th>
                      <th>Date de fin</th>
                      <th>Type de conge</th>
                      <th>Statut</th>
                      <th>Action</th>
                    </tr>
                </thead> 
                <tbody>';
              $vac=$vac[0];
              for($i=0;$i<count($vac);$i++){
                if($vac[$i]['statut']==0)$u="en cour de traitement";
                if($vac[$i]['statut']==1)$u="Accepté";
                if($vac[$i]['statut']==10)$u="Refusé";
                echo '<tr>
                        <td>'.$vac[$i]['begin'].'</td>
                        <td>'.$vac[$i]['end'].'</td>
                        <td>'.$vac[$i]['nom'].'</td>
                        <th>'.$u.'</th>
                        <td><input type="button" class="delconge btn btn-primary" alt="'.$vac[$i]['id'].'" value="supprimer"/></td>
                      </tr>';
              }
              echo '     </tbody> 
              </table>';
          }
          if(isset($_GET['function'])){
            switch ($_GET['function']) {
              case "cal":
                  include('include/calendar.php');
                 
                  break;
            }
          }
  ?>
</div>
<script src="./js/user.js"></script>
<script src="./js/popup.js"></script>
<<<<<<< HEAD
<script src="./js/bootstrap.min.js"></script>
=======
>>>>>>> origin/master
</body>
</html>
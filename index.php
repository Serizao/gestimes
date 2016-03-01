 <head>
            <title>Auth</title>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" type="text/css" href="css/global.css">
            <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
			<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
</head>
<body>
<?php
date_default_timezone_set('Europe/Paris');
    include_once('include/bdd.php');
    include_once('include/function.php');

    secureAccess();
    include_once ('include/top-barre.php');
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
  			<tr>' ;
  	for($i=0;$i<$nbj;$i++){
  		$now1='';
  		$now2='';
		  $color='';
      $time='';
      $total=array();
  		if($result['jour'][$i]=='Samedi' or $result['jour'][$i]=='Dimanche' or $result['numero'][$i] < date('j')) $color= "style='background-color:#67809F'";
  		if ($result['numero'][$i]==date('j') and $result['mois2'][$i]==date('n')){
  			$now1='class="now-ar"';
  			$now2='class="now-par"';
  			$color= "style='background-color:#87D37C'";
		}  		
   for($o=0;$o<count($result[$i]);$o++){
      if(isset($result[$i][$o]) and !empty($result[$i][$o])){
        if($result[$i][$o]['es']=="e"){
          $time=$time.'<br>Arrivé à '.$result[$i][$o]['time'];
          $total[]=strtotime($result[$i][$o]['temps']);
        }
        if($result[$i][$o]['es']=="s"){
          $time=$time.'<br>Parti à '.$result[$i][$o]['time'];
          $total[]=strtotime($result[$i][$o]['temps']);
        }
      }
    }
    $tempspasser=calcul_time($total);
    $finaltime='';
    if(isset($tempspasser) and !empty($tempspasser['second'])) $finaltime=$tempspasser['heure'].'h'.$tempspasser['minutes'].'min'.$tempspasser['second'];
  		echo'<td '.$color.'>'. $result['jour'][$i].' '.$result['numero'][$i].' '.$result['mois'][$i].'<br>('.$result['annee'][$i].')<br>'.$time.'<div '.$now1.' id="arrive"></div><br><div '.$now2.' id="depart"></div><br><div  id="total">'.$finaltime.'</div></td>';
    
    }
  	
  	echo '</tr></table>';
echo $yeartime['heure'].'h'.$yeartime['minutes'].'min'.$yeartime['second'] .'au total';
  	
?>
<script type="text/javascript">
	$(document).ready(function(){
    $('button').click(function(){
        var clickBtnValue = $(this).attr('id');
        var ajaxurl = 'index.php',
        data =  {'action': clickBtnValue};
        $.post(ajaxurl, data, function (response) {
        	
        });
        var date = new Date;

		var seconds = date.getSeconds();
		var minutes = date.getMinutes();
		var hour = date.getHours();
        if(clickBtnValue=="arriver")
        {
        	$(".now-ar").html('arriver à:'+hour+':'+minutes+':'+seconds+'')
        }
         if(clickBtnValue=="sortir")
        {
        	$(".now-par").html('parti à:'+hour+':'+minutes+':'+seconds+'')
        }
    });

});
</script>
</body>
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
    include_once('include/bdd.php');
    include_once('include/function.php');

    secureAccess();
    include_once ('include/top-barre.php');
    include_once ('include/ajax.php');
 
	$result=current_semaine('');
	$nbj=count($result['jour']);
	echo '<table style="width:100%">
  			<tr>' ;
  	for($i=0;$i<$nbj;$i++){
  		$now1='';
  		$now2='';
		$color='';
  		if($result['jour'][$i]=='Samedi' or $result['jour'][$i]=='Dimanche' or $result['numero'][$i] < date('j')) $color= "style='background-color:#67809F'";
  		if ($result['numero'][$i]==date('j')){
  			$now1='class="now-ar"';
  			$now2='class="now-par"';
  			$color= "style='background-color:#87D37C'";
		}  		

  		echo'<td '.$color.'>'. $result['jour'][$i].' '.$result['numero'][$i].' '.$result['mois'][$i].'<br>('.$result['annee'][$i].')<br><div '.$now1.' id="arive"></div><br><div '.$now2.' id="depart"></div><br><div  id="total"></div></td>';
  	}
  	echo '</tr></table>';

  	
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
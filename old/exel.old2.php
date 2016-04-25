<?php
session_start();
$mois='03';
$year='2016';
$user="1";
$f=1;
$g=1;
$mem=1;
$m=0;
$moissans=ltrim($mois,0);
 include_once('include/bdd.php');
 include_once('include/function.php');

    secureAccess();
   // include_once ('include/top-barre.php');
    include_once ('include/ajax.php');
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/Paris');

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/Classes/PHPExcel.php';
require_once dirname(__FILE__) . '/Classes/PHPExcel/Writer/Excel2007.php';


// Create new PHPExcel object

$objPHPExcel = new PHPExcel();
$moisname= month($moissans);
$number=number_day($moissans, $year);
// Set document properties
$bdd=new bdd();
$array=array($user);
$username=$bdd->tab('select username from user where id=?',$array);
print_r($username);
$objPHPExcel->getProperties()->setCreator($_SESSION['username'])
							 ->setTitle("Fiche de temps ".$moisname.'-'.$year)
							 ->setSubject("PHPExcel Test Document")
							 ->setDescription("fiche de temps pour le mois de ".$moisname.'de l\'année'.$year)
							 ->setKeywords("fiche de temps")
							 ->setCategory("administratif");

$moisname= month($moissans);
$number=number_day($moissans, $year);

$wday=$number;
$alphabet[] = '';
for($x = 'A'; $x < 'ZZZ'; $x++) $alphabet[] = $x;
// Add some data
//ajout colomne a


            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', $moisname.' - '.$year);
            $objPHPExcel->getActiveSheet()->getStyle('A1:'.$alphabet[$number].'1')->applyFromArray(
        array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'FF9900')
            )
        )
    );

            $z=2;
            $y=2;
            $mm=0;
  $bdd=new bdd();
  $domaine=$bdd->tab('select * from domaine','');
  $categories=$bdd->tab('select * from categorie', '');
 
 for($j=0;$j<count($domaine);$j++){
  	for($i=0;$i<count($categories);$i++){
  		if($domaine[$j]['id']==$categories[$i]['id_domaine']){
	  		$objPHPExcel->setActiveSheetIndex(0)
	  					->setCellValue('A'.$z, $categories[$i]['nom']);
	  					$objPHPExcel->getActiveSheet()->freezePane('A2');
	  					$objPHPExcel->getActiveSheet()->freezePane('B1');
	  		$catbyname[$mm]['space']=$z;
	  		$catbyname[$mm]['id']=$categories[$i]['id'];
	  		$z++;
	  		$mm++;
  		}
  	}

  	$objPHPExcel->setActiveSheetIndex(0)
	  					->setCellValue('A'.$z, 'TOTAL : '.$domaine[$j]['nom']);
	  					$tab[]=$z;
	$objPHPExcel->getActiveSheet()->getStyle('A'.$z.':'.$alphabet[$number].$z)->applyFromArray(
        array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'FF9900')
            )
        )
    );

    $u=$z-1;
    for($i=1;$i<=$number;$i++){
    	$objPHPExcel->getActiveSheet()->setCellValue($alphabet[$i].$z, '=SUM('.$alphabet[$i].$y.':'.$alphabet[$i].$u.')');
    }
    $objPHPExcel->getActiveSheet()->setCellValue($alphabet[$number+1].$z, '=SUM('.$alphabet[$number+1].$y.':'.$alphabet[$number+1].$u.')');

	  					$z++;
	  					$y=$z;
  }

$inc=$z+1;
$incc=$z+2;
$inccc=$z+3;
$less=$z-1;
//ajout des deux ligne du bas
$objPHPExcel->getActiveSheet()->getStyle('A'.$inc.':'.$alphabet[$number+2].$inccc)->applyFromArray(
        array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'E26B0A')
            )
        )
    );



//ajout de date header

for($i=1;$i<=$number;$i++){
	 $array=array($user, $i.'-'.$mois.'-'.$year);
  $usercat=$bdd->tab("select * from heure where id_user=? and DATE_FORMAT(date, '%e-%m-%Y')=?", $array);

    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($alphabet[$i].'1', $i.'-'.substr($moisname, 0, 4) );
    $d=jour(date("z", strtotime($year.'-'.$mois.'-'.$i)), $year);
    //formule
    $re2='0';
    $re=0;
    for($p=0;$p<count($tab);$p++){
    	$re=$alphabet[$i-1].$tab[$p]."+".$re;
    	$re2=$alphabet[$number+1].$tab[$p]."+".$re2;
    	$objPHPExcel->getActiveSheet()->setCellValue($alphabet[$number+2].$tab[$p], '=IF('.$alphabet[$number+1].$inc.'>0,('.$alphabet[$number+1].$tab[$p].'/'.$alphabet[$number+1].$inc.')*100,"")');
    }

 	if(!empty($alphabet[$i-1])){
 		$objPHPExcel->getActiveSheet()->setCellValue($alphabet[$i-1].$inc, '=SUM('.$re.')');
 	}
    
//couleur
 $datess = new DateTime($i.'-'.$mois.'-'.$year);

    if($d=="Samedi" or $d=="Dimanche" ){
    	$wday=$wday-1;
    	if($i!=1 ){
	        $objPHPExcel->getActiveSheet()->getStyle($alphabet[$i-1].'1:'.$alphabet[$i-1].$z)->applyFromArray(
	        array(
	            'fill' => array(
	                'type' => PHPExcel_Style_Fill::FILL_SOLID,
	                'color' => array('rgb' => 'FF9900')
	                )
	            )
	        );
	    }

    }
     if(isHoliday($datess->getTimestamp())  ){
    	$wday=$wday-1;
    	if($i!=1 ){
	        $objPHPExcel->getActiveSheet()->getStyle($alphabet[$i].'1:'.$alphabet[$i].$z)->applyFromArray(
	        array(
	            'fill' => array(
	                'type' => PHPExcel_Style_Fill::FILL_SOLID,
	                'color' => array('rgb' => 'FF9900')
	                )
	            )
	        );
	    }

    }

    if($d=="Samedi"){
    	if($i!=1 and $i!=2){
    		$objPHPExcel->getActiveSheet()->setCellValue($alphabet[$i-1].$incc, '=SUM('.$alphabet[$g].$inc.':'.$alphabet[$i-1].$inc.')');
        	$objPHPExcel->getActiveSheet()->setCellValue($alphabet[$i-2].$incc, 'TOTAL SEMAINE '.$f);

	     
    	}
           if(($m % 2 != 0)){
	            $objPHPExcel->getActiveSheet()->setCellValue($alphabet[$i-1].$inccc, '=IF((('.$alphabet[$mem].$incc.'+'.$alphabet[$i-1].$incc.')/2)>35,('.$alphabet[$mem].$incc.'+'.$alphabet[$i-1].$incc.')-70,"")');
	            $objPHPExcel->getActiveSheet()->setCellValue($alphabet[$i-2].$inccc, 'à regulariser ');
	        }
     
         $f++;
         $g=$i+2;
         $mem=$i-1;
         $m++;
        
    }
     $objPHPExcel->getActiveSheet()->setCellValue($alphabet[$number+2].$incc, '='.$wday.'*7');
    $objPHPExcel->getActiveSheet()
    ->getStyle('B'.$inc.':'.$alphabet[$number].$inc)
    ->getAlignment()
    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle('B1')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);

    //insertion des heure effectuées


for($m=0;$m<count($catbyname);$m++){
	$h='';
	for($l=0;$l<=count($usercat[0]);$l++){ 
		if(isset($usercat[0][$l]['id'])){ 
			if(isset($usercat[0][$l]['id_cat']) and ($catbyname[$m]['id']==$usercat[0][$l]['id_cat'])){
				$h=$usercat[0][$l]['nb']+$h;
			}
		}
		//echo "123";
	}
;
	if($h!=''){
		$k=sectohour($h);
		if(!isset($k['h']))$k['h']="00";
		if(!isset($k['m']))$k['m']="00";
		if(!isset($k['s']))$k['s']="00";

	$objPHPExcel->getActiveSheet()->setCellValue($alphabet[$i].$catbyname[$m]['space'], $k['h'].'.'.mintodec($k['m']));
	
	}	
}

  
//ajout formule

}
//fin de boucle du listage des jour du mois



//total
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($alphabet[$i].'1', 'Total' );


             //ajout de formule totale
 $objPHPExcel->getActiveSheet()->setCellValue($alphabet[$number+1].$inc, '=SUM('.$re2.')');
 



for($o=2;$o<=$less;$o++){
    $objPHPExcel->getActiveSheet()->setCellValue($alphabet[$number+1].$o, '=SUM(B'.$o.':'.$alphabet[$number].$o.')');
}



 $objPHPExcel->getActiveSheet()->getStyle($alphabet[$i].'1:'.$alphabet[$i].$less)->applyFromArray(
        array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'E26B0A')
            )
        )
    );



$objPHPExcel->getActiveSheet()->getColumnDimension('A')
        ->setAutoSize(true);
// Rename worksheet


$filename = 'text.xlsx';

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')
        ->setAutoSize(true);
// Rename worksheet


/*// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Save Excel 2007 file

$callStartTime = microtime(true);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;
*/
#echo date('H:i:s') . " Write to Excel2007 format\n";
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
ob_end_clean();
// We'll be outputting an excel file
header('Content-type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="fiche de temps.xlsx"');
$objWriter->save('php://output');
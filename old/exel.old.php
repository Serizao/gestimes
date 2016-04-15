<?php
$mois='03';
$year='2016';
$f=1;
$g=1;
$mem=1;
$m=0;
$moissans=ltrim($mois,0);
 include_once('include/bdd.php');
    include_once('include/function.php');

    //secureAccess();
    include_once ('include/top-barre.php');
    include_once ('include/ajax.php');
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/Classes/PHPExcel.php';


// Create new PHPExcel object
echo date('H:i:s') , " Create new PHPExcel object" , EOL;
$objPHPExcel = new PHPExcel();

// Set document properties
echo date('H:i:s') , " Set document properties" , EOL;
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("PHPExcel Test Document")
							 ->setSubject("PHPExcel Test Document")
							 ->setDescription("Test document for PHPExcel, generated using PHP classes.")
							 ->setKeywords("office PHPExcel php")
							 ->setCategory("Test result file");

$moisname= month($moissans);
$number=number_day($moissans, $year);
$alphabet = array('','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH');
// Add some data
//ajout colomne a
echo date('H:i:s') , " Add some data" , EOL;
/*$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', $moisname.' - '.$year)
            ->setCellValue('A2', 'Fabrication résines')
            ->setCellValue('A3', 'Contrôle qualité')
            ->setCellValue('A4', 'TOTAL PRODUCTION')
            ->setCellValue('A5', 'TOTAL DEVELOPPEMENT PRODUCT°')
            ->setCellValue('A6', 'Traitement commercial')
            ->setCellValue('A7', 'Traitement /T.M.D.')
            ->setCellValue('A8', 'Sécurité produits (REACH, FDS…)')
            ->setCellValue('A9', 'Support technique')
            ->setCellValue('A10', 'Salons/Conférences')
            ->setCellValue('A11', 'Visite distributeurs / clients')
            ->setCellValue('A12', 'Réunions Utilisateurs')
            ->setCellValue('A13', 'Développement commercial')
            ->setCellValue('A14', 'Outils Marketing')
            ->setCellValue('A15', 'Temps de voyages')
            ->setCellValue('A16', 'TOTAL COMMERCIAL / MARKETING')
            ->setCellValue('A17', 'Processus ISO 9001')
            ->setCellValue('A18', 'Environnement')
            ->setCellValue('A19', 'Sécurité')
            ->setCellValue('A20', 'TOTAL QUALITE / ISO')
            ->setCellValue('A21', 'CARAT')
            ->setCellValue('A22', 'Scandium_CDI')
            ->setCellValue('A23', 'FIRM')
            ->setCellValue('A24', 'Zr_93 (Haasi)')
            ->setCellValue('A25', '"Determinat° vials" for 99Tc (Un. Barcelone)')
            ->setCellValue('A26', 'BOKU (nom du projet à venir)')
            ->setCellValue('A27', 'Autres (en cours de négociations)')
            ->setCellValue('A28', 'TOTAL R&D')
            ->setCellValue('A29', 'Inventaire')
            ->setCellValue('A30', 'Administration générale')
            ->setCellValue('A31', 'Réunions entreprises')
            ->setCellValue('A32', 'Réunions Sécurité')
            ->setCellValue('A33', 'Formations/connaissances et pratiques')
            ->setCellValue('A34', 'TOTAL ADMINISTRATION')
            ->setCellValue('A36', 'TOTAL HEURES');*/
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
  $bdd=new bdd();
  $domaine=$bdd->tab('select * from domaine','');
  $categories=$bdd->tab('select * from categorie', '');
 for($j=0;$j<count($domaine);$j++){
  	for($i=0;$i<count($categories);$i++){
  		if($domaine[$j]['id']==$categories[$i]['id_domaine']){
	  		$objPHPExcel->setActiveSheetIndex(0)
	  					->setCellValue('A'.$z, $categories[$i]['nom']);
	  		$z++;
  		}
  	}
  	$objPHPExcel->setActiveSheetIndex(0)
	  					->setCellValue('A'.$z, 'TOTAL : '.$domaine[$j]['nom']);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$z.':'.$alphabet[$number].$z)->applyFromArray(
        array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'FF9900')
            )
        )
    );
    $u=$z-1;
    $objPHPExcel->getActiveSheet()->setCellValue($alphabet[$i].$z, '=SUM('.$alphabet[$i].$y.':'.$alphabet[$i].$u.')');

	  					$z++;
	  					$y=$z;
  }







//ajout de date header

for($i=1;$i<=$number;$i++){
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($alphabet[$i].'1', $i.'-'.substr($moisname, 0, 4) );
    $d=jour(date("z", strtotime($year.'-'.$mois.'-'.$i)), $year);
//couleur
  
    if($d=="Samedi" or $d=="Dimanche"){
     
        $objPHPExcel->getActiveSheet()->getStyle($alphabet[$i-1].'1:'.$alphabet[$i-1].'34')->applyFromArray(
        array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'FF9900')
                )
            )
        );

    }
    if($d=="Samedi"){

        $objPHPExcel->getActiveSheet()->setCellValue($alphabet[$i-1].'37', '=SUM('.$alphabet[$g].'36:'.$alphabet[$i-1].'36)');
        $objPHPExcel->getActiveSheet()->setCellValue($alphabet[$i-2].'37', 'TOTAL SEMAINE '.$f);
        if(($m % 2 != 0)){
            $objPHPExcel->getActiveSheet()->setCellValue($alphabet[$i-1].'38', '=IF((('.$alphabet[$mem].'37+'.$alphabet[$i-1].'37)/2)>35,('.$alphabet[$mem].'37+'.$alphabet[$i-1].'37)-70,"")');
            $objPHPExcel->getActiveSheet()->setCellValue($alphabet[$i-2].'38', 'à regulariser ');
        }
     
         $f++;
         $g=$i+2;
         $mem=$i-1;
         $m++;
        
    }

    $objPHPExcel->getActiveSheet()
    ->getStyle('B37:'.$alphabet[$number].'37')
    ->getAlignment()
    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle('B1')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
   

    $objPHPExcel->getActiveSheet()->getStyle('A36:'.$alphabet[$number].'36')->applyFromArray(
        array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'E26B0A')
            )
        )
    );
    $objPHPExcel->getActiveSheet()->getStyle('A37:'.$alphabet[$number].'37')->applyFromArray(
        array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'E26B0A')
            )
        )
    );
    $objPHPExcel->getActiveSheet()->getStyle('A38:'.$alphabet[$number].'38')->applyFromArray(
        array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'E26B0A')
            )
        )
    );
//ajout formule

}
//fin de boucle du listage des jour du mois



//total
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($alphabet[$i].'1', 'Total' );

            //ajout de formule totale
;
for($o=2;$o<=34;$o++){
    $objPHPExcel->getActiveSheet()->setCellValue($alphabet[$number+1].$o, '=SUM(B'.$o.':'.$alphabet[$number].$o.')');
}

$objPHPExcel->getActiveSheet()->setCellValue($alphabet[$number+1].'4', '=SUM('.$alphabet[$number+1].'2:'.$alphabet[$number+1].'3)');
$objPHPExcel->getActiveSheet()->setCellValue($alphabet[$number+1].'16', '=SUM('.$alphabet[$number+1].'6:'.$alphabet[$number+1].'15)');
$objPHPExcel->getActiveSheet()->setCellValue($alphabet[$number+1].'20', '=SUM('.$alphabet[$number+1].'17:'.$alphabet[$number+1].'19)');
$objPHPExcel->getActiveSheet()->setCellValue($alphabet[$number+1].'28', '=SUM('.$alphabet[$number+1].'21:'.$alphabet[$number+1].'27)');
$objPHPExcel->getActiveSheet()->setCellValue($alphabet[$number+1].'34', '=SUM('.$alphabet[$number+1].'29:'.$alphabet[$number+1].'33)');

 $objPHPExcel->getActiveSheet()->getStyle($alphabet[$i].'1:'.$alphabet[$i].'34')->applyFromArray(
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
echo date('H:i:s') , " Rename worksheet" , EOL;
$objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Save Excel 2007 file
echo date('H:i:s') , " Write to Excel2007 format" , EOL;
$callStartTime = microtime(true);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;

echo date('H:i:s') , " File written to " , str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;
echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
// Echo memory usage
echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;


// Echo memory peak usage
echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , EOL;

// Echo done
echo date('H:i:s') , " Done writing files" , EOL;
echo 'Files have been created in ' , getcwd() , EOL;

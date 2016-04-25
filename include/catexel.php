<?php
session_start();
$cachem=explode("-",$_REQUEST['begindate']);
$cachem2=explode("-",$_REQUEST['enddate']);
//print_r($cachem);

 include_once('bdd.php');
 include_once('function.php');
$month=array($cachem[1],$cachem2[1]);
$year=array($cachem[0], $cachem2[0]);

$f=1;
$g=1;
$mem=1;
$m=0;
$catid=$_REQUEST['catid'];
//$catid=2;
$moissans="3";

    secureAccess();
   // include_once ('include/top-barre.php');
    include_once ('ajax.php');
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/Paris');

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include PHPExcel */
require_once '../Classes/PHPExcel.php';
require_once '../Classes/PHPExcel/Writer/Excel2007.php';
$alphabet[] = '';
for($x = 'B'; $x < 'ZZZ'; $x++) $alphabet[] = $x;

// Create new PHPExcel object

$objPHPExcel = new PHPExcel();
$moisname= month($moissans);
$numberj=number_day($month, $year, 'a');

// Set document properties
$bdd=new bdd();

$username=$bdd->tab('select * from users','');
$array=array($catid);
$cat=$bdd->tab('select nom from categorie where id=?',$array);
$begindate=$cachem[1].'-'.$cachem[0];
$enddate=$cachem2[1].'-'.$cachem2[0];
$array=array($begindate, $enddate, $catid);
$usercat=$bdd->tab("select sum(nb) as nb, id_user from heure where DATE_FORMAT(date, '%m-%Y')>=? and DATE_FORMAT(date, '%m-%Y')<=? and id_cat=? group by `id_user`", $array);


$objPHPExcel->getProperties()->setCreator($_SESSION['username'])
							 ->setTitle("Fiche de temps ")
							 ->setSubject("PHPExcel Test Document")
							 ->setDescription("fiche de temps pour le mois de de l\'année")
							 ->setKeywords("fiche de temps")
							 ->setCategory("administratif");
//ecriture ce la catégorie et autosize de la colomne
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', $cat[0][0]['nom']);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', 'Poucentage');
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);	
$objPHPExcel->getActiveSheet()->freezePane('A2');
$objPHPExcel->getActiveSheet()->freezePane('B2');				//liste des utilisateurs 
for($i=0;$i<count($username);$i++){
	$a=$i+1;

		$objPHPExcel->setActiveSheetIndex(0)->setCellValue($alphabet[$a].'1', $username[$i]['prenom'].' '.$username[$i]['nom']);
		$objPHPExcel->getActiveSheet()->getColumnDimension($alphabet[$a])->setAutoSize(true);	
		
		//on liste le tablea contenu les somme des catégorie
		for($aa=0;$aa<count($usercat);$aa++){
			if($usercat[0][$aa]['id_user']==$username[$i]['id']){
				$array2=array($begindate, $enddate, $usercat[0][$aa]['id_user']);
				$userpurcent=$bdd->tab("select sum(nb) as nb from heure where DATE_FORMAT(date, '%m-%Y')>=? and DATE_FORMAT(date, '%m-%Y')<=? and id_user=?  ", $array2);
				$k=0;
				$k=sectohour($usercat[0][$aa]['nb']);
				
				$c=($usercat[0][$aa]['nb']*100)/$userpurcent[0][0]['nb'];
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($alphabet[$a].'2', $k['h'].'.'.mintodec($k['m']) );
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($alphabet[$a].'3',$c );
			}
		}
}
//on colorise
//les nom des user
$objPHPExcel->getActiveSheet()->getStyle('A1:'.$alphabet[$i].'1')->applyFromArray(array(
			            'fill' => array(
			                'type' => PHPExcel_Style_Fill::FILL_SOLID,
			                'color' => array('rgb' => 'FF9900')
			                )
			            )
			        );
//la ligne du bas
$objPHPExcel->getActiveSheet()->getStyle('A3:'.$alphabet[$i].'3')->applyFromArray(array(
			            'fill' => array(
			                'type' => PHPExcel_Style_Fill::FILL_SOLID,
			                'color' => array('rgb' => 'FF9900')
			                )
			            )
			        );
//le nom de la cat
$objPHPExcel->getActiveSheet()->getStyle('A1:A2')->applyFromArray(array(
			            'fill' => array(
			                'type' => PHPExcel_Style_Fill::FILL_SOLID,
			                'color' => array('rgb' => 'FF9900')
			                )
			            )
			        );


$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
ob_end_clean();
// We'll be outputting an excel file
header('Content-type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="fiche de temps.xlsx"');
$objWriter->save('php://output');
<?php
$mois='03';
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

echo month($mois);
// Add some data
echo date('H:i:s') , " Add some data" , EOL;
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A1', month($mois))
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
            ->setCellValue('A36', 'TOTAL HEURES');






$objPHPExcel->getActiveSheet()->getStyle('A4:A5')->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'FF9900')
        )
    )
);

$objPHPExcel->getActiveSheet()->getStyle('A16')->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'FF9900')
        )
    )
);

$objPHPExcel->getActiveSheet()->getStyle('A20')->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'FF9900')
        )
    )
);

$objPHPExcel->getActiveSheet()->getStyle('A28')->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'FF9900')
        )
    )
);

$objPHPExcel->getActiveSheet()->getStyle('A34')->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'FF9900')
        )
    )
);

$objPHPExcel->getActiveSheet()->getStyle('A36:A38')->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'FF9900')
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

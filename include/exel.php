<?php
include_once('autoload.php');
include_once('function.php');
user::session();
date_default_timezone_set('Europe/Paris');
if (isset($_REQUEST['begindate']) and user::check_admin()) {
    $d1b     = $_REQUEST['begindate'];
    $d2e     = $_REQUEST['enddate'];
    $cachem  = explode("-", $_REQUEST['begindate']);
    $cachem2 = explode("-", $_REQUEST['enddate']);
    $user    = $_REQUEST['userid'];
} else {
    if (!isset($_GET['m']) and empty($_GET['m'])) {
        $user    = $_SESSION['userid'];
        $d1b     = date("Y-m");
        $d2e     = date("Y-m");
        $cachem  = explode("-", date("Y-m"));
        $cachem2 = explode("-", date("Y-m"));
    }
    echo date('Y-m', strtotime('-1 month'));
    if (isset($_GET['m']) and !empty($_GET['m']) and $_GET['m'] == 1) {
        $onemonthago = date('Y-m', strtotime('-1 month'));
        $d1b         = $onemonthago;
        $d2e         = $onemonthago;
        $user        = $_SESSION['userid'];
        $cachem      = explode("-", $onemonthago);
        $cachem2     = explode("-", $onemonthago);
    }
}
$month    = array(
    $cachem[1],
    $cachem2[1]
);
$year     = array(
    $cachem[0],
    $cachem2[0]
);
$liste_somme        =array();
$hour_letter_mem    = 'B';
$hour_by_cat_mem    = 0;
$f                  = 1;
$g                  = 1;
$mem                = 1;
$m                  = 0;
$moissans           = "3";
include_once('ajax.php');
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
/** Include PHPExcel */
require_once '../Classes/PHPExcel.php';
require_once '../Classes/PHPExcel/Writer/Excel2007.php';
$alphabet[] = '';
for ($x = 'B'; $x < 'ZZZ'; $x++) {
    $alphabet[] = $x;
}
// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
$moisname    = month($moissans);
$numberj     = number_day($month, $year, 'a');
// Set document properties
$bdd         = new bdd();
$array       = array(
    $user
);
$bdd->cache('select username from users where id=?', $array);
$username    = $bdd->exec();
$objPHPExcel->getProperties()->setCreator($_SESSION['username'])->setTitle("Fiche de temps du " . $d1b . '-' . $d2e . '')->setSubject("PHPExcel Test Document")->setDescription("fiche de temps pour le mois de de l\'année")->setKeywords("fiche de temps")->setCategory("administratif");
$moisname = month($moissans);
$wday     = $numberj;
// Add some data
//ajout colomne a
$objPHPExcel->getActiveSheet()->getStyle('A1:' . $alphabet[$numberj] . '1')->applyFromArray(array(
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array(
            'rgb' => 'FF9900'
        )
    )
));
$z          = 2;
$y          = 2;
$mm         = 0;
$bdd        = new bdd();
$bdd->cache('select * from domaine', '');
$domaine    = $bdd->exec();
$bdd->cache('select * from categorie', '');
$categories = $bdd->exec();
for ($j = 0; $j < count($domaine); $j++) {
    for ($i = 0; $i < count($categories); $i++) {
        if ($domaine[$j]['id'] == $categories[$i]['id_domaine']) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $z, $categories[$i]['nom']);
            $objPHPExcel->getActiveSheet()->freezePane('A2');
            $objPHPExcel->getActiveSheet()->freezePane('B2');
            $catbyname[$mm]['space'] = $z;
            $catbyname[$mm]['id']    = $categories[$i]['id'];
            $z++;
            $mm++;
        }
    }
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $z, 'TOTAL : ' . $domaine[$j]['nom']);
                                 if(!in_array($z, $liste_number_somme)){
                                    $liste_number_somme[]=$z;
                                }
    $tab[] = $z;
    $objPHPExcel->getActiveSheet()->getStyle('A' . $z . ':' . $alphabet[$numberj] . $z)->applyFromArray(array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array(
                'rgb' => 'FF9900'
            )
        )
    ));
    $u = $z - 1;
    for ($i = 1; $i <= $numberj; $i++) {
        $objPHPExcel->getActiveSheet()->setCellValue($alphabet[$i] . $z, '=SUM(' . $alphabet[$i] . $y . ':' . $alphabet[$i] . $u . ')');
    }
    $objPHPExcel->getActiveSheet()->setCellValue($alphabet[$numberj + 1] . $z, '=SUM(' . $alphabet[$numberj + 1] . $y . ':' . $alphabet[$numberj + 1] . $u . ')');
    $z++;
    $y = $z;
}
$inc   = $z + 1;
$incc  = $z + 2;
$inccc = $z + 3;
$less  = $z - 1;
//ajout des deux ligne du bas
$objPHPExcel->getActiveSheet()->getStyle('A' . $inc . ':' . $alphabet[$numberj + 2] . $inccc)->applyFromArray(array(
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array(
            'rgb' => 'E26B0A'
        )
    )
));
$re2      = '0';
$re       = 0;
$compteur = 0;
//ajout de date header$
$idee     = number_day($month, $year, 'm');
$oi       = 0;
$moisbase = $month[0];
$yy       = $year[0];
$all      = 0;
$jour_semaine=0;
for ($y = $yy; $y <= end($year); $y++) { //list des année
    $number = number_day($moisbase, $y, '');
    for ($pp = $month[0]; $pp <= end($month); $pp++) { //liste des mois
        for ($i = 1; $i <= $number; $i++) { //liste de jour
            $all++;
        }
    }
}
if(isset($catbyname) and !empty($catbyname)){
    for ($y = $yy; $y <= end($year); $y++) { //list des année
        for ($pp = $month[0]; $pp <= end($month); $pp++) { //liste des mois
            $number   = number_day($moisbase, $y, '');
            $wday     = $number;
            $moisname = month(ltrim($moisbase, 0));
            for ($i = 1; $i <= $number; $i++) { //liste de jour
                if (strlen($i) == 1) {
                    $i = '0' . $i;
                }
                if (strlen($pp) == 1) {
                    $pp = '0' . $pp;
                }
                $compteur++;
                $array   = array(
                    $user,
                    $i . '-' . $pp . '-' . $y
                );
                $bdd->cache("select * from heure where id_user=? and DATE_FORMAT(date, '%d-%m-%Y')=?", $array);
                $usercat = $bdd->exec();
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($alphabet[$compteur] . '1', $i . '-' . substr($moisname, 0, 4) . '-' . substr($y, -2));
                $objPHPExcel->getActiveSheet()->getColumnDimension($alphabet[$compteur])->setAutoSize(true);
                $oao    = mktime(0, 0, 0, $pp, $i, $year[0]);
                $jour   = array(
                    "Dimanche",
                    "Lundi",
                    "Mardi",
                    "Mercredi",
                    "Jeudi",
                    "Vendredi",
                    "Samedi"
                );
                $times  = date("w", $oao);
                $d      = $jour[$times];
                //echo $d.' '.$oao.' '.$year[0].'-'.$pp.'-'.$i.'<br>';
                $datess = new DateTime($i . '-' . $pp . '-' . $year[0]);
                //formule
                $mmm    = $oi + $i + 2;
                for ($p = 0; $p < count($tab); $p++) {
                    $re  = $alphabet[$oi + $i - 1] . $tab[$p] . "+" . $re;
                    $re2 = $alphabet[$number + 1] . $tab[$p] . "+" . $re2;
                }
                if (!empty($alphabet[$oi - 1])) {
                    $objPHPExcel->getActiveSheet()->setCellValue($alphabet[$oi - 1] . $inc, '=SUM(' . $re . ')');
                }
                $hour_by_cat_mem++;
                //couleur
                //colorisation des samedi et dimanche
                $ligne=$z+1;
                
                if ($d === "Samedi" or $d === "Dimanche") {
                    if ($i != 1) {
                        $objPHPExcel->getActiveSheet()->getStyle($alphabet[$i + $oi] . '1:' . $alphabet[$i + $oi] . $z)->applyFromArray(array(
                            'fill' => array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array(
                                    'rgb' => 'FF9900'
                                )
                            )
                        ));
                        if($d=="Samedi"){
                            
                        
                            //somme total hebdomadaire
                            
                            for($cat_total=0;$cat_total<count($tab);$cat_total++){
                                //somme par catégorie
                             //   $objPHPExcel->setActiveSheetIndex(0)->setCellValue($alphabet[$i + $oi] . $tab[$cat_total], '=SUM('.$hour_letter_mem.$tab[$cat_total].':'.$alphabet[$i + $oi-1] . $tab[$cat_total].')');
                                if(!in_array($alphabet[$i + $oi], $liste_somme)){
                                    $liste_somme[]=$alphabet[$i + $oi];
                                }
                                 if(!in_array($tab[$cat_total], $liste_number_somme)){
                                    $liste_number_somme[]=$tab[$cat_total];
                                }
                            }
                        }
                         if($d=="Dimanche"){
                            $hour_by_cat_mem=0;
                            $hour_letter_mem=$alphabet[$i + $oi+1];
                            $ligne_total=$z+2;
                            $ligne_total_bis=$z+1;
                            $bas_colonne_total=$z-1;
                            $begin_total_hebdo=($i + $oi)-$jour_semaine;
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($alphabet[$i+$oi] . $ligne_total, '="TOTAL : "&SUM('.$alphabet[$i + $oi].$ligne_total_bis.':'.$alphabet[$begin_total_hebdo].$ligne_total_bis.')');
                            $jour_semaine=0;
                         }
                    }
                }
                $somme_par_jour='=SUM('.$alphabet[$oi + $i].$liste_number_somme['0'];
                for($count_ligne_somme=1;$count_ligne_somme<count($liste_number_somme);$count_ligne_somme++){
                    $somme_par_jour=$somme_par_jour.'+'.$alphabet[$oi + $i].$liste_number_somme[$count_ligne_somme];
                 
                }
                $jour_semaine++;
                $somme_par_jour=$somme_par_jour.')';
              $objPHPExcel->getActiveSheet()->setCellValue($alphabet[$oi + $i] . $ligne, $somme_par_jour);
                //colorisation desq vaccance et jour ferié
                if (isHoliday($oao)) {
                    $wday = $wday - 1;
                    $objPHPExcel->getActiveSheet()->getStyle($alphabet[$i + $oi] . '1:' . $alphabet[$i + $oi] . $z)->applyFromArray(array(
                        'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array(
                                'rgb' => 'FF9900'
                            )
                        )
                    ));
                }
                if ($d == "Samedi") {
                    $f++;
                    $g   = $i + 2;
                    $mem = $i - 1;
                    $m++;
                }
                $objPHPExcel->getActiveSheet()->getStyle('B' . $inc . ':' . $alphabet[$number] . $inc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $objPHPExcel->getActiveSheet()->getStyle('B1')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);

                //insertion des heure effectuées
                for ($m = 0; $m < count($catbyname); $m++) {
                    $h = '';
                    for ($l = 0; $l <= count($usercat[0]); $l++) {
                        if (isset($usercat[0][$l]['id'])) {
                            if (isset($usercat[0][$l]['id_cat']) and ($catbyname[$m]['id'] == $usercat[0][$l]['id_cat'])) {
                                $h = $usercat[0][$l]['nb'] + $h;
                            }
                        }
                    }
                    if ($h != '') {
                        $k = sectohour($h);
                        if (!isset($k['h'])) {
                            $k['h'] = "00";
                        }
                        if (!isset($k['m'])) {
                            $k['m'] = "00";
                        }
                        if (!isset($k['s'])) {
                            $k['s'] = "00";
                        }
                        $objPHPExcel->getActiveSheet()->setCellValue($alphabet[$oi + $i] . $catbyname[$m]['space'], $k['h'] . '.' . mintodec($k['m']));
                        
                    }
                }
                //ajout formule
            }
            $moisbase++;
            $oi = $i + $oi - 1;
        }
    }

    //fin de boucle du listage des jour du mois
    $re2 = 0;
    for ($p = 0; $p < count($tab); $p++) {
        $re  = $alphabet[$oi - 1] . $tab[$p] . "+" . $re;
        $re2 = $alphabet[$oi + 1] . $tab[$p] . "+" . $re2;
        //FOMULE POUCENTAGE
        $objPHPExcel->getActiveSheet()->setCellValue($alphabet[$oi + 2] . $tab[$p], '=IF(' . $alphabet[$oi + 1] . $inc . '>0,CONCATENATE((' . $alphabet[$oi + 1] . $tab[$p] . '/' . $alphabet[$oi + 1] . $inc . ')*100,"%"),"")');

    }
    //total
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($alphabet[$oi + 1] . '1', 'Total');
    //ajout de formule totale
    $objPHPExcel->getActiveSheet()->setCellValue($alphabet[$oi + 1] . $inc, '=SUM(' . $re2 . ')');
    function total_total($a,$liste_somme,$letter,$alphabet){
        $return_total=$liste_somme['0'].$a;
         for($test_count=1;$test_count<count($liste_somme);$test_count++){
            $return_total=$return_total.'+'.$liste_somme[$test_count].$a;
        }
        
        if($letter!=$liste_somme[$test_count]){
                $letter_begin_id=array_search($letter, $alphabet)-$jour_semaine;
                $letter_end_id=array_search($letter, $alphabet);
                $return_total=$return_total.'+ SUM('.$alphabet[$letter_end_id].$a.':'.$alphabet[$letter_end_id].$a.')';
            } 
        
        return $return_total;
    }

//total collonne
    for ($o = 0; $o < count($liste_number_somme); $o++) {
       // $objPHPExcel->getActiveSheet()->setCellValue($alphabet[$oi + 1] . $liste_number_somme[$o], '='.total_total($liste_number_somme[$o],$liste_somme,$alphabet[$oi],$alphabet));
        $objPHPExcel->getActiveSheet()->setCellValue($alphabet[$oi + 1] . $liste_number_somme[$o], '=SUM(B'.$liste_number_somme[$o].':'.$alphabet[$oi].$liste_number_somme[$o].')');

    }

    $objPHPExcel->getActiveSheet()->getStyle($alphabet[$oi + 1] . '1:' . $alphabet[$oi + 1] . $less)->applyFromArray(array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array(
                'rgb' => 'E26B0A'
            )
        )
    ));
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
    // Rename worksheet
}
$filename = 'text.xlsx';
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
ob_end_clean();
// We'll be outputting an excel file


header('Content-type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="fiche de temps du ' . $d1b . ' au ' . $d2e . '.xlsx"');
$objWriter->save('php://output');
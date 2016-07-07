<?php
include_once('function.php');
include_once('bdd.php'); 
user::check_admin();
include_once('admin-function.php');
$cachem=explode("-",$_REQUEST['begindate']);
$cachem2=explode("-",$_REQUEST['enddate']);
$catdom=$_REQUEST['catdom'];
if($catdom==1){
    $type='categorie';
    $sql="select sum(a.nb) as nb, a.id_cat, b.nom from heure a, categorie b where DATE_FORMAT(a.date, '%m-%Y')>=? and DATE_FORMAT(a.date, '%m-%Y')<=? and b.id=a.id_cat group by a.id_cat";
}
if($catdom==2){
    $type='domaine';
    $sql="select sum(a.nb) as nb, a.id_cat, c.nom from heure a, categorie b , domaine c where DATE_FORMAT(a.date, '%m-%Y')>=? and DATE_FORMAT(a.date, '%m-%Y')<=? and b.id=a.id_cat and b.id_domaine=c.id group by c.id";
}
$month=array($cachem[1],$cachem2[1]);
$year=array($cachem[0], $cachem2[0]);
$bdd=new bdd();
$begindate=$cachem[1].'-'.$cachem[0];
$enddate=$cachem2[1].'-'.$cachem2[0];
$array=array($begindate, $enddate);
?>
<div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
<script>
$(function () {
    $(document).ready(function () {
        // Build the chart
        $('#container').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
                },
                title: {
                    text: 'Export des catégories du <?php echo $begindate." au ".$enddate;?> '
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: false
                        },
                        showInLegend: true
                    }
                },
                series: [{
                    name: 'Brands',
                    colorByPoint: true,
                    data: [

<?php
$bdd->cache( $sql, $array);
$result   = $bdd->exec();
$result   = $result[0];
$all      = 0;
$compteur = count($result);
for($i=0;$i<$compteur;$i++){
 $all=$all+$result[$i]['nb'];
}
for($i=0;$i<$compteur;$i++){
    $percent=0;
    $percent=($result[$i]['nb']*100)/$all;
    echo "
    {   
                    name: '".$result[$i]['nom']."',
                    y: ".$percent."
                },";
}

?>
                 ]
            }]
        });
    });
});
    </script>
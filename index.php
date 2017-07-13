<?php
session_start();
date_default_timezone_set('Europe/Paris');
include_once('include/autoload.php');
user::check_login();
include_once('include/function.php');
?>
<!doctype html>
 <html class="no-js" lang="">
 <head>
            <title>Gestime</title>
            <meta charset="utf-8">
            <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
            <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
            <link rel="stylesheet" href="css/font-awesome.min.css">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" type="text/css" href="css/global.css">
            <link rel="stylesheet" type="text/css" href="css/popup.css">
            <script src="js/jquery-2.0.2.js" type="text/javascript"></script>
            <!--style retro compatibilité html5-->
            <link rel="stylesheet" href="css/shim-ext.css">
            <link rel="stylesheet" href="css/nprogress.css">
            <link rel="stylesheet" href="css/forms-picker.css">
            <script src="js/jquery-migrate-1.2.1.min.js"></script>
            <script src="./js/nprogress.js"></script>
            <script src="js/polyfiller.js"></script>
<script>
    webshims.setOptions('forms-ext', {types: 'date'});
    webshims.polyfill('forms forms-ext');
    var timer = null;
    //refresh auto de la page
    setTimeout(function(){
   window.location.reload(1);
}, <?php echo REFRESH_TIME; ?>);

</script>
</head>
<body>
<?php
include_once('include/top-barre.php');
if(isset($_REQUEST['action']) and !empty($_REQUEST['action']))
{
  $i=$_REQUEST['action'];
} else {
  $i="";
}
switch ($i) {
    case 'user-modo':
        include('include/user-modo.php');
        break;
    case 'ics':
        include('include/user-ics.php');
        break;
    default:
        include('include/user-index.php');
        break;
}
?>
<script src="./js/user.js"></script>
<script src="./js/popup.js"></script>
<script src="./js/bootstrap.min.js"></script>
</body>
</html>

<nav class="navbar navbar-default"> 
    <div class="container-fluid"> <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-7" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span> 
            <span class="icon-bar"></span> <span class="icon-bar"></span>
            <span class="icon-bar"></span> 
        </button>
        <a class="navbar-brand" href="index.php">Gestime</a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-7">
        <ul class="nav navbar-nav">
            <li><a href="#" id="arriver" class="esbutton"><i class="fa fa-arrow-down" aria-hidden="true"></i> Arriver</a></li>
            <li><a href="#" id="sortir" class="esbutton"><i class="fa fa-arrow-up" aria-hidden="true"></i> Sortir</a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-file-excel-o" aria-hidden="true"></i> Mes exports Excel<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="include/exel.php">ce mois-ci</a></li>
                        <li><a href="include/exel.php?m=1">le mois dernier</a></li>
                    </ul>
            </li>
            <li><a href="?function=cal" ><i class="fa fa-calendar" aria-hidden="true"></i> Le calendrier</a></li>
            
            <?php
if ($_SESSION['acl']==10) {
    echo '<li><a href="admin.php" id ><i class="fa fa-cog" aria-hidden="true"></i> Panneau d\'administration</a></li>';
}
?>
        </ul>
        <ul class="nav navbar-nav navbar-right">
                <li><a href="include/ajax.php?action=disconnect" id="diconnect" name="disconnect"> Déconnexion <i class="fa fa-sign-out" aria-hidden="true"></i></a>
            </ul>
    </div>
</nav>
<div id="retourtop"></div>
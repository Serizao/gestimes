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
            <li><a href="#" id="arriver" class="esbutton">Arriver</a></li>
            <li><a href="#" id="sortir" class="esbutton">Sortir</a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Mes exports Excel<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="include/exel.php">ce mois-ci</a></li>
                        <li><a href="include/exel.php?m=1">le mois dernier</a></li>
                    </ul>
            </li>
            <li><a href="?function=cal" >Le calendrier</a></li>
            <li><a href="include/ajax.php?action=disconnect" id="diconnect" name="disconnect"> Déconnexion</a>
            <?php
if ($_SESSION['acl']==10) {
    echo '<li><a href="admin.php" id >Panneau d\'administration</a></li>';
}
?>
            
        </ul>
        
    </div>
</nav>
<div id="retourtop"></div>
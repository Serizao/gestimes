<?php
    include_once('include/function.php');
    include_once('include/bdd.php'); 
    include_once('include/admin-function.php');
    if(user::check_admin()){
        ?>
        <!DOCTYPE html>
        <html>
            <head>
                <title>Auth</title>
                <meta charset="utf-8">
                <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
                <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" type="text/css" href="css/popup.css"> 
                <link rel="stylesheet" type="text/css" href="css/global.css">
                <script src="js/jquery-1.12.0.min.js"></script>
                <script src="js/jquery-migrate-1.2.1.min.js"></script>
                
                <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
                <!--[if lt IE 9]>
                  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
                  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
                <![endif]-->
                <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, user-scalable=0">
    <!--[if lt IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!-- CSS ======================================================
        <link rel="stylesheet" href="css/responsivetables.css">-->
        <!-- Demo CSS (don't use) -->
    <link rel="stylesheet" href="css/monthly.css">
            </head>
            <body>
                <?php
                    $bdd = new bdd();
                    $bdd->cache('select id from conge where state=0','');
                    $a   = $bdd->exec();
                    if(count($a)>0){
                        $not='<span class="badge">'.count($a).' </span>';
                    }else{
                        $not="";
                    }
                    
                    ?>
                <div>
                    <nav class="navbar navbar-inverse" style="border-radius:0px">
                      <div class="container-fluid">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                          </button>
                          <a class="navbar-brand" href="index.php">Gestime</a>
                        </div>

                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                          <ul class="nav navbar-nav">
                            <li><a href="index.php">retour au menu utilisateur</a></li>
                            <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Les exports <span class="caret"></span></a>
                              <ul class="dropdown-menu">
                                <li><a href="admin.php?action=statuser">statistiques utilisateur</a></li>
                                <li><a href="admin.php?action=hour">les exports excel</a></li>
                                <li><a href="admin.php?action=view">les graphiques</a></li>
                                <li><a href="admin.php?action=timeline">les projets eligible cir</a></li>
                              </ul>
                            </li>
                          
                           <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">gestion <?php echo $not; ?><span class="caret"></span></a>
                              <ul class="dropdown-menu">
                                
                                <li><a href="admin.php?action=user">gerer les utilsateurs</a></li>
                                <li><a href="admin.php?action=contrat">gerer les contrats</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="admin.php?action=conge">gerer les congés <?php echo $not; ?></span></a></li>
                                <li><a href="admin.php?action=motif">gerer les motifs de congés</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="admin.php?action=domaine">gerer les domaines</a></li>
                                <li><a href="admin.php?action=categorie">gerer les catégories</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="admin.php?action=geshour">gerer les heures</a></li>
                              </ul>
                              
                            </li>
                             <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Système<span class="caret"></span></a>
                              <ul class="dropdown-menu">
                                
                                <li><a href="admin.php?action=clean">nettoyer la base de donnée</a></li>
                                <li><a href="admin.php?action=config">configuration</a></li>
                                <li><a href="admin.php?action=importldap">import LDAP</a></li>
                              
                              </ul>
                              <li><a href="admin.php?action=calendar">le calendrier</a></li>
                            </li>
                          </ul>
                         
                          <ul class="nav navbar-nav navbar-right">
                           <li><a href="include/ajax.php?action=disconnect">deconnexion</a></li>
                          </ul>
                        </div><!-- /.navbar-collapse -->
                      </div><!-- /.container-fluid -->
                    </nav>





                    <?php
                    if(isset($_REQUEST['action'])){
                        $choix=$_REQUEST['action'];
                        switch($choix){

                        case "user": //panneau de gestion des utilisateurs
                            include('include/admin-user.php');
                            break;
                        case "categorie":
                            include('include/admin-categorie.php');
                            break;
                        case "domaine":
                            include('include/admin-domaine.php');
                            break;
                        case "hour":
                            include('include/admin-hour.php');
                            break;
                        case "view":
                            include('include/admin-view.php');
                        break;
                        case "statuser":
                            include('include/admin-statuser.php');
                        break;
                        case "contrat":
                            include('include/admin-contrat.php');
                        break;
                        case "motif":
                            include('include/admin-motif.php');
                        break;
                        case "conge":
                            include('include/admin-conge.php');
                        break;
                        case "calendar":
                            include('include/admin-calendar.php');
                        break;
                        case "generateevent":
                            include('include/admin-generateevent.php');
                        break;
                        case "geshour":
                            include('include/admin-geshour.php');
                        break;
                        case "clean":
                            include('include/admin-clean.php');
                        break;
                        case "importldap":
                            include('include/admin-ildap.php');
                        break;
                        case "timeline":
                            include('include/admin-cir-proj.php');
                        break;
                        }
                    }    
                    ?>
                </div>
                <script src="./js/admin.js"></script>
                <script src="./js/popup.js"></script>
                <script src="./js/bootstrap.min.js"></script>

            </body>
        </html>
        <?php
        
        
    }
    else{
        echo 'vous n\'avez pas les droits pour acceder à cette section';
    }
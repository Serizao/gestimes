<?php
    session_start();
    include_once('include/function.php');                                                                                                                                                                     
    $page['windowTitle'] = 'Connexion';
    if (isset($_GET['action']) AND isset($_SESSION['username']) AND $_SESSION['username']=='admin'){
        header('location: index.php');
        exit;
    }
    if ($_POST){
        if ($_POST['username']=='admin' && $_POST['password']=='monpass'){
            $_SESSION['username']=$_POST['username'];
            header('location: index.php');
            exit;
        }else{
            $errMsg='<div style="border:solid 2px red; background:pink;color:red;padding:1em;display:inline-block" class="droid">Nom d´utilisateur ou mot de passe invalide.</div>';
        }
    }
?>
<!DOCTYPE html>
    <html>
        <head>
            <title>Auth</title>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" type="text/css" href="css/auth.css">
        </head>
        <body>
           
            <form method="POST">
                <div class="content">
                    <h1>Connexion</h1>
                    <?php if (isset($errMsg)) { print $errMsg;} ?>
                    <p class="free_sans">Please, logon to use</p>
                    <input type="text" class="free_sans" name="username" placeholder="Nom d'utilisateur">
                    <br>
                    <input class="free_sans" name="password" placeholder="Mot de passe" type="password">
                    <br>
                    <input class="input" type="submit" value="Valider">
                    <br>
                    <a href="subscribe.php"> s'inscrire</a>
                </div>
            </form>
            

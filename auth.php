<?php
    session_start();
    include_once('include/function.php');
    include_once('include/bdd.php');

    $ad=new ad();                                                  
    $page['windowTitle'] = 'Connexion';
    if (isset($_GET['action']) AND isset($_SESSION['username']) AND $_SESSION['username']=='admin'){
        header('location: index.php');
        exit;
    }
    if ($_POST and !empty( $_POST['password']) and !empty( $_POST['username'])){
        $bdd=new bdd;
        $data=array($_POST['username'], hash('sha512', $_POST['password']));
        $result=$bdd->tab("select id, acl from users where username=? and password=?",$data);
        if (isset($result[0][0]['id'])){
           
            $_SESSION['username']=$_POST['username'];
            $_SESSION['userid']=$result[0][0]['id'];
			 $_SESSION['acl']=$result[0][0]['acl'];

            header('location: index.php');
            exit;
        }elseif($ad->login($_POST['username'], $_POST['password'])){
            $data2=array($_POST['username']);
            $result=$bdd->tab("select id, acl, state from users where username=?",$data2);
             if (isset($result[0][0]['id'])){
                if($result[0][0]['state']==1){
                $_SESSION['username']=$_POST['username'];
                $_SESSION['userid']=$result[0][0]['id'];
                $_SESSION['acl']=$result[0][0]['acl'];
                header('location: index.php');
                }else{
                    echo 'compte en cour de validation';
                    exit;
                }
                
            }else{
                $info=$ad->get_info($_POST['username'], $_POST['password']);
                $array=array($_POST['username'],$info[0]['sn'][0],$info[0]['givenname'][0],'','1', $info[0]['mail'][0], '','','0');

                echo '<br><br>';
                var_dump($array);
                $bdd->tab("insert into users set id='', username=?, nom=?, prenom=?, password=?, acl=?, mail=?, id_contrat=?, begin=?,state=?", $array);
            }

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
            

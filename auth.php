<?php
include_once('include/function.php');
include_once('include/bdd.php');
$ad                  = new ad();
$util                = new user;
$bdd               = new bdd;
$page['windowTitle'] = 'Connexion';
if (isset($_SESSION['uid'])) { //si deja connecté
    $util->check_login();
    header('location: index.php');
    exit;
}
if (!empty($_POST['password']) and !empty($_POST['username'])) { //auth dans la bdd
    $result = $util->auth($_POST['password'], $_POST['username']);
    if ($result) {
        header('location: index.php');
        exit;
    } elseif ($ad->login($_POST['username'], $_POST['password'])) { //auth ad
        $data2 = array(
            $_POST['username']
        );
        setcookie ("username", $_POST['username'], time() + 432000);
        //on verifie que le user exite dans notre table
        $bdd->cache("select id, acl, state from users where username=?", $data2);
        $result = $bdd->exec();
        if (isset($result[0][0]['id'])) {
            if ($result[0][0]['state'] == 1) {
                $_SESSION['username'] = $_POST['username'];
                $_SESSION['userid']   = $result[0][0]['id'];
                $_SESSION['acl']      = $result[0][0]['acl'];
                $_SESSION['uid'] = sha1(uniqid('',true).'_'.mt_rand()); 
                $_SESSION['ip']=user::ip();                
                $_SESSION['expires_on']=time()+INACTIVITY_TIMEOUT;
                header('location: index.php');
                exit();
            } else {
                echo 'compte en cour de validation';
                exit;
            }
            
        } else {// on l'ajout si il n'est pas present en temps qu'utilisateur desactivé
            $info  = $ad->get_info($_POST['username'], $_POST['password']);
            $array = array(
                $_POST['username'],
                $info[0]['sn'][0],
                $info[0]['givenname'][0],
                '',
                '1',
                $info[0]['mail'][0],
                '',
                '',
                '0'
            );
            
            echo '<br><br>';
            var_dump($array);
            $bdd->cache("insert into users set id='', username=?, nom=?, prenom=?, password=?, acl=?, mail=?, id_contrat=?, begin=?,state=?", $array);
            $bdd->exec();
        }
        
    } else {
        $errMsg = '<div style="border:solid 2px red; background:pink;color:red;padding:1em;display:inline-block" class="droid">Nom d´utilisateur ou mot de passe invalide.</div>';
    }
}
if(isset($_COOKIE['username'])){
    $value='value="' . $_COOKIE['username'] . '"';
} else {
    $value="";
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
                    <?php
if (isset($errMsg)) {
    print $errMsg;
}
?>
                    <p class="free_sans">Please, login to use</p>
                    <input type="text" class="free_sans" <?php echo $value; ?> name="username" placeholder="username" >
                    <br>
                    <input class="free_sans" name="password" placeholder="Mot de passe" type="password">
                    <br>
                    <input class="input" type="submit" value="Valider">
                    <br>
                    
                </div>
            </form>
</body>
</html>            

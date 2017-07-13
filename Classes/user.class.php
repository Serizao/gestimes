<?php
class user
  {
    public function __construct(){
        user::session();
        $this->_bdd=new bdd;
        $this->_colusername='username';  //username colonne
        $this->_colpassword='password';  //password colonne
        $this->_coluserid='id';  //user id colonne
        $this->_tabuser='users';  //user table
        if(isset($_SESSION['id']) and $_SESSION['id']!=''){
            $this->_userid=$_SESSION['id'];
        }
        else $this->_userid='';
        $this->_userid='';  //id de l'utilisateur il sera initaliser après l'auth
        $this->_password_type='sha512';  //type d'encodage du password user dans la bdd
    }
    public static function ip(){
         $ip = $_SERVER["REMOTE_ADDR"];
        // empechement du hijaking de session
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { $ip=$ip.'_'.$_SERVER['HTTP_X_FORWARDED_FOR']; }
        if (isset($_SERVER['HTTP_CLIENT_IP'])) { $ip=$ip.'_'.$_SERVER['HTTP_CLIENT_IP']; }
        return $ip;
    }
    public function auth($user,$password){
        user::session();
        $password=hash($this->_password_type, $password);
        $this->_bdd->cache('SELECT '.$this->_coluserid.' as nb, acl FROM '.$this->_tabuser.' where '.$this->_colusername.'=? and '.$this->_colpassword.'=?',array($user,$password));
        $var=$this->_bdd->exec();
        //var_dump('SELECT '.$this->_coluserid.' as nb, acl FROM '.$this->_tabuser.' where '.$this->_colusername.'=? and '.$this->_colpassword.'=?'.$user,$password);
        if(isset($var[0][0]['nb']) and $var[0][0]['nb']!=''){
            setcookie ("username", $_POST['username'], time() + 432000);
            $_SESSION['id']=$var[0][0]['nb'];
            $_SESSION['acl']=$var[0][0]['acl'];
            $_SESSION['userid']=$var[0][0]['nb'];
            $_SESSION['uid'] = sha1(uniqid('',true).'_'.mt_rand());
            $_SESSION['ip']=$this->ip();   // stockage de l'ip deu visiteur
            $_SESSION['username']=$user;
            $_SESSION['expires_on']=time()+INACTIVITY_TIMEOUT;  // Set session expiration.
            return True;
        }
        else{
            return False;
        }
    }
    public function inscription($username,$password){
        $password=hash($this->_password_type, $password);
        $this->_bdd->cache('INSERT INTO '.$this->_tabuser.' set '.$this->_colpassword.'=?, '.$this->_colusername.'=?',array($username,$password));
        $this->_bdd->exec();
    }
    public function getinfo(){
        $this->_bdd->cache('select * from '.$this->_tabuser.' where '.$this->_coluserid.' = '.$this->_userid,'');
        $var=$this->_bdd->exec();
        return $var;
    }
    public static function check_login($referer=''){
        user::session();
        // si la session n'existe pas ou qu l'ip a changer -> logout
        if (!isset ($_SESSION['uid']) || !$_SESSION['uid'] || $_SESSION['ip']!=user::ip() || time()>=$_SESSION['expires_on'])
        {
            user::logout();
        }
        if($referer!='' and $referer!=$_SERVER['HTTP_REFERER']){
            user::logout();
        }
        $_SESSION['expires_on']=time()+INACTIVITY_TIMEOUT;  // mise a jour de la dte d'expiration
    }
    public static function check_admin($referer=''){
        user::session();
        user::check_login($referer);
        if(isset($_SESSION['acl']) and $_SESSION['acl']==10){
            $resultat = true;
        } else {
            $resultat = false;
        }
        return $resultat;
    }
    public static function check_modo($referer=''){
        user::session();
        user::check_login($referer);
        if(isset($_SESSION['acl']) and ($_SESSION['acl']==5 or $_SESSION['acl']==10)){
            $resultat = true;
        } else {
            $resultat = false;
        }
        return $resultat;
    }
    public static function logout()
    // forcer la deconnexion
    {
        user::session();
        session_destroy();
        header('Location: auth.php');
        exit();
    }
    public static function session(){
        if(!isset($_SESSION)){
           session_start();
        }
    }
}

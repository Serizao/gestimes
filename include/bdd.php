 <?php

 if (file_exists('config/config.php')){
   include_once 'config/config.php'; 
 }
 if (file_exists('../config/config.php')){
    include_once '../config/config.php';
 }       
       
            
/**
 * Created by Joe of ExchangeCore.com
 */
class ad
{
    public function __construct()
    {
        $this->_host   = HOST_LDAP;
        $this->_domain = DOMAIN_LDAP;
        $this->_dn     = DN_LDAP;
        $this->_ldap   = ldap_connect($this->_host);
    }
    public function connect($user, $password)
    {
        $ldaprdn = $this->_domain . "\\" . $user;
        ldap_set_option($this->_ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($this->_ldap, LDAP_OPT_REFERRALS, 0);
        $bind = @ldap_bind($this->_ldap, $ldaprdn, $password);
        return $bind;
    }
    public function login($user, $password)
    {
        $bind = $this->connect($user, $password);
        if ($bind) {
            return 1;
        } else {
            return 0;
        }
    }
    public function get_info($user, $password, $searchuser = false)
    {
        $bind = $this->connect($user, $password);
        if ($bind) {
            if ($searchuser != false) {
                $u = $searchuser;
            } else {
                $u = $user;
            }
            $filter = "(sAMAccountName=$u)";
            $result = ldap_search($this->_ldap, $this->_dn, $filter);
            ldap_sort($this->_ldap, $result, "sn");
            $info = ldap_get_entries($this->_ldap, $result);
            @ldap_close($this->_ldap);
            return $info;
        } else {
            $msg = "Invalid email address / password";
            echo $msg;
        }
    }
    public function get_group_user($user, $password, $group)
    {
        $bind = $this->connect($user, $password);
        if ($bind) {
            $filter = "(&(objectCategory=person)(OU=$group))";
            $result = ldap_search($this->_ldap, $this->_dn, $filter);
            ldap_sort($this->_ldap, $result, "sn");
            $info = ldap_get_entries($this->_ldap, $result);
            @ldap_close($this->_ldap);
            return $info;
        } else {
            $msg = "Invalid email address / password";
            echo $msg;
        }
    }
    public function get_all_user($user, $password)
    {
        $bind = $this->connect($user, $password);
        if ($bind) {
            $search_filter = '(&(objectCategory=person)(samaccountname=*))';
            $attributes    = array();
            $attributes[]  = 'givenname';
            $attributes[]  = 'mail';
            $attributes[]  = 'samaccountname';
            $attributes[]  = 'sn';
            $result        = ldap_search($this->_ldap, $this->_dn, $search_filter, $attributes);
            if (FALSE !== $result) {
                $entries  = ldap_get_entries($this->_ldap, $result);
                $compteur = -1;
                for ($x = 0; $x < $entries['count']; $x++) {
                    if (!empty($entries[$x]['givenname'][0]) && !empty($entries[$x]['mail'][0]) && !empty($entries[$x]['samaccountname'][0]) && !empty($entries[$x]['sn'][0]) && 'Shop' !== $entries[$x]['sn'][0] && 'Account' !== $entries[$x]['sn'][0]) {
                        $compteur++;
                        $ad_users[$compteur] = array(
                            'email' => strtolower(trim($entries[$x]['mail'][0])),
                            'first_name' => trim($entries[$x]['givenname'][0]),
                            'last_name' => trim($entries[$x]['sn'][0]),
                            'samaccountname' => strtolower(trim($entries[$x]['samaccountname'][0]))
                        );
                        
                    }
                }
            }
            return $ad_users;
        } else {
            $msg = "Invalid email address / password";
            echo $msg;
        }
    }
}
class bdd
  {
    public function __construct() //connection a la base de donnée dans la classe
    {
        $this->_data=array();
        $this->_cache=array();
        $this->_result=array();
        $this->_pdo = new PDO('mysql:host='.HOST_BDD.';dbname='.BASE_BDD,USER_BDD,PASS_BDD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    }
    public function cache($requete,$data){
        $this->_cache[]=$requete;
        $this->_data[]=$data;
    }
    public function exec()
    {
        $number_req = count($this->_cache);
        for($r=0;$r<$number_req;$r++)
        {   
            $exclude_fetch = array('update', 'delete','insert');
            $req=explode(" ",$this->_cache[$r]);
            $i=0;
            if(isset($this->_data[$r]) and !empty($this->_data[$r]) and $this->_data[$r]!='')
            {
                $stmt = $this->_pdo->prepare($this->_cache[$r]);
                $taille=count($this->_data[$r]);
                for($s=0;$s<$taille;$s++)
                {
                    $i++;
                    $stmt->bindParam($i, $this->_data[$r][$s], PDO::PARAM_STR);
                }
                try {
                    $stmt->execute();
                } catch (PDOException $e) {
                    echo 'Echec de la connexion : ' . $e->getMessage();
                    exit;
                }
                if(isset($req[0]) and !in_array(strtolower($req[0]), $exclude_fetch)){ //on verifie que la requete ne commence pas pas update delete etc...
                    $result[$r]=$stmt->fetchAll(); 
                } else {
                    $result= 'ok';
                }
                $this->_result=$result;
            }else{
                $stmt = $this->_pdo->prepare($this->_cache[$r]);
                $stmt->execute();
                if ($number_req>1){
                    $result[$r]=$stmt->fetchAll();
                } else {
                    if(isset($req[0]) and !in_array(strtolower($req[0]), $exclude_fetch)){ //on verifie que la requete ne commence pas pas update delete etc...
                    $result=$stmt->fetchAll();
                    } else {
                        $result= 'ok';
                    }
                } 
                $this->_result=$result;
            }
        }
        $result=$this->_result;
        $this->clear_cache();
        return $result;
    }
    public function clear_cache(){
        unset($this->_cache);
        unset($this->_result);
        unset($this->_data);
    }
    public function lastid()
    {
        return $this->_pdo->lastInsertId();
    }
    public function countcol($i)
    {
        return $i->columnCount();
    }
    public function countrow($i)
    {
        return $i->rowCount();
    }
    
    
}
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
        if(isset($var[0][0]['nb']) and $var[0][0]['nb']!=''){
            setcookie ("username", $_POST['username'], time() + 432000);
            $_SESSION['id']=$var[0][0]['nb'];
            $_SESSION['acl']=$var[0][0]['acl'];
            $_SESSION['userid']=$var[0][0]['nb'];
            $_SESSION['uid'] = sha1(uniqid('',true).'_'.mt_rand()); // générer un numero unique different du php id                                                               // which can be used to hmac forms and form token (to prevent XSRF)
            $_SESSION['ip']=$this->ip();                // stockage de l'ip deu visiteur
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
    public static function check_login(){
        user::session();
        // si la session n'existe pas ou qu l'ip a changer -> logout
        if (!isset ($_SESSION['uid']) || !$_SESSION['uid'] || $_SESSION['ip']!=user::ip() || time()>=$_SESSION['expires_on'])
        {
            user::logout();
        }
        $_SESSION['expires_on']=time()+INACTIVITY_TIMEOUT;  // mise a jour de la dte d'expiration
    }
    public static function check_admin(){
        user::session();
        user::check_login();
        if(isset($_SESSION['acl']) and $_SESSION['acl']==10){
            return true;
        } else {
            return false;
        }
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

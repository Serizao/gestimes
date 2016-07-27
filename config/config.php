<?php
if (!defined('BASE_BDD')){
    //bdd
    define('BASE_BDD','time');
    define('USER_BDD','');
    define('PASS_BDD','');
    define('HOST_BDD','127.0.0.1');
    //session
    define('INACTIVITY_TIMEOUT',900);
    //ldap
    define('HOST_LDAP','');
    define('DOMAIN_LDAP','exemple.local');
    define('DN_LDAP','dc=exemple,dc=local');
    // enable bug hunter
    define('BUG_HUNTER', true);
     //temps du refresh de la page en ms
    define('REFRESH_TIME', 960000);
}



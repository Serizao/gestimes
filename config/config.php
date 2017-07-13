<?php
if (!defined('BASE_BDD')){
    //bdd
    define('BASE_BDD','bdd');
    define('USER_BDD','bdd-user');
    define('PASS_BDD','bdd-password');
    define('HOST_BDD','bdd-host');
    //session
    define('INACTIVITY_TIMEOUT',900);
    //ldap
    define('HOST_LDAP','AD-IP');
    define('DOMAIN_LDAP','TKI');
    define('DN_LDAP','dc=exemple,dc=lan');
    // enable bug hunter
    define('BUG_HUNTER', true);
    //enable or disable auth by HTTP_HEADER
    define('HTTP_HEADER',false);
    //enble or disable cas auth
     define('CAS_STATUS',true);
     define('CAS_HOST','url-CA-srv');
      define('CAS_DIR','/cas/');
     //temps du refresh de la page en ms
    define('REFRESH_TIME', 960000);
}

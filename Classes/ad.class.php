<?php 
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
<?php
include_once('bdd.php');
user::session();
include_once('function.php');
include_once('admin-function.php');
date_default_timezone_set('Europe/Paris');
if(isset($_REQUEST['action']))$action=$_REQUEST['action'];
else $action="";
switch($action){
	case "arriver":
		add_mouvement($_SESSION['userid'],'e',date('Y-m-d H:i:s'),$_REQUEST['url']);
		break;
	case "sortir":
		add_mouvement($_SESSION['userid'],'s',date('Y-m-d H:i:s'),$_REQUEST['url']);
		break;
	case "edittime":
		add_mouvement($_SESSION['userid'], $_REQUEST['sens'], $_REQUEST['date'], $_REQUEST['url']);
		break;
	case"disconnect":
		session_destroy();
  		header('location: ../auth.php');
  		break;
	case "adduser":
		add_user($_REQUEST['nom'], $_REQUEST['prenom'], $_REQUEST['password'], $_REQUEST['acl'], $_REQUEST['mail'], $_REQUEST['hour'], $_REQUEST['begin'],$_REQUEST['nbconge']);
		break;
	case "deluser":
		delete_user($_REQUEST['id']);
		break;
	case "updateuser":
		update_user($_REQUEST['nom'], $_REQUEST['prenom'], $_REQUEST['password'], $_REQUEST['acl'], $_REQUEST['mail'], $_REQUEST['hour'], $_REQUEST['id'], $_REQUEST['begin'],$_REQUEST['nbconge']);
		break;
	case "delcat":
		delete_cat($_REQUEST['id']);
		break;
	case "addcat":
		add_cat($_REQUEST['cat'],$_REQUEST['catdom']);
		break;
	case "renamecat":
		rename_cat($_REQUEST['id'],$_REQUEST['nom'],$_REQUEST['catdom'],$_REQUEST['cir']);
		break;
	case "deldom":
		delete_dom($_REQUEST['id']);
		break;
	case "adddom":
		add_dom($_REQUEST['dom']);
		break;
	case "renamedom":
		rename_dom($_REQUEST['id'],$_REQUEST['nom']);
		break;
	case "categorize":
		cat_hour($_REQUEST['date'],$_REQUEST['cathour'],$_REQUEST['nb'],$_REQUEST['url'],$_REQUEST['comment']);
		break;
	case "gethour":
		count_hour($_REQUEST['date'], '0');
		break;
	case "gethour2":
		count_hour($_REQUEST['date'], '3');
		break;
	case "delcontrat":
		delcontrat($_REQUEST['id']);
		break;
	case "updatecontrat":
		$array=array($_REQUEST['nom'],$_REQUEST['pourcent'],$_REQUEST['conge'],$_REQUEST['id']);
		updatecontrat($array);
		break;
	case "addcontrat":
		$array=array($_REQUEST['nom'],$_REQUEST['pourcent'],$_REQUEST['conge']);
		addcontrat($array);
		break;
	case "modifmotif":
		modifmotif($_REQUEST['nom'],$_REQUEST['type'],$_REQUEST['id']);
		break;
	case "addmotif":
		addmotif($_REQUEST['nom'],$_REQUEST['type']);
		break;
	case "delmotif":
		delmotif($_REQUEST['id']);
		break;
	case "addconge":
		addconge($_REQUEST['type'],$_SESSION['userid'],$_REQUEST['begin'],$_REQUEST['end'],$_REQUEST['jbegin'],$_REQUEST['jend']);
		break;
	case "delconge":
		delconge($_REQUEST['id'],$_SESSION['userid']);
		break;
	case "admconge":
		admconge($_REQUEST['id'],$_REQUEST['state']);
		break;
	case "credit_conge":
		credit_conge();
		break;
	case "transfere":
		transfere($_REQUEST['date'],$_REQUEST['id'],'10');
		break;
		case "transferehuser":
		transfere($_REQUEST['date'],$_SESSION['userid'],'1');
		break;
	case "valid_transf":
		transfere_v($_REQUEST['id'],$_REQUEST['date'],$_REQUEST['user'],$_REQUEST['time'],$_REQUEST['vers'],$_REQUEST['de']);
		break;
	case "valid_transf_user":
		transfere_v($_REQUEST['id'],$_REQUEST['date'],$_SESSION['userid'],$_REQUEST['time'],$_REQUEST['vers'],$_REQUEST['de']);
		break;
	case "del_mouv":
	    del_mouvement($_REQUEST['id'],$_SESSION['userid'],$_REQUEST['url']);
	    break;
	case "timeline":
	    gentimeline($_REQUEST['id']);
	  break;
	}
?>
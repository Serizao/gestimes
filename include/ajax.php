<?php

if(isset($_REQUEST['action']))$action=$_REQUEST['action'];
else $action="";

switch($action){
	case "arriver":
		arriver();
		break;
	case "sortir":
		partir();
		break;
}
?>
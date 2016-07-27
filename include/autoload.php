<?php
 if (file_exists('config/config.php')){
   include_once 'config/config.php'; 
 }
 if (file_exists('../config/config.php')){
    include_once '../config/config.php';
 }       
function chargerClasse($classe)
{
    if(file_exists('./Classes/'.$classe . '.class.php')){ //suivant d'ou la classe est appeler 
        require './Classes/'.$classe . '.class.php';
    }
    if(file_exists('../Classes/'.$classe . '.class.php')){
        require '../Classes/'.$classe . '.class.php'; 
    }
}
spl_autoload_register('chargerClasse');

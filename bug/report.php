<?php

$comment = isset($_REQUEST['comment']) ? $_REQUEST['comment'] : ''; 
$screenshot =  isset($_REQUEST['screenshot']) ? $_REQUEST['screenshot'] : false;

/* convert screen shot to tmp file in current folder */
$name=time().'_'.rand(0,30);
if($screenshot) $screenshot = base64_to_jpg($screenshot, 'screen/'.$name.'.jpg');
if($comment) $comment = string_to_file($comment, 'txt/'.$name.'.txt');



/*
*
* Since you have a lot of options for mail, and you're better off not using mail() 
* it will be up to you on how you want to send this e-mail, I use laravel, if not I use phpmailer directly - so attaching files is easy.
*
* $comment = what was typed
* $screenshot = the tmp file created for the screen shot.
* 
* Be sure to unlink the screenshot after you send it.
*
*/



echo json_encode(array('result' => 'success'));

/* comment out if you want to see the file */
//if($screenshot) unlink($screenshot);


/* function to conver base64 to jpg image */
function base64_to_jpg($string, $file) {
  $fp = fopen($file, "wb"); 
  $data = explode(',', $string);
  fwrite($fp, base64_decode($data[1])); 
  fclose($fp); 
  return $file; 
}
function string_to_file($string,$file) {
  $fp = fopen($file, "wb"); 
  fwrite($fp, $string); 
  fclose($fp); 
  return $file; 
}
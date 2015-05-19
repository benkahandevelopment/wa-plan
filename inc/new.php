<?php

//Start the session
session_start();


//Process and sort the data
$data = '';

//Show data in console / add data to session (debug)
#print_r($data); $_SESSION['plan'] = $data;

//Check if session code exists and, if not, generate one
$code = fiveString();

// save data to that code
file_put_contents('../sessions/'.$code.'.txt',$data);
$_SESSION['code']=$code;

exit('success');


/**
 * @param $a
 * @param $b
 * @return int
 */
function sortThis($a,$b){
    return strcmp($a[1],$b[1]);
}

/**
 * @return string
 */
function fiveString(){
    return substr(md5(microtime()),rand(0,26),5);
}
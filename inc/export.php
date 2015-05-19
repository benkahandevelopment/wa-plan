<?php

//Process and sort the data
$data = json_decode(stripslashes($_POST['data']));
usort($data,'sortThis');
exit(serialize($data));

/**
 * @param $a
 * @param $b
 * @return int
 */
function sortThis($a,$b){
    return strcmp($a[1],$b[1]);
}
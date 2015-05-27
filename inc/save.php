<?php


//Start the session
session_start();

//Process and sort the data
$data = json_decode(stripslashes($_POST['data']));

usort($data,function($a, $b){
	
	//$a[0] = name
	//$a[1] = instruction
	//$a[2] = day
	//$a[3] = month
	//$a[4] = hour ("AM"/"PM")
	
	//get today's day, month and hour
	$day = intval(date('j'));
	$mon = intval(date('n'));
	$hou = intval(date('G'));	
	
	$c = 0;
	$d = 0;
	
	//test if today
	if($a[2]==$b[2]&&$a[3]==$b[3]&&$a[2]==$day&&$a[3]==$mon){
		//test if right now
		$ah = ((($hou>=12&&$a[4]=='PM')||($hou<12&&$a[4]=='AM')||$a[4]=='') ? true : false);
		$bh = ((($hou>=12&&$b[4]=='PM')||($hou<12&&$b[4]=='AM')||$b[4]=='') ? true : false);
		//if both right now
		if($ah&&$bh){
			//if both have instructions
			if(!empty($a[1])&&!empty($b[1])&&$a[1]!=$b[1]){
				return strcasecmp($a[1],$b[1]);
			} elseif(!empty($a[1])&&!empty($b[1])&&$a[1]==$b[1]){
				return strcasecmp($a[0],$b[0]);
			} elseif(empty($a[1])&&empty($b[1])){
				return strcasecmp($a[0],$b[0]);
			} else {
				if(empty($a[1])&&!empty($b[1])) return -1;
				if(!empty($a[1])&&empty($b[1])) return 1;
			}
		} elseif($ah&&!$bh){
			return -1;
		} elseif(!$ah&&$bh) { 
			return 1;
		} else {
			//then sort by instruction
			if(!empty($a[1])&&!empty($b[1])&&$a[1]!=$b[1]){
				//if they both have different instructions, compare inst string
				return strcasecmp($a[1],$b[1]);
			} else {
				if(empty($a[1])||empty($b[1])){
					//if one of them doesn't have instruction, place it higher
					return empty($a[1]) ? -1 : 1;
				} else {
					//if they have same instructions, compare name string
					return strcasecmp($a[0],$b[0]);
				}
			}
		}
	}
	
	if(!empty($a[2])&&!empty($a[3])){
		if($a[2]==$day&&$a[3]==$mon){
			return -1;
		}
	}
	
	if(!empty($b[2])&&!empty($b[3])){
		if($b[2]==$day&&$b[3]==$mon){
			return 1;
		}
	}
	
	//then sort by date
	if(!empty($a[2])&&!empty($a[3])&&!empty($b[2])&&!empty($b[3])){
		//if both dates are set
		if($a[3]!=$b[3]){
			//if they're not the same month and a>b
			return (intval($a[3])>intval($b[3])) ? -1 : 1;
		} else {
			if($a[2]!=$b[2]){
				//if they're the same month and not the same day and a>b
				return (intval($a[2])>intval($b[2])) ? -1 : 1;
			}
		}
	} else {
		//if one date is set
		if((!empty($a[2])&&!empty($a[3]))||(!empty($b[2])&&!empty($b[3]))){
			//if a is set
			return !empty($a[2])&&!empty($a[3]) ? -1 : 1;
		}
	}
	
	//then sort by instruction/name
	if(!empty($a[1])&&!empty($b[1])&&$a[1]!=$b[1]){
		//if they both have different instructions, compare inst string
		return strcasecmp($a[1],$b[1]);
	} elseif(!empty($a[1])&&!empty($b[1])&&$a[1]==$b[1]){
		//they both have the same instruction
		return strcasecmp($a[0],$b[0]);
	} elseif(empty($a[1])&&empty($b[1])){
		return strcasecmp($a[0],$b[0]);
	} else {
		return (empty($a[1]) ? -1 : 1);
	}
});

//Show data in console / add data to session (debug)
#print_r($data); $_SESSION['plan'] = $data;

//Check if session code exists and, if not, generate one
(isset($_SESSION['code'])) ? $code = $_SESSION['code'] : $code = fiveString();

// save data to that code
file_put_contents('../sessions/'.$code.'.txt',serialize($data));
$_SESSION['code']=$code;

exit();


function sortThis($a,$b){
    return strcasecmp($a[1],$b[1]);
}

function fiveString(){
    return substr(md5(microtime()),rand(0,26),5);
}
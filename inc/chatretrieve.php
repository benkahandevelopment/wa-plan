<?php

session_start();

$cont = file_get_contents('../sessions/chats/log_'.$_SESSION['chatCode'].'.txt');

$content = '';

$lines = explode(PHP_EOL,$cont);


if(isset($_POST['num'])&&$_POST['num']>=count($lines)) exit();

foreach($lines as $line){
	$data = unserialize($line);
	
	$time = (strtotime($data['time'])===FALSE ? time_elapsed_string(gmdate('Y-m-d\TH:i:s\Z',$data['time'])) : time_elapsed_string($data['time']));

	if($data['author']!=''&&$data['time']!=''){
		$content.='<div class="msgln">';
			$content.='<div class="meta">';
				$content.='<span class="name">'.($data['author']==$_SESSION['code'] ? 'you' : $data['author'] ).'</span>';
				$content.='<span class="time">'.$time.'</span>';
			$content.='</div>';
			$content.='<div class="msg">'.links(emoticons(formatting(stripslashes(htmlspecialchars($data['message']))))).'</div>';
		$content.='</div>';
	}
}

exit($content);

function emoticons($message){
	$icons = array(
		':)' => '<span class="emoticon emoticon-smile"></span>',
		':p' => '<span class="emoticon emoticon-tongue"></span>',
		':(' => '<span class="emoticon emoticon-sad"></span>',
		';)' => '<span class="emoticon emoticon-wink"></span>',
		':D' => '<span class="emoticon emoticon-grin"></span>',
		'8)' => '<span class="emoticon emoticon-cool"></span>',
		'(Y)'=> '<span class="emoticon emoticon-like"></span>'
	);
	
	$message = ' '.$message.' ';
	
	foreach($icons as $search => $replace){
		$message = str_replace(' '.$search.' ', ' '.$replace.' ', $message);
	}
	
	return trim($message);
}

function links($message){
	$text = preg_replace('#((https?|ftp)://(\S*?\.\S*?))([\s)\[\]{},;"\':<]|\.\s|$)#i', '<a href="$1" target="_blank">$1</a>', $message);
	$text = preg_replace('/\_blank">(.*\.(jpg|png|jpeg|gif))\<\/a\>/i','_blank"><img src="$1"></a>',$text);
	return($text);
}

function formatting($message){
	$text = preg_replace('#\*{2}(.*)\*{2}#i','<strong>$1</strong>',$message);
	$text = preg_replace('#\_{2}(.*)\_{2}#i','<em>$1</em>',$text);
	return($text);
}

function time_elapsed_string($datetime, $full = false) {
	$now = new DateTime;
	$ago = new DateTime($datetime);
	$diff = $now->diff($ago);

	$diff->w = floor($diff->d / 7);
	$diff->d -= $diff->w * 7;

	$string = array(
		'y' => 'year',
		'm' => 'month',
		'w' => 'week',
		'd' => 'day',
		'h' => 'hour',
		'i' => 'minute',
		's' => 'second',
	);
	foreach ($string as $k => &$v) {
		if ($diff->$k) {
			$v = ($k!='s' ? $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '') : 'moments');
		} else {
			unset($string[$k]);
		}
	}

	if (!$full) $string = array_slice($string, 0, 1);
	return $string ? implode(', ', $string) . ' ago' : 'just now';
}
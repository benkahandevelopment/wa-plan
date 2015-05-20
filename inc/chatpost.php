<?
session_start();
if(isset($_POST['code'])){
	if(isset($_POST['name'])){
		$text = $_POST['text'];
		$name = $_SESSION['code'];
		$code = $_POST['code'];
		
		if(trim($_POST['text'])!=''){
			$fp = fopen("../sessions/chats/log_".$code.".html", 'a');
		
			$content = '<div class="msgln">';
				$content.='<div class="meta">';
					$content.='<span class="name">'.$name.'</span>';
					$content.='<span class="time">'.date("H:i:s").'</span>';
				$content.='</div>';
				$content.='<div class="msg">'.stripslashes(htmlspecialchars($text)).'</div>';
			$content.='</div>';
			
			fwrite($fp, $content);
			fclose($fp);
		}
	} else {
		$_SESSION['chatCode'] = $_POST['code'];
		$fp = fopen("../sessions/chats/log_".$_SESSION['chatCode'].".html", 'a');
		fclose($fp);
		exit('New chat code: '.$_SESSION['chatCode']);
	}
    
}
?>
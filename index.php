<?php

/*
 * WA-Plan 1.2
 *
 * Created by Ben Kahan,
 * copyright(C) 2015
 * 
 *
 * Changelog 1.2:
 * ------------------------------------
 * - Streamlining of LiveSearch
 * - Added "AM"/"PM" differentiation
 * - More advanced sorting, taking 
 *   into account AM/PM and current
 *   time
 *
 *	 Turn on debug mode
 */	 $debug = true;
/*
 *	 Root location
 */	 $root = 'http://www.bkdev.co.uk/beta/tap/plan/';
/*
 *	 Page title
 */	 $title = 'Plan v1.2';
/*
 *	 Page subtitle
 */	 $subtitle = 'The future of 5-6pm';
/*
 ***************************************************/
 
 session_start();

if($debug){
	error_reporting(-1);
	ini_set("display_errors", "1");
	ini_set("log_errors", 1);
	ini_set("error_log", "tmp/php-error.log");
}

if(isset($_GET['code'])&&$_GET['code']=='new'){
    $_SESSION['code']= substr(md5(microtime()),rand(0,26),5);
    header('location: '.$root.'code/'.$_SESSION['code']);
    exit();
}

if(isset($_SESSION['code'])&&!isset($_GET['code'])) {
    header('location: '.$root.'code/'.$_SESSION['code']);
    exit();
}

if(!isset($_SESSION['code'])&&isset($_GET['code'])){
    $_SESSION['code'] = $_GET['code'];
    echo '<script type="text/javascript">window.location.reload();</script>';
    exit();
}

if(isset($_SESSION['code'])&&isset($_GET['code'])&&$_SESSION['code']!=$_GET['code']){
    $_SESSION['code'] = $_GET['code'];
    header('location: '.$root.'code/'.$_SESSION['code']);
    exit();
}

if(!isset($_SESSION['code'])&&!isset($_GET['code'])){
    $_SESSION['code']=substr(md5(microtime()),rand(0,26),5);
    header('location: '.$root.'code/'.$_SESSION['code']);
    exit();
}

include 'sec/head.php';

include 'sec/top.php';

include 'sec/commands.php';

include 'sec/meta.php';

?>

    <div class="container" id="rows">
        <div class="col-md-12 column">
        </div>
    </div>

<?php

include 'sec/modals.php';

include 'sec/footer.php';

?>
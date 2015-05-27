<?php

/**************************************
 *      -----------------------
 *      |     WA-Plan 1.4     |
 *      -----------------------
 *
 * Created by Ben Kahan,
 * copyright(C) 2015
 * 
 *
 * Changelog 1.4:
 * ------------------------------------
 *
 * - Added statistic figures,
 *   percentages and graphs to a toggle
 *   button at the top of the page
 * - Optimised saving order
 * - Chat optimisation of content
 *   retrieval
 * - Added conversion of links, images
 *   and emoticons (including sprites)
 *   to chat
 *
 *
 * TODO
 * ------------------------------------
 * 
 * - Import to add to current session
 *   (instead of override)
 * - Export to only render checked rows
 * - Statistics: Number of [btn] per 
 *   day/total, tasks per day/total
 * - Settings: change chat name, auto-
 *   save/auto-refresh
 * - View second session in separate
 *   window/section of page
 *
 *
 *  USER CONFIGURATION
 * ------------------------------------
 *
 *  Customise the app with these settings
 *
 *		Turn on Debug Mode
 */		$debug = true;
/*
 *  	Root Location
 */		$root = 'http://www.bkdev.co.uk/beta/tap/plan/';
/*  
 *  	Page Title 
 */		$title = 'Plan v1.4';
/*
 *  	Page Subtitle
 */		$subtitle = 'The future of 5-6pm';
/*
 *  	Turn on Livesearch
 */		$livesearch = true;
/*
 *  	Turn on Chatroom
 */		$chatroom = true;
/*	 
 **************************************/
 
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

include 'sec/stats.php';

include 'sec/commands.php';

include 'sec/meta.php';

?>

<a href="https://github.com/benkahandevelopment/wa-plan" target="_blank">
	<img style="position: absolute; top: 0; right: 0; border: 0;" src="https://camo.githubusercontent.com/365986a132ccd6a44c23a9169022c0b5c890c387/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f72696768745f7265645f6161303030302e706e67" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_red_aa0000.png">
</a>

    <div class="container" id="rows">
        <div class="col-md-12 column">
        </div>
    </div>
	
	

<?php

include 'sec/modals.php';

include 'sec/footer.php';

<?php

session_start();

/*
 * WA-Plan 1.1
 *
 * Created by Ben Kahan,
 * copyright(C) 2015
 *
 */
 
 //Turn on debug mode
 $debug = false;
 
 //Root location
 $root = 'http://www.example.com/plan/';
 
 /***************************************************/

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

?>

<!doctype html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <base href="<?php echo $root ?>">

    <title>Plan</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style/style.css">

    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<script src="js/sugar.js"></script>
    <script src="js/main.js"></script>


    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- tooltips -->
    <script type="text/javascript">
        $(document).ready(function(){
            formatTooltips();
        });
    </script>

    <style>
        div.row { margin-bottom:5px; }
        div#alerts {
            position:fixed;
            top:10px; left:10px; right:10px;
            z-index:99;
        }
        div#alerts div { display:none; }
    </style>

</head>

<body>

    <div id="alerts">
        <div class="alert alert-success" id="savedAlert">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            Saved
        </div>
    </div>

    <div class="container-fluid">

        <div class="jumbotron text-center">
            <h1>Plan&#8482;</h1>
            <p class="lead">The Future of 5-6pm. Session code: <?php echo $_SESSION['code']; ?></p>
        </div>

    </div>

    <div class="container" id="commands">
        <div class="col-md-12">
            <div class="row">
                <div class="btn-toolbar">
                    <div class="btn-group command-btns">
                        <button type="button" id="saveBtn" class="btn btn-default" aria-label="Save" onclick="saveAll()">
                            <span class="glyphicon glyphicon-save" aria-hidden="true"></span> Save
                        </button>
                        <button type="button" id="openBtn" class="btn btn-default" aria-label="Open" data-toggle="modal" data-target=".modal-open">
                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span> Open
                        </button>
                        <button type="button" id="importBtn" class="btn btn-default" aria-label="Import" data-toggle="modal" data-target=".modal-import">
                            <span class="glyphicon glyphicon-import" aria-hidden="true"></span> Import
                        </button>
                        <button type="button" id="exportBtn" class="btn btn-default" aria-label="Export" data-toggle="modal" data-target=".modal-export" onclick="exportCode()">
                            <span class="glyphicon glyphicon-export" aria-hidden="true"></span> Export
                        </button>
                        <button type="button" id="refreshBtn" class="btn btn-default" aria-label="Refresh" onclick="refreshAll()">
                            <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Refresh
                        </button>
                        <button type="button" id="newBtn" class="btn btn-default" aria-label="New Session" data-toggle="modal" data-target=".modal-new">
                            <span class="glyphicon glyphicon-new-window" aria-hidden="true"></span> New Session
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr/>

    <div class="container" id="meta">
        <div class="col-md-12">
            <!-- Row Creation -->
            <div class="row">
                <div class="input-group">
                    <input type="text" class="form-control" id="create-row-name" placeholder="New Task Name">
                    <div class="input-group-btn add-btn">
                        <button type="button" class="btn btn-success" onclick="createRow()">Go</button>
                    </div>
                </div>
            </div>
            <!-- Filter -->
            <div class="row">
                <div class="btn-toolbar">
                    <div class="btn-group filter-btns pull-right">
                        <button type="button" data-class="success" class="btn btn-default" data-original-title="Business Development"><span class="glyphicon glyphicon-phone-alt" aria-hidden="true"></span></button>
                        <button type="button" data-class="success" class="btn btn-default" data-original-title="Visit Booked"><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span></button>
                        <button type="button" data-class="info" class="btn btn-default" data-original-title="Sent Email"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></button>
                        <button type="button" data-class="info" class="btn btn-default" data-original-title="Call Later"><span class="glyphicon glyphicon-time" aria-hidden="true"></span></button>
                        <button type="button" data-class="warning" class="btn btn-default" data-original-title="Left Message"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
                        <button type="button" data-class="warning" class="btn btn-default" data-original-title="Reception Block/Couldn't Connect"><span class="glyphicon glyphicon-minus-sign" aria-hidden="true"></span></button>
                        <button type="button" data-class="danger" class="btn btn-default" data-original-title="Not Interested"><span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container" id="rows">
        <div class="col-md-12 column">
            <?php
            /*$data = $_SESSION['code'];
            $n = 1;
            for($i = 0; $i<count($data); $i++){
                echo '<div class="row" data-id="'.$n.'">
                    <div class="input-group">
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-default task-delete" data-toggle="modal" data-target=".modal-delete" onclick="deleteRow(1,'.$n.')">
                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                            </button>
                        </div>
                        <input type="text" class="form-control row-name" value="'.$data[$i][0].'">
                        <div class="input-group-btn task-btns">
                            <button type="button" data-class="success" class="btn btn-'.($data[$i][1]=="Business Development" ? 'success' : 'default' ).'" data-toggle="tooltip" data-original-title="Business Development" onclick="classButton($(this))"><span class="glyphicon glyphicon-phone-alt" aria-hidden="true"></span></button>
                            <button type="button" data-class="success" class="btn btn-'.($data[$i][1]=="Visit Booked" ? 'success' : 'default' ).'" data-toggle="tooltip" data-original-title="Visit Booked" onclick="classButton($(this))"><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span></button>
                            <button type="button" data-class="info" class="btn btn-'.($data[$i][1]=="Sent Email" ? 'info' : 'default' ).'" data-toggle="tooltip" data-original-title="Sent Email" onclick="classButton($(this))"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></button>
                            <button type="button" data-class="info" class="btn btn-'.($data[$i][1]=="Call Later" ? 'info' : 'default' ).'" data-toggle="tooltip" data-original-title="Call Later" onclick="classButton($(this))"><span class="glyphicon glyphicon-time" aria-hidden="true"></span></button>
                            <button type="button" data-class="warning" class="btn btn-'.($data[$i][1]=="Left Message" ? 'warning' : 'default' ).'" data-toggle="tooltip" data-original-title="Left Message" onclick="classButton($(this))"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
                            <button type="button" data-class="danger" class="btn btn-'.($data[$i][1]=="Not Interested" ? 'danger' : 'default' ).'" data-toggle="tooltip" data-original-title="Not Interested" onclick="classButton($(this))"><span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span></button>
                        </div>
                    </div>
                </div>';
                $n++;
            }*/
            ?>
        </div>
    </div>

    <!-- Modals -->
    <div class="modal fade modal-delete" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirm Delete Task</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure you wish to delete this task?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger task-delete-confirm" data-dismiss="modal" onclick="deleteRow(2,null)">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-open" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Open Session</h4>
                </div>
                <div class="modal-body">
                    <p>Type in the session code you wish to open:</p>
                    <div class="form-group">
                        <input type="text" class="form-control" id="openCode" placeholder="Code" maxlength="5">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success open-confirm" data-dismiss="modal" onclick="openCode()">Open</button>                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-import" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Import Session</h4>
                </div>
                <div class="modal-body">
                    <p>Paste the code you wish to import:</p>
                    <div class="form-group">
                        <textarea class="form-control" id="importCode" placeholder="Import Data"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success load-confirm" data-dismiss="modal" onclick="importCode()">Import</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-export" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Export Session</h4>
                </div>
                <div class="modal-body">
                    <p>Copy the following data to export:</p>
                    <div class="form-group">
                        <!--<textarea class="form-control" id="exportCode" placeholder="Export Data"></textarea>-->
                        <pre id="exportCode"></pre>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Done</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-new" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirm New Session</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure you wish to start a new session? You will lose all data from the current session.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger task-delete-confirm" data-dismiss="modal" onclick="newSession()">Yes, I'm sure</button>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="text-muted">Copyright&copy; 2015 Ben Kahan.</p>
        </div>
    </footer>

</body>

</html>

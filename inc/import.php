<?php

$data = unserialize($_POST['data']);

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
}
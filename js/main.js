/**
 * Plan v1.2 (beta)
 * 
 * Created by Ben Kahan
 * http://www.bkdev.co.uk/
 * 
 **/ 

$(document).ready(function(){
	
	if($('input#create-row-name').attr('data-livesearch')=='1'){	
		/*$('input#create-row-name').keyup(function(e){
			if($(this).val()!==''){
				liveSearch();
			} else $('div#rows>div.column>div.row').show();
		});*/
		
		var keyupTimer = -1;
		$('input#create-row-name').keyup(function(e){
			if ($(this).val()!==''){
				if(keyupTimer != -1)
					window.clearTimeout(keyupTimer);
				keyupTimer = window.setTimeout(function(){
					liveSearch();
					keyupTimer = -1;
				},200);
			} else $('div#rows>div.column>div.row').show();
		});
	}
	
    $('input#create-row-name').keypress(function(e){
        if(e.which==13){
            createRow();
        }
    });

    $('div.filter-btns>button').click(function(){
        if($(this).hasClass('btn-default')){
            //div.parent().children('button').removeClass().addClass('btn').addClass('btn-default');
            var cl = $(this).attr('data-class');
            $(this).removeClass().addClass('btn').addClass('btn-'+cl);
        } else {
            $(this).removeClass().addClass('btn').addClass('btn-default');
            $(this).parent().parent().find('input').prop('disabled',false);
        }
        filterAll();
    });

    refreshAll();
});


function classButton(div){
    if(div.hasClass('btn-default')){
        div.parent().children('button').removeClass().addClass('btn').addClass('btn-default');
        var cl = div.attr('data-class');
        div.removeClass().addClass('btn').addClass('btn-'+cl);
        if(cl=='danger'){
            div.parent().parent().find('input').prop('disabled',true);
        } else {
            div.parent().parent().find('input').prop('disabled',false);
        }
    } else {
        div.removeClass().addClass('btn').addClass('btn-default');
        div.parent().parent().find('input').prop('disabled',false);
    }

    saveAll();

}

function createRow(){
    var inp = $('#create-row-name'); //input

    var nam = inp.val(); //new name of row
    var num = $('div#rows>div.column>div').length; //number of rows
    num++; //data-id of THIS row

    var data = '<div class="row" data-id="'+num+'">';
        data+= '<div class="input-group"><div class="input-group-btn">';
        data+= '<button type="button" class="btn btn-default task-delete" data-toggle="modal" data-target=".modal-delete" onclick="deleteRow(1,'+num+')">';
        data+= '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></div>';
        data+= '<input type="text" class="form-control row-name" value="'+nam+'">';
        data+= '<div class="input-group-btn task-btns">';
        data+= '<button type="button" data-class="success" class="btn btn-default" data-toggle="tooltip" data-original-title="Business Development" onclick="classButton($(this))"><span class="glyphicon glyphicon-phone-alt" aria-hidden="true"></span></button>';
        data+= '<button type="button" data-class="success" class="btn btn-default" data-toggle="tooltip" data-original-title="Visit Booked" onclick="classButton($(this))"><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span></button>';
        data+= '<button type="button" data-class="info" class="btn btn-default" data-toggle="tooltip" data-original-title="Sent Email" onclick="classButton($(this))"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></button>';
        data+= '<button type="button" data-class="info" class="btn btn-default" data-toggle="tooltip" data-original-title="Call Later" onclick="classButton($(this))"><span class="glyphicon glyphicon-time" aria-hidden="true"></span></button>';
        data+= '<button type="button" data-class="warning" class="btn btn-default" data-toggle="tooltip" data-original-title="Left Message" onclick="classButton($(this))"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>';
        data+= '<button type="button" data-class="warning" class="btn btn-default" data-toggle="tooltip" data-original-title="Reception Block/Couldn\'t Connect" onclick="classButton($(this))"><span class="glyphicon glyphicon-minus-sign" aria-hidden="true"></span></button>';
        data+= '<button type="button" data-class="danger" class="btn btn-default" data-toggle="tooltip" data-original-title="Not Interested" onclick="classButton($(this))"><span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span></button>';
        data+= '</div>';
        data+= '</div>';
        data+= '</div>';

    $('div#rows>div.column').prepend(data); //add row
    inp.val(''); //unload input

    saveAll();
	$('div#rows>div.column>div.row').show();
}

function deleteRow(fn,id){
    if(fn===1){
        $('div.modal-delete').attr('data-id',id);
    } else if(fn===2){
        var id2 = $('div.modal-delete').attr('data-id');
        $('div.row[data-id="'+id2+'"]').remove();
    }

    formatTooltips();
}

function saveAll(){
	callBackTime();

    $('div.command-btns>button').prop('disabled',true);

    var saveData = [];
    $('div#rows>div.column>div.row').each(function(){
		var day = $(this).attr('data-date-day');
		var mon = $(this).attr('data-date-month');
		var hou = $(this).attr('data-date-hour');
        var name = $(this).find('div.input-group>input').val();
        var inst = $(this).find('div.input-group>div.task-btns>button:not(.btn-default)').attr('data-original-title');
        var thisData = [name,inst,day,mon,hou];
        saveData.push(thisData);
    });

    var jsonSaveData = JSON.stringify(saveData);

    $.ajax({
        url: './inc/save.php',
        type: 'POST',
        data: {data:jsonSaveData},
        success: function(data, textStatus,jqXHR){
            $('div.command-btns>button').prop('disabled',false);
            formatTooltips();
			//console.log(data);
            showAlert('saved');
			if($('button#autoRefreshBtn').attr('data-checked')=='1')
				refreshAll();
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log(errorThrown);
        }
    });
}

function refreshAll(){
    $('div.command-btns>button').prop('disabled',true).parent().find('#refreshBtn>span').addClass('gly-spin');
    var div = $('div#rows>div.column');

    div.html('');

    $.ajax({
        url: './inc/refresh.php',
        type: 'POST',
        success: function(data, textStatus, jgXHR){
            div.html(data);
            $('div.command-btns>button').prop('disabled',false).parent().find('#refreshBtn>span').removeClass('gly-spin');
            formatTooltips();
			callBackTime();
        }
    });
}

function callBackTime(){
    $('div#rows>div.column>div.row>div.input-group>input.row-name').each(function(){
		$(this).parent().find('div.input-group-btn>button.button-time').remove();
		var day = 0;
		var mon = 0;
		var hou = '';
		var isDate = false;
		
        var searchResult = $(this).val().toString();
        if(searchResult.indexOf('/')>=0){
            var words = searchResult.split(' ');
            $(words).each(function (index, word){
				if (word.indexOf('/') >=0 ){
					var dayMon = word.split('/');
					day = dayMon[0];
					mon = dayMon[1];
					hou = (typeof dayMon[2]!== 'undefined' ? dayMon[2] : false);

					isDate = ($.isNumeric(day)&&$.isNumeric(mon) ? true : false);
				}
			});
        } else {
			$(this).parent().parent().removeAttr('data-date-month').removeAttr('data-date-day').removeAttr('data-date-hour');
		}
		
		if(isDate){
			var d = new Date();
			var tmon = d.getMonth()+1;
			var tday = d.getDate();
			var thou = d.getHours();

			shou = ((hou=='PM'&&thou>=12)||(hou=='AM'&&thou<12)||!hou) ? true : false;
			var clas = (tday==day&&tmon==mon&&shou) ? 'disabled btn-success' : 'disabled btn-default';
			
			var data = '<button type="button" class="btn button-time '+clas+'">'+day+'/'+mon+'</button>';
			$(this).parent().parent().attr('data-date-month',mon).attr('data-date-day',day);
			if(hou!==false) $(this).parent().parent().attr('data-date-hour',hou);
			var output = $(this).parent().find('div.input-group-btn>button.task-delete');
			output.after(data);
		}
    })
}

function formatTooltips(){
    $('[data-toggle="tooltip"]').tooltip({
        placement : 'top'
    });
}

function openCode(){
    var code = $('input#openCode').val();
    window.location.href = 'code/'+code;
}

function importCode(){
    var data = $('textarea#importCode').val();

    var div = $('div#rows>div.column');

    $.ajax({
        url: './inc/import.php',
        type: 'POST',
        data: {data: data},
        success: function(data, textStatus,jqXHR){
            div.html(data);
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log(errorThrown);
        }
    });
}

function exportCode(){

    var textarea = $('#exportCode');

    var saveData = [];
    $('div#rows>div.column>div.row').each(function(){
		var day = $(this).attr('data-date-day');
		var mon = $(this).attr('data-date-month');
        var name = $(this).find('div.input-group>input').val();
        var inst = $(this).find('div.input-group>div.task-btns>button:not(.btn-default)').attr('data-original-title');
        var thisData = [name,inst,day,mon];
        saveData.push(thisData);
    });

    var jsonSaveData = JSON.stringify(saveData);

    $.ajax({
        url: './inc/export.php',
        type: 'POST',
        data: {data:jsonSaveData},
        success: function(data, textStatus,jqXHR){
            textarea.html(data);
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log(errorThrown);
        }
    });
}

function showAlert(message) {
    if(message=='saved'){
        $('div#savedAlert').stop().fadeIn(1).fadeOut(1500);
    }
}

function liveSearch(){
    var searchTerm = $('input#create-row-name').val().toString().toLowerCase();
    $('div#rows>div.column>div.row').each(function(){
        var searchResult = $(this).find('div.input-group>input.row-name').val().toString().toLowerCase();
        if(searchResult.indexOf(searchTerm)>=0){
            $(this).show();
        } else $(this).hide();
    })
}

function newSession(){
    window.location.href = "http://www.bkdev.co.uk/beta/tap/plan/code/new";
}

function filterAll(){
    var filters = [];
    var rows = [];
    var divs = $('div#rows>div.column>div.row');
    divs.show();
    $('div.filter-btns>button').each(function(){
        if(!$(this).hasClass('btn-default')){
            filters.push($(this).attr('data-original-title'));
        }
    });
    if(filters.length>0){
        divs.each(function(){
            var rowID = $(this).attr('data-id');
            $(this).find('div.input-group>div.input-group-btn>button').each(function(){
                if(!$(this).hasClass('btn-default')){
                    var thisFilter = $(this).attr('data-original-title');
                    if(jQuery.inArray(thisFilter,filters)!==-1){
                        rows.push(rowID);
                    }
                }
            });
        });
        divs.each(function(){
            var rowID = $(this).attr('data-id');
            if(jQuery.inArray(rowID,rows)==-1){
                $(this).hide();
            }
        })
    }
}

function autoRefresh(){
	var btn = $('button#autoRefreshBtn');
	btn.attr('data-checked')=='1'
			? btn.attr('data-checked','0').find('span').removeClass('glyphicon-check').addClass('glyphicon-unchecked')
			: btn.attr('data-checked','1').find('span').removeClass('glyphicon-unchecked').addClass('glyphicon-check');
}
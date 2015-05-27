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
	
	calculateStats();
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
			calculateStats();
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
					hou = (typeof dayMon[2]!== 'undefined' ? dayMon[2].toUpperCase() : false);

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
	
	$('[data-toggle="tooltip_below"]').tooltip({
		placement : 'right'
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

function calculateStats(){
	//tasks-t, tasks-y, tasks-a : tasks #, % over yesterday/average
	//bd-t, bd-y, bd-a : business dev #, % over yesterday/average
	//bd>vb>em>cb>lm>rb>ni% today/yesterday/all-time tasks
	
	var d = new Date();
	var tmon = d.getMonth()+1;
	var tday = d.getDate();
	
	ymon = tmon;
	
	if(tday-1==0){
		tmon-1==0 ? ymon=12 : ymon=tmon-1;
		if(ymon==1||ymon==3||ymon==5||ymon==7||ymon==8||ymon==10||ymon==12) yday=31;
		if(ymon==4||ymon==6||ymon==9||ymon==11)	yday=30;
		if(ymon==2) yday=28;
	} else yday=tday-1;
	
	//Tasks	
	var tasks_t = $('div.row[data-date-month="'+tmon+'"][data-date-day="'+tday+'"]').length;
	var tasks_y = $('div.row[data-date-month="'+ymon+'"][data-date-day="'+yday+'"]').length;
	var tasks_a = $('div#rows>div.column>div.row').length;	
	$('#stat-tasks-t').html(tasks_t);
	$('#stat-tasks-y').html(tasks_y);
	$('#stat-tasks-a').html(tasks_a);
	
	//Business Development
	var bd_t = $('div.row[data-date-month="'+tmon+'"][data-date-day="'+tday+'"]>div.input-group>div.task-btns>button[data-original-title="Business Development"]:not(.btn-default)').length+$('div.row[data-date-month="'+tmon+'"][data-date-day="'+tday+'"]>div.input-group>div.task-btns>button[data-original-title="Not Interested"]:not(.btn-default)').length;
	var bd_y = $('div.row[data-date-month="'+ymon+'"][data-date-day="'+yday+'"]>div.input-group>div.task-btns>button[data-original-title="Business Development"]:not(.btn-default)').length+$('div.row[data-date-month="'+ymon+'"][data-date-day="'+yday+'"]>div.input-group>div.task-btns>button[data-original-title="Not Interested"]:not(.btn-default)').length;
	var bd_c = Math.round((bd_t-bd_y)/bd_y*100);
	$('#stat-bd-t').html(bd_t+' ('+Math.round((bd_t/tasks_t)*100)+'%)');
	$('#stat-bd-y').html(bd_y+' ('+Math.round((bd_y/tasks_y)*100)+'%)');
	$('#stat-bd-c').html((!isNaN(bd_c) ? (bd_t-bd_y) : (bd_t-bd_y)+' ('+bd_c+'%)'));
	
	//Graphs
		//Today
		var g_t_bd = $('div.row[data-date-month="'+tmon+'"][data-date-day="'+tday+'"]>div.input-group>div.task-btns>button[data-original-title="Business Development"]:not(.btn-default)').length;
		var g_t_vb = $('div.row[data-date-month="'+tmon+'"][data-date-day="'+tday+'"]>div.input-group>div.task-btns>button[data-original-title="Visit Booked"]:not(.btn-default)').length;
		var g_t_se = $('div.row[data-date-month="'+tmon+'"][data-date-day="'+tday+'"]>div.input-group>div.task-btns>button[data-original-title="Sent Email"]:not(.btn-default)').length;
		var g_t_cl = $('div.row[data-date-month="'+tmon+'"][data-date-day="'+tday+'"]>div.input-group>div.task-btns>button[data-original-title="Call Later"]:not(.btn-default)').length;
		var g_t_lm = $('div.row[data-date-month="'+tmon+'"][data-date-day="'+tday+'"]>div.input-group>div.task-btns>button[data-original-title="Left Message"]:not(.btn-default)').length;
		var g_t_ni = $('div.row[data-date-month="'+tmon+'"][data-date-day="'+tday+'"]>div.input-group>div.task-btns>button[data-original-title="Not Interested"]:not(.btn-default)').length;
		var g_t_rb = $('div.row[data-date-month="'+tmon+'"][data-date-day="'+tday+'"]>div.input-group>div.task-btns>button[data-original-title="Reception Block/Couldn\'t Connect"]:not(.btn-default)').length;
		//As percentages
		g_t_bd_p = (g_t_bd/tasks_t*100);
		g_t_vb_p = (g_t_vb/tasks_t*100);
		g_t_se_p = (g_t_se/tasks_t*100);
		g_t_cl_p = (g_t_cl/tasks_t*100);
		g_t_lm_p = (g_t_lm/tasks_t*100);
		g_t_ni_p = (g_t_ni/tasks_t*100);
		g_t_rb_p = (g_t_rb/tasks_t*100);
		g_t_total = g_t_bd_p+g_t_vb_p+g_t_se_p+g_t_cl_p+g_t_lm_p+g_t_ni_p+g_t_rb_p;		
		
		//Output
		$('#stat-g-t>.progress>.bd').css('width',g_t_bd_p+'%');
		$('#stat-g-t>.progress>.vb').css('width',g_t_vb_p+'%');
		$('#stat-g-t>.progress>.se').css('width',g_t_se_p+'%');
		$('#stat-g-t>.progress>.cl').css('width',g_t_cl_p+'%');
		$('#stat-g-t>.progress>.lm').css('width',g_t_lm_p+'%');
		$('#stat-g-t>.progress>.ni').css('width',g_t_ni_p+'%');
		$('#stat-g-t>.progress>.rb').css('width',g_t_rb_p+'%');
		$('#stat-gl-t-bd').html((Math.round(g_t_bd_p))+'%');
		$('#stat-gl-t-vb').html((Math.round(g_t_vb_p))+'%');
		$('#stat-gl-t-se').html((Math.round(g_t_se_p))+'%');
		$('#stat-gl-t-cl').html((Math.round(g_t_cl_p))+'%');
		$('#stat-gl-t-lm').html((Math.round(g_t_lm_p))+'%');
		$('#stat-gl-t-ni').html((Math.round(g_t_ni_p))+'%');
		$('#stat-gl-t-rb').html((Math.round(g_t_rb_p))+'%');
		$('#stat-gl-t-in').html(Math.round(100-g_t_total)+'%');
		
		//Yesterday
		var g_y_bd = $('div.row[data-date-month="'+ymon+'"][data-date-day="'+yday+'"]>div.input-group>div.task-btns>button[data-original-title="Business Development"]:not(.btn-default)').length;
		var g_y_vb = $('div.row[data-date-month="'+ymon+'"][data-date-day="'+yday+'"]>div.input-group>div.task-btns>button[data-original-title="Visit Booked"]:not(.btn-default)').length;
		var g_y_se = $('div.row[data-date-month="'+ymon+'"][data-date-day="'+yday+'"]>div.input-group>div.task-btns>button[data-original-title="Sent Email"]:not(.btn-default)').length;
		var g_y_cl = $('div.row[data-date-month="'+ymon+'"][data-date-day="'+yday+'"]>div.input-group>div.task-btns>button[data-original-title="Call Later"]:not(.btn-default)').length;
		var g_y_lm = $('div.row[data-date-month="'+ymon+'"][data-date-day="'+yday+'"]>div.input-group>div.task-btns>button[data-original-title="Left Message"]:not(.btn-default)').length;
		var g_y_ni = $('div.row[data-date-month="'+ymon+'"][data-date-day="'+yday+'"]>div.input-group>div.task-btns>button[data-original-title="Not Interested"]:not(.btn-default)').length;
		var g_y_rb = $('div.row[data-date-month="'+ymon+'"][data-date-day="'+yday+'"]>div.input-group>div.task-btns>button[data-original-title="Reception Block/Couldn\'t Connect"]:not(.btn-default)').length;
		//As percentages
		g_y_bd_p =(g_y_bd/tasks_y*100);
		g_y_vb_p =(g_y_vb/tasks_y*100);
		g_y_se_p =(g_y_se/tasks_y*100);
		g_y_cl_p =(g_y_cl/tasks_y*100);
		g_y_lm_p =(g_y_lm/tasks_y*100);
		g_y_ni_p =(g_y_ni/tasks_y*100);
		g_y_rb_p =(g_y_rb/tasks_y*100);
		g_y_total = g_y_bd_p+g_y_vb_p+g_y_se_p+g_y_cl_p+g_y_lm_p+g_y_ni_p+g_y_rb_p;		
		
		//Output
		$('#stat-g-y>.progress>.bd').css('width',g_y_bd_p+'%');
		$('#stat-g-y>.progress>.vb').css('width',g_y_vb_p+'%');
		$('#stat-g-y>.progress>.se').css('width',g_y_se_p+'%');
		$('#stat-g-y>.progress>.cl').css('width',g_y_cl_p+'%');
		$('#stat-g-y>.progress>.lm').css('width',g_y_lm_p+'%');
		$('#stat-g-y>.progress>.ni').css('width',g_y_ni_p+'%');
		$('#stat-g-y>.progress>.rb').css('width',g_y_rb_p+'%');
		$('#stat-gl-y-bd').html((Math.round(g_y_bd_p))+'%');
		$('#stat-gl-y-vb').html((Math.round(g_y_vb_p))+'%');
		$('#stat-gl-y-se').html((Math.round(g_y_se_p))+'%');
		$('#stat-gl-y-cl').html((Math.round(g_y_cl_p))+'%');
		$('#stat-gl-y-lm').html((Math.round(g_y_lm_p))+'%');
		$('#stat-gl-y-ni').html((Math.round(g_y_ni_p))+'%');
		$('#stat-gl-y-rb').html((Math.round(g_y_rb_p))+'%');
		$('#stat-gl-y-in').html(Math.round(100-g_y_total)+'%');
		
		//All-Time
		var g_a_bd = $('div.row>div.input-group>div.task-btns>button[data-original-title="Business Development"]:not(.btn-default)').length;
		var g_a_vb = $('div.row>div.input-group>div.task-btns>button[data-original-title="Visit Booked"]:not(.btn-default)').length;
		var g_a_se = $('div.row>div.input-group>div.task-btns>button[data-original-title="Sent Email"]:not(.btn-default)').length;
		var g_a_cl = $('div.row>div.input-group>div.task-btns>button[data-original-title="Call Later"]:not(.btn-default)').length;
		var g_a_lm = $('div.row>div.input-group>div.task-btns>button[data-original-title="Left Message"]:not(.btn-default)').length;
		var g_a_ni = $('div.row>div.input-group>div.task-btns>button[data-original-title="Not Interested"]:not(.btn-default)').length;
		var g_a_rb = $('div.row>div.input-group>div.task-btns>button[data-original-title="Reception Block/Couldn\'t Connect"]:not(.btn-default)').length;
		//As percentages
		g_a_bd_p = (g_a_bd/tasks_a*100);
		g_a_vb_p = (g_a_vb/tasks_a*100);
		g_a_se_p = (g_a_se/tasks_a*100);
		g_a_cl_p = (g_a_cl/tasks_a*100);
		g_a_lm_p = (g_a_lm/tasks_a*100);
		g_a_ni_p = (g_a_ni/tasks_a*100);
		g_a_rb_p = (g_a_rb/tasks_a*100);
		g_a_total = g_a_bd_p+g_a_vb_p+g_a_se_p+g_a_cl_p+g_a_lm_p+g_a_ni_p+g_a_rb_p;
		//Output
		$('#stat-g-a>.progress>.bd').css('width',g_a_bd_p+'%');
		$('#stat-g-a>.progress>.vb').css('width',g_a_vb_p+'%');
		$('#stat-g-a>.progress>.se').css('width',g_a_se_p+'%');
		$('#stat-g-a>.progress>.cl').css('width',g_a_cl_p+'%');
		$('#stat-g-a>.progress>.lm').css('width',g_a_lm_p+'%');
		$('#stat-g-a>.progress>.ni').css('width',g_a_ni_p+'%');
		$('#stat-g-a>.progress>.rb').css('width',g_a_rb_p+'%');
		$('#stat-gl-a-bd').html((Math.round(g_a_bd_p))+'%');
		$('#stat-gl-a-vb').html((Math.round(g_a_vb_p))+'%');
		$('#stat-gl-a-se').html((Math.round(g_a_se_p))+'%');
		$('#stat-gl-a-cl').html((Math.round(g_a_cl_p))+'%');
		$('#stat-gl-a-lm').html((Math.round(g_a_lm_p))+'%');
		$('#stat-gl-a-ni').html((Math.round(g_a_ni_p))+'%');
		$('#stat-gl-a-rb').html((Math.round(g_a_rb_p))+'%');
		$('#stat-gl-a-in').html(Math.round(100-g_a_total)+'%');
		
		formatTooltips();
}
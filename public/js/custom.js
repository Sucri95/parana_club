
$(window).on('load', function() {

	var d = new Date();
	var year = d.getFullYear();
		
	loadProducts();

	$('#sandbox-container input').datepicker({
	  language: "es",
	  autoclose: true,
	  dateFormat: 'yy-mm-dd',
	  changeYear: true,
	  changeMonth: true,
	  yearRange: '1920:' + year + '',
	  maxDate: '-1d'
	});

	$('#sandbox-container-inicio input').datepicker({
	});

	$('#sandbox-container-fin input').datepicker({
	});

	$('#sandbox-container-show input').datepicker({
	});

	$('#show_on').datepicker({
	});




	$('#birthdate').datepicker({
		language: "es",
		autoclose: true,
		dateFormat: 'yy-mm-dd',
		changeYear: true,
		changeMonth: true,
		yearRange: '1920:' + year + '',
		maxDate: '-1d'
	});

	if($('#activity_id').length && $('#classroom_id').length){

	    var $value1 =$('option:selected', '#classroom_id').attr('type');
	    m2Salon = $value1;

	    var $value2 =$('option:selected', '#activity_id').attr('type');
	    m2Activity = $value2;

	    loadSchedulesByClassrooms();
	    loadSchedulesByTutor();


	}

	if($('#user_id').length && $("#user_id").val() == "") {
		loadUsers();
	} else if($('#user_id').length){
		loadUserInscriptions();
	}

	if ($('#tutor_id').length) {
		loadActivities();
	}

	if($('#class_id').length) {
		loadSchedules();
	}


});


var activityList = [];
localStorage.clear();
var m2Salon = 0;
var m2Activity = 0;

function loadActivities(){
	var tutor_id = $("#tutor_id").val();
	
	$.ajax({
		type: "GET",
		url: '/activities_by_tutor',
		data: { tutor_id: tutor_id },
		success: function (data) {
			for (var i = 0; i < data.length; i++) {
				changeActivity(data[i].activity_id, data[i].activity_name, data[i].percentage_gain);
			}
		},
		error: function (data) {
			alert('Error:', data);
		}
	});

}

$(document).on('change','#activities',function(){
	
	changeActivity($("#activities").val(), $("#activities option:selected").text(), $("#perc"+$("#activities").val()).val());

});


function changeActivity(activities_data, activity_name, activity_percentage_gain){

	var activityId = activities_data; 
	var found = false;
	var percentage_gain = activity_percentage_gain || '';


	if(activityId !== '')
	{
		activity = JSON.parse(localStorage.getItem('activity')) || [];
		for (var j = 0; j < activity.length; j++) {
			if(activity[j].id == activityId){
				found = true;
				break;
			} 
		}

		if(found!==true)
		{

			var data = {
				id: activityId,
				name: activity_name,
				percentage_gain: percentage_gain
			}

			activity.push(data);
			localStorage.setItem('activity', JSON.stringify(activity));
			$('#activitySelected').show();

			$('#listActivities').empty();

			var htmlApp = '';

			for (var i = 0; i < activity.length; i++) {
				htmlApp += '<input type="text" name="qty[]" value="'+activity[i].id+'" id="qty-'+i+'" style="display:none" />';
				htmlApp += ' <li class="list-group-item" id="li-cat-'+i+'">'+activity[i].name+' <a class="btn btn-xs btn-warning pull-right" onclick="removeItemActivity('+i+')"><span class="glyphicon glyphicon-trash"></span></a><input type="text" placeholder="% de ganacia" value="'+activity[i].percentage_gain+'" name="perc'+activity[i].id+'" name="perc'+activity[i].id+'" style="line-height: 1.6; color: #555555;background-color: #fff;background-image: none;border: 1px solid #ccd0d2;border-radius: 4px;width: 40%;margin-left: 30px; float: right;margin-right: 20px;" /></li><br>';
			}

			$('#listActivities').append(htmlApp);
			$('#activity').val(0);

		} else {
			$('#activities').val(0);
		}

	}

};

function removeItemActivity (id) {

	activity = JSON.parse(localStorage.getItem('activity')) || [];
	$('#li-cat-'+id).remove();
	$('#qty-'+id).remove();
	activity.splice(id,1);
	localStorage.setItem('activity', JSON.stringify(activity));
}

function changeCapacity(){
	if(m2Activity != 0 && m2Salon != 0){
		var capacity = parseInt(m2Salon, 10) / parseInt(m2Activity, 10);
		$("#capacity").val(Math.trunc(capacity));		
	}

}


$(document).on('change','#answer',function(){
	if($(this).prop('checked') == true){
		$("#div-answer").show();
	} else {
		$("#div-answer").hide();

	}
});


$(document).on('change','#all_employees',function(){
	if($(this).prop('checked') == true){
		$("#div-employee").hide();
	} else {
		$("#div-employee").show();

	}
});

$(document).on('change','#all_employees',function(){
	if($(this).prop('checked') == true){
		$("#div-employee").hide();
	} else {
		$("#div-employee").show();

	}
});

$(document).on('change','#all_days',function(){
	if($(this).prop('checked') == true){
		$("#div-date").hide();
	} else {
		$("#div-date").show();

	}
});

$(document).on('change','#all_days',function(){
	if($(this).prop('checked') == true){
		$("#div-date").hide();
	} else {
		$("#div-date").show();

	}
});

$(document).on('change','#activity_id',function(){
	
    var $value =$('option:selected',this).attr('type');
    m2Activity = $value;
    loadTutors();
    changeCapacity();
});

$(document).on('change','#classroom_id',function(){
		
    var $value =$('option:selected',this).attr('type');
    m2Salon = $value;
    changeCapacity();
    loadSchedulesByClassrooms();
});

function loadTutors(){
	
	var activity_id = $("#activity_id").val();
	$("#tutor_id").val("");

  $("#tutor_id").autocomplete({
            source: function(request, response) {
              $.getJSON("/activities_by_tutor/autocomplete", { term: request.term,  activity_id: activity_id }, 
              response);
            },
            minLength: 1,
            select: function( event, ui ) {
                $('#tutor_id').val(ui.item.value);
                $('#tutor_uid').val(ui.item.id);
                loadSchedulesByTutor();
            }
    });

};


function loadUsers(){

  $("#user_id").val("");

  $("#user_id").autocomplete({
            source: function(request, response) {
              $.getJSON("/user_inscriptions/autocomplete", { term: request.term }, 
              response);
            },
            minLength: 1,
            select: function( event, ui ) {
                $('#user_id').val(ui.item.value);
                $('#user_uid').val(ui.item.id);
                loadUserInscriptions();
            }
    });

};

function loadProducts(){

  $("#product_id").val("");

  $("#product_id").autocomplete({
            source: function(request, response) {
              $.getJSON("/product/autocomplete", { term: request.term }, 
              response);
            },
            minLength: 1,
            select: function( event, ui ) {
                $('#product_id').val(ui.item.value);
                $('#product_uid').val(ui.item.id);
                $('#product_price').val(ui.item.price);
                $("#quantity").val(1);
                $("#quantity").trigger('change');
            }
    });

};


$(document).on('click','#addSchedule',function(){

	var day = $("#days").val();
	var schedules_start = $("#schedules_start").val();
	var schedules_end  =  $("#schedules_end").val();
	var value = $("#value").val();

	if(day != 0 && schedules_end != 0 && schedules_start != 0 && value != ""){
		$("#days").val(0);
		$("#schedules_start").val(0);
		$("#schedules_end").val(0);
		$("#value").val("");

	    addSchedule(day, schedules_start, schedules_end, value);	
	} else {
		alert("Complete todos los campos.");
	}
	
});

$(document).on('click', '#addOptionsQuizzes', function(){
	var random = Math.random().toString(36).substr(2, 5);
	$("#options-input").append('<div class="input-group margin-top" id="'+random+'"><div class="input-group-addon" onclick="removeOptionAnswer(\''+random+'\')"><span class="glyphicon glyphicon-remove"></span></div><input type="text" class="form-control" name="option[]"></div>');
});

$(document).on('click', '#addSaleDetail', function (){
	$("#listDetails").empty();
	var product_name = $("#product_id").val();
	var product_uid = $("#product_uid").val();
	var product_price = $("#product_price").val();
	var quantity = $("#quantity").val();
	var subtotal = $("#sub_total").val();
	var htmlTH = '';
	var total = 0;
	$("#total").val('');


	products_sale_details = JSON.parse(localStorage.getItem('products_sale_details')) || [];
	
	var data = {
		product_name: product_name,
		product_uid: product_uid,
		product_price: product_price,
		quantity: quantity,
		sub_total: subtotal
	}

	products_sale_details.push(data);
	localStorage.setItem('products_sale_details', JSON.stringify(products_sale_details));

	for (var i = 0; i < products_sale_details.length; i++) {

		total =  parseInt(total)+ parseInt(products_sale_details[i].sub_total);

		$("#listDetails").append('<input type="text" name="psd[]" value="'+products_sale_details[i].product_uid+','+products_sale_details[i].quantity+','+products_sale_details[i].sub_total+'" id="psd-'+products_sale_details[i].product_uid+'-'+i+'" style="display:none" />')
		htmlTH += '<tr id="tr-psd-'+products_sale_details[i].product_uid+'-'+i+'"><th>'+products_sale_details[i].product_name+'</th>';
		htmlTH += '<th>'+products_sale_details[i].product_price+'</th>';
		htmlTH += '<th>'+products_sale_details[i].quantity+'</th>';
		htmlTH += '<th>'+products_sale_details[i].sub_total+'</th>';
		htmlTH += '<th><a class="btn btn-default btn-circle" onclick="removeProductDetail(\'psd-'+products_sale_details[i].product_uid+'-'+i+','+i+'\')"><i class="fa fa-times"></i></a></th><tr>';

	}

	$("#total").val(total);

	$("#tbody-list").empty().append(htmlTH);

	$("#product_id").val('');
	$("#product_uid").val('');
	$("#product_price").val('');
	$("#quantity").val('');
	$("#sub_total").val('');


});

function removeOptionAnswer(id){

	$("#"+id).remove();

}

function removeProductDetail(id,i){
	products_sale_details = JSON.parse(localStorage.getItem('products_sale_details')) || [];

	$('#'+id).remove();
	$("#tr-"+id).remove();

	products_sale_details.splice(i,1);
	localStorage.setItem('products_sale_details', JSON.stringify(products_sale_details));


}

$(document).on('click', '#addScheduleInscription', function(){
	getClassDayScheduleById();
});

function addSchedule(day, schedules_start, schedules_end, value){
	console.log("IN ADD SCEHDULE");
	var found = false;
	var htmlApp = "";
	var day = day;
	var schedules_start = schedules_start;
	var schedules_end = schedules_end;
	var value = value;
	var data_id = "d-"+day+"-s-"+schedules_start;
	console.log(data_id);
	schedules = JSON.parse(localStorage.getItem('schedules')) || [];
	schedulesOcuppatedByTutor = JSON.parse(localStorage.getItem('schedulesOcuppatedByTutor')) || [];
	schedulesOcuppatedByClassroom = JSON.parse(localStorage.getItem('schedulesOcuppatedByClassroom')) || [];
	for (var j = 0; j < schedules.length; j++) {
		if(schedules[j].day == day){
			if(schedules[j].schedules_start == schedules_start || schedules[j].schedules_end == schedules_end ) {
				found = true;
				alert("Ya existe un horario asignado. 4");
				break;
			}

			for (var k = schedules_start; k < schedules_end; k++) {
				if(k == schedules[j].schedules_start){
					found = true;
					alert("Ya existe un horario asignado. 5");
					break;	
				} else if(k > schedules[j].schedules_start && k < schedules[j].schedules_end){
					found = true;
					alert("Ya existe un horario asignado. 6");
					break;	
				}
			}

		} 
	}
	console.log(schedulesOcuppatedByTutor.length);
	for (var y = 0; y < schedulesOcuppatedByTutor.length; y++) {
		if(schedulesOcuppatedByTutor[y].day == day){
			console.log("SAME DAY");
			if(schedulesOcuppatedByTutor[y].schedules_start == schedules_start || schedulesOcuppatedByTutor[y].schedules_end == schedules_end ) {
				found = true;
				alert("Ya existe un horario asignado. 7");
				break;
			}
				console.log("DISTINTOS START AND END");
				console.log("START " + schedules_start);
				console.log("END " + schedules_end);
				console.log("START DE TUTOR " + schedulesOcuppatedByTutor[y].schedules_start );
			for (var k = schedules_start; k < schedules_end; k++) {
				if(k == schedulesOcuppatedByTutor[y].schedules_start){
					found = true;
					alert("Ya existe un horario asignado. 8");
					break;	
				} else if(k > schedulesOcuppatedByTutor[y].schedules_start && k < schedulesOcuppatedByTutor[y].schedules_end){
					found = true;
					alert("Ya existe un horario asignado. 9");
					break;	
				}
			}

		} 
	}


	for (var h = 0; h < schedulesOcuppatedByClassroom.length; h++) {
		if(schedulesOcuppatedByClassroom[h].day == day){
			if(schedulesOcuppatedByClassroom[h].schedules_start == schedules_start || schedulesOcuppatedByClassroom[h].schedules_end == schedules_end ) {
				found = true;
				alert("Ya existe un horario asignado. 10");
				break;
			}

			for (var k = schedules_start; k < schedules_end; k++) {
				if(k == schedulesOcuppatedByClassroom[h].schedules_start){
					found = true;
					alert("Ya existe un horario asignado. 11");
					break;	
				} else if(k > schedulesOcuppatedByClassroom[h].schedules_start && k < schedulesOcuppatedByClassroom[h].schedules_end){
					found = true;
					alert("Ya existe un horario asignado. 12");
					break;	
				}
			}

		} 
	}


	if(found!==true)
	{			

		var data = {
			id: data_id,
			day: day,
			schedules_start: schedules_start,
			schedules_end: schedules_end,
			value: value
		}

		schedules.push(data);
		localStorage.setItem('schedules', JSON.stringify(schedules));

		for (var i = schedules_start; i < schedules_end; i++) {
			console.log("#d-"+day+"-s-"+i);
			$("#d-"+day+"-s-"+i).attr('style', 'background-color: palegreen;');
		}

		for (var i = 0; i < schedules.length; i++) {

			htmlApp += '<input type="text" name="cds[]" value="'+schedules[i].day+','+schedules[i].schedules_start+','+schedules[i].schedules_end+','+schedules[i].value+'" id="cds-'+schedules[i].id+'" style="display:none" />';
			$("#d-"+day+"-s-"+schedules_start).empty().append('<a class="btn btn-xs btn-warning pull-right" onclick="removeSchedules('+day+','+schedules_end+','+schedules_start+','+i+')"><span class="glyphicon glyphicon-trash"></span></a>');

		}

		$("#inputs-schedules").empty().append(htmlApp);
	}

}

function removeSchedulesInscriptions(day, schedules_end, schedules_start, i) {

	schedulesInscriptions = JSON.parse(localStorage.getItem('schedulesInscriptions')) || [];
	var data_id = "d-"+day+"-s-"+schedules_start;

	$('#cds-'+data_id).remove();
	$("#d-"+day+"-s-"+schedules_start).empty();
	$("#d-"+day+"-s-"+schedules_end).empty();
		for (var i = schedules_start; i <= schedules_end; i++) {
			$("#d-"+day+"-s-"+i).removeAttr('style');
		}


	schedulesInscriptions.splice(i,1);
	localStorage.setItem('schedulesInscriptions', JSON.stringify(schedulesInscriptions));
}


function removeSchedules(day, schedules_end, schedules_start, i) {

	schedules = JSON.parse(localStorage.getItem('schedules')) || [];
	var data_id = "d-"+day+"-s-"+schedules_start;
	$('#cds-'+data_id).remove();
	$("#d-"+day+"-s-"+schedules_start).empty();
	$("#d-"+day+"-s-"+schedules_end).empty();
		for (var i = schedules_start; i <= schedules_end; i++) {
			$("#d-"+day+"-s-"+i).removeAttr('style');
		}


	schedules.splice(i,1);
	localStorage.setItem('schedules', JSON.stringify(schedules));
}


function removeSchedulesByTutor(day, schedules_end, schedules_start) {

	schedulesOcuppatedByTutor = JSON.parse(localStorage.getItem('schedulesOcuppatedByTutor')) || [];
	$("#d-"+day+"-s-"+schedules_start).empty();
	$("#d-"+day+"-s-"+schedules_end).empty();
		for (var i = schedules_start; i < schedules_end; i++) {
			console.log(" REMOVIENDO LAS CELDAS ");
			console.log("#d-"+day+"-s-"+i);
			$("#d-"+day+"-s-"+i).removeAttr('style');
		}


	schedulesOcuppatedByTutor.splice(i,1);
	localStorage.setItem('schedulesOcuppatedByTutor', JSON.stringify(schedulesOcuppatedByTutor));
}

function removeSchedulesByClassroom(day, schedules_end, schedules_start) {

	schedulesOcuppatedByClassroom = JSON.parse(localStorage.getItem('schedulesOcuppatedByClassroom')) || [];
	$("#d-"+day+"-s-"+schedules_start).empty();
	$("#d-"+day+"-s-"+schedules_end).empty();
		for (var i = schedules_start; i < schedules_end; i++) {
			console.log(" REMOVIENDO LAS CELDAS ");
			console.log("#d-"+day+"-s-"+i);
			$("#d-"+day+"-s-"+i).removeAttr('style');
		}


	schedulesOcuppatedByClassroom.splice(i,1);
	localStorage.setItem('schedulesOcuppatedByClassroom', JSON.stringify(schedulesOcuppatedByClassroom));
}


function loadSchedules(){

	var class_id = $("#class_id").val();
	
	$.ajax({
		type: "GET",
		url: '/classes_days_schedules',
		data: { class_id: class_id },
		success: function (data) {

			for (var i = 0; i < data.length; i++) {

				addSchedule(data[i].day_id, data[i].schedule_start_id, data[i].schedule_end_id, data[i].value );
			}


		},
		error: function (data) {
			alert('Error:', data);
		}
	});

}


$(document).on('change','#schedules_start',function() {

	var schedules_start = $("#schedules_start").val();

	$(document.getElementById('schedules_end').options).each(function(index, option) {

	    if( parseInt(option.value) < parseInt(schedules_start) ) {

	        $("#schedules_end option[value='"+option.value+"']").hide();

	    } else {

	      	$("#schedules_end option[value='"+option.value+"']").show();
	    }

	});

});

$(document).on('change','#quantity',function() {

	var quantity = $("#quantity").val();
	var price = $("#product_price").val();
	var total = parseInt(quantity, 10) * parseInt(price, 10);

	$("#sub_total").val(total);


});

function loadSchedulesByClassrooms(){

	var classroom_id = $("#classroom_id").val();
	
	$.ajax({
		type: "GET",
		url: '/classrooms_days_schedules',
		data: { classroom_id: classroom_id },
		success: function (data) {


			if(data.length > 0){

				localStorage.setItem('schedulesOcuppatedByClassroom', '[]');
				console.log("tamaño de data -> " + data.length);
				for (var i = 0; i < data.length; i++) {
					console.log(data[i].class_id + " es distinto a " + $("#class_id").val());
					if(data[i].class_id != $("#class_id").val()){
						console.log("SI");
						addScheduleOccupatedByClassroom(data[i].day_id, data[i].schedule_start_id, data[i].schedule_end_id, data[i].value );
					}

				}				
			} else {

				schedulesOcuppatedByClassroom = JSON.parse(localStorage.getItem('schedulesOcuppatedByClassroom')) || [];

				for (var i = 0; i < schedulesOcuppatedByClassroom.length; i++) {
					removeSchedulesByClassroom(schedulesOcuppatedByClassroom[i].day, schedulesOcuppatedByClassroom[i].schedules_end, schedulesOcuppatedByClassroom[i].schedules_start);
				}				
	
			}

		},
		error: function (data) {
			alert('Error:', data);
		}
	});

}

function loadSchedulesByTutor(){

	var tutor_id = $("#tutor_uid").val();
	
	$.ajax({
		type: "GET",
		url: '/tutor_days_schedules',
		data: { tutor_id: tutor_id },
		success: function (data) {
				console.log(data.length);

			if(data.length > 0){

				localStorage.setItem('schedulesOcuppatedByTutor', '[]');
				for (var i = 0; i < data.length; i++) {
console.log(data[i].class_id+ " es distinto a " + $("#class_id").val());
					if(data[i].class_id != $("#class_id").val()){
						console.log("Call addScheduleOccupatedByTutor");

						addScheduleOccupatedByTutor(data[i].day_id, data[i].schedule_start_id, data[i].schedule_end_id, data[i].value );
					}

				}				
			} else {

				schedulesOcuppatedByTutor = JSON.parse(localStorage.getItem('schedulesOcuppatedByTutor')) || [];

				for (var i = 0; i < schedulesOcuppatedByTutor.length; i++) {
					removeSchedulesByTutor(schedulesOcuppatedByTutor[i].day, schedulesOcuppatedByTutor[i].schedules_end, schedulesOcuppatedByTutor[i].schedules_start);
				}				
	
			}


		},
		error: function (data) {
			alert('Error:', data);
		}
	});

}

function addScheduleOccupatedByTutor(day, schedules_start, schedules_end, value){

	var found = false;
	var htmlApp = "";
	var day = day;
	var schedules_start = schedules_start;
	var schedules_end = schedules_end;
	var value = value;
	var data_id = "d-"+day+"-s-"+schedules_start;

	schedulesOcuppatedByTutor = JSON.parse(localStorage.getItem('schedulesOcuppatedByTutor')) || [];
	for (var j = 0; j < schedulesOcuppatedByTutor.length; j++) {
		if(schedulesOcuppatedByTutor[j].day == day){
			if(schedulesOcuppatedByTutor[j].schedules_start == schedules_start || schedulesOcuppatedByTutor[j].schedules_end == schedules_end ) {
				found = true;
				break;
			}

			for (var k = schedules_start; k < schedules_end; k++) {
				if(k == schedulesOcuppatedByTutor[j].schedules_start){
					found = true;
					console.log("IF 1");
					break;	
				} else if(k > schedulesOcuppatedByTutor[j].schedules_start && k < schedulesOcuppatedByTutor[j].schedules_end){
					found = true;
					console.log("Else IF 1");

					break;	
				}
			}

		} 
	}

	if(found!==true)
	{			

		var data = {
			id: data_id,
			day: day,
			schedules_start: schedules_start,
			schedules_end: schedules_end,
			value: value
		}

		schedulesOcuppatedByTutor.push(data);
		localStorage.setItem('schedulesOcuppatedByTutor', JSON.stringify(schedulesOcuppatedByTutor));


		for (var i = schedules_start; i < schedules_end; i++) {
			$("#d-"+day+"-s-"+i).attr('style', 'background-color: darkgrey;');
		}

	}

}

function addScheduleOccupatedByClassroom(day, schedules_start, schedules_end, value){

	var found = false;
	var htmlApp = "";
	var day = day;
	var schedules_start = schedules_start;
	var schedules_end = schedules_end;
	var value = value;
	var data_id = "d-"+day+"-s-"+schedules_start;

	schedulesOcuppatedByClassroom = JSON.parse(localStorage.getItem('schedulesOcuppatedByClassroom')) || [];
	for (var j = 0; j < schedulesOcuppatedByClassroom.length; j++) {
		if(schedulesOcuppatedByClassroom[j].day == day){
			if(schedulesOcuppatedByClassroom[j].schedules_start == schedules_start || schedulesOcuppatedByClassroom[j].schedules_end == schedules_end ) {
				found = true;
				break;
			}

			for (var k = schedules_start; k < schedules_end; k++) {
				if(k == schedulesOcuppatedByClassroom[j].schedules_start){
					found = true;
					break;	
				} else if(k > schedulesOcuppatedByClassroom[j].schedules_start && k < schedulesOcuppatedByClassroom[j].schedules_end){
					found = true;
					break;	
				}
			}

		} 
	}

	if(found!==true)
	{			

		var data = {
			id: data_id,
			day: day,
			schedules_start: schedules_start,
			schedules_end: schedules_end,
			value: value
		}

		schedulesOcuppatedByClassroom.push(data);
		localStorage.setItem('schedulesOcuppatedByClassroom', JSON.stringify(schedulesOcuppatedByClassroom));

		for (var i = schedules_start; i < schedules_end; i++) {
			console.log(" PINTANDO LAS CELDAS ");
			console.log("#d-"+day+"-s-"+i);
			$("#d-"+day+"-s-"+i).attr('style', 'background-color: darkgrey;');
		}

	}

}

function loadUserInscriptions(){
	var user_id = $("#user_uid").val();
	
	$.ajax({
		type: "GET",
		url: '/user_inscriptions',
		data: { user_id: user_id },
		success: function (data) {

			for (var i = 0; i < data.length; i++) {
				addScheduleInscriptions(data[i].classes_days_schedules.day_id, data[i].classes_days_schedules.schedule_start_id, data[i].classes_days_schedules.schedule_end_id, data[i].classes_days_schedules.value, data[i].classes_days_schedules.id);
			}

		},
		error: function (data) {
			alert('Error:', data);
		}
	});

}

function addScheduleInscriptions(day, schedules_start, schedules_end, value, uid){

	var found = false;
	var htmlApp = "";
	var day = day;
	var schedules_start = schedules_start;
	var schedules_end = schedules_end;
	var value = value;
	var data_id = "d-"+day+"-s-"+schedules_start;

	schedulesInscriptions = JSON.parse(localStorage.getItem('schedulesInscriptions')) || [];

	for (var j = 0; j < schedulesInscriptions.length; j++) {
		if(schedulesInscriptions[j].day == day){
			if(schedulesInscriptions[j].schedules_start == schedules_start || schedulesInscriptions[j].schedules_end == schedules_end ) {
				found = true;
				alert("Ya existe un horario asignado.");
				break;
			}

			for (var k = schedules_start; k < schedules_end; k++) {
				if(k == schedulesInscriptions[j].schedules_start){
					found = true;
					alert("Ya existe un horario asignado.");
					break;	
				} else if(k > schedulesInscriptions[j].schedules_start && k < schedulesInscriptions[j].schedules_end){
					found = true;
					alert("Ya existe un horario asignado.");
					break;	
				}
			}

		} 
	}

	if(found!==true)
	{			

		var data = {
			uid: uid,
			id: data_id,
			day: day,
			schedules_start: schedules_start,
			schedules_end: schedules_end,
			value: value
		}

		schedulesInscriptions.push(data);
		localStorage.setItem('schedulesInscriptions', JSON.stringify(schedulesInscriptions));

		for (var i = schedules_start; i < schedules_end; i++) {
			console.log("#d-"+day+"-s-"+i);
			$("#d-"+day+"-s-"+i).attr('style', 'background-color: palegreen;');
		}

		for (var i = 0; i < schedulesInscriptions.length; i++) {

			htmlApp += '<input type="text" name="cds[]" value="'+schedulesInscriptions[i].uid+','+schedulesInscriptions[i].day+','+schedulesInscriptions[i].schedules_start+','+schedulesInscriptions[i].schedules_end+','+schedulesInscriptions[i].value+'" id="cds-'+schedulesInscriptions[i].id+'" style="display:none" />';

			$("#d-"+day+"-s-"+schedules_start).empty().append('<a> $'+schedulesInscriptions[i].value+'</a><a class="btn btn-xs btn-warning pull-right" onclick="removeSchedulesInscriptions('+day+','+schedules_end+','+schedules_start+','+i+')"><span class="glyphicon glyphicon-trash"></span></a>');

		}

		$("#inputs-schedules").empty().append(htmlApp);
	}

}

function getClassDayScheduleById(){

	var classes_days_schedules_id = $("#class_day_schedule").val();
	
	$.ajax({
		type: "GET",
		url: '/classes_days_schedules_by_id',
		data: { classes_days_schedules_id: classes_days_schedules_id },
		success: function (data) {

			var uid = data.id;
			var day = data.day_id;
			var schedules_start = data.schedule_start_id;
			var schedules_end  =  data.schedule_end_id;
			var value = data.value;

			if(data.inscribed < data.classes.capacity){

			    addScheduleInscriptions(day, schedules_start, schedules_end, value, uid);

			} else {

				alert("Ya no hay cupos en esta clase. ");

			}

		},
		error: function (data) {
			alert('Error:', data);
		}
	});

}


function getByDNI(){

	var dni = $("#document").val();
	
	$.ajax({
		type: "GET",
		url: '/get_by_dni',
		data: {document: dni },
		success: function (data) {

			$("#client_name").show();
			$("#client_name").append("Cliente: " + data.name + "  " + data.last_name);
			$("#uid_user").val(data.id);


			console.log(data);
		},
		error: function (data) {
			alert('Error:', data);
		}
	});

}

$(function () {
    $('.check').on('click', function () {
        $('.seleccionados').prop('checked',true);
    });
});


$(function () {
    $('.uncheck').on('click', function () {
        $('.seleccionados').prop('checked',false);
    });
});


/*********************************************Js Susana***************************************************/

function getProfitability(){

	var inicial_date = $('#start_date').val();
	var final_date = $('#end_date').val();
	var html = '';

	$.ajax({
		type: "GET",
		url: '/activities_profitability',
		data:{ 
			inicial: inicial_date, 
			final : final_date
		},

		success: function (data) {
			
			for (var i = 0; i < data.length; i++) {

				html += '<div class="metricContainer height-20">'+
				'<ul>'+
				'<h3>'+data[i].activity+'</h3>'+
				'<li class="text-left">Valor: '+data[i].value+'</li>'+
				'<li class="text-left">Inscritos: '+data[i].number_inscribed+'</li>'+
				'<li class="text-left">Profesor: '+data[i].tutor+'</li>'+
				'<li class="text-left">%Ganacia Profesor: '+data[i].tutor_prc_gain+'</li>'+
				'<li class="text-left">SubTotal: '+data[i].sub_total+'</li>'+
				'<li class="text-left">Costos: '+data[i].costs+'</li>'+
				'<li class="text-left">Total: '+data[i].total+'</li>'+
				'</ul>'+
				'</div>';

			}

		},

		error: function (data) {
			alert('Error:', data);
		}
	}).done(function() {
		$('#append_profits').append(html);
	});
}




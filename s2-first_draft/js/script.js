function ajaxOK(data) {
	var heures = data.split(';');

	$('#cmm').val(heures[0]);
	$('#tdd').val(heures[1]);
	$('#tpp').val(heures[2]);

}

function ajaxOKprog(data) {
	$("#mod").html(data);
}

function cmOK(data) {
	if (data < 0) {
		$(".CMtrophaut").remove();
		errorMes("body", "CMtrophaut", "");
	} else {
		$(".CMtrophaut").remove();
		$('.cm').html(data);
	}

	$('.total').html(parseInt($('.cm').text()) + parseInt($('.td').text()) + parseInt($('.tp').text()));

}

function tpOK(data) {
	if (data < 0) {
		$(".TPtrophaut").remove();
		errorMes("body", "TPtrophaut", "");
	} else {
		$(".TPtrophaut").remove();
		$('.tp').html(data);
	}

	$('.total').html(parseInt($('.cm').text()) + parseInt($('.td').text()) + parseInt($('.tp').text()));
}

function tdOK(data) {
	if (data < 0) {
		$(".TDtrophaut").remove();
		errorMes("body", "TDtrophaut", "");
	} else {
		$(".TDtrophaut").remove();
		$('.td').html(data);
	}

	$('.total').html(parseInt($('.cm').text()) + parseInt($('.td').text()) + parseInt($('.tp').text()));
}

function ajaxOKtab(data) {
	$("#RECAP_HEURE").html(data);
}

function insertok(data) {

	console.log(data);

}

function buildTab($id_mod) {

	var params = "id_m=" + $id_mod;
	$.ajax({
		type: 'POST',
		url: 'js/ajax/ajaxbuildtab.php',
		data: params,
		success: ajaxOKtab
	});
}

$('document').ready(function () {

	//AJAX section
	$('#prog').change(function () {
		var params = "prog=" + $("#prog").val();
		$.ajax({
			type: 'POST',
			url: 'js/ajax/ajaxheureprog.php',
			data: params,
			success: ajaxOKprog
		});
	});

	$('#prof').change(function () {
		var params = "prof=" + $('#prof').val() + "&mod=" + $('#mod').val();
		$.ajax({
			type: 'POST',
			url: 'js/ajax/ajax.php',
			data: params,
			success: ajaxOK
		});
	});

	$('#mod').change(function () {
		buildTab($("#mod").val());
		var params = "prof=" + $('#prof').val() + "&mod=" + $('#mod').val();
		$.ajax({
			type: 'POST',
			url: 'js/ajax/ajax.php',
			data: params,
			success: ajaxOK
		});
	});

	$('#cmm').on("change paste keyup", function () {
		if ($('#cmm').val() >= 0) {
			var params = "prof=" + $('#prof').val() + "&mod=" + $('#mod').val() + "&cm=" + $('#cmm').val();

			$.ajax({
				type: 'POST',
				url: '../php/cm.php',
				data: params,
				success: cmOK
			});
		} else alert('Veuillez mettre un nombre positif');
	});

	$('#tdd').on("change paste keyup", function () {
		var params = "prof=" + $('#prof').val() + "&mod=" + $('#mod').val() + "&td=" + $('#tdd').val() + "&prog=" + $("#prog").val();
		$.ajax({
			type: 'POST',
			url: '../php/td.php',
			data: params,
			success: tdOK
		});
	});


	$('#tpp').on("change paste keyup", function () {
		var params = "prof=" + $('#prof').val() + "&mod=" + $('#mod').val() + "&tp=" + $('#tpp').val() + "&prog=" + $("#prog").val();
		$.ajax({
			type: 'POST',
			url: '../php/tp.php',
			data: params,
			success: tpOK
		});
	});


	$('#butval').click(function (e) {
		var params = "prof=" + $('#prof').val() + "&mod=" + $('#mod').val() + "&cm=" + $('#cmm').val() + "&td=" + $('#tdd').val() + "&tp=" + $('#tpp').val();
		$.ajax({
			type: 'POST',
			url: '../php/valider.php',
			data: params,
			success: insertok
		});
	});
	//fin AJAX section


	$('window').resize(function () {
		$('body').height($('window').innerHeight);
	});

	$(".selectProg").change(function () {
		var JSON = {
			type: 'POST',
			url: 'php/fillCalendar.php',
			data: {
				"id_prog": parseInt($(".selectProg").val())
			},
		};

		$("#calendar").fullCalendar('removeEventSources');
		$("#calendar").fullCalendar('addEventSource', JSON);
	});

	$('#calendar').fullCalendar({
		locale: 'fr',
		height: 'auto',
		header: {
			left: 'prev,next today',
			center: '',
			right: 'title'
			//right: 'month,agendaWeek'
		},
		weekNumberCalculation: 'ISO',
		defaultView: 'month',
		weekNumbers: true,
		displayEventTime: false,
		allDayDefault: false,
		minTime: "00:00:00",
		maxTime: "23:59:59",
	});

	//BUTTON STYLING
	$('button').click(function () {
		$(this).parent().children('button').removeClass("btnActive");
		$(this).addClass("btnActive");
	});
	$("input[type='button']").click(function () {
		$(this).parent().children("input[type='button']").removeClass("btnActive");
		$(this).addClass("btnActive");
	});

	$('.pieBtn').click();
});

$('document').ready(function () {
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

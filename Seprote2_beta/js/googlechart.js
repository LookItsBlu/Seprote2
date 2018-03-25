$(document).ready(()=>{
	var hour = [0,0,0];
	//get the number of hours for the current user in the current program
	window.addEventListener('Chart Update', evt => {
		$.ajax({
			type: 'POST',
			url: 'php/chartHour.php',
			data: { 'id_prog': evt.detail.program },
			success: function(data){
				var time = JSON.parse(data);
				for(var i=0; i<data.length; i++)
					hour[i]=time[i];
				google.charts.setOnLoadCallback(drawChart);
			}
		});
	});

    //GOOGLE CHART
	google.charts.load('current', {'packages':['corechart']}); //charge le paquet "corechart" ainsi que l'API de visualisation
	google.charts.setOnLoadCallback(drawChart); //appelle drawChart() dès que l'API est chargé

	var chartType = "pie";
	function drawChart() {

		// Create the data table.
		var data = new google.visualization.DataTable();
		data.addColumn('string', 'Type');
		data.addColumn('number', 'Heures');
		data.addRows([
		  ['heures de CM', hour[0]],
		  ['heures de TD', hour[1]],
		  ['heures de TP', hour[2]],
		]);

		// Set chart options
		var options = {
		  'title':'Repartition des heures de cours',
		  'width':600,
		  'height':500,
		  'backgroundColor': {
			'fill': '#fafafa',
			'opacity': 0
		  }
		};

		// Instantiate and draw our chart, passing in some options.
		if(chartType=="pie") {
			var chart = new google.visualization.PieChart(document.getElementById('chart'));
		} else if(chartType=="bar") {
			var chart = new google.visualization.BarChart(document.getElementById('chart'));
		}

		chart.draw(data, options);
	}

	$('.selection>button').click(function(e){
		if(e.currentTarget.className == "tabBtn btnActive" && chartType!="table") {
			//A FAIRE
        	chartType = "table";
        	$("#chart").html("<table><tr><td>CM</td><td>"+hour[0]+"</td></tr><tr><td>TD</td><td>"+hour[1]+"</td></tr><tr><td>TP</td><td>"+hour[2]+"</td></tr></table>");
		} else if(e.currentTarget.className == "pieBtn btnActive" && chartType!="pie") {
			chartType="pie";
			drawChart();
		} else if(e.currentTarget.className == "barBtn btnActive" && chartType!="bar") {
			chartType="bar";
			drawChart();
		}
	});
});

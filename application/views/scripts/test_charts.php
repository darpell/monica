<!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">

      // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {
	  
	  //get date 
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1;
		var yyyy = today.getFullYear() -1 ;
		if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm} today = mm+'/'+dd+'/'+yyyy;
		
	  var str = document.getElementById("data").value;
		str = str.split("%%");
		
		var data = new Array();
		for (var i = 0; i < str.length; i++)
		{
			data[i] = str[i].split("&&");
		}
		var age0m = 0;
		var age1m = 0;
		var age2m = 0;
		var age3m = 0;
		var age4m = 0;
		var age0f = 0;
		var age1f = 0;
		var age2f = 0;
		var age3f = 0;
		var age4f = 0;
		for (var i = 0; i < data.length; i++)
		{	
			if (data[i][2] == 0) 
			{
			if(data[i][1] == 'F')
			{age0f = data[i][0];}
			else {age0m = data[i][0];}
			}
			else if (data[i][2] == 1) 
			{
			if(data[i][1] == 'F')
			{age1f = data[i][0];}
			else {age1m = data[i][0];}
			}
			else if (data[i][2] == 2) 
			{
			if(data[i][1] == 'F')
			{age2f = data[i][0];}
			else {age2m = data[i][0];}
			}
			else if (data[i][2] == 3) 
			{
			if(data[i][1] == 'F')
			{age3f = data[i][0];}
			else {age3m = data[i][0];}
			}
			else if (data[i][2] >= 4) 
			{
			if(data[i][1] == 'F')
			{age4f = age4f + parseInt(data[i][0]);}
			else {age4m = age4m + parseInt(data[i][0]);}
			}
			
		}
		
		var str2 = document.getElementById("data1").value;
		str2 = str2.split("%%");
		
		var data2 = new Array();
		for (var i = 0; i < str2.length; i++)
		{
			data2[i] = str2[i].split("&&");
		}
		var m1 = 0;
		var m2 = 0;
		var m3 = 0;
		var m4 = 0;
		var m5 = 0;
		var m6 = 0;
		var m7 = 0;
		var m8 = 0;
		var m9 = 0;
		var m10 = 0;
		var m11 = 0;
		var m12 = 0;
		
		var mn1 = 0;
		var mn2 = 0;
		var mn3 = 0;
		var mn4 = 0;
		var mn5 = 0;
		var mn6 = 0;
		var mn7 = 0;
		var mn8 = 0;
		var mn9 = 0;
		var mn10 = 0;
		var mn11 = 0;
		var mn12 = 0;


		
		for (var i = 0; i < data2.length; i++)
		{	
			if(parseInt(data2[i][2]) == parseInt(yyyy))
			{
			if (data2[i][1] == 1) 
			{mn1 = data2[i][0];}
			if (data2[i][1] == 2) 
			{mn2 = data2[i][0];}
			if (data2[i][1] == 3) 
			{mn3 = data2[i][0];}
			if (data2[i][1] == 4) 
			{mn4 = data2[i][0];}
			if (data2[i][1] == 5) 
			{mn5 = data2[i][0];}
			if (data2[i][1] == 6) 
			{mn6 = data2[i][0];}
			if (data2[i][1] == 7) 
			{mn7 = data2[i][0];}
			if (data2[i][1] == 8) 
			{mn8 = data2[i][0];}
			if (data2[i][1] == 9) 
			{mn9 = data2[i][0];}
			if (data2[i][1] == 10) 
			{mn10 = data2[i][0];}
			if (data2[i][1] == 11) 
			{mn11 = data2[i][0];}
			if (data2[i][1] == 12) 
			{mn12 = data2[i][0];}
			}
			else if(parseInt(data2[i][2]) == parseInt(yyyy) -1)
			{
			if (data2[i][1] == 1) 
			{m1 = data2[i][0];}
			if (data2[i][1] == 2) 
			{m2 = data2[i][0];}
			if (data2[i][1] == 3) 
			{m3 = data2[i][0];}
			if (data2[i][1] == 4) 
			{m4 = data2[i][0];}
			if (data2[i][1] == 5) 
			{m5 = data2[i][0];}
			if (data2[i][1] == 6) 
			{m6 = data2[i][0];}
			if (data2[i][1] == 7) 
			{m7 = data2[i][0];}
			if (data2[i][1] == 8) 
			{m8 = data2[i][0];}
			if (data2[i][1] == 9) 
			{m9 = data2[i][0];}
			if (data2[i][1] == 10) 
			{m10 = data2[i][0];}
			if (data2[i][1] == 11) 
			{m11 = data2[i][0];}
			if (data2[i][1] == 12) 
			{m12 = data2[i][0];}
			}
		}
		
		
		
        // Create the data table.
      var data = google.visualization.arrayToDataTable([
          ['Age Group', 'Female', 'Male'],
          ['1-10',  parseInt(age0f),      parseInt(age0m)],
          ['11-20',  parseInt(age1f),      parseInt(age1m)],
          ['21-30',  parseInt(age2f),      parseInt(age2m)],
          ['31-40',  parseInt(age3f),      parseInt(age3m)],
          ['>40', parseInt( age4f),      parseInt(age4m)]
        ]);
		
		
		
        // Set chart options
		var curtotal = parseInt(mn1) + parseInt(mn2) + parseInt(mn3) + parseInt(mn4) + parseInt(mn5) + parseInt(mn6) + parseInt(mn7) + parseInt(mn8) + parseInt(mn9) + parseInt(mn10) + parseInt(mn11) + parseInt(mn12);
        var options = {
          title : 'Fig.1 Dengue Cases by Agegroup and Gender Dasmarinas City, Philippines as of '+today,
          vAxis: {title: "Number Of Cases"},
          hAxis: {title: "Age Group"},
          seriesType: "bars",
          series: {5: {type: "line"}}
        };


        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
        chart.draw(data, options);
		
		
		
		var data3 = google.visualization.arrayToDataTable([
          ['Month', '2012', '2011'],
          ['Jan',  parseInt(mn1),      parseInt(m1)],
          ['Feb',  parseInt(mn2),     parseInt( m2)],
          ['Mar',  parseInt(mn3),      parseInt(m3)],
          ['Apr',  parseInt(mn4),     parseInt( m4)],
		  ['May',  parseInt(mn5),      parseInt(m5)],
          ['Jun',  parseInt(mn6),      parseInt(m6)],
          ['Jul',  parseInt(mn7),     parseInt( m7)],
          ['Aug',  parseInt(mn8),     parseInt( m8)],
		  ['Sep',  parseInt(mn9),     parseInt( m9)],
          ['Oct',  parseInt(mn10),     parseInt( m10)],
          ['Nov',  parseInt(mn11),     parseInt( m11)],
          ['Dec',  parseInt(mn12),     parseInt( m12)]
        ]);
		
        // Set chart options
		var curtotal = parseInt(mn1) + parseInt(mn2) + parseInt(mn3) + parseInt(mn4) + parseInt(mn5) + parseInt(mn6) + parseInt(mn7) + parseInt(mn8) + parseInt(mn9) + parseInt(mn10) + parseInt(mn11) + parseInt(mn12);
        var options2 = {
          title : 'Fig.2 Dengue Cases by Month, Dasmarinas, Philippines, ' + yyyy +' vs '+ (yyyy-1),
          vAxis: {title: "Number Of Cases"},
          hAxis: {title: "Month"},
          seriesType: "line",
          series: {1: {type: "line"}}
        };
		
		var chart = new google.visualization.ComboChart(document.getElementById('chart_div1'));
        chart.draw(data3, options2);
	
			
		}
		
      
    </script>

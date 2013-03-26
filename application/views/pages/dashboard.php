<!-- HEADER -->
<?php $this->load->view('templates/header');?>

	
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>    
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?v=3&sensor=true"></script>
<script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/src/markerclusterer.js"></script>
<script src="<?= base_url('scripts/OverlappingMarkerSpiderfier.js') ?>"></script><script type="text/javascript" src="http://www.google.com/jsapi"></script>

    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load('visualization', '1.1', {packages: ['controls','corechart','gauge','table']});
    </script>
    <script type="text/javascript">
      function drawVisualization() {
    		var today = new Date();
    		var dd = today.getDate();
    		var mm = today.getMonth()+1;
    		var yyyy = today.getFullYear() ;
    		if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm} today = mm+'/'+dd+'/'+yyyy;

		//cases
    	var str2 = document.getElementById('barangay_count').value.toString();
		str2 = str2.split("%%");
		var data = new Array();
		for (var i = 0; i < str2.length; i++)
		{
			data[i] = str2[i].split("&&");
		}
		data.pop();

		//quartile
		var quartile = document.getElementById('quartile').value.toString();
		quartile = quartile.split("&&");
		quartile.pop();
		//csum
		var csum = document.getElementById('csum').value.toString();
		csum = csum.split("&&");
		csum.pop();
		//m2sd
		var m2sd = document.getElementById('m2sd').value.toString();
		m2sd = m2sd.split("&&");
		m2sd.pop();
		//csum192sd
		var csum196sd = document.getElementById('csum196sd').value.toString();
		csum196sd = csum196sd.split("&&");
		csum196sd.pop();
		//cases
		var cases = document.getElementById('cases').value.toString();
		cases = cases.split("&&");
		cases.pop();
		var today2 = new Date();

		//larval points
		var str3 = document.getElementById('larval').value.toString();
		str3 = str3.split("%%");
		var larval = new Array();
		for (var i = 0; i < str3.length; i++)
		{
			larval[i] = str3[i].split("&&");
		}
		larval.pop();
		var larval1 = 0;
		var larval2 = 0;
		var larval3 = 0;
		var larval4 = 0;

		for (var i = 0; i < larval.length; i++)
		{	
			if (larval[i][1] == 'LANGKAAN II') 
			{larval1 = larval[i][0];}
			if (larval[i][1] == 'SAMPALOC I') 
			{larval2 = larval[i][0];}
			if (larval[i][1] == 'SAN AGUSTIN I') 
			{larval3 = larval[i][0];}
			if (larval[i][1] == 'SAN AGUSTIN III') 
			{larval4 = larval[i][0];}
		}

		
		
		var tquartile = Math.round(((cases[ today2.getMonth()]/quartile[ today2.getMonth()]))*100);
		var tcsum =  Math.round(((cases[ today2.getMonth()]/csum[ today2.getMonth()]))*100);
		var tmean2sd = Math.round(((cases[ today2.getMonth()]/m2sd[ today2.getMonth()]))*100);
		var tcsum196sd = Math.round(((cases[ today2.getMonth()]/csum196sd[ today2.getMonth()]))*100);
		

		 var epi = google.visualization.arrayToDataTable([
		            ['Label', 'Value'],
		         	['3rd Quartile', tquartile],
		            ['C-SUM', tcsum] ,
		            ['mean+2SD', tmean2sd ],
		            ['C-SUM+1.96SD', tcsum196sd],
		                                                 ]);
		 var epioptions = {
		          redFrom: 90, redTo: 150,
		          yellowFrom:75, yellowTo: 90,
		          minorTicks: 0,
		          max:150
		        };
				
		
			var m1 = 0;
			var m2 = 0;
			var m3 = 0;
			var m4 = 0;
    		
			var mn1 = 0;
			var mn2 = 0;
			var mn3 = 0;
			var mn4 = 0;
	
			for (var i = 0; i < data.length; i++)
			{	
				if(parseInt(data[i][2]) == parseInt(yyyy))
				{
				if (data[i][1] =='LANGKAAN II' ) 
				{mn1 = data[i][0];}
				if (data[i][1] == 'SAMPALOC I') 
				{mn2 = data[i][0];}
				if (data[i][1] == 'SAN AGUSTIN I') 
				{mn3 = data[i][0];}
				if (data[i][1] == 'SAN AGUSTIN III') 
				{mn4 = data[i][0];}
				}
				else if(parseInt(data[i][2]) == parseInt(yyyy-1))
				{
				if (data[i][1] == 'LANGKAAN II') 
				{m1 = data[i][0];}
				if (data[i][1] == 'SAMPALOC I') 
				{m2 = data[i][0];}
				if (data[i][1] == 'SAN AGUSTIN I') 
				{m3 = data[i][0];}
				if (data[i][1] == 'SAN AGUSTIN III') 
				{m4 = data[i][0];}
				}
			}


			//number of postive
			
			var xvalues = [68, 71 ,62 ,75, 58, 60, 67, 68, 71, 69, 68, 67, 63, 62, 60, 63, 65, 67, 63, 61];
			//number of cases
			var yvalues = [4.1, 4.6, 3.8, 4.4, 3.2, 3.1, 3.8, 4.1, 4.3, 3.7, 3.5, 3.2, 3.7, 3.3, 3.4, 4.0, 4.1, 3.8, 3.4, 3.6];
			var n = 4; //number of barangays
			var xyprod = 0; // sum of the products of x and y
			var xsum = 0;
			var ysum = 0;
			var xsumsq = 0;
			var ysumsq = 0;

			for (var i = 0; i < n; i++)
			{
				xyprod = xyprod + (xvalues[i]*yvalues[i]);
				xsum = xsum + xvalues[i];
				ysum = ysum + yvalues[i];
				xsumsq = xsumsq + (xvalues[i]*xvalues[i]);
				ysumsq = ysumsq + (yvalues[i]*yvalues[i]);
			}

			//correlation formula

			var a = (n*xyprod) - (xsum*ysum); //numerator
			var b = Math.sqrt(((n*xsumsq)-(xsum*xsum)) * ((n*ysumsq)-(ysum*ysum))); //denominator
			var r = a/b; //correlation result;
			
 
          // Prepare the data
        var str = document.getElementById('age_count').value.toString();

					str = str.split("%%");
					var data2 = new Array();
					for (var i = 0; i < str.length; i++)
					{
						data2[i] = str[i].split("&&");
					}
					data2.pop();
		 var datatable = new google.visualization.DataTable();
		 datatable.addColumn('string', 'Barangay');
		 datatable.addColumn('string', 'Age Group');
		 datatable.addColumn('number', 'No. of Cases');
		 datatable.addRows(data2.length);
		 for (var i = 0; i < data2.length; i++)
			{
			 datatable.setCell(i, 0 , data2[i][0]);
			 datatable.setCell(i, 1 , data2[i][1]);
			 datatable.setCell(i, 2 , parseInt(data2[i][2]));
			}

   
        var categoryPicker = new google.visualization.ControlWrapper({
          'controlType': 'CategoryFilter',
          'containerId': 'control2',
          'options': {
            'filterColumnLabel': 'Age Group',
            'ui': {
            'labelStacking': 'vertical',
              'allowTyping': false,
              'allowMultiple': false
            }
          }
        });
        var categoryPicker2 = new google.visualization.ControlWrapper({
            'controlType': 'CategoryFilter',
            'containerId': 'control3',
            'options': {
              'filterColumnLabel': 'Barangay',
              'ui': {
              'labelStacking': 'vertical',
                'allowTyping': false,
                'allowMultiple': false
              }
            }
          });
      
        // Define a table
        var table = new google.visualization.ChartWrapper({
          'chartType': 'Table',
          'containerId': 'chart2',
          'options': {
           
          }
        });
        var pie = new google.visualization.ChartWrapper({
            'chartType': 'PieChart',
            'containerId': 'chart1',
            'options': {
              'width': 300,
              'height': 300,
              'legend': {position: 'top', textStyle: {color: 'blue', fontSize: 16}},
              
              'title': 'No. of cases',
              'chartArea': {'left': 15, 'top': 15, 'right': 0, 'bottom': 0},
              'pieSliceText': 'label'
            },
            // from the 'data' DataTable.
            'view': {'columns': [0, 2]}
          });

        var ctr = document.getElementById('immediate_cases').value.toString();

		ctr = ctr.split("%%");
		var icase = new Array();
		for (var i = 0; i < ctr.length; i++)
		{
			icase[i] = ctr[i].split("&&");
		}
		icase.pop();
		var datatable2 = new google.visualization.DataTable();
		datatable2.addColumn('string', 'Name');
		datatable2.addColumn('string', 'Age');
		datatable2.addColumn('string', 'sex');
		datatable2.addColumn('string', 'Address');
		datatable2.addColumn('string', 'Remarks');
		datatable2.addRows(icase.length);
		for (var i = 0; i < icase.length; i++)
		{
		 datatable2.setCell(i, 0 , icase[i][0]);
		 datatable2.setCell(i, 1 , icase[i][1]);
		 datatable2.setCell(i, 2 , icase[i][2]);
		 datatable2.setCell(i, 3 , icase[i][3]);
		 datatable2.setCell(i, 4 , icase[i][4]);

		}
		        

      
 
        // Create a dashboard
        new google.visualization.Dashboard(document.getElementById('dashboard')).
            // Establish bindings, declaring the both the slider and the category
            // picker will drive both charts.
            bind([categoryPicker,categoryPicker2], [pie,table]).
            // Draw the entire dashboard.
            draw(datatable);

         var options = {
                title : 'This month dengue cases by barangay compared to the previous year',
                vAxis: {title: "Number Of Cases"},
                hAxis: {title: "Barangay"},
                seriesType: "bars",
                series: {5: {type: "line"}}
              };
         var options2 = {
                 title : 'Correlation Between Larval Survey and Dengue Cases with a Correlation Result* ' + r,
                 vAxis: {title: "Number"},
                 hAxis: {title: "Barangay"},
                 seriesType: "line",
                 series: {5: {type: "line"}}
               };
         
        var data = google.visualization.arrayToDataTable([
       	['Barangay', yyyy, yyyy-1],
        ['Langkaan II',  parseInt(mn1),      parseInt(m1)],
        ['Sampaloc I',  parseInt(mn2),      parseInt(m2)],
        ['San Agustin I',  parseInt(mn3),     parseInt(m3)],
        ['San Agustin III',  parseInt(mn4),      parseInt(m4)]
        ]);
        var data2 = google.visualization.arrayToDataTable([
         ['Barangay', 'No. of Cases', 'No. Positive Larval Points'],
         ['Langkaan II',  parseInt(mn1),  parseInt(larval1)    ],
         ['Sampaloc I',  parseInt(mn2),    parseInt(larval2)  ],
         ['San Agustin I',  parseInt(mn3),  parseInt(larval3)   ],
         ['San Agustin III',  parseInt(mn4),  parseInt(larval4)    ]
         ]);

        var sumofcases = parseInt(mn1)+parseInt(mn2)+parseInt(mn3)+parseInt(mn4);
        document.getElementById('tquartile').value = tquartile;
        document.getElementById('tcases').value = sumofcases;
        document.getElementById('tcsum').value = tcsum;
        document.getElementById('tm2sd2').value = tmean2sd;
        document.getElementById('tcsum196sd').value = tcsum196sd;
        
              // Instantiate and draw our chart, passing in some options.
              var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
              chart.draw(data, options);

              var chart2 = new google.visualization.ComboChart(document.getElementById('chart_div2'));
              chart2.draw(data2, options2);
              
              new google.visualization.Gauge(document.getElementById('visualization')).
              draw(epi,epioptions);

              var table = new google.visualization.Table(document.getElementById('table_div1'));
              table.draw(datatable2, {showRowNumber: true,width: '1000px'});
                    
      }

      google.setOnLoadCallback(drawVisualization);

      function loadXMLDoc(q)
      {
      	

      var xmlhttp;
      if (q=="")
        {
        //document.getElementById("txtHint").innerHTML="";
        //return;
        }
      if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
        }
      else
        {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
       
      xmlhttp.onreadystatechange=function()
        {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
          {
         	//document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
          //alert(xmlhttp.responseText);
          }
        };
        var url = 'http://localhost/workspace/monica/index.php/case_report/get_denguecases/' + q;
        xmlhttp.open("post",url,false);
      xmlhttp.send(null);

      }
      var infoWindow = new google.maps.InfoWindow();
      infoWindow.setOptions({maxWidth:400});
      var customIcons = {
      		  larvalpositive: {
      	        icon: 'http://labs.google.com/ridefinder/images/mm_20_blue.png',
      	        shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
      	      },
      	      denguecase: {
      	        icon: 'http://labs.google.com/ridefinder/images/mm_20_red.png',
      	        shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
      	      }
      	    };

      function splitter(str){//Data splitter
      	
      	str = str.split("%%");
      	
      	var data = new Array();
      	for (var i = 0; i < str.length; i++)
      	{
      		data[i] = str[i].split("&&");
      	}
      	return data;
      	}

      	var refNumber = new Array();
      	var nodeType = new Array();
      	var lat = new Array();
      	var lng = new Array();
      	var id=new Array();
      	var household = new Array();
      	var container = new Array();
      	var createdOn = new Array();
      	

      function createMarker(map,point,image,info,bounce,isOld,isPoI,RiskOrSource){//General marker creation
      	var centroidMarker;
      	var oms = new OverlappingMarkerSpiderfier(map);
      	if(image === null && !isPoI)
      	{
      		if(isOld===false)
      		{
      			centroidMarker = new google.maps.Marker({
      			  position: point,
      			  map: map,
      			  shadow:null
      			});
      			oms.addMarker(centroidMarker);
      			if(bounce !== null)
      			{
      			    centroidMarker.setAnimation(google.maps.Animation.BOUNCE);
      			}
      		}
      		else
      		{
      			centroidMarker = new google.maps.Marker({
      				  position: point,
      				  map: map,
      			      icon: new google.maps.MarkerImage('https://maps.gstatic.com/mapfiles/ms2/micons/ltblue-dot.png'),
      				});
      				oms.addMarker(centroidMarker);
      				if(bounce !== null)
      				{
      				    centroidMarker.setAnimation(google.maps.Animation.BOUNCE);
      				}
      		}
      	}
      	else if (isPoI)
      	{
      		var centroidMarker = new google.maps.Marker({  
              position: point,   
              map: map,  
              icon: 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld='+RiskOrSource+'|FF0000|000000'  
          	});  
      	}
      	else
      	{
      		centroidMarker = new google.maps.Marker({
      		      map: map,
      		      position: point,
      		      icon: image,
      			});
      	}
      	if (type!==null)
      	{
      		
      	}
      	 /*
      	centroidMarker.info = new google.maps.InfoWindow({
      		content: info
      	});
      	//*/
      	  
      	google.maps.event.addListener(centroidMarker, 'click', function() {
      		infoWindow.setContent(info);
      		infoWindow.open(map, this);
      	});
      	
      		google.maps.event.addListener(centroidMarker, 'click', function() {
      			loadXMLDoc(info);
      	});
      	/*google.maps.event.addListener(centroidMarker, 'onClick', function() {
      		
      	});*/
      }

      function mapPointsOfInterest(googleMap)
      {
      	var tempo=splitter(document.getElementById("interest").value.toString());
      	var length=tempo.length;
      	//alert(tempo);
      	for(var i=0;i<length;i++)
      	{
      		var tempoagain;
      		var point = new google.maps.LatLng(tempo[i][1],tempo[i][2]);
      		var html = "<b>"+tempo[i][0]+"</b><br/>"+tempo[i][3]+"<br/><br/><b>Location:</b> "+tempo[i][6]+" City, Barangay "+tempo[i][5]+"<br/><br/><b>Notes:</b> "+tempo[i][4]+"<br/><br/><i>Added on "+tempo[i][7]+"</i>";
      		if(tempo[i][8]==0)
      		{
      			tempoagain="S";
      		}
      		else
      		{
      			tempoagain="R";
      		}
      		createMarker(googleMap,point,null,html,false,false,true,tempoagain);
      	}
      }

      function mapBarangayOverlay(map,barangayCount,barangayAge,datax,barangayInfo,isOld) {//Denguecase barangay polygon display

      	//*DECLARATION OF VALUES AND CONTAINERS
      	var x1=999;
      	var x2=-999;
      	var y1=999;
      	var y2=-999;
      	var currPoly = 1;
      	var latLng = [];
      	var nodeInfoCounter=0;
      	var bcount=splitter(barangayCount);
      	var data2=splitter(datax);
      	var binfo=splitter(barangayInfo);
      	var bage=splitter(barangayAge);
      	var problem=false;
      	//-------------------*/
      	
      	for (var _i=0; _i <= data2.length-1;)
      	{//alert("Iterating through index "+_i);
      		if(currPoly==data2[_i][0])
      		{//alert("Current polygon index number "+currPoly+" == "+data2[_i][0]);
      			currName=data2[_i][3];
      			//*CENTROID LOCATOR
      			if(parseFloat(data2[_i][1]) < x1)
      			{x1=parseFloat(data2[_i][1]);}
      			if(parseFloat(data2[_i][2]) < y1)
      			{y1=parseFloat(data2[_i][2]);}
      			if(parseFloat(data2[_i][1]) > x2)
      			{x2=parseFloat(data2[_i][1]);}
      			if(parseFloat(data2[_i][2]) > y2)
      			{y2=parseFloat(data2[_i][2]);}
      			//-------------------*/

      			latLng.push(new google.maps.LatLng(parseFloat(data2[_i][1]), parseFloat(data2[_i][2])));
      			_i++;
      			problem=true;
      		}
      		else if(!problem)
      		{
      			currPoly++;
      		}
      		else
      		{
      			//*CREATION OF POLYGON
                 if(!isOld)
      			var bermudaTriangle = new google.maps.Polygon(
      					{
      						paths: latLng,
      						fillColor: "#FF0000",
      						fillOpacity:0.3,
      						clickable:false
      					});
      			//-------------------*/
      			
      			//*BARANGAY MARKER INFORMATION EXTRACTION
      			var html="<b><i>No Data to Display</b></i>";
      			var casecount=0;
      			var countUnderage=0;
      			
      			for(var i=0;i<=bcount.length-1;i++)
      			{
      				if(bcount[i][0]===currName)
      				{
      					var ageArr=[];
      					for(var __i=0;__i<bage.length;__i++)
      					{
      						if(bage[__i][0]==currName)
      						{
      							ageArr.push(bage[__i][1]);
      						}
      					}
      					ageArr.sort();
      					
      				    for ( var ___i = 0; ___i < ageArr.length; ___i++ ) 
      					{
      						if(ageArr[___i]<18)
      							countUnderage++;
      				    }
      					//alert(binfo[i]);
      					casecount=bcount[i][1];
      					
      					html="<b>" +binfo[i][0]+"</b> ("+bcount[i][1]+" cases)<br/><br/><b>DENGUE CASES INFORMATION</b>"+
      					" <br/>" + "<b>Gender Distribution</b>" +
      					" <br/>" + "Female cases: " +binfo[i][1]+
      					" <br/>" + "Male cases: " +binfo[i][2]+"<br/>";

      					if(casecount!=0)
      					html=html+"<br/><b>Age Distribution</b>"+
      					" <br/>" + "Youngest: " +binfo[i][3]+
      					" <br/>" + "Oldest: " +binfo[i][4]+
      					" <br/>" + "Below 18: " +countUnderage+"("+(countUnderage/parseFloat(bcount[i][1])).toFixed(2)*100+"%)"+
      					" <br/>" + "Average Age: " +parseFloat(binfo[i][5]).toFixed(0)+" <br/>";
      					else
      					html=html+"<br/><b>Age Distribution</b>"+
      					" <br/>" + "Youngest: 0" +
      					" <br/>" + "Oldest: 0" +
      					" <br/>" + "Below 18: 0(0%)" +
      					" <br/>" + "Average Age: 0" + " <br/>";
      					
      					html=html+
      					" <br/>" + "<b>Outcome</b>" +
      					" <br/>" + "Alive: " +binfo[i][6]+
      					" <br/>" + "Deceased: " +binfo[i][7]+
      					" <br/>" + "Undetermined: " +binfo[i][8];
      				}
      			}
      			//-------------------*/
      			
      			//*CREATION OF CENTROID POINT
      			var centroidX = x1 + ((x2 - x1) * 0.5);
      			var centroidY = y1 + ((y2 - y1) * 0.5);
      			var image;
      			var point;
      			
      			if(isOld)
      			{
      				image = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld='+casecount+'|8FD8D8';
      				point = new google.maps.LatLng(centroidX,centroidY);
      				
      			}
      			else
      			{
      				image = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld='+casecount+'|ff776b';
      				point = new google.maps.LatLng(centroidX,centroidY+0.0010);
      			}
      			createMarker(map,point,image,html,null,true,false);
      			nodeInfoCounter++;
      			//-------------------*/
                 if(!isOld)
      			bermudaTriangle.setMap(map);
      			latLng = [];

      			x1=999;
      			x2=-999;
      			y1=999;
      			y2=-999;
      			currPoly++;
      			while(currPoly!=data2[_i][0])
      			{
      				currPoly++;
      			}	
      		}
      	}
      	//*CREATION OF POLYGON
          if(!isOld)
      	var bermudaTriangle = new google.maps.Polygon(
      			{
      				paths: latLng,
      				fillColor: "#FF0000",
      				fillOpacity:0.3,
      				clickable:false
      			});
      	//-------------------*/
      	
      	//*BARANGAY MARKER INFORMATION EXTRACTION
      			var html="<b><i>No Data to Display</b></i>";
      			var casecount=0;
      			var countUnderage=0;
      			for(i=0;i<bcount.length;i++)
      			{
      				if(bcount[i][0]===currName)
      				{
      					var ageArr=[];
      					for(var __i=0;__i<bage.length;__i++)
      					{
      						if(bage[__i][0]==currName)
      						{
      							ageArr.push(bage[__i][1]);
      						}
      					}
      					ageArr.sort();
      				    for ( var ___i = 0; ___i < ageArr.length; ___i++ ) 
      					{
      						if(ageArr[___i]<18)
      							countUnderage++;
      				    }
      					//alert(binfo[i]);
      					casecount=bcount[i][1];
      					
      					html="<b>" +binfo[i][0]+"</b> ("+bcount[i][1]+" cases)<br/><br/><b>DENGUE CASES INFORMATION</b>"+
      					" <br/>" + "<b>Gender Distribution</b>" +
      					" <br/>" + "Female cases: " +binfo[i][1]+
      					" <br/>" + "Male cases: " +binfo[i][2]+"<br/>";

      					if(casecount!=0)
      					html=html+"<br/><b>Age Distribution</b>"+
      					" <br/>" + "Youngest: " +binfo[i][3]+
      					" <br/>" + "Oldest: " +binfo[i][4]+
      					" <br/>" + "Below 18: " +countUnderage+"("+(countUnderage/parseFloat(bcount[i][1])).toFixed(2)*100+"%)"+
      					" <br/>" + "Average Age: " +parseFloat(binfo[i][5]).toFixed(0)+" <br/>";
      					else
      					html=html+"<br/><b>Age Distribution</b>"+
      					" <br/>" + "Youngest: 0" +
      					" <br/>" + "Oldest: 0" +
      					" <br/>" + "Below 18: 0(0%)" +
      					" <br/>" + "Average Age: 0" + " <br/>";
      					
      					html=html+
      					" <br/>" + "<b>Outcome</b>" +
      					" <br/>" + "Alive: " +binfo[i][6]+
      					" <br/>" + "Deceased: " +binfo[i][7]+
      					" <br/>" + "Undetermined: " +binfo[i][8];
      				}
      			}
      			//-------------------*/
      	
      	//*CREATION OF CENTROID POINT
      	var centroidX = x1 + ((x2 - x1) * 0.5);
      			var centroidY = y1 + ((y2 - y1) * 0.5);
      			var image;
      			var point;
      			if(isOld)
      			{
      				image = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld='+casecount+'|8FD8D8';
      				point = new google.maps.LatLng(centroidX,centroidY);
      			}
      			else
      			{
      				image = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld='+casecount+'|ff776b';
      				point = new google.maps.LatLng(centroidX,centroidY+0.0010);
      			}
      			createMarker(map,point,image,html,null,true,false);
      			nodeInfoCounter++;
      	//-------------------*/
         	if(!isOld)
      	bermudaTriangle.setMap(map);
      	
      }

      function mapLarvalOverlay(map,distance,datax,isOld) //Larvalpositive nodes display
      {
      	var dist = splitter(distance);
      	var data = splitter(datax);
      	for (var i = 0; i < data.length; i++)
      		{
      			nodeType[i] = data[i][0];		
      			refNumber[i] = data[i][1];
      			lat[i] = data[i][2];
      			lng[i] = data[i][3];
      			id[i]=data[i][4];
      			household[i]=data[i][5];
      			container[i]=data[i][6];
      			createdOn[i]=data[i][7];
      		}//alert(lat);
      		
          for (var i = 0; i < data.length; i++) 
          {
      	    var amount50a="fail";
      	    var amount50p="fail";
      	    var amount200a="fail";
      	    var amount200p="fail";
      	    for(var _i=0; _i < data.length; _i++)
      	    {
      		    //alert("Comparing "+id[i]+" to "+dist[_i][0]);
      		    if(id[i]===dist[_i][0])
      		    {
      		    	 amount50a=dist[_i][1];
      				 amount50p=dist[_i][2];
      				 amount200a=dist[_i][3];
      				 amount200p=dist[_i][4];
      		    }
      	    }			            
          	var type = nodeType[i];
          	var householdcount=0;
          	var containercount=0;
          	var householdpercent;
          	var containerpercent;
          	for(var __i=0; __i < household.length;__i++)
          	{
              	if(household[i]===household[__i])
              	{
              		householdcount++;
              	}
          	}
          	for(var __i=0; __i < container.length;__i++)
          	{
              	if(container[i]===container[__i])
              	{
              		containercount++;
              	}
          	}
          	householdpercent=householdcount/household.length*100;
          	containerpercent=containercount/container.length*100;
         		var point = new google.maps.LatLng(
              	lat[i],
              	lng[i]);
          	var html = "<b>Larval Survey Report #: </b>" + refNumber[i] +" <i>("+createdOn[i]+")</i>"
          	+ " <br/>" + "<b>Tracking #: </b>" + dist[i][0]
          	+ " <br/>" + "<b>Larval positives (LP) within: </b>"
          	+ " <br/>" + "<b>200m:</b>" + amount50a+" ("+ amount50p+"% of displayed LP)"
          	+ " <br/>" + "<b>50m:</b>" + amount200a+" ("+ amount200p+"% of displayed LP)"
          	+ "<br/><br/>" + "<b>Household: </b>" + household[i]+" ("+ householdcount+" of "+ household.length +" total occurrences, "+householdpercent.toFixed(2)+"%)"
          	+ " <br/>" + "<b>Container: </b>" + container[i]+" ("+ containercount+" of "+ container.length +" total occurances, "+containerpercent.toFixed(2)+"%)";
         		//var icon = customIcons[type] || {};
         		var bounce;
         		if((amount50p>=25)||(amount200p>=50))
        			bounce = 1;
        		else
        			bounce = null;
        		var image = null;
        		var circle = null;
      		if(isOld)
      		{
      	 		createMarker(map,point,image,html,bounce,true,false);
      	 		circle = new google.maps.Circle({
      				center:point,
      				radius:200,
      				strokeColor:"#66CCCC",
      				strokeOpacity:0.7,
      				strokeWeight:1,
      				fillColor:"#66CCCC",
      				fillOpacity:0.05,
      				clickable:false
      			});
      		}
      		else
      		{
      	 		createMarker(map,point,image,html,bounce,false,false);
      	 		circle = new google.maps.Circle({
      				center:point,
      				radius:200,
      				strokeColor:"#0000FF",
      				strokeOpacity:0.7,
      				strokeWeight:1,
      				fillColor:"#0000FF",
      				fillOpacity:0.05,
      				clickable:false
      			});
      		}
      			
      		circle.setMap(map); 
      	}
      }
      	
      function load() {
      	var map = new google.maps.Map(document.getElementById("map"), {
      		center: new google.maps.LatLng(14.301716, 120.942506),
      		zoom: 14,
      		mapTypeId: 'hybrid'
      	});
      	mapPointsOfInterest(map);
          	
      	if(document.getElementById('type').value.toString()=="larvalpositive")
          {
              mapLarvalOverlay(map,document.getElementById('dist').value,document.getElementById("data").value,false);
          }
      	else if(document.getElementById('type').value.toString()=="denguecase")
      	{
      		mapBarangayOverlay(map,document.getElementById('dataBCount').value.toString(),document.getElementById('dataBAge').value.toString(),document.getElementById('data').value.toString(),document.getElementById('dataBInfo').value.toString(),false);
          }
      	else
      	{
          	//*Data handler, SPLITTER
      		var str = document.getElementById('data').value.toString();
      		str = str.split("%&");
      		//-------------------*/
      		
      		mapLarvalOverlay(map,document.getElementById('dist').value.toString(),str[0],false);
      		mapBarangayOverlay(map,document.getElementById('dataBCount').value.toString(),document.getElementById('dataBAge2').value.toString(),str[1],document.getElementById('dataBInfo').value.toString(),false);
      	}
      }
        function doNothing() {}

      google.maps.event.addDomListener(window, 'load', initialize);
      </script>

      <script type="text/javascript">
      jQuery(document).ready(function(){
      	  $("#old").change(function() {
      		  if($("#old").val()==1)
      		  {
      			  var map = new google.maps.Map(document.getElementById("map"), {
      					center: new google.maps.LatLng(14.301716, 120.942506),
      					zoom: 14,
      					mapTypeId: 'hybrid'
      				});
      				mapPointsOfInterest(map);
      			    	
      				if(document.getElementById('type').value.toString()=="larvalpositive")
      			    {
      					mapLarvalOverlay(map,document.getElementById('dist').value,document.getElementById("data").value,false);
      			        mapLarvalOverlay(map,document.getElementById('Pdist').value,document.getElementById("Pdata").value,true);
      			    }
      				else if(document.getElementById('type').value.toString()=="denguecase")
      				{
      					mapBarangayOverlay(map,document.getElementById('dataBCount').value.toString(),document.getElementById('dataBAge').value.toString(),document.getElementById('data').value.toString(),document.getElementById('dataBInfo').value.toString(),false);
      					mapBarangayOverlay(map,document.getElementById('PdataBCount').value.toString(),document.getElementById('PdataBAge2').value.toString(),document.getElementById('Pdata').value.toString(),document.getElementById('PdataBInfo').value.toString(),true);
      			    }
      				else
      				{
      			    	//*Data handler, SPLITTER
      					var str = document.getElementById('data').value.toString();
      					str = str.split("%&");
      					var Pstr = document.getElementById('Pdata').value.toString();
      					Pstr = Pstr.split("%&");
      					//-------------------*/
      					
      					mapLarvalOverlay(map,document.getElementById('dist').value.toString(),str[0],false);
      					mapLarvalOverlay(map,document.getElementById('Pdist').value.toString(),Pstr[0],true);
      					mapBarangayOverlay(map,document.getElementById('dataBCount').value.toString(),document.getElementById('dataBAge').value.toString(),str[1],document.getElementById('dataBInfo').value.toString(),false);
      					mapBarangayOverlay(map,document.getElementById('PdataBCount').value.toString(),document.getElementById('PdataBAge2').value.toString(),Pstr[1],document.getElementById('PdataBInfo').value.toString(),true);
      				}
      		  }
      		  else
      		  {
      			  load();
      		  }
      	  });
      	});
    </script>
  <div class="body">
   <center>
   <h3>Epidemic Threshold shown in Percentage</h3>
   <div id="visualization" style="width: 600px; height: 150px;"></div>
   <h3>Dengue Cases Summary</h3>
    <div id="dashboard">
      <table>
        <tr style='vertical-align: top'>
          <td style='width: 300px; font-size: 0.9em;'>
            <div id="control1"></div>
            <div id="control2"></div>
            <div id="control3"></div>
          </td>
          <td>
            <div style="float: left;" id="chart1"></div>
            <div style="float: left;" id="chart2"></div>
            <div style="float: left;" id="chart3"></div>
          </td>
        </tr>
      </table>
    </div>
   <div id='chart_div'></div>
   <div id='chart_div2'></div>
   <div><h5>*1 means perfect correlation, 0 means no correlation, positive values means the relationship is positive (when one goes up so does the other), negative values mean the relationship is negative (when one goes up the other goes down)
   </h5></div>
   
   

<?php 
$attributes = array(
						'id' => 'TPcr-form'
					);
echo form_open('CHO/tweet',$attributes); ?>

		<div class="blog">

<input type="hidden" name="table_data" id="table_data" value="<?php echo $table_data; ?>" />
<input type="hidden" name="barangay_count" id="barangay_count" value="<?php echo $barangay_count; ?>" />
<input type="hidden" name="age_count" id="age_count" value="<?php echo $age_count; ?>" />
<input type="hidden" name="quartile" id="quartile" value="<?php echo $quartile; ?>" />
<input type="hidden" name="csum" id="csum" value="<?php echo $csum; ?>" />
<input type="hidden" name="m2sd" id="m2sd" value="<?php echo $m2sd; ?>" />
<input type="hidden" name="csum196sd" id="csum196sd" value="<?php echo $csum196sd; ?>" />
<input type="hidden" name="cases" id="cases" value="<?php echo $cases; ?>" />
<input type="hidden" name="larval" id="larval" value="<?php echo $larval; ?>" />
<input type="hidden" name="immediate_cases" id="immediate_cases" value="<?php echo $immediate_cases; ?>" />

<input type="hidden" name="tquartile" id="tquartile" value="" />
<input type="hidden" name="tcsum" id="tcsum" value="" />
<input type="hidden" name="tm2sd2" id="tm2sd2" value="" />
<input type="hidden" name="tcsum196sd" id="tcsum196sd" value="" />
<input type="hidden" name="tcases" id="tcases" value="" />


<input type = 'hidden' id ='data' name='data' value='<?php echo $nodes?>'>
<input type = 'hidden' id ='dataBInfo' name='dataBInfo' value='<?php echo $binfo?>'>
<input type = 'hidden' id ='dataBAge' name='dataBAge' value='<?php echo $table1?>'>
<input type = 'hidden' id ='dataBAge2' name='dataBAge2' value='<?php echo $bage?>'>
<input type = 'hidden' id ='dataBCount' name='dataBCount' value='<?php echo $bcount?>'>
<input type = 'hidden' id ='type' name='type' value='<?php echo $node_type?>'>
<input type = 'hidden' id ='dist' name='dist' value='<?php echo $dist?>'>

<input type = 'hidden' id ='interest' name='interest' value='<?php echo $interest?>'>

<input type = 'hidden' id ='Pdata' name='Pdata' value='<?php echo $Pnodes?>'>
<input type = 'hidden' id ='PdataBInfo' name='PdataBInfo' value='<?php echo $Pbinfo?>'>
<input type = 'hidden' id ='PdataBAge' name='PdataBAge' value='<?php echo $table2?>'>
<input type = 'hidden' id ='PdataBAge2' name='PdataBAge2' value='<?php echo $Pbage?>'>
<input type = 'hidden' id ='PdataBCount' name='PdataBCount' value='<?php echo $Pbcount?>'>
<input type = 'hidden' id ='Ptype' name='Ptype' value='<?php echo $node_type?>'>
<input type = 'hidden' id ='Pdist' name='Pdist' value='<?php echo $Pdist?>'>

<body onload="load()">
<h4>Larval Positives</h4>
<table border="1" width=70%>
<tr>
	<td style="width:100%; height:600px" rowspan="2">
	    <div id="map" style="width: 100%%; height: 600px"></div>
	</td>
</tr>
		<table>
		<tr>
		<td>
			<h5>Legend</h5>
		</td>
		</tr>
		<tr>
		<td><img border="0" src="http://maps.google.com/mapfiles/marker.png"></td>
		<td>Larval sampling, current search data. Bounces when 25% of all nodes returned by the search is within 50 meters or if 50% are within 200 meters.</td>
		</tr>	
		<tr>
			<td><img border="0" src="http://maps.google.com/mapfiles/ms/micons/ltblue-dot.png"></td>
			<td>"Old" Larval sampling. Same as previous, but uses old search data. <i>(Optionally activated)</i></td>
		</tr>	
		<tr>
			<td><img border="0" src="http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=S|FF0000|000000"></td>
			<td>Point of interest. Possible source of Mosquitoes.</td>
		</tr>	
		<tr>
			<td><img border="0" src="http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=R|FF0000|000000"></td>
			<td>Point of interest. Possible risk area susceptible to Mosquito bites.</td>
		</tr>	
		<tr>
			<td><img border="0" src="http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=4|ff776b"></td>
			<td>Barangay marker, number is the amount of dengue cases for the period. Commonly located at the center of the barangay boundary. For irregularly shaped barangays, the location may vary.</td>
		</tr>
		<tr>
			<td><img border="0" src="http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=4|8FD8D8"></td>
			<td>"Old" Barangay Marker. Same as previous, but uses old search data. Located beside Barangay Marker <i>(Optionally activated)</i></td>
		</tr>
		</table>
	</td>
</tr>
</table>
</body>
</div>
<center>
<h3>Immediate Cases found during the week by BHW</h3>
<div id='table_div1' align="center"></div>
</center>
<br />
<h4><center>Tweet Status</center></h4>
<table  border="1"  align="center">

<tr>
	<td><input type="radio" name="tweettype" value="epi" checked = "true"/></td>
    <td>Epidemic Threshold</td> 
    <td><input type="radio" name="epitype" value="quartile" checked = "true" /> 3rd Quartile <br/>
	<input type="radio" name="epitype" value="csum" /> C-SUM <br/>
	<input type="radio" name="epitype" value="mean2sd" /> mean+2SD <br/>
	<input type="radio" name="epitype" value="csum196sd" /> C-SUM+1.96SD <br/></td>
  </tr>
  <tr>
  <td ><input type="radio" name="tweettype" value="count" /></td>
  <td>No. Of Cases</td>
  <td></td>
  </tr>
  <tr>
  <td><input type="radio" name="tweettype" value="fact" checked = "true"/></td>
  <td>Random Fact about Dengue</td>
  <td></td>
  </tr>
  <tr>
  <td><input type="radio" name="tweettype" value="msg" checked = "true"/></td>
  <td>Custom Tweet</td>
  <td width = "500"><input type="text"  name= "customtweet" value="" style="width:500px;"/></td>
  </tr>
</table>
<input type="submit" class="submitButton" value="Tweet"/><?php echo form_close(); ?>
</center>
</div>


<?php $this->load->view('templates/footer'); ?>
</html>

	

function mapBarangayOverlay(map,barangayCount,barangayAge,datax,barangayInfo,isOld) //Denguecase barangay polygon display
{
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
           {
			var bermudaTriangle = new google.maps.Polygon(
					{
						paths: latLng,
						fillColor: "#FF0000",
						fillOpacity:0.3,
						clickable:false
					});
			bermudaTriangle.setMap(map);
           }
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
    {
    	var bermudaTriangle = new google.maps.Polygon(
    			{
    				paths: latLng,
    				fillColor: "#FF0000",
    				fillOpacity:0.3,
    				clickable:false
    			});
    	bermudaTriangle.setMap(map);
    }
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
	
}
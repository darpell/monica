
var refNumber = new Array();
//var nodeType = new Array();
var lat = new Array();
var lng = new Array();
var id=new Array();
var household = new Array();
var container = new Array();
var createdOn = new Array();
var updatedOn = new Array();
var lbarangay = new Array();
var lstreet = new Array();
var createdBy = new Array();

function mapLarvalOverlay(map,distance,datax,isOld) //Larvalpositive nodes display
{
	var dist = splitter(distance);
	var data = splitter(datax);
	for (var i = 0; i < data.length; i++)
		{
			//nodeType[i] = data[i][0];		
			refNumber[i] = data[i][1];
			lat[i] = data[i][2];
			lng[i] = data[i][3];
			id[i]=data[i][4];
			household[i]=data[i][5];
			container[i]=data[i][6];
			createdOn[i]=data[i][7];
			updatedOn[i]=data[i][8];
			lbarangay[i]=data[i][9];
			lstreet[i]=data[i][10];
			createdBy[i]=data[i][11];
		}//alert(lat);
		
	var tempArrz=countInstances(lbarangay);
		
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
    	var amt=0;
		for(var ii=0; ii<tempArrz.length;ii++)
		{
			if(tempArrz[0][ii]==lbarangay[i])
				amt=tempArrz[1][ii];
		}
    	
    	var html = "<b>Larval Survey Report #: </b>" + refNumber[i] +" <i>("+createdOn[i]+")</i>"
    	+ " <br/>" + "<b>Tracking #: </b>" + dist[i][0]
    	+ " <br/>" + "<b>Larval positives (LP) within: </b>"
    	+ " <br/>" + "<b>200m:</b>" + amount50a+" ("+ amount50p+"% of displayed LP)"
    	+ " <br/>" + "<b>50m:</b>" + amount200a+" ("+ amount200p+"% of displayed LP)"
    	+ "<br/><br/>" + "<b>Household: </b>" + household[i]+" ("+ householdcount+" of "+ household.length +" total occurrences, "+householdpercent.toFixed(2)+"%)"
    	+ " <br/>" + "<b>Container: </b>" + container[i]+" ("+ containercount+" of "+ container.length +" total occurances, "+containerpercent.toFixed(2)+"%)";

		html=html+"<br/><br/><b>Location: </b>Barangay "+lbarangay[i]+", "+lstreet[i]+" Street."
    	+ " <br/>" + "<b>Amount per barangay: </b>" + amt
    	+ " <br/>" + "<b>Amount total: </b>" + container.length
		+ "<br/>" + "<i>Created on "+createdOn[i]
		+ " last updated on "+updatedOn[i]+"</i>";
   		//var icon = customIcons[type] || {};
   		var bounce;
   		if((amount50p>=5)||(amount200p>=15))
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
	
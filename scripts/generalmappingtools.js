function createMarker(map,point,image,info,bounce,isOld,isPoI,RiskOrSource)
{//General marker creation
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
		centroidMarker = new google.maps.Marker({  
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
	  
	google.maps.event.addListener(centroidMarker, 'click', function() {
		infoWindow.setContent(info);
		infoWindow.open(map, this);
	});
	
		google.maps.event.addListener(centroidMarker, 'click', function() {
			loadXMLDoc(info);
	});
}

function mapPointsOfInterest(googleMap)
{
	var tempo=splitter(document.getElementById("interest").value.toString());
	var length=tempo.length;
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


<!-- HEADER -->
<?php $this->load->view('templates/header');?>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script> 
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?v=3&sensor=true"></script>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?v=3&libraries=weather,visualization&sensor=true"></script>
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />

 <script>

 function load() {
		//alert("Present: "+document.getElementById("presRemvd").value+" remvd "+document.getElementById("present_length").value+" remain");
		//alert("Old: "+document.getElementById("oldRemvd").value+" remvd "+document.getElementById("old_length").value+" remain");
		var dasma = new google.maps.LatLng(14.2990183, 120.9589699);
		var heatmap, map;
		var mapProp = {
			center: dasma,
			zoom: 12,
			mapTypeId: google.maps.MapTypeId.HYBRID
		};
		map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
			var cases = new Array();
		
		/** Sample Larval Data used as case data **/
		if ((document.getElementById("present_length").value != 0)||(document.getElementById("old_length").value != 0))
		{//alert("0");
			//var case_img = document.getElementById("case_icon").value;
			if(document.getElementById("present_length").value != 0)
			for (var pt_ctr = 0; pt_ctr < document.getElementById("present_length").value; pt_ctr++) 
			{	//alert("1");				
				cases.push(new google.maps.LatLng(
						document.getElementById("lsPres_lat" + pt_ctr).value,
						document.getElementById("lsPres_lng" + pt_ctr).value
						));
			}
			if(document.getElementById("old_length").value != 0)
			for (var pt_ctr = 0; pt_ctr < document.getElementById("old_length").value; pt_ctr++) 
			{	//alert("2");						
				cases.push(new google.maps.LatLng(
						document.getElementById("lsOld_lat" + pt_ctr).value,
						document.getElementById("lsOld_lng" + pt_ctr).value
						));
			}
			pointArray = new google.maps.MVCArray();
			heatmap = new google.maps.visualization.HeatmapLayer({
				  data: cases
				});
				heatmap.setMap(map);
		}
		/** end of sample data**/
	}
 
$(function() {
$( "#tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
$( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
});
</script>
<style>
.ui-tabs-vertical { width: 55em; }
.ui-tabs-vertical .ui-tabs-nav { padding: .2em .1em .2em .2em; float: left; width: 12em; }
.ui-tabs-vertical .ui-tabs-nav li { clear: left; width: 100%; border-bottom-width: 1px !important; border-right-width: 0 !important; margin: 0 -1px .2em 0; }
.ui-tabs-vertical .ui-tabs-nav li a { display:block; }
.ui-tabs-vertical .ui-tabs-nav li.ui-tabs-active { padding-bottom: 0; padding-right: .1em; border-right-width: 1px; border-right-width: 1px; }
.ui-tabs-vertical .ui-tabs-panel { padding: 1em; float: right; width: 40em;}
</style>
</head>
<!-- CONTENT -->
<div class="body" onload="aveMap()">
			<div id="tabs">
				<ul>
					<li><a href="#tabs-1"> Route Information </a></li>
					<li><a href="#tabs-2"> Event Calendar </a></li>
					<li><a href="#tabs-3"> Larval Occurrences</a></li>
				</ul>
				<div id="tabs-1">
					<h2> Route Information </h2>
					<?php 
						echo $this->table->generate($query);
					?>
				</div>
				<div id="tabs-2">
					<h2> Event Calendar </h2>
					<p>Morbi tincidunt, dui sit amet facilisis feugiat, odio metus gravida ante, ut pharetra massa metus id nunc. Duis scelerisque molestie turpis. Sed fringilla, massa eget luctus malesuada, metus eros molestie lectus, ut tempus eros massa ut dolor. Aenean aliquet fringilla sem. Suspendisse sed ligula in ligula suscipit aliquam. Praesent in eros vestibulum mi adipiscing adipiscing. Morbi facilisis. Curabitur ornare consequat nunc. Aenean vel metus. Ut posuere viverra nulla. Aliquam erat volutpat. Pellentesque convallis. Maecenas feugiat, tellus pellentesque pretium posuere, felis lorem euismod felis, eu ornare leo nisi vel felis. Mauris consectetur tortor et purus.</p>
				</div>
				<div id="tabs-3">
					<h2> Larval Occurrences</h2>
					<div id="googleMap" style="width: 100%; height: 350px"></div>
					<?php if ($presentDataExists === true){$ctr=0;?>
					<input type="hidden" id="present_length" value="<?php echo count($presentData); ?>" />
						<?php foreach ($presentData as $value) {?>
							<input type="hidden" id="lsPres_lat<?= $ctr ?>" 		value="<?php echo $value['ls_lat']; ?>"	/>
							<input type="hidden" id="lsPres_lng<?= $ctr ?>" 		value="<?php echo $value['ls_lng']; ?>"	/>
							<input type="hidden" id="lsPres_household<?= $ctr ?>" 		value="<?php echo $value['ls_household']; ?>"	/>
							<input type="hidden" id="lsPres_street<?= $ctr ?>" 		value="<?php echo $value['ls_street']; ?>"	/>
							<input type="hidden" id="lsPres_barangay<?= $ctr ?>" 		value="<?php echo $value['ls_barangay']; ?>"	/>
							<input type="hidden" id="lsPres_container<?= $ctr ?>" 		value="<?php echo $value['ls_container']; ?>"	/>
							<input type="hidden" id="lsPres_date<?= $ctr ?>" 		value="<?php echo $value['ls_date']; ?>"	/>
							<input type="hidden" id="lsPres_createdby<?= $ctr ?>" 		value="<?php echo $value['created_by']; ?>"	/>
						<?php $ctr++;}?> 
						<?php } else { ?> <input type="hidden" id="present_length" value="0" /> <?php } ?>
					
					<?php if ($oldDataExists === true){$ctr=0;
							echo "<p>There are ".count($oldData)." areas that have consistent repeating larval samplings for this season over the past 2 years.<br/>These areas are: </p>";?>
					<input type="hidden" id="old_length" value="<?php echo count($oldData); ?>" />
						<?php foreach ($oldData as $value) {?>
							<input type="hidden" id="lsOld_lat<?= $ctr ?>" 		value="<?php echo $value['ls_lat']; ?>"	/>
							<input type="hidden" id="lsOld_lng<?= $ctr ?>" 		value="<?php echo $value['ls_lng']; ?>"	/>
							<input type="hidden" id="lsOld_household<?= $ctr ?>" 		value="<?php echo $value['ls_household']; ?>"	/>
							<input type="hidden" id="lsOld_street<?= $ctr ?>" 		value="<?php echo $value['ls_street']; ?>"	/>
							<input type="hidden" id="lsOld_barangay<?= $ctr ?>" 		value="<?php echo $value['ls_barangay']; ?>"	/>
							<input type="hidden" id="lsOld_container<?= $ctr ?>" 		value="<?php echo $value['ls_container']; ?>"	/>
							<input type="hidden" id="lsOld_date<?= $ctr ?>" 		value="<?php echo $value['ls_date']; ?>"	/>
							<input type="hidden" id="lsOld_createdby<?= $ctr ?>" 		value="<?php echo $value['created_by']; ?>"	/>
						<?php echo "(".($ctr+1).") ".$value['ls_household']." household at ".$value['ls_street']." Street, ".$value['ls_barangay'].".<br/>"; $ctr++;}?>
						<?php } else { ?> <input type="hidden" id="old_length" value="0" /> <?php } ?>
				</div>
			</div>
			
	</div>
	

	
<body onload="load()">
<!-- FOOTER -->
<?php $this->load->view('templates/footer');?>
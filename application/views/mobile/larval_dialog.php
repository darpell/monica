<!-- HEADER -->
<?= $this->load->view('/mobile/templates/mob_header') ?>

<!-- CONTENT -->
</head> 
<body> 

<div data-role="page">
	<script type="text/javascript">
        $("div:jqmData(role='page'):last").bind('pageinit', function() {
        	$('#brgy_div').hide();
        	$('#city_div').hide();
        	$('#street_div').hide();
        });
	</script>
		<div data-role="header">
			<a href="<?php echo site_url('mobile/riskmap');?>" data-ajax="false" data-icon="delete"> Back </a>
			<h1>Filter Larval Nodes</h1>
		</div>

		<div data-role="content" data-theme="c">
			<form action="larval_dialog" method="post" data-ajax="false">
			<label for="place-ddl" class="select"> Filter by: </label>
				<select id="place-ddl" name="place-ddl" data-mini="true">
				   <option value="NULL"> None </option>
				   <option value="street"> Street </option>
				   <option value="brgy"> Barangay </option>
				   <option value="city"> City </option>
				</select>
				
				<script>
					$('#place-ddl').change(function(){
						value = $('#place-ddl').val();
						if (value == 'street')
						{
							$('#brgy_div').hide();
							$('#city_div').hide();
							$('#street_div').show();
						}
						else if (value == 'brgy')
						{
							$('#brgy_div').show();
							$('#city_div').hide();
							$('#street_div').hide();
						}
						else if (value == 'city')
						{
							$('#brgy_div').hide();
							$('#city_div').show();
							$('#street_div').hide();
						}
						else
						{
							$('#brgy_div').hide();
							$('#city_div').hide();
							$('#street_div').hide();
						}
					});
				</script>
				
				<div id="brgy_div">
					<select id="brgy_op" name="brgy_op" data-mini="true">
						<?php for ($ctr = 0; $ctr < count($brgys); $ctr++) {?>
						<option value="<?= $brgys[$ctr]['ls_barangay'] ?>"> <?= $brgys[$ctr]['ls_barangay'] ?> </option>
						<?php }?>
					</select>
				</div>
				
				<div id="street_div">
					<select id="street_op" name="street_op" data-mini="true">
						<?php for ($ctr = 0; $ctr < count($streets); $ctr++) {?>
						<option value="<?= $streets[$ctr]['ls_street'] ?>"> <?= $streets[$ctr]['ls_street'] ?> </option>
						<?php }?>
					</select>
				</div>
				
				<div id="city_div">
					<select id="city_op" name="city_op" data-mini="true">
						<?php for ($ctr = 0; $ctr < count($cities); $ctr++) {?>
						<option value="<?= $cities[$ctr]['ls_municipality'] ?>"> <?= $cities[$ctr]['ls_municipality'] ?> </option>
						<?php }?>
					</select>
				</div>
			    
			    <!-- TODO
				    http://pastebin.com/dtyVuy5H
				    http://stackoverflow.com/questions/13568969/get-jquery-mobile-datebox-running-typeerror-a-mobile-datebox-is-undefined
			     -->
				<label for="begin_date"> From: </label>
				<input name="begin_date" id="begin_date" type="date" data-role="datebox" data-options='{"mode":"calbox", "beforeToday": true, "calShowWeek": true, "calUsePickers": true, "calNoHeader": true, "noButtonFocusMode": true, "useNewStyle":true}' />
			    
			    <label for="end_date"> To: </label>
				<input name="end_date" id="end_date" type="date" data-role="datebox" data-options='{"mode":"calbox", "beforeToday": true, "calShowWeek": true, "calUsePickers": true, "calNoHeader": true, "useTodayButton": true, "noButtonFocusMode": true, "useNewStyle":true}' />
					
			    <input type="submit" value="Submit" />    
			    </form>
		</div>
</div>

</body>
</html>
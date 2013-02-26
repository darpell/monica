<!-- HEADER -->
<?= $this->load->view('/mobile/templates/mob_header') ?>

<!-- CONTENT -->
<script language="javascript" type="text/javascript" src="<?php echo base_url('/scripts/datetimepicker.js'); ?>"></script>
</head> 
<body> 

<div data-role="dialog">
	
		<div data-role="header" data-theme="d">
			<h1>Filter Larval Nodes</h1>

		</div>

		<div data-role="content" data-theme="c">
			<form action="mobile/larval_dialog" method="post">
			<label for="place-ddl" class="select"> Filter by: </label>
				<select id="place-ddl" name="place-ddl" data-mini="true">
				   <option value="NULL"> None </option>
				   <option value="street"> Street </option>
				   <option value="brgy"> Barangay </option>
				   <option value="city"> City </option>
				</select>
			    
				<label for="begin_date"> From: </label>
				<input name="begin_date" id="begin_date" type="text" data-role="datebox" data-options='{"mode":"calbox", "useNewStyle":true}' />
			    
			    <label for="end_date"> To: </label>
				<input name="end_date" id="end_date" type="text" data-role="datebox" data-options='{"mode":"calbox", "useNewStyle":true}' />
					
			    <input type="submit" value="Submit" />
			</form>     
			<a href="<?php echo site_url('mobile/riskmap');?>" data-role="button" data-rel="back" data-theme="c" data-transition="slide"> Cancel </a>    
		</div>
	</div>


</body>
</html>
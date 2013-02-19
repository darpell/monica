<!-- HEADER -->
<?= $this->load->view('/mobile/templates/mob_header') ?>

<!-- CONTENT -->
</head> 
<body> 

<div data-role="dialog">
	
		<div data-role="header" data-theme="d">
			<h1>Filter Larval Nodes</h1>

		</div>

		<div data-role="content" data-theme="c">
			<form action="mobile/larval_dialog" method="post">
			<label for="place-ddl" class="select"> Filter by: </label>
				<select id="place-ddl" data-mini="true">
				   <option value="NULL"> None </option>
				   <option value="street"> Street </option>
				   <option value="brgy"> Barangay </option>
				   <option value="city"> City </option>
				</select>
			    <label> From: </label>
			    <input type="text" style="background-color:#CCCCCC;" name="date1" id="date1" value="01/01/2011" readonly="true" />
			    <a href="javascript:NewCal('date1','mmddyyyy')">
			    	<img src="<?php echo base_url('/application/views/cal.gif'); ?>" width="16" height="16" border="0" alt="Pick a date">
			    </a> 
			    
			    <label> To: </label>
			    <input type="text" style="background-color:#CCCCCC;"name="date2" id="date2" value="01/01/2020" readonly="true" />
			    <a href="javascript:NewCal('date2','mmddyyyy')">
			    	<img src="<?php echo base_url('/application/views/cal.gif'); ?>" width="16" height="16" border="0" alt="Pick a date">
			    </a>
			    <input type="submit" value="Submit" />
			</form>     
			<a href="<?php echo site_url('mobile/riskmap');?>" data-role="button" data-rel="back" data-theme="c" data-transition="slide"> Cancel </a>    
		</div>
	</div>


</body>
</html>
<!-- HEADER -->
<?php $this->load->view('templates/header');?>

<!-- CONTENT -->
<?php 
//$attributes = array(
//						'id' => 'TPcr-form'
//					);
echo form_open('mapping/mapByType'); //*/
?>
<h3>Mapping Information</h3>

<label style="color:red"></label>
		<div id="info" class="info"><h4>
		Select 'denguecase' to view dengue cases per area.<br />
		Select 'larvalpositive' to view positive larval samplings.<br />
		Select 'both' to view overlays displaying both larval positives and dengue cases.<br />
		</h4></div>
	<?php 
		$options=array(
			"denguecase"=>"denguecase",
			"larvalpositive"=>"larvalpositive",
			"both"=>"both"
		);
		echo form_dropdown('NDtype-ddl', $options, $options["denguecase"]);
	?>
		<br />
		<br />
		
	    Search Date
	    From: <input type="text" style="background-color:#CCCCCC;" name="date1" id="date1" value="01/01/2011" readonly="true" /><a href="javascript:NewCal('date1','mmddyyyy')"><img src="<?php echo  $this->config->item('base_url'); ?>/application/views/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
	    To: <input type="text" style="background-color:#CCCCCC;"name="date2" id="date2" value="01/01/2020" readonly="true" /><a href="javascript:NewCal('date2','mmddyyyy')"><img src="<?php echo $this->config->item('base_url'); ?>/application/views/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a> <br />
 		<br />
		<br />
<div><input type="submit" value="Submit" /></div>

</form>

<!-- FOOTER -->
<?php $this->load->view('templates/footer');?>
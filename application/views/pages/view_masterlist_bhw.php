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
$(function() {
	var hv = $('#selected').val();
	hv =  parseInt(hv);
$( "#accordion" ).accordion({active : hv});
});
</script>
 

 <body>
 
 <center>
 <h2>Catchment Area</h2>
 </center>
 <br>
 <br>
<div id="accordion">
<?php 
$ctr =0 ;
foreach($households as $row)
{
echo '<h3>'.$row['house_no'].' '.$row['street'].' - '. $row['household_name'] .'</h3>';
if($selected ==$row['household_id'] )
echo '<div data-options="selected:true" >';
else
echo '<div data-options="selected:true" >';

$this->table->set_heading(
		array(	'Name',
				'Birthday',
				'Gender',
				'Marital Status',
				'Nationality',
				'Blood Type'
		));
echo $this->table->generate($masterlist[$row['household_id']]);
$attributes = array(
						'id' => 'TPcr-form'
					);
echo form_open('master_list/add_masterlist_bhw',$attributes); 

?>

<input type="hidden" name="house_id" id="house_id" value="<?php echo $row['household_id']; ?>" />
<input type="hidden" name="ctr<?php echo $row['household_id']; ?>" id="ctr" value="<?php echo $ctr ?>" />

 <table    align="center" cellpadding="5" style="width: 100%;">
  <tr>
  <td colspan = "7">
  <center><b>Add member</b></center>

  </td>
  </tr>
  
   <tr>
        <td >First Name:</td>
    <td>
    <label style="color:red"><?php echo form_error('TPname-txt'.$row['household_id']); ?></label>
     <input type="text" name="TPname-txt<?php echo $row['household_id']; ?>" value="<?php echo set_value('patientno'); ?>"  size="30"/>
     </td>
        <td >last Name:</td>
    <td>
    <label style="color:red"><?php echo form_error('TPlname-txt'.$row['household_id']); ?></label>
     <input type="text" name="TPlname-txt<?php echo $row['household_id']; ?>" value="<?php echo set_value('patientno'); ?>"  size="30"/>
     </td>

    
    <td >birthday:</td>
    <td>
<label style="color:red"><?php echo form_error('TPbirthdate-txt'.$row['household_id']); ?></label>
<input type="text" name="TPbirthdate-txt<?php echo $row['household_id']; ?>" readonly = "true" id = "date1<?php echo $row['household_id']; ?>" value=""  onClick = "javascript:NewCal('date1<?php echo $row['household_id']; ?>','mmddyyyy')" />
    
     </td>
     
  </tr>
  
    
     
        <td >Gender:</td>
    <td>
		 <label style="color:red"><?php echo form_error('TPsex-dd'.$row['household_id']); ?></label>
		<?php 
		$options = array(
		          'M'  => 'Male',
					'F'    => 'Female'
		                );
		$js = 'id="TPsex-dd"';
		echo form_dropdown('TPsex-dd'. $row['household_id'], $options, 'male',$js);
		?>
     </td>
     
        <td >Marital Status:</td>
    <td>
    <label style="color:red"><?php echo form_error('TPstatus-txt'.$row['household_id']); ?></label>
     <input type="text" name="TPstatus-txt<?php echo $row['household_id']; ?>" value="<?php echo set_value('patientno'); ?>"  size="30"/>
     </td>

    
    <td >Nationality:</td>
    <td>
<label style="color:red"><?php echo form_error('TPnation-txt'.$row['household_id']); ?></label>
<input type="text" name="TPnation-txt<?php echo $row['household_id']; ?>" />
    
     </td>
      </tr>
       <tr>
         <td >blood type:</td>
    <td>
		<?php 
		$options = array(

       					'null'  => '',
		                'O'    => 'O',
						'AB'  => 'AB',
						'A'    => 'A',
						'B'  => 'B',
		                );
		$js = 'id="TPblood-dd"';
		echo form_dropdown('TPblood-dd'.$row['household_id'], $options, 'male',$js);
		?>
     </td>
  </tr>
	</table>
	<center>
  <input type="submit" class="submitButton" value="Add"/><?php echo form_close(); ?>
 </center>
<?php
echo '</div>';
$ctr++;
}
?>
</div>

<br>
 <table    align="center" cellpadding="5" style="width: 100%;">

<?php 
$attributes = array(
						'id' => 'TPcr-form'
					);
echo form_open('master_list/view_household_bhw',$attributes); ?>
   <tr>
  <td colspan = "7">
  <center><b>Household Details</b></center>

  </td>
  </tr>
    <tr>
        <td >Household:</td>
    <td>
    <label style="color:red"><?php echo form_error('TPhousehold-txt'); ?></label>
     <input type="text" name="TPhousehold-txt" value="<?php echo set_value('patientno'); ?>"  size="50"/>
     </td>

    
    <td >House no:</td>
    <td>
    <label style="color:red"><?php echo form_error('TPhouseno-txt'); ?></label>
     <input type="text" name="TPhouseno-txt" value="<?php echo set_value('patientno'); ?>"  />
     </td>
     
         <td >Street:</td>
    <td>
    <label style="color:red"><?php echo form_error('TPstreet-txt');?></label>
     <input type="text" name="TPstreet-txt" value="<?php echo set_value('patientno'); ?>" size="50" />
     </td>
  </tr>
  <tr>
  <td colspan = "7">
  <center><b> Head of Household</b></center>

  </td>
  </tr>
  
   <tr>
        <td >First Name:</td>
    <td>
    <label style="color:red"><?php echo form_error('TPname-txt'); ?></label>
     <input type="text" name="TPname-txt" value="<?php echo set_value('patientno'); ?>"  size="30"/>
     </td>
        <td >last Name:</td>
    <td>
    <label style="color:red"><?php echo form_error('TPlname-txt'); ?></label>
     <input type="text" name="TPlname-txt" value="<?php echo set_value('patientno'); ?>"  size="30"/>
     </td>

    
    <td >birthday:</td>
    <td>
<label style="color:red"><?php echo form_error('TPbirthdate-txt'); ?></label>
<input type="text" name="TPbirthdate-txt" readonly = "true" id = "date1" value=""  onClick = "javascript:NewCal('date1','mmddyyyy')" />
    
     </td>
     
  </tr>
  
    
     
        <td >Gender:</td>
    <td>
		 <label style="color:red"><?php echo form_error('TPsex-dd'); ?></label>
		<?php 
		$options = array(
		          'M'  => 'Male',
					'F'    => 'Female'
		                );
		$js = 'id="TPsex-dd"';
		echo form_dropdown('TPsex-dd', $options, 'male',$js);
		?>
     </td>
     
        <td >Marital Status:</td>
    <td>
    <label style="color:red"><?php echo form_error('TPstatus-txt'); ?></label>
     <input type="text" name="TPstatus-txt" value="<?php echo set_value('patientno'); ?>"  size="30"/>
     </td>

    
    <td >Nationality:</td>
    <td>
<label style="color:red"><?php echo form_error('TPnation-txt'); ?></label>
<input type="text" name="TPnation-txt" />
    
     </td>
      </tr>
       <tr>
         <td >blood type:</td>
    <td>
		<?php 
		$options = array(

       					'null'  => '',
		                'O'    => 'O',
						'AB'  => 'AB',
						'A'    => 'A',
						'B'  => 'B',
		                );
		$js = 'id="TPblood-dd"';
		echo form_dropdown('TPblood-dd', $options, 'male',$js);
		?>
     </td>
  </tr>
  
  <input type="hidden" name="selected" id="selected" value="<?php echo $selected; ?>" />
	</table>
	<center>
 <input type="submit" class="submitButton" value="Add Catchment Area"/><?php echo form_close(); ?>
	</center>
 <br>


</body>
<!-- FOOTER -->
<?php $this->load->view('templates/footer');?>
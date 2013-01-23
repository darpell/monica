<!-- HEADER -->
<?php $this->load->view('templates/header');?>

<!-- CONTENT -->
<?php 
$attributes = array(
						'id' => 'TPcr-form'
					);
echo form_open('case_report/addcase',$attributes); ?>
<h3>DRU Information</h3>

 <h5>Region</h5>
<label style="color:red"><?php echo form_error('TPregion-txt'); ?></label>
<input type="text" name="TPregion-txt" value="<?php echo set_value('patientno'); ?>" size="50" />

<h5>Province</h5>
<label style="color:red"><?php echo form_error('TPprovince2-txt'); ?></label>
<input type="text" name="TPprovince2-txt" value="<?php echo set_value('patientno'); ?>" size="50" />

<h5>Name of DRU</h5>
<label style="color:red"><?php echo form_error('TPdru-txt'); ?></label>
<input type="text" name="TPdru-txt" value="<?php echo set_value('patientno'); ?>" size="50" />

<h5>Address</h5>
<label style="color:red"><?php echo form_error('TPaddress-txt'); ?></label>
<input type="text" name="TPaddress-txt" value="<?php echo set_value('patientno'); ?>" size="50" />

<h5>City/Municipality</h5>
<label style="color:red"><?php echo form_error('TPcity2-txt'); ?></label>
<input type="text" name="TPcity2-txt" value="<?php echo set_value('patientno'); ?>" size="50" />


<h3>Patient Info.</h3>

<h5>Patient No.</h5>
<label style="color:red"><?php echo form_error('TPpatientno-txt'); ?></label>
<input type="text" name="TPpatientno-txt" value="<?php echo set_value('patientno'); ?>" size="50" />

<h5>Patient's First Name</h5>
<label style="color:red"><?php echo form_error('TPfirstname-txt'); ?></label>
<input type="text" name="TPfirstname-txt" value="<?php echo set_value('fullname'); ?>" size="50" />

<h5>Patient's Last Name</h5>
<label style="color:red"><?php echo form_error('TPlastname-txt'); ?></label>
<input type="text" name="TPlastname-txt" value="<?php echo set_value('fullname'); ?>" size="50" />


<h5>Age</h5>
<label style="color:red"><?php echo form_error('TPage-txt'); ?></label>
<input type="text" name="TPage-txt" value="<?php echo set_value('age'); ?>" size="50" />

<h5>Sex</h5>
<label style="color:red"><?php echo form_error('TPsex-dd'); ?></label>
<?php 
$options = array(
                  'M'  => 'Male',
                  'F'    => 'Female'
                );
$js = 'id="TPsex-dd"';
echo form_dropdown('TPsex-dd', $options, 'male',$js);
?>

<h5>Date of Birth</h5>
<label style="color:red"><?php echo form_error('birthdate'); ?></label>
<input type="text" name="TPbirthdate-txt" readonly = "true" id = "date1" value="" size="50" /><a href="javascript:NewCal('date1','mmddyyyy')"><img src="<?php echo  $this->config->item('base_url'); ?>/application/views/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>

<h5>Province</h5>
<label style="color:red"><?php echo form_error('TPprovince-txt'); ?></label>
<input type="text" name="TPprovince-txt" value="<?php echo set_value('address'); ?>" size="50" />

<h5>City</h5>
<label style="color:red"><?php echo form_error('TPcity-txt'); ?></label>
<input type="text" name="TPcity-txt" value="<?php echo set_value('address'); ?>" size="50" />

<h5>Barangay</h5>
<label style="color:red"><?php echo form_error('TPbarangay-txt'); ?></label>
<input type="text" name="TPbarangay-txt" value="<?php echo set_value('address'); ?>" size="50" />

<h5>House No. and Street</h5>
<label style="color:red"><?php echo form_error('TPstreet-txt'); ?></label>
<input type="text" name="TPstreet-txt" value="<?php echo set_value('address'); ?>" size="50" />

<h5>Admitted?</h5>
<label style="color:red"><?php echo form_error('TPadmitted-rd'); ?></label>
<input type="radio" name="TPadmitted-rd" value="1" <?php echo set_radio('myradio', '1', TRUE); ?> /> Yes <br/>
<input type="radio" name="TPadmitted-rd" value="2" <?php echo set_radio('myradio', '0'); ?> /> No <br/>

<h5>Date of Consultation</h5>
<label style="color:red"><?php echo form_error('consuldate'); ?></label>
<input type="text" name="TPconsuldate-txt" value="" size="50" id="date2" /><a href="javascript:NewCal('date2','mmddyyyy')"><img src="<?php echo  $this->config->item('base_url'); ?>/application/views/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>

<h5>Date onset of illness</h5>
<label style="color:red"><?php echo form_error('birthdate'); ?></label>
<input type="text" name="TPillnessdate-txt" value="" size="50" id="date3" /><a href="javascript:NewCal('date3','mmddyyyy')"><img src="<?php echo  $this->config->item('base_url'); ?>/application/views/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>

<h5>Case Classification</h5>
<label style="color:red"><?php echo form_error('TPclassification-rd'); ?></label>
<input type="radio" name="TPclassification-rd" value="S" <?php echo set_radio('myradio', 'S', TRUE); ?> /> Suspect <br/>
<input type="radio" name="TPclassification-rd" value="P" <?php echo set_radio('myradio', 'P'); ?> /> Probable <br/>
<input type="radio" name="TPclassification-rd" value="C" <?php echo set_radio('myradio', 'C'); ?> /> Confirmed <br/>

<h5>Type</h5>
<label style="color:red"><?php echo form_error('TPtype-rd'); ?></label>
<input type="radio" name="TPtype-rd" value="DF" <?php echo set_radio('myradio', 'DF', TRUE); ?> /> DF <br/>
<input type="radio" name="TPtype-rd" value="DHF" <?php echo set_radio('myradio', 'DHF'); ?> /> DHF <br/>
<input type="radio" name="TPtype-rd" value="DSS" <?php echo set_radio('myradio', 'DSS'); ?> /> DSS <br/>
<input type="radio" name="TPtype-rd" value="DHF" <?php echo set_radio('myradio', 'WITH WARNING SIGNS'); ?> /> WITH WARNING SIGNS <br/>
<input type="radio" name="TPtype-rd" value="DSS" <?php echo set_radio('myradio', 'NO WARNING SIGNS'); ?> /> NO WARNING SIGNS <br/>

<h5>Outcome</h5>
<label style="color:red"><?php echo form_error('TPoutcome-rd'); ?></label>
<input type="radio" name="TPoutcome-rd" value="A" <?php echo set_radio('myradio', 'A', TRUE); ?> /> Alive <br/>
<input type="radio" name="TPoutcome-rd" value="D" <?php echo set_radio('myradio', 'D'); ?> /> Died <br/>
<input type="radio" name="TPoutcome-rd" value="U" <?php echo set_radio('myradio', 'U'); ?> /> Unknown <br/>

<div><input type="submit" value="Submit" /></div>

</form>
<!-- FOOTER -->
<?php $this->load->view('templates/footer');?>
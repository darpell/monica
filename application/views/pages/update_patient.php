<!-- HEADER -->
<?php $this->load->view('templates/header');?>

<!-- CONTENT -->
<div class="body">
		<div class="blog">
<?php 
$attributes = array(
						'id' => 'TPcr-form'
					);
echo form_open('case_report/update_patient_info',$attributes); ?>

<h3>Patient Info.</h3>

<h5>Patient No.</h5>
<label style="color:red"><?php echo form_error('patientno'); ?></label>
<input type="text" name="TPpatientno-txt" value="<?php echo $info['TPpatientno-txt']; ?>" size="50" readonly = "true" />

<h5>Patient's First Name</h5>
<label style="color:red"><?php echo form_error('fullname'); ?></label>
<input type="text" name="TPfirstname-txt" value="<?php echo $info['TPfirstname-txt'];  ?>" size="50" />

<h5>Patient's Last Name</h5>
<label style="color:red"><?php echo form_error('fullname'); ?></label>
<input type="text" name="TPlastname-txt" value="<?php echo $info['TPlastname-txt'];  ?>" size="50" />


<h5>Age</h5>
<label style="color:red"><?php echo form_error('age'); ?></label>
<input type="text" name="TPage-txt" value="<?php echo $info['TPage-txt']; ?>" size="50" />

<h5>Sex</h5>
<label style="color:red"><?php echo form_error('sex'); ?></label>
<?php 
$options = array(
                  'male'  => 'Male',
                  'female'    => 'Female'
                );
$js = 'id="TPsex-dd"';
if ($info['TPsex-dd'] == 'm')
echo form_dropdown('TPsex-dd', $options, 'male',$js);
else
echo form_dropdown('TPsex-dd', $options, 'female',$js);
?>

<h5>Date of Birth</h5>
<label style="color:red"><?php echo form_error('birthdate'); ?></label>
<input type="text" name="TPbirthdate-txt" readonly = "true" id = "date1" value="<?php echo $info['TPbirthdate-txt'];  ?>" size="50" onClick = "javascript:NewCal('date1','mmddyyyy')"/>
<h5>Province</h5>
<label style="color:red"><?php echo form_error('address'); ?></label>
<input type="text" name="TPprovince-txt" value="<?php echo $info['TPprovince-txt'];  ?>" size="50" />

<h5>City</h5>
<label style="color:red"><?php echo form_error('address'); ?></label>
<input type="text" name="TPcity-txt" value="<?php echo $info['TPcity-txt'];  ?>" size="50" />

<h5>Barangay</h5>
<label style="color:red"><?php echo form_error('address'); ?></label>
<input type="text" name="TPbarangay-txt" value="<?php echo $info['TPbarangay-txt'];  ?>" size="50" />

<h5>House No. and Street</h5>
<label style="color:red"><?php echo form_error('address'); ?></label>
<input type="text" name="TPstreet-txt" value="<?php echo $info['TPstreet-txt'];  ?>" size="50" />

<h5>Admitted?</h5>
<label style="color:red"><?php echo form_error('admitted'); ?></label>
<input type="radio" name="TPadmitted-rd" value="1" <?php if ($info['TPadmitted-rd'] == '1') echo set_radio('myradio', '1', TRUE); else echo set_radio('myradio', '1');  ?> /> Yes <br/>
<input type="radio" name="TPadmitted-rd" value="0" <?php if ($info['TPadmitted-rd'] == '0') echo set_radio('myradio', '0',TRUE); else echo set_radio('myradio', '0');  ?> /> No <br/>

<h5>Date of Consultation</h5>
<label style="color:red"><?php echo form_error('consuldate'); ?></label>
<input type="text" name="TPconsuldate-txt" readonly = "true" value="<?php echo $info['TPconsuldate-txt'];  ?>" size="50" id="date2" onClick = "javascript:NewCal('date2','mmddyyyy')" />
<h5>Date onset of illness</h5>
<label style="color:red"><?php echo form_error('birthdate'); ?></label>
<input type="text" name="TPillnessdate-txt" readonly = "true" value="<?php echo $info['TPillnessdate-txt'];  ?>" size="50" id="date3" onClick = "javascript:NewCal('date3','mmddyyyy')" />

<h5>Case Classification</h5>
<label style="color:red"><?php echo form_error('classification'); ?></label>
<input type="radio" name="TPclassification-rd" value="S" <?php if ($info['TPclassification-rd'] == 'S') echo set_radio('myradio', 'S', TRUE); else echo set_radio('myradio', 'S');  ?> /> Suspect <br/>
<input type="radio" name="TPclassification-rd" value="P" <?php if ($info['TPclassification-rd'] == 'P')  echo set_radio('myradio', 'P', TRUE); else echo set_radio('myradio', 'P');?> /> Probable <br/>
<input type="radio" name="TPclassification-rd" value="C" <?php if ($info['TPclassification-rd'] == 'C')  echo set_radio('myradio', 'C', TRUE); else echo set_radio('myradio', 'C');?> /> Confirmed <br/>

<h5>Type</h5>
<label style="color:red"><?php echo form_error('type'); ?></label>
<input type="radio" name="TPtype-rd" value="DF" <?php if ($info['TPtype-rd'] == 'DF') echo set_radio('myradio', 'DF', TRUE); else echo set_radio('myradio', 'DF');  ?> /> DF <br/>
<input type="radio" name="TPtype-rd" value="DHF" <?php if ($info['TPtype-rd'] == 'DHF') echo set_radio('myradio', 'DHF',TRUE); else echo set_radio('myradio', 'DHF');?> /> DHF <br/>
<input type="radio" name="TPtype-rd" value="DSS" <?php if ($info['TPtype-rd'] == 'DSS') echo set_radio('myradio', 'DSS',TRUE); else echo set_radio('myradio', 'DHF');?> /> DSS <br/>
<input type="radio" name="TPtype-rd" value="WITH WARNING SIGNS" <?php if ($info['TPtype-rd'] == 'WITH WARNING SIGNS') echo set_radio('myradio', 'WITH WARNING SIGNS',TRUE); else echo set_radio('myradio', 'WITH WARNING SIGNS');?> /> WITH WARNING SIGNS <br/>
<input type="radio" name="TPtype-rd" value="NO WARNING SIGNS" <?php if ($info['TPtype-rd'] == 'NO WARNING SIGNS') echo set_radio('myradio', 'NO WARNING SIGNS',TRUE); else echo set_radio('myradio', 'NO WARNING SIGNS');?> /> NO WARNING SIGNS <br/>

<h5>Outcome</h5>
<label style="color:red"><?php echo form_error('outcome'); ?></label>
<input type="radio" name="TPoutcome-rd" value="A" <?php if ($info['TPoutcome-rd'] == 'A') echo set_radio('myradio', 'A', TRUE); else echo set_radio('myradio', 'A');?> /> Alive <br/>
<input type="radio" name="TPoutcome-rd" value="D" <?php if ($info['TPoutcome-rd'] == 'D')echo set_radio('myradio', 'D', TRUE); else echo set_radio('myradio', 'D');?> /> Died </br>
<input type="radio" name="TPoutcome-rd" value="U" <?php if ($info['TPoutcome-rd'] == 'U') echo set_radio('myradio', 'U',TRUE); else echo set_radio('myradio', 'D');?> /> Unknown </br>

<div><input type="submit" value="Submit" /></div>

</form>
</div>
</div>
<!-- FOOTER -->
<?php $this->load->view('templates/footer');?>
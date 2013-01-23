<!-- HEADER -->
<?php $this->load->view('templates/header');?>

<!-- CONTENT --><?php 
$attributes = array(
						'id' => 'TPcr-form'
					);
echo form_open('larval_survey/addls',$attributes); ?>
<h3>Larval Survey Report</h3>

<h5>Name of Volunteer Inspector</h5>
<label style="color:red"><?php echo form_error('TPinspector-txt'); ?></label>
<input type="text" name="TPinspector-txt" value="<?php echo set_value('patientno'); ?>" size="50" />

<h5>Date</h5>
<label style="color:red"><?php echo form_error('TPdate-txt'); ?></label>
<input type="text" name="TPdate-txt" value="<?php echo set_value('patientno'); ?>" size="50" />

<h5>Barangay</h5>
<label style="color:red"><?php echo form_error('TPbarangay-txt'); ?></label>
<input type="text" name="TPbarangay-txt" value="<?php echo set_value('patientno'); ?>" size="50" />

<h5>Street</h5>
<label style="color:red"><?php echo form_error('TPstreet-txt'); ?></label>
<input type="text" name="TPstreet-txt" value="<?php echo set_value('patientno'); ?>" size="50" />

<h5>Municipality</h5>
<label style="color:red"><?php echo form_error('TPmunicipality-txt'); ?></label>
<input type="text" name="TPmunicipality-txt" value="<?php echo set_value('patientno'); ?>" size="50" />

<h5>Name of Household</h5>
<label style="color:red"><?php echo form_error('TPhousehold-txt'); ?></label>
<input type="text" name="TPhousehold-txt" value="<?php echo set_value('patientno'); ?>" size="50" />

<h5>Result of Survey Positive or Negative</h5>
<label style="color:red"><?php echo form_error('TPresult-rd'); ?></label>
<input type="radio" name="TPresult-rd" value="Positive" <?php echo set_radio('myradio', 'Positive', TRUE); ?> /> Positive <br/>
<input type="radio" name="TPresult-rd" value="Negative" <?php echo set_radio('myradio', 'Negative'); ?> /> Negative <br/>

<h5>Type of Container</h5>
<label style="color:red"><?php echo form_error('TPcontainer-txt'); ?></label>
<input type="text" name="TPcontainer-txt" value="<?php echo set_value('patientno'); ?>" size="50" />

<h5>Created by:</h5>
<label style="color:red"><?php echo form_error('TPcreatedby-txt'); ?></label>
<input type="text" name="TPcreatedby-txt" value="<?php echo set_value('fullname'); ?>" size="50" />

<h5>Created on:</h5>
<label style="color:red"><?php echo form_error('TPcreatedon-txt'); ?></label>
<input type="text" name="TPcreatedon-txt" value="<?php echo set_value('fullname'); ?>" size="50" />

<h5>Last Updated by: </h5>
<label style="color:red"><?php echo form_error('TPlastupdatedby-txt'); ?></label>
<input type="text" name="TPlastupdatedby-txt" value="<?php echo set_value('fullname'); ?>" size="50" />

<h5>Last Updated on:</h5>
<label style="color:red"><?php echo form_error('TPlastupdatedon-txt'); ?></label>
<input type="text" name="TPlastupdatedon-txt" value="<?php echo set_value('age'); ?>" size="50" />

<div><input type="submit" value="Submit" /></div>

</form>

<!-- FOOTER -->
<?php $this->load->view('templates/footer');?>
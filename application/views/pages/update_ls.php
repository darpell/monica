<!-- HEADER -->
<?php $this->load->view('templates/header');?>

<!-- CONTENT -->
<div class="body">
		<div class="blog">
<?php 
$attributes = array(
						'id' => 'TPcr-form'
					);
echo form_open('larval_survey/update_survey',$attributes); ?>
<h3>Larval Survey Report</h3>

<h5>Name of Household</h5>
<label style="color:red"></label>
<input type="text" readonly="true"  style="background-color:#CCCCCC;"name="TPhousehold-txt" value="<?php echo $info['TPhousehold-txt']; ?>" size="50" />

<h5>Result of Survey Positive or Negative</h5>
<label style="color:red"></label>
<?php if($info['TPresult-rd'] == 'positive') {?> 
<input type="radio" name="TPresult-rd" value="Positive" <?php echo set_radio('myradio', 'Positive', TRUE); ?> /> Positive <br/>
<input type="radio" name="TPresult-rd" value="Negative" <?php echo set_radio('myradio', 'Negative'); ?> /> Negative <br/>
<?php } else {?>
<input type="radio" name="TPresult-rd" value="Positive" <?php echo set_radio('myradio', 'Positive'); ?> /> Positive <br/>
<input type="radio" name="TPresult-rd" value="Negative" <?php echo set_radio('myradio', 'Negative', TRUE); ?> /> Negative <br/>
<?php }?>
<h5>Type of Container</h5>
<label style="color:red"></label>
<input type="text" readonly="true"  style="background-color:#CCCCCC;" name="TPcontainer-txt" value="<?php echo $info['TPcontainer-txt'];  ?>" size="50" />
<input type="hidden" readonly="true"  style="background-color:#CCCCCC;" name="tracking" value="<?php echo $info['tracking'];  ?>" size="50" />

<h5>Created by:</h5>
<label style="color:red"></label>
<input type="text" readonly="true"  style="background-color:#CCCCCC;" name="TPcreatedby-txt" value="<?php echo $info['TPcreatedby-txt'];  ?>" size="50" />

<h5>Created on:</h5>
<label style="color:red"></label>
<input type="text" readonly="true"  style="background-color:#CCCCCC;" name="TPcreatedon-txt" value="<?php echo $info['TPcreatedon-txt']; ?>" size="50" />

<div><input type="submit" value="Update" /></div>

</form>
</div>
</div>
<!-- FOOTER -->
<?php $this->load->view('templates/footer');?>
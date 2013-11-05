<!-- HEADER -->
<?php $this->load->view('templates/header');?>

<!-- CONTENT -->
<div class="body">
		<div class="blog">
<?php 
$attributes = array(
						'id' => 'TPcr-form'
					);
echo form_open('master_list/update_immediate_case',$attributes); ?>

<h3>Case Info.</h3>
<input type="hidden" name="person_id" id="person_id" value="<?php echo $person['hidden']['person_id']?>"/>
<input type="hidden" name="imcase_no" id="imcase_no" value="<?php echo $person['hidden2']['imcase_no']?>"/>
<?php 

$this->table->set_heading(
		array(	'Name',
				'Birthday',
				'Contact Nos.',
				'Gender',
				'Marital Status',
				'Nationality',
				'Blood Type',
		));
if($person != null){
echo $this->table->generate($person['table']);


?>
</table>
<h3>Case Symptoms.</h3>
<table border="1"  cellpadding="4" cellspacing="0" id="results"  style="width: 100%;"    >
<tr>
<td><b>Severity</b></td>
<td><b>Age</b></td>
<td><b>Days Of Fever</b></td>
<td><b>Muscle Pain</b></td>
<td><b>Joint Pain   </b></td>
<td><b>Head Ache   </b></td>
<td><b>Bleeding</b></td>
<td><b>Rashes</b></td>
<td><b>Remarks</b></td>
<td><b>Date Onset</b></td>
<td></td>

</tr>

<?php 

	?>

<tr >
<td style="width:100% "><input type="radio" name="status" value="serious" <?php if ($person['symptoms']['Severity']== 'serious') echo set_radio('myradio', 'serious', TRUE); else echo set_radio('myradio', 'serious');  ?>  /> Serious <br/>
<input type="radio" name="status" value="threatening" <?php if ($person['symptoms']['Severity']== 'threatening') echo set_radio('myradio', 'threatening', TRUE); else echo set_radio('myradio', 'threatening');?> /> Threatening <br/>
<input type="radio" name="status" value="suspected" <?php if ($person['symptoms']['Severity']== 'suspected')  echo set_radio('myradio', 'suspected', TRUE); else echo set_radio('myradio', 'suspected');?> /> Suspected <br/>
<input type="radio" name="status" value="finished" <?php if ($person['symptoms']['Severity']== 'finished')  echo set_radio('myradio', 'finished', TRUE); else echo set_radio('myradio', 'finished');?>/>  Finished <br/>
</td>
<td style="width:100% "> <?php echo $person['symptoms']['Age']?></td>

<td style="width:100% "> <input type="text" name="daysoffever" value="<?php echo $person['symptoms']['Days Of Fever'];  ?>" /></td>

<td style="width:100% "><input type="radio" name="musclepain" value="Y" <?php if ($person['symptoms']['Muscle Pain']== 'Y') echo set_radio('myradio', 'Y', TRUE); else echo set_radio('myradio', 'Y');  ?>   /> Yes <br/>
<input type="radio" name="musclepain" value="N" <?php if ($person['symptoms']['Muscle Pain']== 'N')  echo set_radio('myradio', 'N', TRUE); else echo set_radio('myradio', 'N');?> />  No <br/>
</td>

<td style="width:100% "><input type="radio" name="jointpain" value="Y" <?php if ($person['symptoms']['Joint Pain']== 'Y') echo set_radio('myradio', 'Y', TRUE); else echo set_radio('myradio', 'Y');  ?>   /> Yes <br/>
<input type="radio" name="jointpain" value="N" <?php if ($person['symptoms']['Joint Pain']== 'N')  echo set_radio('myradio', 'N', TRUE); else echo set_radio('myradio', 'N');?> />  No <br/>
</td>

<td style="width:100% "><input type="radio" name="headache" value="Y" <?php if ($person['symptoms']['Head Ache']== 'Y') echo set_radio('myradio', 'Y', TRUE); else echo set_radio('myradio', 'Y');  ?>   /> Yes <br/>
<input type="radio" name="headache" value="N" <?php if ($person['symptoms']['Head Ache']== 'N')  echo set_radio('myradio', 'N', TRUE); else echo set_radio('myradio', 'N');?> />  No <br/>
</td>

<td style="width:100% "><input type="radio" name="bleeding" value="Y" <?php if ($person['symptoms']['Bleeding']== 'Y') echo set_radio('myradio', 'Y', TRUE); else echo set_radio('myradio', 'Y');  ?>   /> Yes <br/>
<input type="radio" name="bleeding" value="N" <?php if ($person['symptoms']['Bleeding']== 'N')  echo set_radio('myradio', 'N', TRUE); else echo set_radio('myradio', 'N');?> />  No <br/>
</td>

<td style="width:100% "><input type="radio" name="rashes" value="Y" <?php if ($person['symptoms']['Rashes']== 'Y') echo set_radio('myradio', 'Y', TRUE); else echo set_radio('myradio', 'Y');  ?>   /> Yes <br/>
<input type="radio" name="rashes" value="N" <?php if ($person['symptoms']['Rashes']== 'N')  echo set_radio('myradio', 'N', TRUE); else echo set_radio('myradio', 'N');?> />  No <br/>
</td>


<td style="width:100% "> <input type="text" name="remarks" value="<?php echo $person['symptoms']['Remarks'];  ?>" /></td>


<td> <?php echo $person['symptoms']['Date Onset']?></td>





	
	

<?php
?>

<td colspan =10><input type="submit" value="Update" /></td>
</tr>
</table>

<?php }?>
</form>
</div>
</div>
<!-- FOOTER -->
<?php $this->load->view('templates/footer');?>
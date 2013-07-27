<!-- HEADER -->
<?php $this->load->view('templates/header');?>

<!-- CONTENT -->
<div class="body">
<center><h1>Case Investigations</h1></center>
		<div class="blog">
<table    align="center" cellpadding="20">
<tr>
<?php 
$attributes = array(
						'id' => 'TPcr-form'
					);
echo form_open('investigatedcases/view_case_investigation',$attributes); ?>
  <tr>
    <td>Barangay:</td>
    <?php foreach ($barangay_form as $row) {
    ?>
    <td>
    <?php 
    echo form_checkbox('barangay[]', $row, TRUE);
    echo $row;
    ?>
    </td>
    <?php }?>
     <tr>
    <td >Date:</td>
    <td>
    <label style="color:red"><?php echo form_error('TPdatefrom-txt'); ?></label>
    From: <input type="text" name="TPdatefrom-txt" readonly = "true" id = "date1" value="" onClick = "javascript:NewCal('date1','mmddyyyy')" /></td>
    
    <td>
    <label style="color:red"><?php echo form_error('TPdateto-txt'); ?></label>
    To: <input type="text" name="TPdateto-txt" readonly = "true" id = "date2" value=""  onClick = "javascript:NewCal('date2','mmddyyyy')" />
    </td> 
     
    
   <td> <input type="submit" class="submitButton" value="View"/><?php echo form_close(); ?></td>
   <td> <label style="color:red"><?php echo $error; ?></label></td>
  </tr>
  
  

	</table>
<p />


<?php if($values != null) {?>
<center>

<?php 

$tmpl = array (
                    'table_open'          => '<table border="1" cellpadding="5" cellspacing="0" id="results" style="width: 80%;">',

                    'heading_row_start'   => '<tr>',
                    'heading_row_end'     => '</tr>',
                    'heading_cell_start'  => '<th id="result" scope="col">',
                    'heading_cell_end'    => '</th>',

                    'row_start'           => '<tr>',
                    'row_end'             => '</tr>',
                    'cell_start'          => '<td align="center">',
                    'cell_end'            => '</td>',

                    'row_alt_start'       => '<tr style="background-color: #e3e3e3">',
                    'row_alt_end'         => '</tr>',
                    'cell_alt_start'      => '<td align="center">',
                    'cell_alt_end'        => '</td>',

                    'table_close'         => '</table>'
              );

$this->table->set_template($tmpl);

echo $this->table->generate($values); 
?>
</center>
<?php } ?>


</div>
</div>
</body>
<!-- FOOTER -->
<?php $this->load->view('templates/footer');?>
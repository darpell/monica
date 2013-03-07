<!-- HEADER -->
<?php $this->load->view('templates/header');?>

<!-- CONTENT -->
<div class="body">
		<div class="blog">
<?php 
if($table == null) {
$attributes = array(
						'id' => 'TPcr-form'
					);
echo form_open_multipart('upload/view');
?> 
<br />
<br />
<center>
<h4> Note: Select Dengue.mdb file</h4>
<h3><?php if($result != "") {echo $result;}?></h3>
<?php echo $error;?>

<input type="file" name="userfile" size="20" />
<input type="submit" value="upload" />
</form>
</center>
<?php } ?>


<?php if($table != null) {?>

<div>

<?php 

$tmpl = array (
                    'table_open'          => '<table border="1" cellpadding="5" cellspacing="0" id="results" >',

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
echo form_open('upload/confirmUpload');
?> 
<br />
<center>
<input type="submit" value="Confirm Upload" name="TPsubmit"/> <input type="submit" value="Cancel"  name="TPsubmit"/>
</center>
<?php
echo $this->table->generate($table); 

?>
<br />

</div>
<?php } ?>
</div>
</div>
<!-- FOOTER -->
<?php $this->load->view('templates/footer');?>
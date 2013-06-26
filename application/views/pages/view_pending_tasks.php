<!-- HEADER -->
<?php $this->load->view('templates/header');?>


<script type="text/javascript" src="http://www.google.com/jsapi"></script>
</script>
 
  <div class="body">
   <center>
   <?php 
$attributes = array(
						'id' => 'TPcr-form'
					);
echo form_open('CHO/approve_tasks',$attributes); ?>
   <?php if($table != null) {?>

<div>
   <h3>Pending Tasks</h3>
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

echo $this->table->generate($table); 
?>
<br />
<input type="hidden" name="tasks" id="tasks" value="<?php echo $tasks; ?>" />
</div>
<div><input type="submit" value="Submit" /></div>
<?php } else {?>

   <h3>No Pending Tasks</h3>
<?php }?>
    
</center>





<?php $this->load->view('templates/footer'); ?>
</html>
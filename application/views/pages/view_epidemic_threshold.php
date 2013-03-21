<!-- HEADER -->
<?php $this->load->view('templates/header');?>

<!-- CONTENT -->
<div class="body">
		<div >
<center>
<?php if($table != null) {?>

<div>
<h3>Five years monthly record of cases (<?php echo (date('Y')-5).'-'.(date('Y')-1); ?>)</h3>
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

echo $this->table->generate($table['data']); 
?>
<br />

</div>
<?php } ?>
</center>
</div>
</div>
<!-- FOOTER -->
<?php $this->load->view('templates/footer');?>
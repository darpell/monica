<!-- HEADER -->
<?php $this->load->view('templates/header');?>

<!-- CONTENT -->
<body>
<div class="body">
		<div class="blog">
<center>
<h2> DENGUE SURVEILLANCE REPORT </h2>
<br />
<br />
</center>
<h4>Trend</h4>
<p>A total of <b><?php echo $totalcur;?> </b> dengue cases was reported nationwide from January 1 to <?php $my_t=getdate(); echo("$my_t[month] $my_t[mday], $my_t[year]");?>.
This is <b><?php if($percent > 0) echo $percent . '% higher'; else echo $percent . '% lower';?> </b>compared to the same time period last year <b>(<?php echo $totalprev;?> )</b>.</p>
<br />
<h4>Geographic Distribution</h4>
<!-- <p>Most of the cases were from the following regions: National Capital Region (22.24%),
Region IV-A (14.08%) and Region III (13.65%)</p>-->

<br />

<?php if($table != null) {?>
<center>
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

echo $this->table->generate($table); 
?>
<br />

</div>
</center>
<?php } ?>
<h4>Profile of Cases</h4>

<p>Ages of cases ranged from less than 1 month to 90 years old (median = 12.67 years).
Majority of cases were <?php if($summ > $sumf) echo 'male (' . $summ ; else echo 'female (' . $sumf ; ?>). <?php echo $agegrouppercent?>% of cases belonged to the 
<?php
if($agegroup == 0)
{echo ' 1 to 10 ' ;}
if($agegroup == 1)
{echo ' 11 to 20 ' ;}
if($agegroup == 2)
{echo ' 21 to 30 '; }
if($agegroup == 3)
{echo '31 to 40 ' ;}
if($agegroup == 4)
{echo ' greater than 40 '; }
?> years age group.</p>

<form>
<input type = 'hidden' id ='data' name='data' value='<?php echo $report_data_age;?>'>
<input type = 'hidden' id ='data1' name='data1' value='<?php echo $report_data_cases;?>'>
</form>


</div>
<center><div id="chart_div"></div>
<div id="chart_div1"></div>
</center>
</div>
<body>
<!-- FOOTER -->
<?php $this->load->view('templates/footer');?>
<!-- HEADER -->
<?php $this->load->view('templates/header');?>

<script language="javascript" type="text/javascript">
function PrintMeSubmitMe()
{
window.print();
}
</script>

<!-- CONTENT -->
<body>
<div class="body">
		<div class="blog">
<?php 
$attributes = array(
						'id' => 'TPcr-form'
					);
echo form_open('case_report/print_report',$attributes); ?>
<input type = 'hidden' id ='data' name='data' value='<?php echo $report_data_age;?>'>
<input type = 'hidden' id ='data1' name='data1' value='<?php echo $report_data_cases;?>'>
<input type = 'hidden' id ='datefrom' name='data' value='<?php echo $report_data_age;?>'>
<input type = 'hidden' id ='dateto' name='data1' value='<?php echo $report_data_cases;?>'>
<INPUT TYPE="submit" value= "PRINTABLE VERSION" 'target="_blank"'>
</form>
<center>
<br />
<?php $this->load->view('pages/report_header');?>
<br />
<br />

<table  style="width: 90%;">
<tr><td>
<h4>Trend</h4>
<p>A total of <b><?php echo $totalcur;?> </b> dengue cases was reported nationwide from January 1 to <?php $my_t=getdate(); echo("$my_t[month] $my_t[mday], $my_t[year]");?>.
This is <b><?php if($percent > 0) echo $percent . '% higher'; else echo $percent . '% lower';?> </b>compared to the same time period last year <b>(<?php echo $totalprev;?> )</b>.</p>

<br />

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
?> years age group.(Fig.1) There were 
<?php 
$c = count($table)-1;
echo $table[$c]['Deathscur']; 
?> deaths (CFR <?php 
$c = count($table)-1;
echo $table[$c]['CFRC']; 
?>%) reported.</p>
</td></tr>
</table>
</center>

<?php 
$attributes = array(
						'id' => 'TPcr-form'
					);
echo form_open('case_report/print_report',$attributes); ?>
<input type = 'hidden' id ='data' name='data' value='<?php echo $report_data_age;?>'>
<input type = 'hidden' id ='data1' name='data1' value='<?php echo $report_data_cases;?>'>
</form>


</div>

<center>
<table border="1" style="width: 70%;height: 400px;">
<tr><td><div id="chart_div1"  style="height: 400px;"></div></td></tr> 
</table>
<br />
<br />
<table border="1" style="width: 70%; height: 400px;">
<tr><td><div id="chart_div" style="height: 400px;"></div></td></tr> 
</table>
</center>
<?php if($table != null) {?>
<center>
<h3></>Table 1. DENGUE Cases & Deaths by Region</h3>
<h4>Philippines, <?php echo date('Y') - 1;?> & <?php echo date('Y');?></h4>
<?php 
$tmpl = array (
                    'table_open'          => '<table border="1" cellpadding="5" cellspacing="0" id="results" style="width: 70%;">',

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


</center>
<?php } ?>


</div>


</body>
<!-- FOOTER -->
<?php $this->load->view('templates/footer');?>
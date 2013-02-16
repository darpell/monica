<!-- HEADER -->
<?php $this->load->view('templates/header');?>

<!-- CONTENT -->
<body>
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
<p> WORK IN PROGRESS </p>
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
?> years age group.</p>

<form>
<input type = 'hidden' id ='data' name='data' value='<?php echo $report_data_age;?>'>
<input type = 'hidden' id ='data1' name='data1' value='<?php echo $report_data_cases;?>'>
</form>

<center><div id="chart_div"></div>
<div id="chart_div1"></div>
</center>
<body>
<!-- FOOTER -->
<?php $this->load->view('templates/footer');?>
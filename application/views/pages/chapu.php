<?php
$q=$_GET["q"];

$con = mysql_connect('localhost', 'root', '');
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("demo", $con);

$sql="SELECT * FROM case_report_main WHERE cr_barangay = '".$q."'";

$result = mysql_query($sql);
$data = '';
$data .= "<table border='1'>
<tr>
<th>Case Report No.</th>
<th>Patient No.</th>
<th>First Name</th>
<th>Last Name</th>
<th>Sex</th>
</tr>";

while($row = mysql_fetch_array($result)or die($result."<br/><br/>".mysql_error()))
  {
 $data .=  "<tr>";
 $data .=  "<td>".$row['cr_no']."</td>";
 $data .=  "<td>".$row['cr_patient_no']."</td>";
 $data .=  "<td>".$row['cr_first_name']."</td>";
$data .=   "<td>".$row['cr_last_name']."</td>";
 $data .=  "<td>".$row['cr_sex']."</td>";
 $data .=  "</tr>";
  }
$data .= "</table>";

print $data;
mysql_close($con);
?> 
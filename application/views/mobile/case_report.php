<!-- HEADER -->
<?= $this->load->view('/mobile/templates/mob_header') ?>

<!-- CONTENT -->
</head>

<body>
		<!-- barangay case count -->
		<?php for ($i = 0; $i < count($data_brgy); $i++) :?>
		<input type="hidden" id="brgy<?= $i ?>"	value="<?php echo $data_brgy[$i]['cr_barangay'];?>" /> <br/>
		<input type="hidden" id="count<?= $i ?>" 		value="<?php echo $data_brgy[$i]['ctr'];?>" /> <br/>
		<input type="hidden" id="year<?= $i ?>"	value="<?php echo $data_brgy[$i]['year'];?>" /> <br/>
		<?php endfor;?>
		<!-- /barangay case count -->
<div data-role="page" style="top:0;left:0; right:0; bottom:0;">
	<div data-role="header" ><!-- data-position="fixed"> -->
    	<a href="<?php echo site_url('mobile');?>" data-ajax="false" data-icon="arrow-l"> Back </a>
    	<h2> Case Info Reports </h2> 
    	<!-- <a href="<?php echo site_url('mobile');?>" data-rel="panel" data-icon="gear" data-ajax="false"> Show All </a> -->
    </div> <!-- /header-->
	<div data-role="content">
		<table>
			<tr>
				<th> Barangay </th>
				<th> 2012 </th>
				<th> 2013 </th>
			</tr>
			<?php for ($i = 0; $i < count($count_current); $i++) :?>
			<tr>
				<td> 
					<?php 
						echo $count_current[$i]['cr_barangay'];
					?>
				</td>
				<td>
					<?php 
						if ($count_past_year[$i]['count'] != NULL)
							echo $count_past_year[$i]['count'];
					?>
				</td>
				<td>
					<?php 
						if ($count_current[$i]['count'] != NULL)
							echo $count_current[$i]['count'];
					?>
				</td>
			</tr>
			<?php endfor; ?>
		</table>
		<br/><br/>
		<ul data-role="listview">
			<li> <a href="<?php echo site_url('mobile/case_report_filter/province');?>"> Check Addresses </a> </li>
		</ul>
		
	</div><!-- /content -->
</div><!-- /page -->
</body>
</html>
<!-- HEADER -->
<?= $this->load->view('/mobile/templates/mob_header') ?>

<!-- CONTENT -->
</head> 
<body onload="initialize()"> 

<div data-role="page">

	<div data-role="header">
		<h1> Person's Details </h1>
		<a href="<?php echo site_url('mobile');?>" data-ajax="false" data-icon="delete"> Cancel </a>
	</div><!-- /header -->
	<div data-role="content">

		
		<ul data-role="listview" data-inset="true">
			
			<!-- <li> <?php //echo $test; ?></li> -->
				<?php for ($ctr = 0; $ctr < count($household_persons); $ctr++) {?>
				
				<li> Name: 
					<?php echo $household_persons[$ctr]['person_first_name']; ?> <!-- First Name -->
					<?php echo $household_persons[$ctr]['person_last_name']; ?> <!-- Last Name --> 
				</li>
				
				<li> Civil Status: 
					<?php echo $household_persons[$ctr]['person_marital'];?> <!-- Civil Status -->
				</li>
				
				<li> Nationality: 
					<?php echo $household_persons[$ctr]['person_nationality']; ?> <!-- Nationality-->
				</li>
				
				<li> Age: 
					<?php echo $household_persons[$ctr]['person_dob']; ?> <!-- Age -->
				</li>
				
				<li> Gender: 
					<?php 
						if ($household_persons[$ctr]['person_sex'] == 'M')
							echo 'Male';
						else if ($household_persons[$ctr]['person_sex'] == 'F')
							echo 'Female';
					?> <!-- Sex -->
				</li>
					
				<li> Blood Type: 
					<?php 
						if ($household_persons[$ctr]['person_blood_type'] == NULL || $household_persons[$ctr]['person_blood_type'] == 'null')
							echo 'N.A.';
						else
							echo $household_persons[$ctr]['person_blood_type'];
					?>
				</li> <!-- Blood Type -->
				
				<li>Guardian: 
					<?php echo $household_persons[$ctr]['person_guardian'];?>
				</li>
			<?php } ?>
		</ul>
		
	</div><!-- /content -->
</div><!-- /page -->

</body>
</html>
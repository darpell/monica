<!-- HEADER -->
<?= $this->load->view('/mobile/templates/mob_header') ?>

<!-- CONTENT -->
</head> 
<body onload="initialize()"> 

<!-- load model -->
<?php 
	$this->load->model('master_list_model','masterlist');
?>
<div data-role="page">

	<div data-role="header">
		<h1> Person's Details </h1>
		<a href="<?php echo site_url('mobile');?>" data-ajax="false" data-icon="delete"> Cancel </a>
	</div><!-- /header -->
	<div data-role="content">

		
		<ul data-role="listview" data-inset="true" data-theme="d">
			
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
					<?php //http://stackoverflow.com/questions/11272691/php-data-difference-giving-fatal-error
						$bday = $household_persons[$ctr]['person_dob']; 
						$today = new DateTime();//date('Y-m-d');
						$diff = $today->diff(new DateTime($bday));
						echo $diff->y;
					?> <!-- Age -->
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
		
		<form name="symptom_form" action="
			<?php echo site_url('mobile/view/household/' . 
									$household_persons[0]['household_id'] .
									'/hosp/' . $household_persons[0]['person_id']); ?>/edit_case"
			method="post" data-ajax="false">
	
					
					<?php for ($ctr = 0; $ctr < count($household_persons); $ctr++) {?>
						<input type="hidden" name="household_id" id="household_id" value="<?php echo $household_persons[$ctr]['household_id']; ?>"	/>
						<input type="hidden" name="person_id" id="person_id" value="<?php echo $household_persons[$ctr]['person_id']; ?>"	/>
						
						<input type="hidden" name="imcase_no" id="imcase_no" value="<?php echo $this->masterlist->get_imcase_no($household_persons[$ctr]['person_id']); ?>"	/>
						<input type="hidden" name="created_on" id="created_on" value="<?php echo $this->masterlist->get_created_on($household_persons[$ctr]['person_id']); ?>"	/>
						<input type="hidden" name="lat" id="lat" value="<?php echo $this->masterlist->get_imcase_lat($household_persons[$ctr]['person_id']); ?>"	/>
						<input type="hidden" name="lng" id="lng" value="<?php echo $this->masterlist->get_imcase_lng($household_persons[$ctr]['person_id']); ?>"	/>
					<?php } ?>	
						
					<!-- 
					<fieldset data-role="controlgroup">
						<legend>Outcome:</legend>
					     	<input type="radio" name="outcome" id="alive" value="alive" checked="checked" />
					     	<label for="alive"> Alive </label>
					
					     	<input type="radio" name="outcome" id="dead" value="dead"  />
					     	<label for="dead"> Dead </label>
					
					</fieldset>
					<br/> 
					-->
					<input type="submit" value="Person is already treated" />
		</form>
	</div><!-- /content -->
</div><!-- /page -->

</body>
</html>
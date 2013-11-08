<!-- HEADER -->
<?= $this->load->view('/mobile/templates/mob_header') ?>

<!-- CONTENT -->

</head>
<body>
	<div data-role="page" id="main_task_page">
		<div data-role="header">
			<a href="<?php echo site_url('mobile');?>" data-ajax="false" data-icon="home"> Home </a>
			<h1> Case Details </h1>
		</div>
		<div data-role="content">
			
			<?php for ($ctr = 0; $ctr < count($cases); $ctr++) {?>
					<input type="hidden" id="imcase_no_<?= $ctr ?>" value="<?php echo $cases[$ctr]['imcase_no']; ?>"	/>
			<?php } ?>
			<ul data-role="listview"data-inset="true" data-split-icon="check" data-theme="d" data-split-theme="d" data-divider-theme="a">
				<?php for ($ctr = 0; $ctr < count($cases); $ctr++) {?>
				<li data-theme="a">
					<?php 
					if ($cases[$ctr]['days_fever'] <= 2)
					{
					?>
						<label style="color:YELLOW;"> [Has Fever for <?php echo $cases[$ctr]['days_fever']; ?> days] </label> <br/>	
					<?php 
						}
						else if ($cases[$ctr]['days_fever'] == 3)
						{
					?>	
						<label style="color:ORANGE;"> [Has Fever for <?php echo $cases[$ctr]['days_fever']; ?> days] </label> <br/>
					<?php 
						}
						else
						{
					?>
						<label style="color:RED;"> [Has Fever for <?php echo $cases[$ctr]['days_fever']; ?> days] </label> <br/>
					<?php 
						}
					?>
					<p class="ui-li-aside"> Last Visited On <strong>
					<?php echo $cases[$ctr]['last_updated_on']; ?> <!-- Last Visited On -->
					</strong></p>
				</li>
				
				<li data-theme="b"> 
					 
					
					<?php 
						$symptoms = array();
						if ($cases[$ctr]['has_muscle_pain'] == 'Y')
							array_push($symptoms,"Muscle Pain");
						if ($cases[$ctr]['has_joint_pain'] == 'Y')
							array_push($symptoms,"Joint Pain");
						if ($cases[$ctr]['has_headache'] == 'Y')
							array_push($symptoms,"Headache");
						if ($cases[$ctr]['has_bleeding'] == 'Y')
							array_push($symptoms,"Bleeding");
						if ($cases[$ctr]['has_rashes'] == 'Y')
							array_push($symptoms,"Rashes");
							
						echo count($symptoms);
							if(count($symptoms) > 1)
								echo " Symptoms:";
							else
								echo " Symptom:";
					?>
						<br/>
					<?php
						echo implode(", ",$symptoms);
					?>
					
				</li>
				<li> Date Recorded: <?php echo $cases[$ctr]['created_on'];?> </li>
				<li> Name: <?php echo $cases[$ctr]['person_first_name']; ?> <?php echo $cases[$ctr]['person_last_name']; ?></li> <!-- Name -->
				<li> Contact No: <?php echo $cases[$ctr]['person_contactno'];?> </li>
				<li> Civil Status: <?php echo $cases[$ctr]['person_marital'];?> <!-- Civil Status --> </li>
				<li> Nationality: <?php echo $cases[$ctr]['person_nationality']; ?> <!-- Nationality--> </li>
				<li> Gender: 
					<?php 
						if ($cases[$ctr]['person_sex'] == 'M')
							echo 'Male';
						else if ($cases[$ctr]['person_sex'] == 'F')
							echo 'Female';
					?> <!-- Sex -->
				</li>
				<li> Age: 
					<?php //http://stackoverflow.com/questions/11272691/php-data-difference-giving-fatal-error
						$bday = $cases[$ctr]['person_dob']; 
						$today = new DateTime();//date('Y-m-d');
						$diff = $today->diff(new DateTime($bday));
						echo $diff->y;
					?> <!-- Age -->
				</li>
				<li>Guardian: 
					<?php echo $cases[$ctr]['person_guardian'];?>
				</li>
				<li> Address: <?php echo $cases[$ctr]['house_no'];?> <?php echo $cases[$ctr]['street'];?> </li>
				<li> Remarks: <?php echo $cases[$ctr]['remarks'];?> </li>
				<?php } ?>
			</ul>
		</div><!-- /content -->
	</div><!-- /page-->
</body>
</html>
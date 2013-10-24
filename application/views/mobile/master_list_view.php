<!-- HEADER -->
<?= $this->load->view('/mobile/templates/mob_header') ?>

<!-- CONTENT -->

</head>
<body>
	<div data-role="page" id="main_task_page">
		<div data-role="header">
			<a href="<?php echo site_url('mobile');?>" data-ajax="false" data-icon="delete"> Cancel </a>
			<h1> People Living in <?php echo $household_persons[0]['house_no'] . ' at ' . $household_persons[0]['street']; ?> </h1>
		</div>
		<div data-role="content">
			
			<?php for ($ctr = 0; $ctr < count($household_persons); $ctr++) {?>
					<input type="hidden" id="household_id_<?= $ctr ?>" 		value="<?php echo $household_persons[$ctr]['household_id']; ?>"	/>
					<input type="hidden" id="person_id_<?= $ctr ?>" 		value="<?php echo $household_persons[$ctr]['person_id']; ?>"	/>
			<?php } ?>
			
			<ul data-role="listview" data-filter="true" data-inset="true" data-split-icon="check" data-split-theme="d">
				<!-- <li> <?php //echo $test; ?></li> -->
				<?php 
				for ($ctr = 0; $ctr < count($household_persons); $ctr++) 
				{
					$this->load->model('master_list_model','masterlist');
					if ($this->masterlist->check_person_fever($household_persons[$ctr]['person_id']))
					{
						if($this->masterlist->check_person_hospitalized(
										$household_persons[$ctr]['person_first_name'],
										$household_persons[$ctr]['person_last_name'],
										$household_persons[$ctr]['person_sex'],
										$household_persons[$ctr]['person_dob']
									)
								) //is sick and hospitalized
						{
				?>
							<li data-theme="d">
								<label style="color:GREEN;"> [Hospitalized] </label>
								<?php echo $household_persons[$ctr]['person_first_name']; ?> <!-- First Name -->
								<?php echo $household_persons[$ctr]['person_last_name']; ?>, <!-- Last Name --> 
								<?php 
									$bday = $household_persons[$ctr]['person_dob'];
									$today = new DateTime();//date('Y-m-d');
									$diff = $today->diff(new DateTime($bday));
									echo $diff->y;
								?>, <!-- Age -->
								<?php echo $household_persons[$ctr]['person_sex']; ?>, <!-- Sex -->
								<?php echo $household_persons[$ctr]['person_nationality']; ?> <!-- Nationality-->
								
							</li>
							
					
				<?php
						}
						else //is sick but unhospitalized
						{
							//$this->masterlist->add_fever_day($household_persons[$ctr]['person_id']);
				?>
							<li data-theme="a">
								<a href="<?php echo site_url('mobile/view/person/' . $household_persons[$ctr]['person_id']);?>" data-ajax="false" data-transition="slide">
				<?php 
							if ($this->masterlist->count_fever_day($household_persons[$ctr]['person_id']) < 3)
							{
				?>
								<label style="color:YELLOW;"> [Has Fever for <?php echo $this->masterlist->count_fever_day($household_persons[$ctr]['person_id']); ?> days] </label>
				<?php 
							}
							else if($this->masterlist->count_fever_day($household_persons[$ctr]['person_id']) >= 3 && $this->masterlist->count_fever_day($household_persons[$ctr]['person_id']) < 5)
							{
				?>		
								<label style="color:ORANGE;"> [Has Fever for <?php echo $this->masterlist->count_fever_day($household_persons[$ctr]['person_id']); ?> days] </label>
				<?php 
							}
							else if($this->masterlist->count_fever_day($household_persons[$ctr]['person_id']) >= 5)
							{
				?>
								<label style="color:RED;"> [Has Fever for <?php echo $this->masterlist->count_fever_day($household_persons[$ctr]['person_id']); ?> days] </label>
				<?php 
							}
				?>
								<?php echo $household_persons[$ctr]['person_first_name']; ?> <!-- First Name -->
								<?php echo $household_persons[$ctr]['person_last_name']; ?>, <!-- Last Name -->
								<?php 
									$bday = $household_persons[$ctr]['person_dob'];
									$today = new DateTime();//date('Y-m-d');
									$diff = $today->diff(new DateTime($bday));
									echo $diff->y;
								?>, <!-- Age -->
								<?php echo $household_persons[$ctr]['person_sex']; ?>, <!-- Sex -->
								<?php echo $household_persons[$ctr]['person_nationality']; ?> <!-- Nationality-->
								
								</a>
							</li>
				<?php
						}
					}
					else //not sick
					{
				?>
				
				<li> <a href="<?php echo site_url('mobile/view/household/' . $household_persons[$ctr]['household_id'] . '/person/' . $household_persons[$ctr]['person_id']);?>" data-ajax="false" data-transition="slide">
					<?php echo $household_persons[$ctr]['person_first_name']; ?> <!-- First Name -->
					<?php echo $household_persons[$ctr]['person_last_name']; ?>, <!-- Last Name --> 
					<?php 
						$bday = $household_persons[$ctr]['person_dob'];
						$today = new DateTime();//date('Y-m-d');
						$diff = $today->diff(new DateTime($bday));
						echo $diff->y;
					?>, <!-- Age -->
					<?php echo $household_persons[$ctr]['person_sex']; ?>, <!-- Sex -->
					<?php echo $household_persons[$ctr]['person_nationality']; ?> <!-- Nationality-->
					
					</a>
				</li>
				<?php
					} 
				} 
				?>
			</ul>
			
		</div><!-- /content -->
	</div><!-- /page-->
</body>
</html>
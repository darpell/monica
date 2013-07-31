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
				<?php for ($ctr = 0; $ctr < count($household_persons); $ctr++) {?>
				
				<li> <a href="<?php echo site_url('mobile/view/household/' . $household_persons[$ctr]['household_id'] . '/person/' . $household_persons[$ctr]['person_id']);?>" data-ajax="false" data-transition="slide">
					<?php echo $household_persons[$ctr]['person_first_name']; ?> <!-- First Name -->
					<?php echo $household_persons[$ctr]['person_last_name']; ?>, <!-- Last Name --> 
					<?php echo $household_persons[$ctr]['person_nationality']; ?>, <!-- Nationality-->
					<?php echo $household_persons[$ctr]['person_sex']; ?>, <!-- Sex -->
					<?php echo $household_persons[$ctr]['person_dob']; ?> <!-- Age -->
					</a>
				</li>
				<?php } ?>
			</ul>
			
		</div><!-- /content -->
	</div><!-- /page-->
</body>
</html>
<!-- HEADER -->
<?= $this->load->view('/mobile/templates/mob_header') ?>

<!-- CONTENT -->

</head>
<body>
	<div data-role="page" id="main_task_page">
		<div data-role="header">
			<a href="<?php echo site_url('mobile');?>" data-ajax="false" data-icon="delete"> Cancel </a>
			<h1> Uninvestigated Cases </h1>
		</div>
		<div data-role="content">
			
			<?php for ($ctr = 0; $ctr < count($cases); $ctr++) {?>
					<input type="hidden" id="cr_patient_no<?= $ctr ?>" 		value="<?php echo $cases[$ctr]['cr_patient_no']; ?>"	/>
			<?php } ?>
			
			<ul data-role="listview" data-filter="true" data-inset="true" data-split-icon="check" data-split-theme="d">
				<!-- <li> <?php //echo $test; ?></li> -->
				<?php for ($ctr = 0; $ctr < count($cases); $ctr++) {?>
				
				<li> <a href="<?php echo site_url('mobile/cases/' . $cases[$ctr]['cr_patient_no']);?>" data-ajax="false" data-transition="slide">
					<?php echo $cases[$ctr]['cr_first_name']; ?> <!-- First Name -->
					<?php echo $cases[$ctr]['cr_last_name']; ?>, <!-- Last Name -->
					<?php echo $cases[$ctr]['cr_sex']; ?>, <!-- Sex -->
					<?php echo $cases[$ctr]['cr_age']; ?>, <!-- Age -->
					<?php echo $cases[$ctr]['cr_street']; ?> <!-- Address -->
					</a>
				</li>
				<?php } ?>
			</ul>
			
		</div><!-- /content -->
	</div><!-- /page-->
</body>
</html>
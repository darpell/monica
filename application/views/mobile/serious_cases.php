<!-- HEADER -->
<?= $this->load->view('/mobile/templates/mob_header') ?>

<!-- CONTENT -->

</head>
<body>
	<div data-role="page" id="main_task_page">
		<div data-role="header">
			<a href="<?php echo site_url('mobile');?>" data-ajax="false" data-icon="delete"> Cancel </a>
			<h1> Catchment Area List </h1>
		</div>
		<div data-role="content">
			
			<?php for ($ctr = 0; $ctr < count($cases); $ctr++) {?>
					<input type="hidden" id="imcase_no_<?= $ctr ?>" value="<?php echo $cases[$ctr]['imcase_no']; ?>"	/>
			<?php } ?>
			<ul data-role="listview" data-filter="true" data-inset="true" data-split-icon="check" data-split-theme="d" data-divider-theme="a">
				<?php for ($ctr = 0; $ctr < count($cases); $ctr++) {?>
				
				<li data-theme="a"> <a href="<?php echo site_url('mobile/');?>" data-ajax="false" data-transition="slide">
					<label style="color:RED;"> [Has Fever for <?php echo $cases[$ctr]['days_fever']; ?> days] </label> <br/>					
					<?php echo $cases[$ctr]['person_first_name']; ?> <!-- First Name -->
					<?php echo $cases[$ctr]['person_last_name']; ?> <!-- Last Name -->
					<p class="ui-li-aside"> Last Visited On <strong>
					<?php echo $cases[$ctr]['last_updated_on']; ?> <!-- Last Visited On -->
					</strong></p>
					</a>
				</li>
				
				
			
				<?php } ?>
			</ul>
		</div><!-- /content -->
	</div><!-- /page-->
</body>
</html>
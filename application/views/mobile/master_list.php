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
			
			<?php for ($ctr = 0; $ctr < count($subjects); $ctr++) {?>
					<input type="hidden" id="household_id_<?= $ctr ?>" 		value="<?php echo $subjects[$ctr]['household_id']; ?>"	/>
			<?php } ?>
			
			<ul data-role="listview" data-filter="true" data-inset="true" data-split-icon="check" data-split-theme="d">
				<!-- <li> <?php //echo $test; ?></li> -->
				<?php for ($ctr = 0; $ctr < count($subjects); $ctr++) {?>
				
				<li> <a href="<?php echo site_url('mobile/household/' . $subjects[$ctr]['household_id']);?>" data-ajax="false" data-transition="slide">
					<?php echo $subjects[$ctr]['house_no']; ?> <!-- Household No. e.g. "Blk 2" --> located at
					<?php echo $subjects[$ctr]['street']; ?> <!-- Street -->
					<p class="ui-li-aside"> Last Visited On <strong>
					<?php echo $subjects[$ctr]['last_visited_on']; ?> <!-- Last Visited On -->
					</strong></p>
					</a>
				</li>
				<?php } ?>
			</ul>
			
		</div><!-- /content -->
	</div><!-- /page-->
</body>
</html>
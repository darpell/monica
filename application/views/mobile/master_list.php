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
			
			
				<!-- <li> <?php //echo $test; ?></li> -->
				<?php for ($ctr = 0; $ctr < count($subjects); $ctr++) {?>
				<ul data-role="listview" data-inset="true" data-split-icon="check" data-split-theme="d" data-divider-theme="a">
				<li data-role="list-divider"> 
					<span> 
						<?php 
							$this->load->model('master_list_model','masterlist');
							$fever_count = $this->masterlist->get_fever_count($subjects[$ctr]['household_id']);
							
							if ($fever_count != NULL)
								echo $fever_count;
							else
								echo '0';
						?> 
					</span> identified with fever for the past 7 days</li>
				<li> <a href="<?php echo site_url('mobile/household/' . $subjects[$ctr]['household_id']);?>" data-ajax="false" data-transition="slide">
					<?php echo $subjects[$ctr]['household_name']; ?> <!-- Household No. e.g. "Blk 2" --> located at
					<?php echo $subjects[$ctr]['house_no']; ?>, <!-- Household No. e.g. "Blk 2" --> 
					<?php echo $subjects[$ctr]['street']; ?> <!-- Street -->
					<p class="ui-li-aside"> Last Visited On <strong>
					<?php echo $subjects[$ctr]['last_visited']; ?> <!-- Last Visited On -->
					</strong></p>
					</a>
				</li>
				
				
			</ul>
				<?php } ?>
			
		</div><!-- /content -->
	</div><!-- /page-->
</body>
</html>
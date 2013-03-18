<!-- HEADER -->
<?= $this->load->view('/mobile/templates/mob_header') ?>

<!-- CONTENT -->

</head>
<body>
	<div data-role="page" id="main_task_page">
		<div data-role="header">
			<p style="font-size:medium;padding:5px;text-align:center;"> Assigned Tasks </p>
		</div>
		<div data-role="content">
			<ul data-role="listview" data-filter="true" data-filter-placeholder="Search for task" data-inset="true">
			<?php for ($ctr = 0; $ctr < count($tasks); $ctr++): ?>
				<li><a href="#page<?= $tasks[$ctr]['task_no'] ?>"> <?= $tasks[$ctr]['task_header'] ?> </a></li>
			<?php endfor; ?>
			</ul>
		</div><!-- /content -->
	</div><!-- /page one-->
	
	<?php for ($ctr = 0; $ctr < count($tasks); $ctr++): ?>
	<div data-role="page" id="page<?= $tasks[$ctr]['task_no'] ?>">
		<div data-role="header">
			<p style="font-size:medium;padding:5px;text-align:center;"> <?= $tasks[$ctr]['task_header'] ?> </p>
		</div>
		<div data-role="content">
			<form action="" data-ajax="false">
				<ul data-role="listview">
					<li><label>Date given: </label><?= $tasks[$ctr]['date_sent'] ?> <br/></li>
					<li><label>Task info: </label><?= $tasks[$ctr]['task'] ?> <br/></li>
					<li><label for="TPtask_remark"> Remarks: </label>
						<textarea name="TPtask_remark" id="TPtask_remark">  </textarea>
					</li>
					<li><input type="submit" value="Submit"/></li>
					<li><a href="#main_task_page"> Back to tasks </a></li>
				</ul>
			</form>
		</div>
	</div>	
	<?php endfor; ?>
</body>
</html>
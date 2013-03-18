<!-- HEADER -->
<?= $this->load->view('/mobile/templates/mob_header') ?>

<!-- CONTENT -->
</head>
<body>
<?php for ($ctr = 0; $ctr < count($tasks); $ctr++): ?>
	<div data-role="page">
		<div data-role="header">
			<a href="<?php echo site_url('mobile/tasks');?>" data-ajax="false" data-icon="delete"> Cancel </a>
			<h1> <?= $tasks[$ctr]['task_header'] ?> </h1>
		</div><!-- /head -->
		<div data-role="content">
			<form action="done" method="post" data-ajax="false">
				<input type="hidden"
					id="task_no" 
					name="task_no" 
					value="<?= $tasks[$ctr]['task_no'] ?>"
					/>
				<ul data-role="listview">
					<li><label>Date given: </label><?= $tasks[$ctr]['date_sent'] ?> <br/></li>
					<li><label>Task info: </label><?= $tasks[$ctr]['task'] ?> <br/></li>
					<li><label for="TPtask_remark"> Remarks when done: </label>
						<label style="color:red"><?php echo form_error('TPtask_remark'); ?></label>
						<textarea name="TPtask_remark" id="TPtask_remark">  </textarea>
					</li>
				</ul> <br/>
				<input type="submit" value="Submit"/>
			</form>
		</div><!-- /content -->
	</div><!-- /page -->
	<?php endfor; ?>
</body>
</html>
<!-- HEADER -->
<?= $this->load->view('/mobile/templates/mob_header') ?>

<!-- CONTENT -->

</head>
<body>
	<div data-role="page" id="main_task_page">
		<div data-role="header">
			<a href="<?php echo site_url('mobile');?>" data-ajax="false" data-icon="delete"> Cancel </a>
			<h1> Assigned Tasks </h1>
		</div>
		<div data-role="content">
			<ul data-role="listview" data-filter="true" data-filter-placeholder="Search for task" data-inset="true">
			<?php for ($ctr = 0; $ctr < count($tasks); $ctr++): ?>
				<li><a href="<?= current_url() . '/' . $tasks[$ctr]['task_no'] ?>" data-ajax="false"> <?= $tasks[$ctr]['task_header'] ?> </a></li>
			<?php endfor; ?>
			</ul>
			<br/>
			<ul data-role="listview">
				<li> <?= $result ?></li>
			</ul>
		</div><!-- /content -->
	</div><!-- /page-->
</body>
</html>
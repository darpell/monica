<!-- HEADER -->
<?= $this->load->view('/mobile/templates/mob_header') ?>

<!-- CONTENT -->

</head>
<body>
	<div data-role="page">
		<div data-role="header">
			<p style="font-size:medium;padding:5px;text-align:center;"> Assigned Tasks </p>
		</div>
		<div data-role="content">
			<ul data-role="listview" data-filter="true" data-filter-placeholder="Search for task" data-inset="true">
				<li><a> Task 1 </a></li>
				<li><a> Task 2 </a></li>
				<li><a> Task 3 </a></li>
			</ul>
		</div><!-- /content -->
	</div><!-- /page -->
</body>
</html>
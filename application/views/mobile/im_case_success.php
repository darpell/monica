<!-- HEADER -->
<?= $this->load->view('/mobile/templates/mob_header') ?>

<!-- CONTENT -->
</head> 
<body> 

<div data-role="page">

	<div data-role="header">
		<h1> Success </h1>
	</div><!-- /header -->

	<div data-role="content">
		<ul data-role="listview">
		<!-- <li> <a href="<?php //echo site_url('mobile/page/uninvestigated_cases');?>" data-ajax="false" data-transition="slide"> Add another entry </a> </li> -->
			<li> <a href="<?php echo site_url('mobile');?>" data-ajax="false" data-transition="slide"> Back to Home </a> </li>
			<li> 
				<?php echo $result; ?> <br/> <br/>
				<?php echo $treatment; ?>
			</li>
		</ul>
	</div><!-- /content -->
</div><!-- /page -->

</body>
</html>
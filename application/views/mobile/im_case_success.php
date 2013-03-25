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
		<p><?php echo $result; ?></p> <br/>
		<ul data-role="listview">
			<li> <a href="<?php echo site_url('mobile/immediate_case');?>" data-ajax="false" data-transition="slide"> Add another entry </a> </li>
			<li> <a href="<?php echo site_url('mobile');?>" data-ajax="false" data-transition="slide"> Back to Home </a> </li>
		</ul>
	</div><!-- /content -->
</div><!-- /page -->

</body>
</html>
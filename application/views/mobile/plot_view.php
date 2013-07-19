<!-- HEADER -->
<?= $this->load->view('/mobile/templates/mob_header') ?>

<!-- CONTENT -->
</head> 
<body> 

<div data-role="page">

	<div data-role="header">
		<h1> <?php echo $title; ?></h1>
	</div><!-- /header -->

	<div data-role="content">	
		
		<?php
		echo '<h2>'.$case_details['title'].'</h2>';
		//echo $case_details['text'];?>
		
	</div><!-- /content -->
</div><!-- /page -->

</body>
</html>
<!-- HEADER -->
<?= $this->load->view('/mobile/templates/mob_header') ?>

<!-- CONTENT -->
</head>

<body>
<div data-role="page" style="top:0;left:0; right:0; bottom:0;">
	<div data-role="header" ><!-- data-position="fixed"> -->
    	<a href="<?php echo site_url('mobile/case_report');?>" data-ajax="false" data-icon="delete"> Cancel </a>
    	<h2> Street/Addess </h2>
    </div> <!-- /header-->
	<div data-role="content">
		<input type="hidden" name="province" value="<?php echo $province;?>" />
			<input type="hidden" name="city" value="<?php echo $city;?>" />
			<input type="hidden" name="brgy" value="<?php echo $brgy;?>" />
		<h2> Street/Addess </h2> <br/>
		<ul data-role="listview">
			<?php for ($i = 0; $i < count($places); $i++) :?>
			<li> <?php echo $places[$i]['place'];?> </li>
			<?php endfor;?>
		</ul>
	</div><!-- /content -->
</div><!-- /page -->
</body>
</html>
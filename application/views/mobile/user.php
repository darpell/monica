<!-- HEADER -->
<?= $this->load->view('/mobile/templates/mob_header') ?>

<!-- CONTENT -->
</head>
<body>
<div data-role="page" id="user" style="width:100%; height:100%;">
    <div data-role="header" data-id="myfooter" id="user_header" data-position="fixed">
		<a href="<?php echo site_url('mobile');?>" data-ajax="false" data-icon="delete"> Cancel </a>
        <h1> User Details </h2>
    </div><!-- /header -->

    <div data-role="content" id="user_content">    
    	<ul data-role="listview">
    		<li> Username: <?php echo $this->session->userdata('TPusername'); ?> </li>
    		<li> Type: <?php echo $this->session->userdata('TPtype'); ?> </li>
    		<li> Name: <?php echo $this->session->userdata('TPfirstname'); ?> <?php echo $this->session->userdata('TPlastname'); ?> </li>
    		<li> Last Visited: <?php echo $last_visit['ls_barangay']; ?> </li>
    		<li> Last Visited on: <?php echo $last_visit['ls_date']; ?> </li>
    		<li> <a href="<?php echo site_url('mobile/logout');?>" data-ajax="false" data-transition="slide"> Logout </a> </li>
    	</ul>
    </div><!-- /content -->
</div><!-- /page -->
</body>
</html>
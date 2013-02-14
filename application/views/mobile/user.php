<!-- HEADER -->
<?= $this->load->view('/mobile/templates/mob_header') ?>

<!-- CONTENT -->
</head>
<body>
<div data-role="page" id="user" style="width:100%; height:100%;">
    <div data-role="header" data-id="myfooter" id="user_header" data-position="fixed">
        <p style="font-size:medium;padding:5px;text-align:center;"> User Details </p>
    </div><!-- /header -->

    <div data-role="content" id="user_content">    
        <table>
        	<tr><!-- username -->
        		<td> Username </td>
        		<td> <?php echo $this->session->userdata('TPusername'); ?> </td>
        	</tr>
        	<tr><!-- type -->
        		<td> Type </td>
        		<td> <?php echo $this->session->userdata('TPtype'); ?></td>
        	</tr>
        	<tr><!-- first name -->
        		<td>First Name</td>
        		<td> <?php echo $this->session->userdata('TPfirstname'); ?> </td>
        	</tr>
        	<tr><!-- last name -->
        		<td> Last Name</td>
        		<td> <?php echo $this->session->userdata('TPlastname'); ?> </td>
        	</tr>
        	<tr>
        		<td rowspan="2"> &nbsp;</td>	
        	</tr>
        	<tr>
        		<td rowspan="2"> <a href="<?php echo site_url('mobile/logout');?>" data-ajax="false" data-transition="slide"> Logout </a> </td>
        	</tr>
        </table>
    </div><!-- /content -->
</div><!-- /page -->
</body>
</html>
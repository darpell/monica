<!-- HEADER -->
<?php echo $this->load->view('mobile/templates/mob_header'); ?>

<!-- CONTENT -->
</head>
<body>
    <div data-role="page" data-title="Login" id="page1"> 
        <div  data-role="header" data-theme="a" id="login_header" data-nobackbtn="true">
            <h1> &nbsp; </h1>
        </div> <!-- /header --> 
        <div data-role="content" id="login_content">
        
        <form id="mob_login" action="mob_check" method="post" data-ajax="false">
        	<ul data-role="listview">
        		<li> <label style="color:red"> <?= $result ?> </label> </li>
	        	<li>
	        	<label for="mob_username">Username:</label> 
	        	<label style="color:red"><?php echo form_error('mob_username-txt_r'); ?></label>
	            <input data-mini="true" type="text" id="mob_username" name="mob_username-txt_r" />
	        	</li>
	
				<li>
	            <label for="mob_password">Password:</label>
	            <label style="color:red"><?php echo form_error('mob_password-txt_r'); ?></label>
	            <input data-mini="true" type="password" id="mob_password" name="mob_password-txt_r" />
	            </li>
           	<li> <input type="submit" value="Submit"/> </li>
           	</ul>
        </form>
        
        </div> <!-- /content -->
	<!-- /dialogs -->
	</div><!-- /page -->
</body>
</html>
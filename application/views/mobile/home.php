<!-- HEADER -->
<?= $this->load->view('/mobile/templates/mob_header') ?>

<!-- CONTENT -->
</head>
<body>
<div data-role="page" id="home" style="width:100%; height:100%;">
    <div data-role="header" data-id="myfooter" id="home_header" data-position="fixed">
        <!-- <p style="font-size:medium;padding:5px;text-align:center;">Dengue Mapping</p> -->
        <h1> Home </h1>
    </div><!-- /header -->

    <div data-role="content" id="home_content">    
    	<ul data-role="listview" data-autodividers="true" data-inset="true">
    		<li> Username: <?php echo $this->session->userdata('TPusername'); ?> </li>
    		<li> Type: <?php echo $this->session->userdata('TPtype'); ?> </li>
    		<li> Name: <?php echo $this->session->userdata('TPfirstname'); ?> <?php echo $this->session->userdata('TPlastname'); ?> </li>
    		<li> Last Visited Barangay: <?php echo $last_visit['ls_barangay']; ?> </li>
    		<li> Last Visited on: <?php echo $last_visit['ls_date']; ?> </li>
    	</ul>

    	<ul data-role="listview" data-autodividers="true" data-inset="true" data-count-theme="b">
			<li><a href="<?php echo site_url('mobile/tasks');?>" data-ajax="false" data-transition="slide"> Tasks <span class="ui-li-count"><?php echo $task_count['task_count']; ?></span></a></li>
			<li> <a href="<?php echo site_url('mobile/immediate_case');?>" data-ajax="false" data-transition="slide"> Report Suspected Case </a> </li>
		</ul>
		<ul data-role="listview" data-autodividers="true" data-inset="true" data-count-theme="b">
			<li> <a href="<?php echo site_url('mobile/page/checklocation');?>" data-ajax="false" data-transition="slide"> Plot Current Location </a> </li>
        	<li> <a href="<?php echo site_url('mobile/page/point_of_interest');?>" data-ajax="false" data-transition="slide"> Add Source/Risk Area </a> </li>
           	<li> <a href="<?php echo site_url('mobile/page/larval_survey');?>" data-ajax="false" data-transition="slide"> Fill up Larval Form </a> </li>
        </ul>
        
        <ul data-role="listview" data-autodividers="true" data-inset="true">
            <li> <a href="<?php echo site_url('mobile/riskmap');?>" data-ajax="false" data-transition="slide"> Risk Map </a> </li>
        	<li> <a href="<?php echo site_url('mobile/casemap');?>" data-ajax="false" data-transition="slide"> Case Map </a> </li>
        	
        </ul>
        
        <ul data-role="listview" data-autodividers="true" data-inset="true">
        	<li> <a href="<?php echo site_url('mobile/page/deng_info');?>" data-ajax="false" data-transition="slide"> Brief Dengue information </a> </li>
        	<li> <a href="<?php echo site_url('mobile/logout');?>" data-ajax="false" data-transition="slide"> Logout </a> </li>
        </ul>
        <br/><br/>
        
        <input type="hidden" id="result" value="<?php echo $result; ?>" />
        
    </div><!-- /content -->
	
</div><!-- /page -->
</body>
</html>
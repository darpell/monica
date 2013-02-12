<!-- HEADER -->
<?= $this->load->view('/mobile/templates/mob_header') ?>

<!-- CONTENT -->
<script type="text/javascript">
		/*$( document ).bind( "mobileinit", function() {
			// Make your jQuery Mobile framework configuration changes here!
			$.support.cors = true;
			$.mobile.allowCrossDomainPages = true;
		});*/
    </script>
    <script type="text/javascript">
	        $(document).ready(function()
	    	{

				var result = $('#result').val();

				if (result != '' || result != null)
				{
					hideMain();
					$('#contentDialog').show();
				}
				else
				{
	        		$('#contentDialog').hide();
				}

	            $('#buttonOK').click(function() {
			    	$('#contentDialog').hide();
			        showMain();
			        return false;      
			      });
			});
			
		    function hideMain(){  
			        $('#home_header').hide();
			        $('#home_content').hide();
			    }  
			    
			    function showMain(){  
			        $('#home_header').show();
			        $('#home_content').show();
			    }
        </script>
</head>
<body>
<div data-role="page" id="home" style="width:100%; height:100%;">
    <div data-role="header" data-id="myfooter" id="home_header" data-position="fixed">
        <p style="font-size:medium;padding:5px;text-align:center;">Dengue Mapping</p>
    </div><!-- /header -->

    <div data-role="content" id="home_content">    
        <ul data-role="listview" data-autodividers="true" data-inset="true">
            <li><a href="<?php echo site_url('mobile/user');?>" data-ajax="false" data-transition="slide"> Login Details </a></li>
            <!-- <li><a href="" data-transition="slide"> Status &amp; Notifications </a></li> -->
        </ul>
        <ul data-role="listview" data-autodividers="true" data-inset="true">
            <li> <a href="<?php echo site_url('mobile/riskmap');?>" data-ajax="false" data-transition="slide"> Risk Map </a> </li>
        	<li> <a href="<?php echo site_url('mobile/casemap');?>" data-ajax="false" data-transition="slide"> Case Map </a> </li>
        	
        </ul>
        <ul data-role="listview" data-autodividers="true" data-inset="true">
			<li> <a href="<?php echo site_url('mobile/checklocation');?>" data-ajax="false" data-transition="slide"> Plot Current Location </a> </li>
        	<li> <a href="<?php echo site_url('mobile/larval_survey');?>" data-ajax="false" data-transition="slide"> Fill up Larval Form </a> </li>
        </ul>
        
        <br/><br/>
        
        <input type="hidden" id="result" value="<?php echo $result; ?>" />
        
    </div><!-- /content -->
    
    <!-- Dialogs -->
	<div align="CENTER" data-role="content" id="contentDialog">	
	 	<div> <?php if ($result != null) echo $result; ?> </div>
	 	<a id="buttonOK" href="#home" data-role="button" data-inline="true">OK</a>
	</div>	<!-- contentDialog -->
	<!-- /dialogs -->
	
</div><!-- /page -->
</body>
</html>
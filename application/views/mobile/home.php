<!-- HEADER -->
<?= $this->load->view('/mobile/templates/mob_header.php') ?>

<!-- CONTENT -->
<script type="text/javascript">
		$( document ).bind( "mobileinit", function() {
			// Make your jQuery Mobile framework configuration changes here!
			$.support.cors = true;
			$.mobile.allowCrossDomainPages = true;
		});
    </script>

<div data-role="page" id="home" style="width:100%; height:100%;">
    <div data-role="header" data-id="myfooter" data-position="fixed">
        <p style="font-size:medium;padding:5px;text-align:center;">Dengue Mapping</p>
    </div><!-- /header -->

    <div data-role="content">    
        <ul data-role="listview" data-autodividers="true" data-inset="true">
            <li><a href="index.php/mobile/login" data-ajax="false" data-transition="slide"> Login Details </a></li>
            <!-- <li><a href="" data-transition="slide"> Status &amp; Notifications </a></li> -->
        </ul>
        <ul data-role="listview" data-autodividers="true" data-inset="true">
            <li><?php echo anchor('mobile/riskmap', 'Risk Map', 'data-ajax="false" data-transition="slide"');?></li>
        	<li><?php echo anchor('mobile/casemap', 'Case Map', 'data-ajax="false" data-transition="slide"');?></li>
        	
        </ul>
        <ul data-role="listview" data-autodividers="true" data-inset="true">
			<li><?php echo anchor('mobile/checklocation', 'Plot Current Location', 'data-ajax="false" data-transition="slide"');?></li>
        	<li><?php echo anchor('mobile/larval_survey', 'Fill up Larval Form', 'data-ajax="false" data-transition="slide"');?></li>
        </ul>
    </div><!-- /content -->

<!-- FOOTER -->
<?= $this->load->view('/mobile/templates/mob_footer.php') ?>
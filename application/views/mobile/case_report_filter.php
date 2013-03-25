<!-- HEADER -->
<?= $this->load->view('/mobile/templates/mob_header') ?>

<!-- CONTENT -->
</head>

<body>
<div data-role="page" style="top:0;left:0; right:0; bottom:0;">
	<div data-role="header" ><!-- data-position="fixed"> -->
    	<a href="<?php echo site_url('mobile/case_report');?>" data-ajax="false" data-icon="delete"> Cancel </a>
    	<h2> Filter </h2>
    </div> <!-- /header-->
	<div data-role="content">
		<form action="<?php echo $action; ?>" method="post" data-ajax="false">
			<input type="hidden" name="province" value="<?php echo $province;?>" />
			<input type="hidden" name="city" value="<?php echo $city;?>" />
			<input type="hidden" name="brgy" value="<?php echo $brgy;?>" />
			
			<?php if ($city != '')
				{
			?>
				<label for="begin_date"> From: </label>
				<label style="color:red"><?php echo form_error('begin_date'); ?></label>
				<input name="begin_date" id="begin_date" type="date" value="<?php echo set_value('begin_date'); ?>" data-role="datebox" data-options='{"mode":"calbox", "beforeToday": true, "calShowWeek": true, "calUsePickers": true, "calNoHeader": true, "noButtonFocusMode": true, "useNewStyle":true}' />
			    
			    <label for="end_date"> To: </label>
			    <label style="color:red"><?php echo form_error('end_date'); ?></label>
				<input name="end_date" id="end_date" type="date" value="<?php echo set_value('end_date'); ?>" data-role="datebox" data-options='{"mode":"calbox", "beforeToday": true, "calShowWeek": true, "calUsePickers": true, "calNoHeader": true, "useTodayButton": true, "noButtonFocusMode": true, "useNewStyle":true}' />
					
			<?php 
				}
				?>
			
			<label for="place" class="select"> Place: </label>
				<select name="place" id="place">
				   <?php for ($i = 0; $i < count($places); $i++) :?>
				   <option value="<?php echo $places[$i]['place'];?>"> <?php echo ucfirst(strtolower($places[$i]['place']));?> </option>
				   <?php endfor;?>
				</select>
				<input type="submit" value="Next" />
		</form>
	</div><!-- /content -->
</div><!-- /page -->
</body>
</html>
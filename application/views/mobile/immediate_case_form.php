<!-- HEADER -->
<?php echo $this->load->view('mobile/templates/mob_header'); ?>
<!-- CONTENT -->
</head> 
<body>

<div data-role="page" id="page-main" style="width:100%; height:100%;">
    <div data-role="header">
		<a href="<?php echo site_url('mobile');?>" data-ajax="false" data-icon="delete"> Cancel </a>
        <h1> Report Suspected Case </h1>
    </div><!-- /header -->
    <div data-role="content" id="ls_content">
    
<form id="" action="case_add" method="post" data-ajax="false">

	<!-- date -->
	<label for="TPdate-txt"> Date: </label>
		<label style="color:red"><?php echo form_error('TPdate-txt_r'); ?></label>
		<input type="date" name="TPdate-txt_r" id="TPdate-txt" value="<?php echo date("Y-m-d"); ?>" data-mini="true" readonly />
		<!-- /date -->
	
	<!-- fname -->
	<label for="TPfname-txt"> First Name: </label>
		<label style="color:red"><?php echo form_error('TPfname-txt_r'); ?></label>
		<input type="text" name="TPfname-txt_r" id="TPfname-txt" value="<?php echo set_value('TPfname-txt_r'); ?>" data-mini="true" />
		<!-- /fname -->
	
	<!-- lname -->
	<label for="TPlname-txt"> Last Name: </label>
		<label style="color:red"><?php echo form_error('TPlname-txt_r'); ?></label>
		<input type="text" name="TPlname-txt_r" id="TPlname-txt" value="<?php echo set_value('TPlname-txt_r'); ?>" data-mini="true" />
		<!-- /lname -->
	
	<!-- age -->
	<label for="TPage-txt"> Age: </label>
		<label style="color:red"><?php echo form_error('TPage-txt_r'); ?></label>
		<input type="text" name="TPage-txt_r" id="TPage-txt" value="<?php echo set_value('TPage-txt_r'); ?>" data-mini="true" />
		<!-- /age -->
	
	<!-- sex -->
	<label> Gender: </label>
	<fieldset data-role="controlgroup" data-mini="true" data-type="horizontal">
			<label style="color:red"><?php echo form_error('TPsex-txt_r'); ?></label>
	    	<input type="radio" name="TPsex-txt_r" id="TPsex-txt-1" value="0" checked="checked" />
	    	<label for="TPsex-txt-1">Male</label>
	
			<input type="radio" name="TPsex-txt_r" id="TPsex-txt-2" value="1"  />
	    	<label for="TPsex-txt-2">Female</label>
		</fieldset>
		<!-- /sex -->
		
	<!-- date of birth -->
	<label for="TPdob-txt"> Date of Birth: </label>
		<label style="color:red"><?php echo form_error('TPdob-txt_r'); ?></label>
		<input name="TPdob-txt_r" id="TPdob-txt" type="date" value="<?php echo set_value('TPdob-txt_r'); ?>" data-mini="true" data-role="datebox" data-options='{"mode":"flipbox", "beforeToday": true, "calShowWeek": true, "calUsePickers": true, "calNoHeader": true, "noButtonFocusMode": true, "useNewStyle":true}' />    
		<!-- /date of birth -->
	
	<!-- address -->
	<label for="TPaddress-txt"> Address: </label>
		<label style="color:red"><?php echo form_error('TPaddress-txt_r'); ?></label>
		<input type="text" name="TPaddress-txt_r" id="TPaddress-txt" value="<?php echo set_value('TPaddress-txt_r'); ?>" data-mini="true" />
		<!-- /address -->
	
	<!-- remarks -->
	<label for="TPremarks-txt"> Remarks: (e.g. symptoms like high fever, etc.)</label>
		<label style="color:red"><?php echo form_error('TPremarks-txt_r'); ?></label>
		<textarea  name="TPremarks-txt_r" id="TPremarks-txt" placeholder="<?php echo set_value('TPremarks-txt_r'); ?>" data-mini="true"> </textarea>
	<!-- /remarks -->

	<div>
		<input type="submit" value="Submit" />
	</div>

</form>

    </div><!-- /content -->
</div><!-- /page -->

</body>
</html>
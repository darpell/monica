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
		<input type="text" name="TPfname-txt_r" id="TPfname-txt" value="<?php echo set_value('TPfname-txt'); ?>" data-mini="true" />
		<!-- /fname -->
	
	<!-- lname -->
	<label for="TPlname-txt"> Last Name: </label>
		<label style="color:red"><?php echo form_error('TPlname-txt_r'); ?></label>
		<input type="text" name="TPlname-txt_r" id="TPlname-txt" value="<?php echo set_value('TPlname-txt'); ?>" data-mini="true" />
		<!-- /lname -->
	
	<!-- age -->
	<label for="TPage-txt"> Age: </label>
		<label style="color:red"><?php echo form_error('TPage-txt_r'); ?></label>
		<input type="text" name="TPage-txt_r" id="TPage-txt" value="<?php echo set_value('TPage-txt'); ?>" data-mini="true" />
		<!-- /age -->
	
	<!-- sex -->
	<label for="TPsex-txt"> Gender: </label>
		<label style="color:red"><?php echo form_error('TPsex-txt_r'); ?></label>
		<input type="text" name="TPsex-txt_r" id="TPsex-txt" value="<?php echo set_value('TPsex-txt'); ?>" data-mini="true" />
		<!-- /sex -->
	
	<!-- date of birth -->
	<label for="TPdob-txt"> Date of Birth: </label>
		<label style="color:red"><?php echo form_error('TPdob-txt_r'); ?></label>
		<input name="TPdob-txt_r" id="TPdob-txt" type="date" value="<?php echo set_value('TPdob-txt'); ?>" data-mini="true" data-role="datebox" data-options='{"mode":"calbox", "beforeToday": true, "calShowWeek": true, "calUsePickers": true, "calNoHeader": true, "noButtonFocusMode": true, "useNewStyle":true}' />    
		<!-- /date of birth -->
	
	<!-- address -->
	<label for="TPaddress-txt"> Address: </label>
		<label style="color:red"><?php echo form_error('TPaddress-txt_r'); ?></label>
		<input type="text" name="TPaddress-txt_r" id="TPaddress-txt" value="<?php echo set_value('TPaddress-txt'); ?>" data-mini="true" />
		<!-- /address -->
	
	<!-- remarks -->
	<label for="TPremarks-txt"> Remarks: </label>
		<label style="color:red"><?php echo form_error('TPremarks-txt_r'); ?></label>
		<input type="text" name="TPremarks-txt_r" id="TPremarks-txt" value="<?php echo set_value('TPremarks-txt'); ?>" data-mini="true" />
	<!-- /remarks -->

	<div>
		<input type="submit" value="Submit" />
	</div>

</form>

    </div><!-- /content -->
    <!-- Dialogs -->
          <div align="CENTER" data-role="content" id="contentDialog">	
	 <div>Please fill in all required fields before submitting the form.</div>
	 <a id="buttonOK" href="#page2" data-role="button" data-inline="true">OK</a>
	</div>	<!-- contentDialog -->
	
  	<!-- contentTransition is displayed after the form is submitted until a response is received back. -->
	<div data-role="content" id="contentTransition">	
	 <div align="CENTER"><h4>Please wait while your data is being entered.</h4></div>
	 <div align="CENTER"><img id="spin" name="spin" src="<?= base_url('images/wait.gif') ?>"/></div>
	</div>	<!-- contentTransition -->

	<!-- /dialogs -->
</div><!-- /page -->

</body>
</html>
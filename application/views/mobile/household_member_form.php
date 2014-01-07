<!-- HEADER -->
<?php echo $this->load->view('mobile/templates/mob_header'); ?>
</head> 
<body>

<div data-role="page" id="page2" style="width:100%; height:100%;">
    <div data-role="header" data-nobackbtn="true">
		<a href="<?php echo site_url('mobile');?>" data-ajax="false" data-icon="delete"> Cancel </a>
        <h1>Add Household Member</h1>
    </div><!-- /header -->
    <div data-role="content">
    
		<form id="hh_mem_form" action="" method="post" data-ajax="false">
			
			<p><?php echo $household_id; ?>	</p>
			
			<!-- first_name -->
			<label for="hh_fname"> First Name: </label>
			<label style="color:red"><?php echo form_error('hh_fname'); ?></label>
			<input type="text" name="hh_fname" id="hh_fname" value="<?php echo set_value('hh_fname'); ?>" data-mini="true" />
			<!-- /first_name -->
			
			<!-- last_name -->
			<label for="hh_lname"> Last Name: </label>
			<label style="color:red"><?php echo form_error('hh_lname'); ?></label>
			<input type="text" name="hh_lname" id="hh_lname" value="<?php echo set_value('hh_lname'); ?>" data-mini="true" />
			<!-- /last_name -->
			
			<!-- dob -->
			<label for="hh_dob"> Date of Birth: </label>
			<label style="color:red"><?php echo form_error('hh_dob'); ?></label>
			<input type="text" name="hh_dob" id="hh_dob" value="<?php echo set_value('hh_dob'); ?>" data-mini="true" />
			<!-- /dob -->
			
			<!-- gender -->
			<label for="hh_gender"> Gender: </label>
			<label style="color:red"><?php echo form_error('hh_gender'); ?></label>
			<input type="text" name="hh_gender" id="hh_gender" value="<?php echo set_value('hh_gender'); ?>" data-mini="true" />
			<!-- /gender -->
			
			<!-- marital -->
			<label for="hh_marital"> Marital Status: </label>
			<label style="color:red"><?php echo form_error('hh_marital'); ?></label>
			<input type="text" name="hh_marital" id="hh_marital" value="<?php echo set_value('hh_marital'); ?>" data-mini="true" />
			<!-- /marital -->
			
			<!-- nationality -->
			<label for="hh_nationality"> Nationality: </label>
			<label style="color:red"><?php echo form_error('hh_nationality'); ?></label>
			<input type="text" name="hh_nationality" id="hh_nationality" value="<?php echo set_value('hh_nationality'); ?>" data-mini="true" />
			<!-- /nationality -->
			
			<!-- blood_type -->
			<label for="hh_blood"> Name of Household: </label>
			<label style="color:red"><?php echo form_error('hh_blood'); ?></label>
			<input type="text" name="hh_blood" id="hh_blood" value="<?php echo set_value('hh_blood'); ?>" data-mini="true" />
			<!-- /blood_type -->
			
			<!-- guardian -->
			<label for="hh_guardian"> Guardian (if any): </label>
			<label style="color:red"><?php echo form_error('hh_guardian'); ?></label>
			<input type="text" name="hh_guardian" id="hh_guardian" value="<?php echo set_value('hh_guardian'); ?>" data-mini="true" />
			<!-- /guardian -->
			
			<!-- adu -->
			<label for="hh_adu"> ADU(?): </label>
			<label style="color:red"><?php echo form_error('hh_adu'); ?></label>
			<input type="text" name="hh_adu" id="hh_adu" value="<?php echo set_value('hh_adu'); ?>" data-mini="true" />
			<!-- /adu -->
			
			<!-- contact -->
			<label for="hh_contact"> Name of Household: </label>
			<label style="color:red"><?php echo form_error('hh_contact'); ?></label>
			<input type="text" name="hh_contact" id="hh_contact" value="<?php echo set_value('hh_contact'); ?>" data-mini="true" />
			<!-- /contact -->
					
			<div>
				<input type="submit" value="Submit" />
			</div>
				
		</form>

    </div><!-- /content -->
</div><!-- /page -->

</body>
</html>
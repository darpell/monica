<!-- HEADER -->
<?= $this->load->view('/mobile/templates/mob_header.php') ?>


<!-- CONTENT -->

		<script type="text/javascript">
	        $(document).ready(function(){
	        	mob_username = $('#mob_username');
	        	mob_password = $('#mob_password');
	        	mob_footer = $('#myfooter');
	        	inputMapVar = $('input[name*="_r"]');

	        	$('#contentDialog').hide();
	            $('#contentTransition').hide();

	            $('#buttonOK').click(function() {
			    	$('#contentDialog').hide();
			        showMain();
			        return false;      
			      });

	            $('#mob_login').submit(function(){
					var err = false;
			        // Hide the Main content
			        hideMain();
			        
			        // Perform form validation
			        inputMapVar.each(function(index){  
			        if($(this).val() == null || $(this).val() == EMPTY){  
			            $(this).prev().addClass(MISSING);            
			            err = true;
			          }          
			        });
			        
			        // If validation fails, show Dialog content
			        if(err == true){            
			        	$('#contentDialog').show();
			          return false;
			        }        
			        
			        // If validation passes, show Transition content
			        $('#contentTransition').show();
			        
			        // Submit the form
			        $.post("mobile/login/check", $('#mob_login').serialize(), function(data){
			        	$('#contentTransition').hide();
			        });        
			        return false;
				});
			});
			
		    function hideMain(){  
		        $('#login_header').hide();  
		        $('#login_content').hide();  
		        mob_footer.hide();  
			    }  
			    
			    function showMain(){  
			        $('#login_header').show();  
			        $('#login_content').show();  
			        mob_footer.show();  
			    }
        </script>

    <div data-role="page" data-title="Login" id="page1"> 
        <div  data-role="header" data-theme="a" id="login_header" name="login_header" data-nobackbtn="true">
            <p style="font-size:medium;padding:5px">Dengue Mapping</p>
        </div> <!-- /header --> 
        <div data-role="content" id="login_content">
        
        <?php //form_open('mobile/login/check'); ?>
        <form id="mob_login" data-ajax="false"> <!-- action="mobile/login/check" method="post"> -->
        	<div data-role="fieldcontain" class="ui-hide-label">
	        	<label for="mob_username">Username:</label>
	        	<label style="color:red"><?php echo form_error('mob_username-txt'); ?></label> <br/> 
	            <input data-mini="true" type="text" id="mob_username" name="mob_username-txt_r" value="<?php echo set_value('Username'); ?>" placeholder="Username"/> <br/>
	             
            </div>
            
            <div data-role="fieldcontain" class="ui-hide-label">
	            <label for="mob_password">Password:</label>
	            <label style="color:red"><?php echo form_error('mob_password-txt'); ?></label> <br/>
	            <input data-mini="true" type="password" id="mob_password" name="mob_password-txt_r" value="<?php echo set_value('Password'); ?>" placeholder="Password"/> <br/>
	             
            </div>
            
            <div id="submitDiv" data-role="fieldcontain">
            	<input data-mini="true" type="submit" value="Submit"/>
            </div>
            <!-- <div data-role="button" data-icon="check" data-theme="b">Login</div> -->
        </form>
        
        </div> <!-- /content -->
        
        <!-- Dialogs -->
          <div align="CENTER" data-role="content" id="contentDialog" name="contentDialog">	
	 <div>Please fill in all required fields before submitting the form.</div>
	 <a id="buttonOK" name="buttonOK" href="#page1" data-role="button" data-inline="true">OK</a>
	</div>	<!-- contentDialog -->
	
  	<!-- contentTransition is displayed after the form is submitted until a response is received back. -->
	<div data-role="content" id="contentTransition" name="contentTransition">	
	 <div align="CENTER"><h4>Logging In. Please wait.</h4></div>
	 <div align="CENTER"><img id="spin" name="spin" src="images/wait.gif"/></div>
	</div>	<!-- contentTransition -->

	<!-- /dialogs -->
   
<!-- FOOTER -->
<?= $this->load->view('/mobile/templates/mob_footer.php') ?>
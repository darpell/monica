<!-- HEADER -->
<?= $this->load->view('/mobile/templates/mob_header') ?>

<!-- CONTENT -->
</head> 
<body> 

<div data-role="page">
	
		<div data-role="header">
			<h1>Filter Cases</h1>

		</div>

		<div data-role="content" data-theme="c">
			<form action="case_dialog" method="post" data-ajax="false">			    

				<label for="begin_date"> From: </label>
				<input name="begin_date" id="begin_date" type="date" data-role="datebox" data-options='{"mode":"calbox", "beforeToday": true, "calShowWeek": true, "calUsePickers": true, "calNoHeader": true, "noButtonFocusMode": true, "useNewStyle":true}' />
			    
			    <label for="end_date"> To: </label>
				<input name="end_date" id="end_date" type="date" data-role="datebox" data-options='{"mode":"calbox", "beforeToday": true, "calShowWeek": true, "calUsePickers": true, "calNoHeader": true, "useTodayButton": true, "noButtonFocusMode": true, "useNewStyle":true}' />
					
			    <input type="submit" value="Submit" />
			</form>     
			<a href="<?php echo site_url('mobile/casemap');?>" data-role="button" data-theme="c" data-ajax="false"> Cancel </a>    
		</div>
</div>

</body>
</html>
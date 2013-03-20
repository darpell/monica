<!-- HEADER -->
<?= $this->load->view('/mobile/templates/mob_header') ?>

<!-- CONTENT -->
    
<body>
<div data-role="dialog">
		<div data-role="header" data-theme="d">
			<h1> Options </h1>
		</div>
		<div data-role="content" data-theme="c">
			<ul data-role="listview">
				<li><a href="<?= site_url('mobile/larval_dialog')?>"> Filter Results </a></li>
	    		<li><a href="<?= site_url('mobile/riskmap')?>"> Show All Results</a></li>
    		</ul>
		</div>
	</div>
</body>
</html>
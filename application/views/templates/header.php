<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $title; ?> - Dengue Information</title>
<?php
echo link_tag('styles/style2.css');
if($script != "")
	$this->load->view('scripts/'.$script);
?>

<?php if ($this->session->userdata('TPusername') == true) {?>
	<style>
	.header div div > a {
		display:block;
		float:right;
		margin:0 19px 0 0;
		width:201px;
		height:54px;
		background:url(<?= base_url('/images/logout1.png')?>);
		text-indent:-99999px;
	}
	.header div div > a:hover {
		background:url(<?= base_url('/images/logout2.png')?>);
	}
	</style>
<?php }?>

</head>
<body>
<!-- <div id="main_container"> -->
<div class="header">
		<div>
			<a href="<?= base_url('index.php') ?>" id="logo"><img src="<?= base_url('/images/logo.png') ?>" alt="logo"></a>
			<div>
			<?php if ($this->session->userdata('TPusername') == FALSE) {?>
				<a href="<?= base_url('index.php/login') ?>">Login</a>
			<?php } else {?>
				<a href="<?= base_url('index.php/logout') ?>">Logout</a>
			<?php } ?>
				<ul>
					<li class="selected"><?= anchor(base_url('index.php'),'Home')?></li>
					<?php if($this->session->userdata('TPtype') == "CHO"){?>
                	<li><?= anchor(base_url('index.php/upload'),'Upload Cases')?></li>
                	<li><?= anchor(base_url('index.php/CHO/dashboard'),'Dashboard')?></li>
                	 <li><?= anchor(base_url('index.php/CHO/view_dengue_profile'),'Dengue Profile')?></li>
                	<?php }?>
                	<?php if($this->session->userdata('TPtype') == "BHW"){?>
                	<li><?= anchor(base_url('index.php/suggested/'),'Route Information')?></li>
                	<li><?= anchor(base_url('index.php/master_list/view_household_bhw'),'Catchment Area	')?></li>
                	<?php }?>
                		<?php if($this->session->userdata('TPtype') == "MIDWIFE"){?>
                	<li><?= anchor(base_url('index.php/master_list/view_household_midwife'),'Dashboard')?></li>
                	<?php }?>
					<li><?= anchor(base_url('index.php/CHO/epidemic_threshold'),'Epidemic Threshold')?></li>
 					<li><?= anchor(base_url('index.php/case_report/testChart'),'Surveillance Report ')?></li>
 					<?php if($this->session->userdata('TPtype') == "CHO"){?>
 					<li><?= anchor(base_url('index.php/login/admin_functions'),'Admin Functions ')?></li>
 					<?php }?>
				</ul>
			</div>
		</div>
	</div>     
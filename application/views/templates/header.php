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
</head>
<body>
<!-- <div id="main_container"> -->

<div class="header">
		<div>
			<a href="<?= base_url('index.php') ?>" id="logo"><img src="<?= base_url('/images/logo.png'); ?>" alt="logo"></a>
			<div>
				<a href="<?= base_url('index.php/login') ?>">Login</a>
				<ul>
					<li class="selected"><?= anchor(base_url('index.php'),'Home')?></li>
                	<li><?= anchor(base_url('index.php/upload'),'Upload Cases')?></li>
                	<li><?= anchor(base_url('index.php/case_report/viewCaseReport'),'Update Cases')?></li>
                	<li><?= anchor(base_url('index.php/larval_survey/viewLarvalReport'),'Update Surveys')?></li>
            		<li><?= anchor(base_url('index.php/mapping'),'Case/Larval Survey Map')?></li>
 					<li><?= anchor(base_url('index.php/case_report/testChart'),'Surveillance Report ')?></li>
				</ul>
			</div>
		</div>
	</div>     
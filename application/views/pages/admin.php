<!-- HEADER -->
<?php 
$data['title'] = 'Success';
$this->load->view('templates/header',$data);
?>

<!-- CONTENT -->
<div class="body">
		<div class="blog">
<center>

<h2>
<ul>
					<li class="selected"><?= anchor(base_url('index.php'),'Home')?></li>
                	<li><?= anchor(base_url('index.php/login/add_user'),'Create User')?></li>
                	<li><?= anchor(base_url('index.php/login/unapproved_users'),'View User Details')?></li>
                	<li><?= anchor(base_url('index.php/addmap'),'Add Polygon')?></li>
            		<li><?= anchor(base_url('index.php/deletemap'),'Delete Polygon')?></li>
				</ul>
</h2>
</center>
</div>
</div>

<!-- FOOTER -->
<?php $this->load->view('templates/footer');?>
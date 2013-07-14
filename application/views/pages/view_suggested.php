<!-- HEADER -->
<?php $this->load->view('templates/header');?>

<!-- CONTENT -->
<div class="body">
		<div class="blog">
			<?php 
				echo $this->table->generate($query);
			?>
		</div>
	</div>

<!-- FOOTER -->
<?php $this->load->view('templates/footer');?>
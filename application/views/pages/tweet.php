<!-- HEADER -->
<?php 
$data['title'] = 'Success';
$this->load->view('templates/header',$data);
?>

<!-- CONTENT -->
<div class="body">
		<div class="blog">
<center>

<?php 
$attributes = array(
						'id' => 'TPcr-form'
					);
echo form_open('CHO/tweet',$attributes); ?>

<input type = 'hidden' id ='total' name='total' value='<?php echo $total?>'>
<input type = 'hidden' id ='fact' name='fact' value='<?php echo $fact?>'>


<h4><center>Tweet Status</center></h4>
<table  border="1"  align="center">

  <tr>
  <td ><input type="radio" name="tweettype" value="count" /></td>
  <td>No. Of Cases</td>
  <td><?php echo $total?></td>
  </tr>
  <tr>
  <td><input type="radio" name="tweettype" value="fact" checked = "true"/></td>
  <td>Random Fact about Dengue</td>
  <td><?php echo $fact?></td>
  </tr>
  <tr>
  <td><input type="radio" name="tweettype" value="msg" checked = "true"/></td>
  <td>Custom Tweet</td>
  <td width = "500"><input type="text"  name= "customtweet" value="" style="width:500px;"/></td>
  </tr>
</table>
<input type="submit" class="submitButton" value="Tweet"/><?php echo form_close(); ?>
</center>
</div>
</div>

<!-- FOOTER -->
<?php $this->load->view('templates/footer');?>
<!-- HEADER -->
<?php $this->load->view('templates/header');?>

<!-- CONTENT -->

<head><title>Twitter Test Callback</title></head>


<script type="text/javascript">

</script>

<body>
<?php




global $tweet;
$tweet = new Tweet();
$tweet->initialize('twitteroauth/twitteroauth/twitteroauth.php','twitteroauth/config.php');


echo date("Y/m/d H:i:s");

echo "<br>".date("e");
echo "<br>";

if(isset($_POST['txtTweet']))
{
	$post = $_POST['txtTweet'];
	
	$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
	
	$i = 0;

	if(preg_match($reg_exUrl, $post, $url))
	{
		if(preg_match($reg_exUrl, $post, $url))
		{
			//Generates a shortened version of the URL
			$short = make_bitly_url($url[0],'json');
			
			//Replaces the original URL with the shortened version
			$post = preg_replace($reg_exUrl, $short, $post);
			echo $post;

			//Post to Twitter
			$tweet->postTweet($post);
		}
	}
	else
	{
		$tweet->postTweet($post);
	}
}

?>

<form name="formTweet" method="post" action="TwitterTestTweet.php"">

Status: <input type="text" name="txtTweet" id="txtTweet"/><br>
<input type="submit" value="Tweet" />

</form>

</body>


<!-- FOOTER -->
<?php $this->load->view('templates/footer');?>
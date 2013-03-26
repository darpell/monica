<!-- 
=Trademark 
	<div id="TPtrademark-div">Copyright 2012 &copy; Department of Health. All rights reserved.</div>
	 Social Networks 
	<div id="TPnetworks-div"> 
		<a class="TPnetworks-img" href="http://www.facebook.com/DOHgovph"><img class="networks" alt="facebook" src="<?= base_url('/images/facebook-logo.png')?>"/> &nbsp; </a>
		<a class="TPnetworks-img" href="http://twitter.com/#!/DOHgovph"><img class="networks" alt="twitter" src="<?= base_url('/images/twitter-blue.png')?>"/> &nbsp; </a>
			<a class="TPnetworks-img" href="#"><img class="networks" alt="google" src="images/google-logo.jpg"/> &nbsp; </a>
		<a class="TPnetworks-img" href="#"><img class="networks" alt="rss" src="images/rss-logo.png"/> &nbsp; </a>
	</div>
</div>
</body>
</html> -->

<div class="footer">
		<div>
			<div>
				<h4>24 hour customer service</h4>
				<ul>
					<li class="phone-num">
						512-943-1069 <br> 512-943-1068
					</li>
					<li class="email">
						<a href="#">info@WTPcom</a>
					</li>
					<li class="address">
						1341 Oakmound Drive <br> Chicago, IL 60609
					</li>
				</ul>
			</div>
			<div>
				<h4>Recent Tweets</h4>
				<a class="twitter-timeline"  href="https://twitter.com/DOHgovph"  data-widget-id="307001620951072768">Tweets by @DOHgovph</a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			</div>
			<div class="connect">
				<h4>Get in touch with us</h4>
				<a href="http://www.facebook.com/DOHgovph" id="facebook">Facebook</a> 
				<a href="http://twitter.com/#!/DOHgovph" id="twitter">Twitter</a> 
				<!-- <a href="http://freewebsitetemplates.com/go/googleplus/" id="googleplus">Google+</a> -->
			</div>
		</div>
		<div>
			<ul>
					<li class="selected"><?= anchor(base_url('index.php'),'Home')?></li>
					<?php if($this->session->userdata('TPtype') == "CHO"){?>
                	<li><?= anchor(base_url('index.php/upload'),'Upload Cases')?></li>
                	<li><?= anchor(base_url('index.php/CHO/dashboard'),'Dashboard')?></li>
                	<li><?= anchor(base_url('index.php/CHO/epidemic_threshold'),'Epidemic Threshold')?></li>
                	<?php }?>
            		<li><?= anchor(base_url('index.php/mapping'),'Case/Larval Survey Map')?></li>
 					<li><?= anchor(base_url('index.php/case_report/testChart'),'Surveillance Report ')?></li>
 					<?php if($this->session->userdata('TPtype') == "CHO"){?>
 					<li><?= anchor(base_url('index.php/login/admin_functions'),'Admin Functions ')?></li>
 					<?php }?>
				</ul>
			<p>
				Copyright 20123 &copy; Department of Health. All rights reserved.
			</p>
		</div>
	</div>
</body>
</html>
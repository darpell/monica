<!-- HEADER -->
<?= $this->load->view('/mobile/templates/mob_header') ?>

<!-- CONTENT -->
</head> 
<body> 

<div data-role="page">

	<div data-role="header">
		<a href="<?php echo site_url('mobile');?>" data-ajax="false" data-icon="arrow-l"> Back </a>
		<h1> Brief Dengue Info </h1>
	</div><!-- /header -->

	<div data-role="content">
		<div data-role="collapsible-set" data-theme="b" data-content-theme="d">
			<div data-role="collapsible">
				<h2> Description </h2>
				<ul data-role="listview" data-theme="d">
					<li>
						 - Dengue fever and the more severe form, dengue hemorrhagic fever, are caused by any
						of the four serotypes of dengue virus (types 1, 2, 3, and 4). An infected day-biting
						female Aedes mosquito transmits this viral disease to humans.
					</li>
					<li>
						- In the Philippines, Aedes aegypti and Aedes albopictus are the primary and secondary
						mosquito vectors, respectively. The mosquito vectors breed in small collections of water
						such as storage tanks, cisterns, flower vases, and backyard litter.
					</li>
					<li>
						 - The incubation period is from 3 to 14 days, commonly 4-7 days.
					</li>
				</ul> <!-- end listview -->
			</div><!-- /collapsible 1 -->
			
			<div data-role="collapsible">
				<h2> Standard Case Definition/Classification </h2>
				<ul data-role="listview" data-theme="d">
					<li>
						<b>Suspected Case:</b> A person with an acute febrile illness of 2-7 days duration with 2 or
more of the following: headache, retro-orbital pain, myalgia, arthralgia, rash,
hemorrhagic manifestations, leucopenia.
					</li>
					<li>
						<b>Probable Case:</b> A suspected case with one or more of the following: Supportive
serology (reciprocal hemagglutination-inhibition antibody titer >= 1280), comparable IgG
EIA titer or positive IgM antibody test in late acute or convalescent-phase serum
specimen.
					</li>
					<li>
						<b>Confirmed Case:</b> A suspected case that is laboratory confirmed
					</li>
				</ul>
			</div><!-- /collapsible 2 -->
			
			<div data-role="collapsible">
				<h2> Outbreak Investigation and Control </h2>
				<ul data-role="listview" data-theme="d">
					<li>
						- Educate the public and promote behaviors to remove, destroy or manage mosquito
						breeding sites, which are usually artificial water-holding containers close to or inside
						human habitations like roof gutters, old tires, flowerpots, discarded containers and
						water storage.
					</li>
					<li>
						Survey the community to:<br/>
						- determine the abundance of vector mosquitoes,<br/>
						- identify the Aedes mosquito breeding sites<br/>
						- promote and implement plans for mosquito and larval elimination
					</li>
					<li>
						- Promote personal protection against day biting mosquitoes through the use of insect
						repellents and screening of homes.
					</li>
				</ul>
			</div><!-- /collapsible 3 -->
			
		</div><!-- /collapsible-set -->
	</div><!-- /content -->
</div><!-- /page -->

</body>
</html>
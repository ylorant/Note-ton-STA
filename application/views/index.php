<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Note ton STA !</title>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<link rel="shortcut icon" type="image/png" href="static/images/favicon.png" />
		<link rel="stylesheet" type="text/css" media="screen" href="static/css/buttons.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="static/css/main.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="static/css/index.css" />
		<meta name="generator" content="Geany 0.21" />
	</head>

	<body>
		
		<div class="header">
			<div class="header-content">
				<img src="static/images/title.png" id="logo" />
				
				<div class="region-select">
					<img src="static/images/map.png" />
					<div class="region-content">
						<h1>Select your campus</h1>
						<?php echo $form->generate('campus'); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="content">
			<div class="content-text">
				<h1>Welcome to Note ton STA !</h1>
				<p>
					This website proposes you to evaluate interventions of SUPINFO speakers.<br />
					You can also get statistics by speaker or by campus.
				</p>
				<p class="leftpanel">
					You are a speaker and you do not have an account ? <a class="cheerilee bigbutton" href="speaker/register">Register</a>
				</p>
				<p class="rightpanel">
					You are a speaker and you already have an account ? <a class="cheerilee bigbutton" href="speaker/login">Login</a>
				</p>
				<p class="clear"></p>
			</div>
		</div>
	</body>
</html>

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
			<img src="static/images/title.png" id="logo" />
			
			<div class="region-select">
				<img src="static/images/map.png" />
				<div class="region-content">
					<h1>Select your campus</h1>
					<form method="post" action="setregion">
						
						<select name="campus">
							<?php foreach($campusList as $campus): ?>
								<option value="<?php echo $campus->id; ?>"><?php echo $campus->name; ?></option>
							<?php endforeach; ?>
						</select>
					</form>
				</div>
			</div>
		</div>
		<div class="content">
			<div class="content-text">
				<h1>Welcome to Note ton STA !</h1>
				<p>
					This website proposes you to evaluate interventions of SUPINFO speakers.<br />
					You canalso get statistics by speaker or by campus.
				</p>
				<p>
					You are a speaker and you do not have an account ? <a class="button cheerilee">Register</a>
				</p>
			</div>
		</div>
	</body>
</html>

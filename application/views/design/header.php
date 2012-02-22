<!--
   sans titre.html
   
   Copyright 2012 linkboss <linkboss@Scruffy>
   
   This program is free software; you can redistribute it and/or modify
   it under the terms of the GNU General Public License as published by
   the Free Software Foundation; either version 2 of the License, or
   (at your option) any later version.
   
   This program is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU General Public License for more details.
   
   You should have received a copy of the GNU General Public License
   along with this program; if not, write to the Free Software
   Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
   MA 02110-1301, USA.
   
   
-->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

	<head>
		<title><?php echo PAGE_TITLE; ?> - Note ton STA !</title>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<link rel="shortcut icon" type="image/png" href="static/images/favicon.png" />
		<link rel="stylesheet" type="text/css" media="screen" href="static/css/buttons.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="static/css/main.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="static/css/design.css" />
		<link rel="stylesheet" type="text/css" media="all" href="static/css/jsDatePick_ltr.min.css" />
		<script type="text/javascript" src="static/js/jsDatePick.min.1.3.js"></script>
		<meta name="generator" content="Geany 0.21" />
	</head>

	<body>
		<div class="header">
			<div class="header-content">
				<a href="index"><img src="static/images/title-small.png" /></a>
				<ul>
					<?php if($logged): ?>
						<li><a href="intervention/mine">My interventions</a></li>
						<li><a href="intervention/create">New intervention</a></li>
						<li><a href="speaker/logout">Logout</a></li>
					<?php else: ?>
						<li><a href="speaker/register">Register</a></li>
						<li><a href="speaker/login">Login</a></li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
		<div class="content">
			<img class="watermark" src="static/images/watermark.png" />
			<div class="content-view">

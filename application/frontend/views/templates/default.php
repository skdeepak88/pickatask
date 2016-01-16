<!DOCTYPE html>
<html lang="en">
   <head>
	  <meta charset="utf-8">
	  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
	  <meta name="viewport" content="width=device-width, initial-scale=1" />
	  <title><?= $gs_title ?></title>
	  <!-- #CSS Links -->
	  <!-- Basic Styles -->
	  <link rel="stylesheet" type="text/css" href="<?= $this->asset('/assets/theme/bootstrap/css/bootstrap.css') ?>"/>
	  <link rel="stylesheet" type="text/css" href="<?= $this->asset('/assets/theme/css/custom.css') ?>"/>
	  <link rel="stylesheet" type="text/css" href="<?= $this->asset('/assets/theme/font-awesome/css/font-awesome.css') ?>"/>
	  <link rel="stylesheet" type="text/css" href="<?= $this->asset('/assets/theme/plugins/iCheck-master/skins/all.css') ?>" >
	  <link rel="stylesheet" type="text/css" href="<?= $this->asset('/assets/css/stylesheet.css') ?>">

	  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	  <!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	  <![endif]-->

	  <!-- #GOOGLE FONT -->
	  <link href='http://fonts.googleapis.com/css?family=PT+Sans+Narrow:400,700' rel='stylesheet' type='text/css'>
	  <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>


		</head>
		<body>
		<!-- #NAVBAR -->
		<nav class="navbar  navbar-inverse" role="navigation">
			<div class="container-fluid">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
				   <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
				   <span class="sr-only">Toggle navigation</span>
				   <span class="icon-bar"></span>
				   <span class="icon-bar"></span>
				   <span class="icon-bar"></span>
				   </button>
				   <a class="navbar-brand" href="/">PickatasK</a>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<?php if(is_object($lo_user)): ?>
					<div class="collapse navbar-collapse">
					   <ul class="nav navbar-nav">
							<? if($lo_user->type == 'ADVERTISER'): ?>
								<li class="<?= $this->styleselector($go_page->alias, 'advertiser') ?>">
									<a href="/advertiser"><span class="fa fa-tachometer"></span>Dashboard</a>
								</li>
							  	<li class="dropdown">
							  		<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-calendar"></span>Create Task <span class="caret"></span></a>
								 	<ul class="dropdown-menu" role="menu">
										<li><a href="/managetask/fbstatus">Facebook Status</a></li>
										<li><a href="/managetask/blogpost">Blog Post</a></li>
										<li><a href="#">SEO Links</a></li>
										<li class="divider"></li>
										<li><a href="#">Email Campaign</a></li>
								 	</ul>
							  	</li>
							<?php endif; ?>

							<?php if($lo_user->type == 'POSTER'): ?>
								<li class="<?= $this->styleselector($go_page->alias, 'poster') ?>">
									<a href="/poster"><span class="fa fa-tachometer"></span>Dashboard</a>
								</li>
							  	<li class="<?= $this->styleselector($go_page->alias, 'accounts') ?>">
									<a href="/accounts"><span class="fa fa-th-large"></span>Accounts</a>
								</li>
							<?php endif; ?>
					   </ul>
					   <ul class="nav navbar-nav navbar-right">
						  <li class="dropdown">
							 <a data-toggle="dropdown" class="dropdown-toggle" href="#"><span class="fa fa-user"></span>Admin <b class="caret"></b></a>
							 <ul class="dropdown-menu">
								<li><a href="/profile"><span class="fa fa-user"></span>Profile</a></li>
								<li><a href="#"><span class="fa fa-cog"></span>Settings</a></li>
								<li class="divider"></li>
								<li><a href="/logout"><span class="fa fa-off"></span>Logout</a></li>
							 </ul>
						  </li>
					   </ul>
					</div>
				<?php endif; ?>
				<!-- /.navbar-collapse -->
			</div>
			<!-- /.container-fluid -->
		</nav>
		<div id="wrapper">

		 <?= $this->section('content') ?>

		</div>

		<footer class="footer">
		  <div class="container">
		    <p class="text-muted">Place sticky footer content here.</p>
		  </div>
		</footer>

		<!-- #JS LINKS -->
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="<?= $this->asset('/assets/theme/bootstrap/js/bootstrap.min.js') ?>"></script>
		<script src="<?= $this->asset('/assets/js/custom.js') ?>"></script>

    </body>
</html>

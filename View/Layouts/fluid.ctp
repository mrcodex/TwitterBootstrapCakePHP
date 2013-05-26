
<!DOCTYPE html>
<html lang="en">
  <head>
	<?php echo $this->Html->charset(); ?>
	<title
		<?php echo $title_for_layout; ?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="">
	<?php
		echo $this->Html->meta('icon');
		echo $this->fetch('meta');
	?>
	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<?php
		echo $this->fetch('css');
		echo $this->fetch('script');
		echo $this->Html->script('jquery');
		echo $this->CakeBootstrapStarter->start();
	?>
	<style type="text/css">
	  body {
		padding-top: 60px;
		padding-bottom: 40px;
	  }
	  .sidebar-nav {
		padding: 9px 0;
	  }

	  @media (max-width: 980px) {
		/* Enable use of floated navbar text */
		.navbar-text.pull-right {
		  float: none;
		  padding-left: 5px;
		  padding-right: 5px;
		}
	  }
	</style>
  </head>
  <body>
	<div class="navbar navbar-inverse navbar-fixed-top">
	  <div class="navbar-inner">
		<div class="container-fluid">
		  <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		  </button>
		  <a class="brand" href="#">Project name</a>
		  <div class="nav-collapse collapse">
			<p class="navbar-text pull-right">
			  Logged in as <?php echo $this->Html->link(
				'Username',
				array('#' => 'user'),
				array('class' => 'navbar-link')
			);?>
			</p>
			<ul class="nav">
				<li class="active"><?php
				echo $this->Html->link(
					'Home',
					array('#' => '')
				);
				?></li>
				<li><?php
				echo $this->Html->link(
					'About',
					array('#' => 'about')
				);
				?></li>
				<li><?php
				echo $this->Html->link(
					'Contact',
					array('#' => 'contact')
				);
				?></li>
			</ul>
		  </div><!--/.nav-collapse -->
		</div>
	  </div>
	</div>
	<div class="container-fluid">
	  <div class="row-fluid">
		<div class="span3">
		  <div class="well sidebar-nav">
			<ul class="nav nav-list">
			  <li class="nav-header">Sidebar</li>
			  <li class="active"><?php
				echo $this->Html->link(
					'Link',
					array('#' => '')
				);
				?></li>
			  <li><?php
				echo $this->Html->link(
					'Link',
					array('#' => '')
				);
				?></li>
			  <li><?php
				echo $this->Html->link(
					'Link',
					array('#' => '')
				);
				?></li>
			  <li class="nav-header">Sidebar</li>
			  <li><?php
				echo $this->Html->link(
					'Link',
					array('#' => '')
				);
				?></li>
			  <li><?php
				echo $this->Html->link(
					'Link',
					array('#' => '')
				);
				?></li>
			  <li><?php
				echo $this->Html->link(
					'Link',
					array('#' => '')
				);
				?></li>
			  <li><?php
				echo $this->Html->link(
					'Link',
					array('#' => '')
				);
				?></li>
			  <li><?php
				echo $this->Html->link(
					'Link',
					array('#' => '')
				);
				?></li>
			  <li><?php
				echo $this->Html->link(
					'Link',
					array('#' => '')
				);
				?></li>
			  <li class="nav-header">Sidebar</li>
			  <li><?php
				echo $this->Html->link(
					'Link',
					array('#' => '')
				);
				?></li>
			  <li><?php
				echo $this->Html->link(
					'Link',
					array('#' => '')
				);
				?></li>
			  <li><?php
				echo $this->Html->link(
					'Link',
					array('#' => '')
				);
				?></li>
			</ul>
		  </div><!--/.well -->
		</div><!--/span-->
		<div class="span9">
			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		</div><!--/span-->
	  </div><!--/row-->

	  <hr>

	  <footer>
		<p>&copy; Company 2013</p>
	  </footer>

	</div><!--/.fluid-container-->
  </body>
</html>
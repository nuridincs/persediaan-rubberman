<!-- Navbar -->
<nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
	<!-- Left navbar links -->
	<ul class="navbar-nav">
		<li class="nav-item">
			<a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
		</li>
	</ul>
	<ul class="navbar-nav ml-auto">
		<li class="nav-item">
			<a class="nav-link" href="#"><i class="fa fa-user-circle"></i> <?php echo $this->session->userdata('nama'); ?></a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="<?php echo base_url('/Auth/logout') ?>"><i class="fa fa-sign-out"></i> Logout</a>
		</li>
	</ul>
</nav>

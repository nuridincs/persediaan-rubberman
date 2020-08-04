<!DOCTYPE html>
<html>
<head>
	<title>PT. RUBBERMAN | Dashboard</title>
	<!-- meta -->
	<?php require_once 'template/_meta.php'; ?>

	<!-- css -->
	<?php require_once 'template/_css.php'; ?>
	<!-- Google Font: Source Sans Pro -->
	<!-- <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"> -->
	<!-- jQuery -->
	<script src="<?php echo base_url('assets'); ?>/vendor/AdminLTE-3.0.0-alpha/plugins/jquery/jquery.min.js"></script>
</head>

<body class="hold-transition sidebar-mini">
	<div class="wrapper">
		<!-- header -->
		<?php require_once 'template/_nav.php'; ?>
		<!-- sidebar -->
		<?php require_once 'template/_sidebar.php'; ?>
		<?php $this->load->view($content); ?>
		<?php require_once 'template/_footer.php'; ?>
	</div>
	<!-- ./wrapper -->
	<!-- js -->
	<?php require_once 'template/_js.php'; ?>
</body>
</html>
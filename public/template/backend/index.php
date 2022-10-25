<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>
	<?php echo $this->_metaHTTP; ?>
	<?php echo $this->_metaName; ?>
	<?php echo $this->_title; ?>
	<?php echo $this->_cssFiles; ?>
	
</head>

<body class="hold-transition sidebar-mini layout-fixed text-sm">
	<div class="wrapper">

		<!-- Navbar -->
		<?php require_once 'html/navbar.php'; ?>
		<!-- /.navbar -->

		<!-- Main Sidebar Container -->
		<?php require_once 'html/sidebar.php'; ?>

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<?php require_once 'html/page-header.php'; ?>
			<!-- /.content-header -->

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					<!--  LOAD CONTENT -->
					<?php
					require_once APPLICATION_PATH . $this->_moduleName . DS . 'views' . DS . $this->_fileView . '.php';
					?>
				</div>
			</section>
			<!-- /.content -->
		</div>
		<!-- /.content-wrapper -->
		<?php require_once 'html/footer.php'; ?>
	</div>
	<!-- ./wrapper -->

	<!-- script -->
	<?php echo $this->_jsFiles; ?>
</body>

</html>
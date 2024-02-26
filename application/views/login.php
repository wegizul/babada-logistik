<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
	<meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
	<meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
	<meta name="author" content="PIXINVENT">
	<title>Logistik Olah Gemilang | Login</title>
	<link rel="apple-touch-icon" href="<?= base_url('assets/') ?>files/logo.png">
	<link rel="shortcut icon" type="image/x-icon" href="<?= base_url('assets/') ?>files/logo.png">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

	<!-- BEGIN: Vendor CSS-->
	<link rel="stylesheet" type="text/css" href="<?= base_url('aset/') ?>app-assets/vendors/css/vendors.min.css">
	<!-- END: Vendor CSS-->

	<!-- BEGIN: Theme CSS-->
	<link rel="stylesheet" type="text/css" href="<?= base_url('aset/') ?>app-assets/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url('aset/') ?>app-assets/css/bootstrap-extended.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url('aset/') ?>app-assets/css/colors.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url('aset/') ?>app-assets/css/components.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url('aset/') ?>app-assets/css/themes/dark-layout.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url('aset/') ?>app-assets/css/themes/bordered-layout.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url('aset/') ?>app-assets/css/themes/semi-dark-layout.css">
	<!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/vendors/css/extensions/toastr.min.css"> -->

	<!-- BEGIN: Page CSS-->
	<link rel="stylesheet" type="text/css" href="<?= base_url('aset/') ?>app-assets/css/core/menu/menu-types/vertical-menu.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url('aset/') ?>app-assets/css/plugins/forms/form-validation.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url('aset/') ?>app-assets/css/pages/page-auth.css">
	<!-- END: Page CSS-->

	<!-- BEGIN: Custom CSS-->
	<link rel="stylesheet" type="text/css" href="<?= base_url('aset/') ?>assets/css/style.css">
	<!-- END: Custom CSS-->

	<!-- Toastr -->
	<link rel="stylesheet" type="text/css" href="<?= base_url('aset/') ?>app-assets/vendors/css/extensions/toastr.min.css">

</head>
<!-- END: Head-->

<!-- BEGIN: Vendor JS-->
<script src="<?= base_url('aset/') ?>app-assets/vendors/js/vendors.min.js"></script>
<script src="<?= base_url('aset/') ?>app-assets/vendors/js/extensions/toastr.min.js"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="blank-page">
	<!-- BEGIN: Content-->
	<div class="app-content content ">
		<div class="content-overlay"></div>
		<div class="header-navbar-shadow"></div>
		<div class="content-wrapper">
			<div class="content-header row">
			</div>
			<div class="content-body">
				<div class="auth-wrapper auth-v2">
					<div class="auth-inner row m-0">
						<!-- Left Text-->
						<div class="d-none d-lg-flex col-lg-8 align-items-center">
							<div class="w-100 d-lg-flex align-items-center justify-content-center"><img class="img-fluid" src="<?= base_url('assets/files/back3.png') ?>"/></div>
						</div>
						<!-- /Left Text-->
						<!-- Login-->
						<div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
							<div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
								<h1 class="card-title font-weight-bold mb-1"><b>Selamat Datang,</b></h1>
								<p class="card-text mb-2">Silahkan masukan username dan password untuk login</p>
								<form class="auth-login-form mt-2" action="<?= base_url("Login/proses"); ?>" method="POST">
									<div class="form-group">
										<input class="form-control" id="login-email" type="text" name="username" placeholder="Masukan Username" aria-describedby="login-email" tabindex="1" />
									</div>
									<div class="form-group">
										<div class="d-flex justify-content-between">
											<!-- <a href="page-auth-forgot-password-v2.html"><small>Forgot Password?</small></a> -->
										</div>
										<div class="input-group input-group-merge form-password-toggle">
											<input class="form-control form-control-merge" id="login-password" type="password" name="password" placeholder="Masukan Password" aria-describedby="login-password" tabindex="2" />
											<div class="input-group-append"><span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span></div>
										</div>
									</div>
									<button class="btn btn-dark btn-block" tabindex="4" type="submit">Login</button>
								</form>
							</div>
						</div>
						<!-- /Login-->
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- END: Content-->

	<!-- BEGIN: Page Vendor JS-->
	<script src="<?= base_url('aset/') ?>app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
	<!-- END: Page Vendor JS-->

	<!-- BEGIN: Theme JS-->
	<script src="<?= base_url('aset/') ?>app-assets/js/core/app-menu.js"></script>
	<script src="<?= base_url('aset/') ?>app-assets/js/core/app.js"></script>
	<!-- END: Theme JS-->

	<!-- BEGIN: Page JS-->
	<script src="<?= base_url('aset/') ?>app-assets/js/scripts/pages/page-auth-login.js"></script>
	<!-- END: Page JS-->

	<script>
		const notifError = "<?= $this->session->flashdata('error') ?>";
		const notifSuccess = "<?= $this->session->flashdata('success') ?>";

		$(document).ready(function() {
			if (notifError) {
				toastr.error(notifError);
			} else if (notifSuccess) {
				toastr.success(notifSuccess);
			}
		});

		$(window).on('load', function() {
			if (feather) {
				feather.replace({
					width: 14,
					height: 14
				});
			}
		});

		var base_link = $("#base_link").val();
		$(function() {
			$('.list-inline li > a').click(function() {
				var activeForm = $(this).attr('href') + ' > form';
				$(activeForm).addClass('magictime swap');
				//set timer to 1 seconds, after that, unload the magic animation
				setTimeout(function() {
					$(activeForm).removeClass('magictime swap');
				}, 1000);
			});

		});
	</script>
</body>
<!-- END: Body-->
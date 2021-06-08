<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Forgot</title>
       	<link rel="shortcut icon" href="<?= site_url('assets/admin/images/favicon.ico'); ?>">
       	 	
		<!-- Tell the browser to be responsive to screen width -->
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<!-- custom css -->
		<link href="<?= site_url('assets/admin/css/custom.css'); ?>" rel="stylesheet" type="text/css" />
		
		<!-- Bootstrap 3.3.7 -->
		<link rel="stylesheet" href="<?= site_url('assets/admin/bower_components/bootstrap/dist/css/bootstrap.min.css'); ?>">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="<?= site_url('assets/admin/bower_components/font-awesome/css/font-awesome.min.css'); ?>">
		<!-- Ionicons -->
		<link rel="stylesheet" href="<?= site_url('assets/admin/bower_components/Ionicons/css/ionicons.min.css'); ?>">
		<!-- Theme style -->
		<link rel="stylesheet" href="<?= site_url('assets/admin/dist/css/AdminLTE.min.css'); ?>">
		<!-- iCheck -->
		<link rel="stylesheet" href="<?= site_url('assets/admin/plugins/iCheck/square/blue.css'); ?>">
		<!-- Google Font -->
		<link rel="stylesheet" href="<?= site_url('assets/admin/google-fonts.css'); ?>">
	</head>
	<style>
		.m-r-5{
			margin-right: 5px;
		}
		.form-group.m-t-30.m-b-0 {
    			margin-top: 15px;
		}
		body{
			overflow-y: hidden;
		}
	</style>
	<body class="hold-transition login-page">
		<div class="login-box">
			<div class="login-logo">FORGOT PASSWORD</div>
			<div class="login-box-body">
				<p class="login-box-msg">
                    Enter your email address and we'll send you an link to reset password
				</p>
				<div id="forgot_error"></div>
				<form action="javascript:void(0)" id="frm-forgot" autocomplete="off">
					<div class="form-group has-feedback">
					<span class="glyphicon glyphicon-user form-control-feedback">
						</span>
						<input type="email" class="form-control" placeholder="Enter email" name="email" id="email" autocomplete="off" required>
					</div>
					<div class="form-group m-t-30 m-b-0">
						<div class="row">
							<div class="col-xs-12 text-center m-t-30">
								<button type="submit" class="login btn btn-primary btn-block btn-flat" name="btnLogin" id="btnLogin">
								    SEND MAIL
								</button>
							</div>
						</div>
					</div>
				</form>
                <div class="text-center">
                    Already have account?
				    <a href="<?= site_url('/'); ?>" > <b>Sign In</b></a>
                </div>
			</div>
		</div>

		<script src="<?= site_url('assets/admin/bower_components/jquery/dist/jquery.min.js'); ?>">
		</script>
		<script src="<?= site_url('assets/admin/bower_components/bootstrap/dist/js/bootstrap.min.js'); ?>">
		</script>
        <script type="text/javascript" src="<?= site_url('assets/admin/plugins/validate/jquery.validate.js'); ?>"></script>
		<script src="<?= site_url('assets/admin/plugins/iCheck/icheck.min.js'); ?>">
		</script>
	</body>
</html>

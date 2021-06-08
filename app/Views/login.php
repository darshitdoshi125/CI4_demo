<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Login</title>
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
			<div class="login-logo">Login</div>
			<div class="login-box-body">
				<p class="login-box-msg">
                    Sign in to start your session
				</p>
				<div id="login_error" class="login_error"></div>
				<form action="javascript:void(0)" id="frm-login" autocomplete="off">
					<div class="form-group has-feedback">
					<span class="glyphicon glyphicon-user form-control-feedback">
						</span>
						<input type="text" class="form-control" placeholder="Username" name="username" id="username" value="<?= @$username;?>" autocomplete="off" required>
					</div>
					<div class="form-group has-feedback">
					<span class="glyphicon glyphicon-lock form-control-feedback">
						</span>
						<input type="password" class="form-control" placeholder="Password" name="password" id="password" value="<?= @$password;?>" required>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<div class="checkbox icheck">
								<label>
									<input type="checkbox" id="remember" name="remember" value="1"> Remember Me
								</label>
							</div>
						</div>
					</div>
					<div class="form-group m-t-30 m-b-0">
						<div class="row">
							<div class="col-xs-12 text-center m-t-30">
								<button type="submit" class="login btn btn-primary btn-block btn-flat" name="btnLogin" id="btnLogin">
								SIGN IN
								</button>
							</div>
						</div>
					</div>
				</form>
				<div class="form-group m-t-30 m-b-0">
					<div class="row">
						<div class="col-xs-12">
							<a href="<?= site_url('forgot-password');?>"><i class="fa fa-lock m-r-5"></i>
								Forgot your password?
							</a><br>
						</div>
					</div>
				</div>
                <div class="text-center">
				    <a href="<?= site_url('/signup'); ?>" ><b>Sign Up</b></a>
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
		<script>
			$(function (){
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' /* optional */
                });
            });
		</script>
		<script type="text/javascript">
            jQuery.validator.addMethod("noSpace", function(value, element) { 
                return value.indexOf(" ") < 0 && value != ""; 
            }, "No space allow in username");
            $('#frm-login').validate
            ({
                rules: {
                    username: {
                        required: true,
                        noSpace :true
                    },
                    password: {
                        required: true,
                    }
                },
                messages: {
                    username: {
                        required: "Please enter username"
                    },
                    password: {
                        required: "Please enter password"
                    },
                },
                submitHandler: function(form)
                {
                    var form_data = new FormData();
                    var username = $('#username').val();
                    var password = $('#password').val();

                    form_data.append('username',username);
                    form_data.append('password',password);
                    form_data.append('btnLogin',true);
                    $("#btnLogin").attr('disabled',true);
                    $.ajax
                    ({
                        url: "<?= site_url('login') ?>",
                        data: form_data,
                        type: 'POST',
                        processData: false,
                        contentType: false,
                        success: function(data)
                        {
                            if (data.success == true) {
                                $("#login_error").html('<div id="error_login" class="alert alert-success">'+data.msg+'</div>');
                                setTimeout(function () {
                                    $("#error_login").css( "display", "none" );
                                    window.location.href = "<?= site_url('product-list') ?>";
                                    $("#btnLogin").attr('disabled',false);
                                },3000);
                            }
                            else {
                                $("#login_error").html('<div id="error_login" class="alert alert-danger">'+data.msg+'</div>');
                                setTimeout(function () {
                                    $("#error_login").css( "display", "none" );
                                    $("#btnLogin").attr('disabled',false);
                                },3000);
                            }
                        }
                    });
                }
            });
		</script>
	</body>
</html>

<div class="row">
	<div class="col-md-12">
		<div class="btn-group pull-right m-t-5 m-b-20">
			<a href="<?= site_url('product-list'); ?>" class="btn btn-custom waves-effect waves-light">
				Back
			</a>
		</div>
	</div>
    <div class="col-md-6 col-sm-6">
      	<div class="box">
        	<div class="box-header with-border">
          		<h3 class="box-title">Account Details</h3>
        	</div>
        	<div class="col-sm-12" id="profile_error"></div>
        	<form method="post" id="update_profile" name="update_profile" action="javascript:void(0)" enctype="multipart/form-data" autocomplete="off">
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Image</label>
                        <input type="file"  placeholder="Change Profile Pic" name="profilepic"  class="form-control" id="profilepic">
                        <?php if (session()->get('userData')->profile_image) {?>
                            <img height="150" width="150" src="<?= site_url('uploads/profile/').session()->get('userData')->profile_image; ?>">
                            <input type="hidden" name="profilepic_img" id="profilepic_img" class="form-control" value="<?= session()->get('userData')->profile_image; ?>" >
                        <?php }?>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Full Name</label>
                        <input type="text" placeholder="Full Name" name="fullname" value="<?= session()->get('userData')->full_name; ?>" class="form-control" id="fullname">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Username</label>
                        <input type="text" placeholder="Username" name="username" value="<?= session()->get('userData')->username; ?>" class="form-control" id="username">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input type="email" placeholder="Email" name="email" value="<?= session()->get('userData')->email; ?>" class="form-control" id="email">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Mobile No</label>
                        <input type="text" placeholder="Mobile No" name="mobile_no" value="<?= session()->get('userData')->mobile_no; ?>" class="form-control" id="mobile_no">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" name="btnSave" id="btnSave">Update</button>
                    </div>
                </div>
        	</form>
      	</div>
    </div>
    <div class="col-md-6 col-sm-6">
      	<div class="box">
        	<div class="box-header with-border">
          		<h3 class="box-title">Account Details</h3>
        	</div>
        	<div class="col-sm-12" id="password_error"></div>
        	<form method="post" id="update_password" name="update_password" action="javascript:void(0)" enctype="multipart/form-data" autocomplete="off">
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Current Password</label>
                        <input type="password" placeholder="Enter Current Password" name="current_password" value="" class="form-control" id="current_password">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">New Password</label>
                        <input type="password" placeholder="Enter New Password" name="new_password" value="" class="form-control" id="new_password">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Confirm Password</label>
                        <input type="password" placeholder="Enter Confirm Password" name="confirm_password" value="" class="form-control" id="confirm_password">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" name="btnSave" id="btnSave">Update</button>
                    </div>
                </div>
        	</form>
      	</div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function()
{
    jQuery.validator.addMethod("noSpace", function(value, element) { 
        return value.indexOf(" ") < 0 && value != ""; 
    }, "No space allow in username");
	$('#update_profile').validate({
        rules: {
            fullname: {
                required: true,
            },
            username: {
                required: true,
                noSpace :true
            },
            email: {
                required: true,
                email: true
            },
            mobile_no: {
                required: true,
            },
            profilepic: {
                required:function(element)
                {
                    return $("#profilepic_img").val() == '';
                },
            }
        },
        messages: {
            fullname: {
                required: "Please enter fullname"
            },
            username: {
                required: "Please enter username"
            },
            email: {
                required: "Please enter email"
            },
            mobile_no: {
                required: "Please enter mobile no"
            },
            profilepic: {
                required: "Please upload profile picture"
            }
        },
        submitHandler: function(form)
        {
            var form_data = new FormData();
            var fullname = $('#fullname').val();
            var username = $('#username').val();
            var email = $('#email').val();
            var mobile_no = $('#mobile_no').val();
            var files = $('#profilepic')[0].files;

            form_data.append('fullname',fullname);
            form_data.append('username',username);
            form_data.append('email',email);
            form_data.append('mobile_no',mobile_no);
            form_data.append('profilepic',files[0]);
            form_data.append('btnSave',true);
            $("#btnSave").attr('disabled',true);
            $.ajax
            ({
                url: "<?= site_url('update-profile') ?>",
                data: form_data,
                type: 'POST',
                processData: false,
                contentType: false,
                success: function(data)
                {
                    if (data.success == true) {
                        $("#profile_error").html('<div id="error_profile" class="alert alert-success">'+data.msg+'</div>');
                        setTimeout(function () {
                            $("#error_profile").css( "display", "none" );
                            window.location.href = "<?= site_url('product-list') ?>";
                            $("#btnSave").attr('disabled',false);
                        },3000);
                    }
                    else {
                        $("#profile_error").html('<div id="error_profile" class="alert alert-danger">'+data.msg+'</div>');
                        setTimeout(function () {
                            $("#error_profile").css( "display", "none" );
                            $("#btnSave").attr('disabled',false);
                        },3000);
                    }
                }
            });
        }
    });

    $('#update_password').validate({
        rules:
        {
            current_password:
            {
                required: true,
            },
            new_password:
            {
                required: true,
            },
            confirm_password:
            {
                required: true,
            }
        },
        messages:
        {
            current_password:
            {
                required: "Please Enter Current password",
            },
            new_password:
            {
                required: "Please Enter New password",
            },
            confirm_password:
            {
                required: "Please Enter Confirm password",
            }
        },
        submitHandler: function(form)
        {
            var form_data = new FormData();

            form_data.append('current_password',$("#current_password").val());
            form_data.append('new_password',$("#new_password").val());
            form_data.append('confirm_password',$("#confirm_password").val());
            form_data.append('btnSave',true);
            $("#btnSave").attr('disabled',true);
            $.ajax
            ({
                url: "<?= site_url('change-password') ?>",
                data: form_data,
                type: 'POST',
                processData: false,
                contentType: false,
                success: function(data)
                {
                    if (data.success == true) {
                        $("#password_error").html('<div id="error_password" class="alert alert-success">'+data.msg+'</div>');
                        setTimeout(function () {
                            $("#error_password").css( "display", "none" );
                            window.location.href = "<?= site_url('product-list') ?>";
                            $("#btnSave").attr('disabled',false);
                        },3000);
                    }
                    else {
                        $("#password_error").html('<div id="error_password" class="alert alert-danger">'+data.msg+'</div>');
                        setTimeout(function () {
                            $("#error_password").css( "display", "none" );
                            $("#btnSave").attr('disabled',false);
                        },3000);
                    }
                }
            });
        }
    });
});

</script>
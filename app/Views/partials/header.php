<header class="main-header">
    <a href="<?=site_url('admin/user'); ?>" class="logo">
      <span class="logo-mini">
        CI4
      </span>
      <span class="logo-lg">
        Codeigniter4
      </span>
    </a>
    <nav class="navbar navbar-static-top">
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <?php $img = session()->get('userData')->profile_image;
              if(file_exists('../public/uploads/profile/'.$img)) { ?>
                <img src="<?= site_url('uploads/profile/').$img; ?>" class="user-image" alt="User Image">
              <?php } else { ?>
                <img src="<?=site_url('assets/admin/images/user.png'); ?>" class="user-image" alt="User Image">
              <?php } ?>
              <span class="hidden-xs"><?=session()->get('userData')->full_name; ?></span>
            </a>
            <ul class="dropdown-menu">
               <li><a href="<?=site_url('account-setting');?>"><i class="fa fa-user m-r-5"></i> Account Setting </a></li>
                <li><a href="<?=site_url('logout');?>"><i class="fa fa-power-off m-r-5"></i> Logout </a></li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
<script>
  var hide_msg_time = 4000;
</script>
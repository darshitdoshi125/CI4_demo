<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="<?= site_url('assets/admin/images/favicon.ico'); ?>">
    <title><?= PROJECT_NAME; ?> | <?= $title; ?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <?=$this->include("partials/loadfiletop.php")?>

    <!-- Google Font -->
    <link rel="stylesheet" href="<?= site_url('assets/admin/google-fonts.css'); ?>">
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
      <?=$this->include("partials/header.php")?>
      <?=$this->include("partials/sidebar.php")?>
      <div class="content-wrapper">
        <section class="content">
          <?=view(@$main_content); ?>
        </section>
      </div>
      <?=$this->include("partials/footer.php")?>
    </div>
    <?=$this->include("partials/loadfilebottom.php")?>
  </body>
</html>

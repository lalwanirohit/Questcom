<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daily Shop | Home</title>

    <!-- Font awesome -->
    <link href="<?php echo $this->baseUrl('View/customer/assets/css/font-awesome.css'); ?>" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="<?php echo $this->baseUrl('View/customer/assets/css/bootstrap.css'); ?>" rel="stylesheet">
    <!-- SmartMenus jQuery Bootstrap Addon CSS -->
    <link href="<?php echo $this->baseUrl('View/customer/assets/css/jquery.smartmenus.bootstrap.css'); ?>" rel="stylesheet">
    <!-- Product view slider -->
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl('View/customer/assets/css/jquery.simpleLens.css'); ?>">
    <!-- slick slider -->
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl('View/customer/assets/css/slick.css'); ?>">
    <!-- price picker slider -->
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseUrl('View/customer/assets/css/nouislider.css'); ?>">
    <!-- Theme color -->
    <link id="switcher" href="<?php echo $this->baseUrl('View/customer/assets/css/theme-color/default-theme.css'); ?>" rel="stylesheet">
    <!-- <link id="switcher" href="<?php echo $this->baseUrl('View/customer/assets/css/theme-color/bridge-theme.css'); ?>" rel="stylesheet"> -->
    <!-- Top Slider CSS -->
    <link href="<?php echo $this->baseUrl('View/customer/assets/css/sequence-theme.modern-slide-in.css'); ?>" rel="stylesheet" media="all">

    <!-- Main style sheet -->
    <link href="<?php echo $this->baseUrl('View/customer/assets/css/style.css'); ?>" rel="stylesheet">

    <!-- Google Font -->
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


  </head>
  <body>

    <table width="100%">
        <tr>
            <td colspan="3"><?php echo $this->getChild('header')->toHtml(); ?></td>
        </tr>
        <tr>
            <td>
                <?php echo $this->getChild('message')->toHtml(); ?>
                <?php echo $this->getChild('content')->toHtml(); ?>
            </td>
        </tr>
        <tr>
            <td colspan="3"><?php echo $this->getChild('footer')->toHtml(); ?></td>
        </tr>
    </table>


    <script src="<?php echo $this->baseUrl('skin/admin/js/bootstrap.bundle.js'); ?>"></script>
    <script src="<?php echo $this->baseUrl('skin/admin/js/bootstrap.min.js'); ?>"></script>
</body>
</html>
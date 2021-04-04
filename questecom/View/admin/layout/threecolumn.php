<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="<?php echo $this->baseUrl('skin/admin/js/jquery.js'); ?>"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script> -->
    <link rel="stylesheet" href="<?php echo $this->baseUrl('skin/admin/css/bootstrap.min.css'); ?>">
    <script src="<?php echo $this->baseUrl('skin/admin/js/bootstrap.min.js'); ?>"></script>
    <link rel="stylesheet" href="<?php echo $this->baseUrl('skin/admin/css/style.css'); ?>">

    <script src="<?php echo $this->baseUrl('skin/admin/js/ckeditor.js'); ?>"></script>
	<script src="<?php echo $this->baseUrl('skin/admin/js/sample.js'); ?>"></script>

    <script type="text/javascript" src="<?php echo $this->baseUrl('skin/admin/js/jquery-3.6.0.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo $this->baseUrl('skin/admin/js/mage.js'); ?>"></script>

    <title>QuesteCom</title>
</head>

<body>

    <table width="100%">
        <tr>
            <td colspan="3"><?php echo $this->getChild('header')->toHtml(); ?></td>
        </tr>
        <tr>
            <td style="" width="325px"><?php echo $this->getChild('left')->toHtml(); ?></td>
            <td>
                <?php echo $this->createBlock('Block\Core\Layout\Message')->toHtml(); ?>
                <?php echo $this->getChild('content')->toHtml(); ?>
            </td>
            <td width="325px"></td>
        </tr>
        <tr>
            <td colspan="3"><?php echo $this->getChild('footer')->toHtml(); ?></td>
        </tr>
    </table>


    <script src="<?php echo $this->baseUrl('skin/admin/js/bootstrap.bundle.js'); ?>"></script>
    <script src="<?php echo $this->baseUrl('skin/admin/js/bootstrap.min.js'); ?>"></script>
</body>
</html>
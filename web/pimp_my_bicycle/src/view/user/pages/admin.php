<?php $title = 'Admin'; $menu = 'admin'; ?>
<?php ob_start(); ?>

<div>
    <?php if($_SESSION['pseudo'] !== 'admin') { ?>
    <p>Only admin is allowed to view this page content !</p>
    <?php } else { ?>
    <p>Congratzzz ! <?= getenv("FLAG_BIKE") ?></p>
    <?php } ?>
</div> 

<?php $content = ob_get_clean(); ?>
<?php require('view/template.php'); ?>

<?php $title = 'About us'; $menu = 'about'; ?>
<?php ob_start(); ?>

<style>
	.aboutContainer {
		display: flex;
		justify-content: space-around;
		padding: 1em 10%;
	}
</style>

<div class="aboutContainer">
      <div class="location">
        <h2>Location</h2>
        <img src="../include/images/map.png" alt="Maps">
      </div>

      <div class="info">
        <h2>Address</h2>
        <p>15 rue de Turenne</p>
        <p>38000 Grenoble</p> <br>
        <h2>Opening hours</h2>
        <p>-Mon-Fri : 9AM - 6PM<br>- Sat : 2PM - 5PM</p><br>
        <h2>Phone number</h2>
        <p>(+33) 7 81 33 86 5?</p>
      </div>
    </div>

<?php $content = ob_get_clean(); ?>
<?php require('view/template.php'); ?>

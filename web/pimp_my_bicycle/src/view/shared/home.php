<?php $title = 'Home'; $menu = 'home'; ?>
<?php ob_start(); ?>

<div id="carouselHome" class="carousel slide" data-ride="carousel">
	<div class="carousel-inner">
		<div class="carousel-item active">
			<img src="../include/images/bike2.png" alt="Bike workshop">
      <h2>You gotta pimp my bike !</h2>
      <p>Create the bike of your dreams : start now !</p>
		</div>
		<div class="carousel-item">
			<img src="../include/images/bike3.png" alt="Wild bike">
      <h2>Unlimited personalization !</h2>
      <p>You can select every shape of every part and change its color to fit your style !</p>
		</div>
		<div class="carousel-item">
			<img src="../include/images/bike1.png" alt="Mountain bike">
			<h2>Everything is hand-made !</h2>
			<p>Because every pimped bike is unique, everything is hand-made in our workshops !</p>
		</div>
	</div>
	<a class="carousel-control-prev" href="#carouselHome" role="button" data-slide="prev">
		<span class="carousel-control-prev-icon" aria-hidden="true"></span>
		<span class="sr-only">Previous</span>
	</a>
	<a class="carousel-control-next" href="#carouselHome" role="button" data-slide="next">
		<span class="carousel-control-next-icon" aria-hidden="true"></span>
		<span class="sr-only">Next</span>
	</a>
</div>

<a style='margin: 30px; padding: 20px 100px; font-size: 3em;font-family: "PMBFont", Arial, sans-serif;' href="/?page=preview" class="btn btn-info">Start now !</a>

<?php $content = ob_get_clean(); ?>
<?php require('view/template.php'); ?>

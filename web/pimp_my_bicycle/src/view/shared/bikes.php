<?php $title = 'Shop'; $menu = 'bikes'; ?>
<?php ob_start(); ?>

<style>
	.render {
		background-color: #ffffff4d;
		border: solid 1px black;
	}

	.container {
		display: flex;
		flex-wrap: wrap;
	}

	.bikeRender {
		margin: 10px 50px;
		max-width: 420px;
	}

	.footer {
		border: solid 1px black;
	}
</style>

<div class="container">
	<?php foreach($bikes as $bike){ ?>

	<div class="container bikeRender">
		<div class="render">
			<iframe src="/?page=preview&id=<?= $bike->id ?>&action=viewBike" frameborder="0" width="410px" height="330px"></iframe>
		</div>
		<div class="footerbike p-2">
			<a href="" class="btn btn-warning" data-toggle="modal" data-target="#shopModal">BUY NOW</a>
			<span class="badge badge-success"><?=$bike->likes ?> likes</span>
			<span class="badge badge-info"> by <?=$bike->user_id ?></span>
		</div>
	</div>

	<?php } ?>

	<div id="shopModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="shopModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-body">
	        <p>Call us at this number :</p>
	        <p>(+33) 7 81 33 86 5?</p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-primary" data-dismiss="modal">Got it !</button>
	      </div>
	    </div>
	  </div>
	</div>

</div>



<?php $content = ob_get_clean(); ?>
<?php require('view/template.php'); ?>

<?php $title = 'Create an account'; $menu = 'login'; ?>
<?php ob_start(); ?>



<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-6">
			<div class="card p-4">
				<div class="card-body">
					<h1>New account</h1>
					<p class="text-muted">Create an account</p>
					<form class="login-form" action="/?page=create" method="post">
						<div class="input-group mb-3">
							<div class="input-group-prepend"><span class="input-group-text"><i
										class="fas fa-user"></i></span>
							</div>
							<input name="pseudo" class="form-control" type="text" placeholder="Pseudo">
						</div>
						<div class="input-group mb-4">
							<div class="input-group-prepend"><span class="input-group-text"><i
										class="fas fa-lock"></i></span>
							</div>
							<input name="password" class="form-control" type="password" placeholder="Password">
						</div>
						<div class="row">
							<div class="col-3">
								<button class="btn btn-primary px-4" type="submit">Register</button>
							</div>
						</div>
						<div class="row">
							<?php if(isset($_GET["error"])){ ?>
							<p><?= $_GET["error"] ?></p>
							<?php } ?>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>



<?php $content = ob_get_clean(); ?>
<?php require('view/template.php'); ?>
<?php $title = 'Login'; $menu = 'login'; ?>
<?php ob_start(); ?>



			<div class="container">
				<div class="row justify-content-center">
					<div class="col-md-6">
						<div class="card p-4">
							<div class="card-body">
								<h1>Login</h1>
								<p class="text-muted">Log in</p>
								<form class="login-form" action="/?page=connect" method="post">
									<div class="input-group mb-3">
										<div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span>
										</div>
										<input name="pseudo" id="pseudo" class="form-control" type="text" placeholder="Pseudo">
									</div>
									<div class="input-group mb-4">
										<div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-lock"></i></span>
										</div>
										<input name="password" id="password" class="form-control" type="password" placeholder="Password">
									</div>
									<div class="custom-control custom-checkbox mb-4">
										<input type="checkbox" class="custom-control-input" name="remember" id="remember">
										<label class="custom-control-label" for="remember">Remember me</label>
									</div>
									<div class="row">
										<div class="col-5">
											<button class="btn btn-primary px-4" type="submit">Login</button>
										</div>
										<div class="col-7 text-right">
											<button class="btn btn-link px-0" type="button"><a href="/?page=register">Create an account</a></button>
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
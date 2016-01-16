<?php $this->layout($gs_template, $ga_templatedata) ?>

<div class="container">
	<div class="jumbotron">
		<p class="text-center">We've <strong class="text-success">1,656,005</strong> available Tasks. Get approved today!</p>
	</div>
	<div class="row">
	  <div class="col-md-6 col-md-offset-3">
		<div class="flat-form">
			<div class="header">
			  <h3>Register / Login</h3>
			</div>
			<div class="content">
				<?= $this->getflashmessage() ?>
				<form role="form" method="POST" action="/login/authenticate">
					<div class="form-group">
						<label>Email address</label>
						<input type="email" class="form-control" placeholder="Enter email" name="email" value="<?= $this->postvalue("email")?>">
					</div>
					<div class="form-group">
						<label>Password</label>
						<input type="password" class="form-control" placeholder="Password" name="password" value="<?= $this->postvalue("password")?>">
					</div>
					<button type="submit" class="btn btn-primary">Register</button>
					<button type="submit" class="btn btn-success">Login</button>
				</form>
			</div>
		</div>
	  </div>
   </div>

</div>
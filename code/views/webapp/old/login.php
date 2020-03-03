<main id="main">
	<div class="container">
        <div class="row">
			<div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2 text-center">
				<div class="intro animate-box">
					<h1>Login</h1>
					<h2>Login to learn english and math.</h2>

                    <?php
                        if($error == 2) {
                            echo "<p class='alert alert-warning'>Your account is not activated yet! Please activate your account.</p>";
                        }
                        if($error == 1) {
                            echo "<p class='alert alert-danger'>Invalid username / password! Please try again.</p>";
                        }
                    ?>

				</div>
			</div>
		</div>
		<div class="col-md-4 col-md-offset-4 animate-box">
            <form role="form" action="<?php echo site_url('login');?>" method="post" name="" enctype="multipart/form-data">
				<div class="form-group row">
					<div class="col-md-12 field">
						<input placeholder='Username / Email' required min='3' max='100' type="text" name="username" id="username" class="form-control" />
					</div>
				</div>
                <div class="form-group row">
					<div class="col-md-12 field">
						<input placeholder='Password' required min='3' max='100' type="password" name="password" id="password" class="form-control" />
					</div>
				</div>
                <div class="form-group row">
                    <div class="col-md-8 field" style='font-size: 12px;'>
						<br /><a href='<?php echo site_url('forgot-password');?>' >Forgot Password</a><br />
                        Don't have an account, <a href='<?php echo site_url('sign-up');?>' >Sign up here</a>.
					</div>
					<div class="col-md-4 field">
						<input type="submit" id="submit" class="btn btn-primary pull-right" value="login">
					</div>
				</div>
			</form>
		</div>
		<!-- <div class="col-md-4"></div> -->
	</div>
</main>
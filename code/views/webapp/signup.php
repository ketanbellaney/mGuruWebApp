<main id="main">
	<div class="container">
        <div class="row">
			<div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2 text-center">
				<div class="intro animate-box">
					<h1>Sign Up</h1>
					<h2>Sign Up to learn english and math.</h2>

                    <?php
                        /*if(@$error == 2) {
                            echo "<p class='alert alert-warning'>Your account is not activated yet! Please activate your account.</p>";
                        }
                        if(@$error == 1) {
                            echo "<p class='alert alert-danger'>Invalid username / password! Please try again.</p>";
                        } */
                    ?>

				</div>
			</div>
		</div>
		<div class="col-md-4 col-md-offset-4 animate-box">
            <form role="form" action="<?php echo site_url('sign-up');?>" method="post" name="" enctype="multipart/form-data" onsubmit='return validateform();' >
				<div class="form-group row">
					<div class="col-md-12 field">
						<input placeholder='First Name*' type="text" name="first_name" id="first_name" required maxlength="100" minlength="3" class="form-control" />
					</div>
				</div>
                <div class="form-group row">
					<div class="col-md-12 field">
						<input placeholder='Last Name*' type="text" name="last_name" id="last_name" required maxlength="100" minlength="3" class="form-control" />
					</div>
				</div>
                <div class="form-group row">
					<div class="col-md-12 field">
						<input placeholder='Mobile Number*' type="text" name="mobile" id="mobile" minlength="10"  maxlength="10" class="form-control" />
					</div>
				</div>
                <div class="form-group row">
					<div class="col-md-12 field">
						<input placeholder='Email Address*' type="email" name="email" id="email" required maxlength="100" minlength="3" class="form-control" />
					</div>
				</div>
                <div class="form-group row">
					<div class="col-md-12 field">
						<input placeholder='Username*' type="text" name="username" id="username" required maxlength="100" minlength="3" class="form-control" onchange='checkusername();'  />
					</div>
				</div>
                <div class="form-group row">
					<div class="col-md-12 field">
						<input placeholder='Password*' type="password" name="password" id="password" required maxlength="100" minlength="3" class="form-control" />
					</div>
				</div>
                <div class="form-group row">
					<div class="col-md-12 field">
						<input placeholder='Confirm Password*' type="password" name="confirm_password" id="confirm_password" required maxlength="100" minlength="3" class="form-control" />
					</div>
				</div>
                <div class="form-group row">
                    <div class="col-md-8 field" style='font-size: 12px;'>
						<br />
                        Already have an account, <a href='<?php echo site_url('login');?>' >Login here</a>.
					</div>
					<div class="col-md-4 field">
						<input type="submit" id="submit" class="btn btn-primary pull-right" value="Sign Up" />
					</div>
				</div>

			</form>
		</div>
		<!-- <div class="col-md-4"></div> -->
	</div>
</main>

<script>
    var c_uname = 0;
    function validateform() {
        if($("#password").val() != $("#confirm_password").val()) {
            alert("Password missmatch!");
            return false;
        }

        if(c_name == 0) {
            alert("Please provide proper username!");
            return false;
        }

        if(c_name == 2) {
            alert("Username already is already being used! Please try a different username.");
            return false;
        }

        if(c_name == 3) {
            alert("Please wait checking the username availability.");
            return false;
        }

        return true;
    }

    function checkusername() {
        c_name = 3;

        var uname = $("#username").val();

        $.post("<?php echo site_url("webapp/checkusername"); ?>", { uname: uname },  function( data ) {
            c_name = data;

            if(c_name == 2) {
                $("#username").val("");
                //$("#username").css("border","red");
                alert("Username already is already being used! Please try a different username.");
                return false;
            }
        });

        return false;
    }
</script>
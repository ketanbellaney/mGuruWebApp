<div class="container main-container">
    <div class="row">
        <div class="col-md-12">
        <br /><br />
            <p class='alert alert-danger'>
            <?php
                if($error == 2) {
                    echo "Your account is not activated yet! Please activate your account.";
                } else {
                    echo "Invalid username / password! Please try again.";
                }
            ?>
            </p>
        </div>
    </div>
</div>
<?= $this->extend('snippet.php') ?>
<?= $this->section('content') ?>

<div class="container mt-2">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h3 class="ms-3">Sign-Up</h3>
            <!-- Alert Message -->
            <!-- <div class="alert alert-success alert-dismissible fade show" id="successAlert" role="alert">
                <strong id="alert"></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div> -->
        
            <form id="formId">
                <div class="form-group m-3">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" placeholder="Enter username" name="username">
                    <div class="invalid-feedback" id="username_msg"></div>
                </div>
                <div class="form-group m-3">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" placeholder="Enter name" name="name">
                    <div class="invalid-feedback" id="name_msg"></div>
                </div>
                <div class="form-group m-3">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
                    <div class="invalid-feedback" id="email_msg"></div>
                </div>
                <div class="form-group m-3">
                    <label for="phone">Phone number</label>
                    <input type="tel" class="form-control" id="phone" placeholder="Enter phone number" name="phone">
                    <div class="invalid-feedback" id="phone_msg"></div>
                </div>
                <div class="form-group m-3">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Enter password"
                        name="password">
                    <div class="invalid-feedback" id="password_msg"></div>
                </div>
                <div class="form-group m-3">
                    <label for="confirmPassword">Confirm Password</label>
                    <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm password"
                        name="confirmPassword">
                    <div class="invalid-feedback" id="confirmPassword_msg"></div>
                </div>
                <button type="button" id="submit" class="btn btn-primary ms-3">Submit</button>
                <p class="ms-3">Already have a account, <a href="<?= base_url('login') ?>">Sign-In</a></p>
            </form>
        </div>
    </div>
</div>

<?= $this->section('scripts') ?>
<script>
   $(document).ready(function () {
    $('#submit').click(function (event) {
        event.preventDefault(); // Prevents the default form submission behavior
        // console.log('clicked');
        let formData = $('#formId').serialize();
        // console.log(formData);
        $.ajax({
            method: "POST",
            url: "<?= base_url('register') ?>",
            data: formData,
            dataType: "json",
            success: function (response) {
                $('input').removeClass('is-invalid');
                // $('#successAlert').hide();
                if (response.status == 'success') {
                    $('input').val('');
                    // console.log(response);
                    // var message =response.message;
                    // document.getElementById("#alert").innerHTML =message;

                } else {
                    let error = response.errors;
                    // console.log(error);
                    for (const key in error) {
                        // console.log(key, error[key]);
                        document.getElementById(key).classList.add('is-invalid');
                        document.getElementById(key + '_msg').innerHTML = error[key];
                    }
                }
            }
        });
    });
});
</script>
<?= $this->endSection() ?>


<?= $this->endSection() ?>
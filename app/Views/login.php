<?= $this->extend('snippet.php') ?>
<?= $this->section('content') ?>

<div class="container mt-2">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h3 class="ms-3">Sign-In</h3>
            <form id="formID">
                <div class="form-group m-3">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
                    <div class="invalid-feedback" id="email_msg"></div>
                </div>
                <div class="form-group m-3">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Enter password"
                        name="password">
                        <div class="invalid-feedback" id="password_msg"></div>
                </div>
                <button type="button" id="submit" class="btn btn-primary ms-3">Sign-In</button>
                <p class="ms-3">Create account, <a href="<?= base_url('register') ?>">Sign-Up</a></p>
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
        let formData = $('#formID').serialize();
        // console.log(formData);
        $.ajax({
            method: "POST",
            url: "<?= base_url('login') ?>",
            data: formData,
            dataType: "json",
            success: function (response) {
                // console.log(response);
                $('input').removeClass('is-invalid');
                if(response.status == 'success'){
                    // console.log(response);
                    window.location.href = "<?= base_url() ?>";
                }else{
                    // console.log(response);
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
<div class="row justify-content-center">
    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

        <div class="d-flex justify-content-center py-4">
            <a href="#" class="logo d-flex flex-column align-items-center w-auto gap-3">
                <img src="<?php print_r($app->info->logo); ?>" alt="" style="max-height: 70px;">
                <!-- <span class="d-none d-lg-block"><?php print_r($app->info->title); ?></span> -->
            </a>
        </div><!-- End Logo -->

        <div class="card mb-3">
            <div class="card-body">
                <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                    <p class="text-center small">Enter your username & password to login</p>
                </div>

                <form class="row g-3 needs-validation" id="loginForm" >

                    <div class="col-12">
                        <label for="yourUsername" class="form-label">Username</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text" id="inputGroupPrepend">@</span>
                            <input type="text" name="username" class="form-control input-field" required>
                            <div class="invalid-feedback">Please enter your username.</div>
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="yourPassword" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control input-field" required>
                        <div class="invalid-feedback">Please enter your password!</div>
                    </div>

                    <div class="col-12">
                        <button class="btn btn-primary w-100" type="submit">Login</button>
                    </div>
                    <div class="col-12">
                        <p class="small mb-0">Don't have account? <a href="/?url=register">Register</a></p>
                    </div>
                </form>

            </div>
        </div>

        <!-- <div class="credits">
            Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div> -->
    </div>
</div>
<script src="/assets/plugin/validate/dist/jquery.validate.min.js"></script>
<script>
    $(document).ready(function(){
        const main = {
            init: function(){
                this.event();
            },
            event: function(){
                const s = this;
                $('#loginForm').validate({
                    messages: {
                        required: "This field is required.",
                        username: "Please enter fullname!",
						password: 'Please enter password'
                    },
                    rules: {
                        username: 'required',
						password: 'required'
                    },
                    errorClass: 'is-invalid',
                    errorPlacement: function(error, element) {
                        const name = element.attr('name');
                        element.parent().find('.invalid-feedback').html(error)
                            .addClass("show-display");
                    },
                    submitHandler: function(form) {
                        const input = {}
                        $(form).find('.input-field').each(function(){
                            const local = $(this);
                            const value = local.val();
                            const name = local.attr('name');
                            if(typeof name != 'undefined'){
                                input[name] = value;
                            }
                        });
                        if(Object.keys(input).length){
                            $.post('/?url=users/auth', input).done(function(res){
                                if(res.status){
                                    window.location.href = '/?url=dashboard';
                                }else{
                                    alert(`${res.message}`);
                                }
                            })
                        }else{
                            alert('No input');
                        }
                    }
                })
            }
        }
        main.init();
    })
</script>
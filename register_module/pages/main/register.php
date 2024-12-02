<div class="row justify-content-center">
    <div class="col-lg-6 col-md-6 d-flex flex-column align-items-center justify-content-center">

        <div class="d-flex justify-content-center py-4">
            <a href="#" class="logo d-flex flex-column align-items-center w-auto">
                <img src="<?php print_r($app->info->logo); ?>" alt="" style="max-height: 70px;">
                <!-- <span class="d-none d-lg-block"><?php print_r($app->info->title); ?></span> -->
            </a>
        </div><!-- End Logo -->

        <div class="card mb-3">

            <div class="card-body">

                <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                    <p class="text-center small">Enter your personal details to create account</p>
                </div>

                <form class="row g-3 needs-validation" novalidate="" id="signupForm">
                    <div class="col-6">
                        <label for="yourName" class="form-label">First Name</label>
                        <input type="text" name="first_name" class="form-control input-field" >
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="col-6">
                        <label for="yourName" class="form-label">Last Name</label>
                        <input type="text" name="last_name" class="form-control input-field" >
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="col-6">
                        <label for="yourName" class="form-label">Middle Name</label>
                        <input type="text" name="middle_name" class="form-control input-field" >
                        <div class="invalid-feedback"></div>
                    </div>   
                    
                    <div class="col-6">
                        <label for="yourName" class="form-label">Gender</label>
                        <select class="form-select input-field" name="gender_id" id="select_gender">
                            <option selected disabled>Select Gender</option>
                        </select>
                    </div> 

                    <div class="col-6">
                        <label for="yourEmail" class="form-label">Email</label>
                        <input type="email" name="email_address" class="form-control input-field">
                        <div class="invalid-feedback">!</div>
                    </div>

                    <div class="col-6">
                        <label for="yourName" class="form-label">Mobile No.</label>
                        <input type="text" name="mobile_no" class="form-control input-field" >
                        <div class="invalid-feedback"></div>
                    </div>  

                    <div class="col-4">
                        <label for="yourName" class="form-label">Birth date</label>
                        <input type="date" name="birth_date" class="form-control input-field" >
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="col-8">
                        <label for="yourName" class="form-label">Birth Place</label>
                        <input type="text" name="birth_place" class="form-control input-field" >
                        <div class="invalid-feedback"></div>
                    </div>  

                    <div class="col-12">
                        <label for="yourName" class="form-label">Present Address</label>
                        <input type="text" name="present_address" class="form-control input-field" >
                        <div class="invalid-feedback"></div>
                    </div> 

                    

                    <!-- <div class="col-12">
                        <div class="form-check">
                        <input class="form-check-input" name="terms" type="checkbox" value="" id="acceptTerms" required="">
                        <label class="form-check-label" for="acceptTerms">I agree and accept the <a href="#">terms and conditions</a></label>
                        <div class="invalid-feedback">You must agree before submitting.</div>
                        </div>
                    </div> -->

                    <div class="col-12">
                        <button class="btn btn-primary w-100" type="submit">Create Account</button>
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
                this.getGender();
                this.event();
                // this.loadQR({code: 12345})
            },
            getGender: function(){
                const s = this;
                $.post('/?url=users/gender', {}).done(function(res){
                    if(res.status){
                        s.loadSelect($('#select_gender'), res.data, 'gender_id', 'gender')
                    }else{
                        alert(`${res.message}`);
                    }
                })
            },
            loadSelect: function(target, data, index, display){
                let html = "";
                if(data.length){
                    for(let i in data){
                        const value = data[i];
                        if(typeof value[index] != 'undefined'){
                            html += `<option value="${value[index]}">${value[display]}</option>`
                        }
                    }
                }
                target.html(html);
            },
            loadQR: function(param){
                Swal.fire({ 
                    title: "Thank you for registering",
                    html:`
                    <span style="font-size: 25px; ">Registration no.</span> 
                    <span style="color: blue; font-size: 25px;">${param.code}</span>                                                                    
                    <br><br>
                    <div id="qr_code"></div>
                    <div class="response-message">
                    <br>
                    <h1><p>Please save this QR Code for Verification</p></h1>
                        </div>`,
                    type: 'success',
                    showConfirmButton: true,
                    confirmButtonText: 'Continue'
                }).then(function(result){
                    // $(s.element.form).trigger('reset');
                })
                $('body').find('#qr_code').qrcode({
                    width: 300,
                    height: 300,
                    text:`${param.code}`
                });
            },
            event: function(){
                const s = this;
                $('#signupForm').validate({
                    messages: {
                        required: "This field is required.",
                        username: "Please enter fullname!",
						password: 'Please enter password',
                        mobile_no:{
                            maxlength: "Invalid mobile number",
                            minlength: "Invalid mobile number"
                        }
                    },
                    rules: {
                        first_name: 'required',
						last_name: 'required',
						email_address: 'required',
						mobile_no: {
                            required: true,
                            maxlength: 11,
                            minlength: 11
                        },
						birth_date: 'required',
						gender_id: 'required',
                        present_address: 'required',
                        birth_place: 'required'
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
                            s.laoder();
                            $.post('/?url=users/member/register', input).done(function(res){
                                if(res.status){
                                    console.log(res);
                                    s.loadQR({code: res.data.registration_no})
                                    $(form).trigger('reset');
                                }else{
                                    alert(`${res.message}`);
                                    Swal.close();
                                }
                            })
                        }else{
                            alert('No input');
                        }
                    }
                })
            },
            laoder: function(){
                Swal.fire({
                    title: "loading please wait.",
                    allowOutsideClick: false
                });
                Swal.showLoading();
            }
        }
        main.init();
    })
</script>
<script>
    $(document).ready(function(){
        const main = {
            init: function(){
                this.laoder();
                this.getQRInfo();
            },
            getQRInfo: function(){
                const s = this;
                const queryString = window.location.search;
                const urlParams = new URLSearchParams(queryString);
                if(urlParams.has('code')){
                    const code = urlParams.get('code');
                    s.loadQR({ code });
                }
            },
            loadQR: function(param){
                Swal.fire({ 
                    title: "Information",
                    html:`
                    <span style="font-size: 25px; ">Ref no.</span> 
                    <span style="color: blue; font-size: 25px;">${param.code}</span>                                                                    
                    <br><br>
                    <div id="qr_code"></div>
                    <div class="response-message">
                    <br>
                    <h1><p>Please save this QR Code for Verification</p></h1>
                        </div>`,
                    type: 'success',
                    showConfirmButton: true,
                    confirmButtonText: 'Continue',
                    allowOutsideClick: false
                }).then(function(result){
                    // $(s.element.form).trigger('reset');
                    window.location.href = "/";
                })
                $('body').find('#qr_code').qrcode({
                    width: 300,
                    height: 300,
                    text:`${param.code}`
                });
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
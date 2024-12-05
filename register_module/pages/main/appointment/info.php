<div class="col-xl-8">
    <div class="card">
        <div class="card-body pt-3">
            <!-- Bordered Tabs -->
            <ul class="nav nav-tabs nav-tabs-bordered" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview" aria-selected="false" role="tab" tabindex="-1">Overview</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#image-gallery" aria-selected="true" role="tab">Images</button>
                </li>
                <!-- <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings" aria-selected="false" role="tab" tabindex="-1">Settings</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password" aria-selected="false" tabindex="-1" role="tab">Change Password</button>
                </li> -->
            </ul>
            <div class="tab-content pt-2">
                <div class="tab-pane fade profile-overview active show" id="profile-overview" role="tabpanel">
                    <h5 class="card-title">Appointment Details</h5>
                    <div class="row">
                        <div class="col-lg-3 col-md-4 label ">Reference No.</div>
                        <div class="col-lg-9 col-md-8"><span class="display-field" data-id="reference"></spam></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-4 label ">Patient Name</div>
                        <div class="col-lg-9 col-md-8"><span class="display-field" data-id="patient_name"></spam></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-4 label ">Patient Code</div>
                        <div class="col-lg-9 col-md-8"><span class="display-field" data-id="code"></spam></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-4 label ">Schedule Date</div>
                        <div class="col-lg-9 col-md-8"><span class="display-field" data-id="date"></spam></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-4 label ">Schedule Time</div>
                        <div class="col-lg-9 col-md-8"><span class="display-field" data-id="time"></spam></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-4 label ">Complaints</div>
                        <div class="col-lg-9 col-md-8"><span class="display-field" data-id="complaints"></spam></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-4 label ">No of Images</div>
                        <div class="col-lg-9 col-md-8"><span class="display-field" data-id="no_of_images"></spam></div>
                    </div>
                </div>

                <div class="tab-pane fade image-gallery pt-3" id="image-gallery" role="tabpanel">
                    No Image Available.
                </div>

                <div class="tab-pane fade pt-3" id="profile-settings" role="tabpanel">
                </div>

                <div class="tab-pane fade pt-3" id="profile-change-password" role="tabpanel">
                </div>

            </div><!-- End Bordered Tabs -->
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        const main = {
            init: function(){
                const qstring = window.location.search;
                const urlParams = new URLSearchParams(qstring);
                if(urlParams.has('id')){
                    const aId = urlParams.get('id');
                    this.getAppointment(aId);
                }else{
                    window.location.href = "/?url=appointment";
                }
            }, 
            getAppointment: function(id){
                const s = this;
                $.post('/?url=appointment/list/single', { id }).done(function(res){
                    if(res.status){
                        s.loadAppointmentInfo(res.data);
                        s.getAppointmentImages(res.data.reference, res.data.code);
                    }
                })
            },
            loadAppointmentInfo: function(param){
                
                $('body').find('.display-field').each(function(){
                    const local = $(this);
                    const id = local.attr('data-id');
                    if(typeof param[id] != 'undefined'){
                        local.html(param[id]);
                    }
                })
            },
            getAppointmentImages: function(reference, patient){
                const s = this;
                $.post('/?url=appointment/patient/files', { reference, patient }).done(function(res){
                    if(res.status){
                        // s.loadAppointmentInfo(res.data);
                        console.log(res);
                    }
                })
            },
            event: function(){
                
            }
        }
        main.init();
    })
</script>

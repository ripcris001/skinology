<div class="row mb-3">
	<form id="filterForm">
		<div class="col-md-6 d-flex justify-content-between gap-2">
			<input type="date" class="form-control datepickerinput" value="<?php print_r(date("Y-m-d")); ?>">
			<button type="submit" class="btn btn-primary">Filter</button>
		</div>
	</form>
</div>
<div class="appointment-list gap-2">
	<div class="card col-md-3">
		<div class="card-body">
			<h5 class="card-title">No Apointment</h5>
			<h6 class="card-subtitle mb-2 text-muted">Currently no appointment</h6>
			<p class="card-text"></p>
		</div>
	</div>
</div>

<script src="/assets/plugin/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="/assets/plugin/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<link href="/assets/plugin/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet">

<script src="/assets/plugin/validate/dist/jquery.validate.min.js"></script>
<script>
    $(document).ready(function(){
        const main = {
            table: {
                main: '#agent-table'
            },
            form: '#form_insurance',
            datatable: {
				main: null
			},
            init: function(){
                this.getAppointment(new Date());
                this.event();
            },
            getMemberTable: function(){
                const s = this;
	        	if ($.fn.DataTable.isDataTable(this.table.main)) {
	        		$(this.table.main).DataTable().destroy();
	        	}
	        	this.datatable.main = $(this.table.main).DataTable({
	        		"processing": true,
	        		"serverSide": false,
	        		"searching": true,
	        		"paginate": true,
	        		"sort": true,
	        		"info": true,
	        		"ajax": {
						data: function(data) {
							const curDate = new Date();
							const iMonth = curDate.getMonth() + 1;
							const iDay = curDate.getDate();
							const today = `${curDate.getFullYear()}-${iMonth > 10 ? iMonth : `0${iMonth}`}-${iDay > 10 ? iDay : `0${iDay}`}`
							let input = {date: today}
							return input;
						},
	        			url: "/?url=appointment/list/daily",
	        			type: "post",
                        beforeSend : function (request) {
                            // request.setRequestHeader("Content-Type", "application/json");
							// request.setRequestHeader(`Authorization`, `Basic ${localStorage.getItem(gnetutils.misc.token)}`);
                        },
	        			dataSrc: function(source){
	        				const arr = [];
	        				const count = source.data && source.data.length ? source.data.length : 0;
	        				if(count){
	        					for(let a = 0; a < count; a++){
	        						const loopdata = source.data[a];
									loopdata.nSchedule = `${loopdata.date} ${loopdata.time}`;
									loopdata.nAction = "";
									loopdata.nAction = `<button class="btn btn-primary btn-action" data-action="view"><i class="bi bi-eye"></i></button>`
	        						arr.push(loopdata);
	        						if(a == (count -1)){
	        							return arr;
	        						}
	        					}
	        				}else{
	        					return arr;
	        				}
	        			}
	        		},
	        		"columns": [
                    {
	        			"data": "reference",
						"title": 'Reference No.',
                    	"className": ''
	        		},
					{
	        			"data": "patient_name",
						"title": 'Patient Name',
                    	"className": ''
	        		},
					{
	        			"data": "nSchedule",
						"title": 'Schedule',
                    	"className": ''
	        		},
					{
	        			"data": "no_of_images",
						"title": 'No. of Images',
                    	"className": ''
	        		},
                    {
	        			"data": "nAction",
						"title": 'Action',
                    	"className": 'col-md-1'
	        		}
					]
	        	});
            },
			getAppointment: function(param){
				const s = this;
				const curDate = new Date(param);
				const iMonth = curDate.getMonth() + 1;
				const iDay = curDate.getDate();
				const today = `${curDate.getFullYear()}-${iMonth > 9 ? iMonth : `0${iMonth}`}-${iDay > 9 ? iDay : `0${iDay}`}`
				let input = {date: today}
				$.post('/?url=appointment/list/daily', input).done(function(res){
                    s.loadAppointment(res.data);
                })
			},
			loadAppointment: function(param){
				let html = "";
				if(typeof param != 'undefined' && param.length){
					for(let i in param){
						const value = param[i];
						html += `
							<div class="card col-md-3">
								<div class="card-body">
									<div class="d-flex justify-content-between mt-2">
										<span class="hightlight-title">
											${value.date}
										</span>
									</div>
									<div class="d-flex justify-content-between mb-4">
										<span class="hightlight-title">
											${value.reference}
										</span>
									</div>
									<h6 class="card-subtitle mb-2 text-muted">${value.patient_code}</h6>
									<h6 class="mb-2 hightlight-title">${value.patient_name}</h6>
									<p class="card-text">${value.service_desc ? value.service_desc : ""}</p>
									<p class="card-text">
										<a class="btn btn-primary btn-action" data-action="upload" data-id="${value.appointment_id}" data-reference="${value.reference}" data-patient="${value.patient_code}">Upload</a>
										<a class="btn btn-primary btn-action" data-action="view_images" data-id="${value.appointment_id}" data-reference="${value.reference}" data-patient="${value.patient_code}">View Images</a>
									</p>
								</div>
							</div>
						`
					}
				}else{
					html += `
							<div class="card col-md-3">
								<div class="card-body">
									<h5 class="card-title">No Apointment</h5>
									<h6 class="card-subtitle mb-2 text-muted">Currently no appointment</h6>
									<p class="card-text"></p>
								</div>
							</div>
						`
				}
				$('.appointment-list').html(html);
			},
			loadAppointmentImages: function(param){
				let html = "";
				if(typeof param != 'undefined' && param.length){
					for(let i in param){
						const value = param[i];
						let addLabel = "";
						const pd = dateFormat(value['data']['date_uploaded']);
						html += `
							<div class="card col-md-6">
								<div class="card-body">
									<img data-url="${value.file}" src="${value.file}" class="card-img-top" alt="...">
									<div>
										${ typeof value['data']['uploaded_by'] != 'undefined' ?
											`<div class="d-flex justify-content-center">		
												<span class="hightlight-title pt-3">${value['data']['uploaded_by']}</span>
											</div>` : ""
										}
										${ typeof value['data']['date_uploaded'] != 'undefined' ? 
										`<div class="d-flex justify-content-center">
											<span class="text-muted">${pd.year}-${pd.month}-${pd.day} ${pd.hour_median}:${pd.minutes} ${pd.median}</span>
										</div>` : ""
										}
									</div>
								</div>
							</div>
						`
					}
					swal.fire({
						title: 'Uploaded Images',
						html : `
							<div class="d-flex flex-wrap" id="appointment_images" style="width: 100%;">
								${html}
							</div>
						`,
						customClass:{
							popup: 'width-m',
						},
						didOpen:function(){
							new Viewer(document.getElementById('appointment_images'), {
                        		url: 'data-url',
                    		});
						}
					})
				}
			},
            event: function(){
                const s = this;
				$('body').on('click', '.btn-action', function(){
                    const local = $(this);
                    const action = local.attr('data-action');
                    let tdata = null;
                    if(typeof action != 'undefined'){
                        switch(action){
                            case 'view_images':
								const aRef = local.attr('data-reference');
								const aPatient = local.attr('data-patient');
								$.post('/?url=appointment/patient/files', {reference: aRef, patient: aPatient}).done(function(res){
									if(res.status){
										if(res.data.length){
											s.loadAppointmentImages(res.data);
										}else{
											swal.fire({
												icon:"warning",
												title: 'No uploaded images',
												text: 'No images uploaded on this appointment'
											})
										}
									}else{
										swal.fire({
											icon: "error",
											title: 'Error',
											text: res.message
										})
									}
								})
							break;
							case 'upload':
								const aID = local.attr('data-id');
								const reference = local.attr('data-reference');
								const patient = local.attr('data-patient');
								const option = {
									icon: 'info',
									title:`Upload Images`,
									html: `
										<div style="text-align: left;">
											<form id="upload-form">
											<div>
												<label for="inputNumber" class="col-form-label">Reference: <b>${reference}</b></label>
											</div>
											<div class="mb-3">
												<label for="inputNumber" class="col-form-label">File Upload</label>
												<div class="col-sm-12">
													<input class="form-control" type="file" name="upload_file" id="upload_file">
												</div>
											</div>
											<div style="text-align: center;">
												<button type="submit" class="swal2-confirm swal2-styled" aria-label="" style="display: inline-block;">Upload</button>
												<button type="button" class="swal2-deny swal2-styled btn-action" data-action="close-swal" aria-label="" style="display: inline-block;">Cancel</button>
											</div>
											</form>
										</div>
									`,
									didOpen:function(){
										$('#upload-form').validate({
											messages: {
												required: "This field is required.",
											},
											rules: {
												upload_file: 'required'
											},
											errorClass: 'is-invalid',
											errorPlacement: function(error, element) {
												const name = element.attr('name');
												element.parent().find('.invalid-feedback').html(error)
													.addClass("show-display");
											},
											submitHandler: function(form) {
												console.log(form);
												const uploadFile = $('#upload_file').prop('files')[0];
												const formInput = new FormData();                  
    	
												formInput.append('patient', patient);
												formInput.append('reference', reference);
												formInput.append('file', uploadFile);
												
												swal.fire({
													title: "File is being upload.",
													allowOutsideClick: false
												})
												swal.showLoading();
												$.ajax({
													url: '/?url=appointment/patient/files/upload', 
													dataType: 'json', 
													cache: false,
													contentType: false,
													processData: false,
													data: formInput,                         
													type: 'post',
													success: function(res){
														console.log(res);
														if(res.status){
															swal.fire({
																icon: 'success',
																title: 'Upload Success',
																text: 'File upload successfully.'
															})
														}else{
															swal.fire({
																icon: 'error',
																title: 'Error',
																text: res.message
															})
														}
													}
												});
											}
										})
									},
									showCloseButton: false,
									showCancelButton: false,
									showDenyButton: false,
									showConfirmButton: false
								}
								swal.fire(option);
							break;
							case "close-swal":
								swal.close();
							break;
						}
					}
				})
				$('body').on('submit', '#filterForm', function(e){
					e.preventDefault();
					const form = $(this);
					const date = form.find('input[type="date"]').val();
					s.getAppointment(date);
				})
            }
        }
        main.init()
    })
</script>
<div class="row mb-3">
	<form id="filterForm">
		<div class="col-md-6 d-flex justify-content-between gap-2">
			<input type="text" class="form-control" placeholder="search patient">
			<button type="submit" class="btn btn-primary">Filter</button>
		</div>
	</form>
</div>
<div class="main-list gap-2">
	<div class="card col-md-3">
		<div class="card-body">
			<h5 class="card-title">No Patient</h5>
			<h6 class="card-subtitle mb-2 text-muted">Currently no patient listed</h6>
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
                this.getPatient('');
                this.event();
            },
			getPatient: function(param){
				const s = this;
				let input = {search: param}
				$.post('/?url=patient/list', input).done(function(res){
                    s.loadPatient(res.data);
                })
			},
			getPatientHistory: function(param){
				const s = this;
				let input = param;
				$.post('/?url=patient/history', input).done(function(res){
                    s.loadPatientHistory(res.data);
                })
			},
			loadPatient: function(param){
				let html = "";
				if(typeof param != 'undefined' && param.length){
					for(let i in param){
						const value = param[i];
						html += `
							<div class="card col-md-3">
								<div class="card-body">
									<h6 class="card-subtitle mb-2 text-muted">${value.code}</h6>
									<div class="d-flex justify-content-between mt-2">
										<span class="card-title">
											${value.patient_name}
										</span>
									</div>
									<p class="card-text">
										<a class="btn btn-primary btn-action" data-action="view_history" data-id="${value.patient_id}" data-code="${value.code}">View History</a>
									</p>
								</div>
							</div>
						`
					}
				}else{
					html += `
							<div class="card col-md-3">
								<div class="card-body">
									<h5 class="card-title">No Patient</h5>
									<h6 class="card-subtitle mb-2 text-muted">Currently no patient listed</h6>
									<p class="card-text"></p>
								</div>
							</div>
						`
				}
				$('.main-list').html(html);
			},
			loadPatientHistory: function(param){
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
				$('.main-list').html(html);
			},
            loadtable: function(param){
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
							let input = {}
							input = {search: param};
							return input;
						},
	        			url: "/?url=patient/list",
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
									loopdata.nAction = `<button class="btn btn-primary btn-action" data-action="view">View</button>`
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
	        			"data": "patient_name",
						"title": 'Name',
                    	"className": ''
	        		}
                    ,{
	        			"data": "code",
						"title": 'Code',
                    	"className": ''
	        		},
                    {
	        			"data": "nAction",
						"title": 'Action',
                    	"className": ''
	        		}
					]
	        	});
            },
			loadAppointmentImages: function(param){
				let html = "";
				if(typeof param != 'undefined' && param.length){
					for(let i in param){
						const value = param[i];
						html += `
							<div class="card col-md-6">
								<div class="card-body">
									<img data-url="${value.file}" src="${value.file}" class="card-img-top" alt="...">
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
                $('body').on('submit', '#filterForm', function(e){
					e.preventDefault();
					const form = $(this);
					const filter = form.find('input[type="text"]').val();
					s.getPatient(filter);
				})

				$('body').on('click', '.btn-action', function(){
					const local = $(this);
					const action = local.attr('data-action');
					console.log('action');
					if(typeof action != 'undfined'){
						switch(action){
							case "view_history":
								const id = local.attr('data-id');
								const code = local.attr('data-code');
								s.getPatientHistory({id: id, code: code});
							break;
							case 'view_images':
								const aRef = local.attr('data-reference');
								const aPatient = local.attr('data-patient');
								$.post('/?url=appointment/patient/files', {reference: aRef, patient: aPatient}).done(function(res){
									console.log(res);
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
						}
					}
				})
            }
        }
        main.init()
    })
</script>
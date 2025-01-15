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
									<div class="d-flex justify-content-between mt-2">
										<span class="card-title">
											${value.patient_name}
										</span>
									</div>
									<h6 class="card-subtitle mb-2 text-muted">${value.code}</h6>
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
										<span class="card-title">
											${value.patient_name}
										</span>
									</div>
									<h6 class="card-subtitle mb-2 text-muted">${value.code}</h6>
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
					const action = local.attr('action');
					if(typeof action != 'undfined'){
						switch(action){
							case "view_history":
								const id = local.attr('id');
								const code = local.attr('code');
								s.getPatientHistory({id: id, code: code});
							break;
						}
					}
				})
            }
        }
        main.init()
    })
</script>
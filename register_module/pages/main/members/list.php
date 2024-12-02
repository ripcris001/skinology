<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title">Member List</h5>
                <div>
                    <button class="btn btn-primary btn-action" data-action="create">Add</button>
                </div>
            </div>
            <!-- Table with stripped rows -->
            <div class="table-responsive">
                <table class="table table-striped" id="agent-table">
                </table>
            </div>
            <!-- End Table with stripped rows -->
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
                this.getMember();
                this.event();
            },
            getMember: function(){
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
							input = JSON.stringify(input);
							return input;
						},
	        			url: "/?url=users/member",
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
	        			"data": "fullname",
						"title": 'Name',
                    	"className": ''
	        		}
                    ,{
	        			"data": "email_address",
						"title": 'Email',
                    	"className": ''
	        		},
                    {
	        			"data": "mobile_no",
						"title": 'Mobile Number',
                    	"className": ''
	        		},
                    {
	        			"data": "birth_date",
						"title": 'Birthdate',
                    	"className": ''
	        		},
                    {
	        			"data": "nAction",
						"title": 'Action',
                    	"className": ''
	        		}
					]
	        	});
                // $.post('/?url=agent/list', {}).done(function(res){
                //     s.generateAgentTable(res.status ? res.data : []);
                // })
            },
            event: function(){
                const s = this;
            }
        }
        main.init()
    })
</script>
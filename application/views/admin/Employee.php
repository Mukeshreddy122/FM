<link rel="stylesheet" href="assets/plugins/intl-tel-input/css/intlTelInput.css">
<script src="assets/plugins/intl-tel-input/js/intlTelInput.js"></script>

<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                    <input type="hidden" id="session_token" value="<?php echo $_SESSION['USER_API_TOKEN'] ?>" />

                        <?php if ($_SESSION['permission'] == "MANAGER" || $_SESSION['permission'] == "ADMIN") {; ?>
                            <a rel="nofollow" id="NewEmployee" href="#newEmployeeModel" data-toggle="modal" class="btn btn-block bg-info" onclick="resetEmployeeFormData()">Add <?php echo $title; ?> <i class="fa fa-plus"></i></a>
                        <?php } ?>
                    </h4>
                </div>
                <div class="card-body">
                    <table id="employeeRecords" class="table table-hover table-sm">
                        <thead class="bg-info">
                            <tr>
                                <th>#</th>
                                <th>Employee Name</th>
                                <th>Mail Address</th>
                                <th>Phone Number</th>
                                <th>Company Role</th>
                                <th>Company</th>
                                <th>Access</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                <!-- New employee Model -->
                <div class="modal fade" tabindex="-1" id="newEmployeeModel">
                    <div class="modal-dialog modal-lg">
                        <form class="form" role="form" method="post" action="<?php echo base_url() ?>Employee/manageEmployee">
                            <div class="modal-content">
                                <div class="modal-header bg-info">
                                    <h4 class="modal-title" id="form-title">New Employee</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row form-group">
                                        <div class="hidden-fields">
                                            <input type="hidden" id="employeeId" name="employeeId" />
                                        </div>
                                        <div class="col-sm-3">
                                            <label class="form-control-label">Employee Name</label>
                                            <input type="text" placeholder="employee Name" id="employeeName" name="employeeName" required class="form-control" />
                                        </div>
                                        <div class="col-sm-3">
                                            <label class="form-control-label">Mail Address</label>
                                            <input type="text" placeholder="Mail Address" id="mailAddress" name="mailAddress" required class="form-control" />
                                        </div>
                                        <div class="col-sm-3">
                                            <label class="form-control-label">Phone Number</label>
                                            <input type="tel" placeholder="Phone Number" id="phoneNumber" name="phoneNumber" required class="form-control" />
                                        </div>
                                        <div class="col-sm-3">
                                            <label class="form-control-label">Company Role</label>
                                            <input type="text" placeholder="Company Role" id="companyRole" name="companyRole" required class="form-control" />
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-sm-3">
                                            <label class="form-control-label">Access</label>
                                            <div class="form-select">
                                                <select id="access" name="access" class="custom-select">
                                                    <option value='User' selected>Standard User</option>
                                                    <option value='ReadOnly'>Read Only</option>
                                                    <option value='Manager'>Manager</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <label class="form-control-label">Projects</label>
                                            <select id="projectId" name="projectId" class="form-control select2bs4" style="width: 100%;" multiple="multiple">
                                            </select>
                                            <!-- <input type="text" placeholder="projectConnection" id="projectConnection" name="projectConnection" class="form-control" /> -->
                                        </div>
                                        <div class="col-sm-3">
                                            <label class="form-control-label">External Company</label>

                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="externalCompany">
                                                <label class="custom-control-label" for="externalCompany"></label>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <label class="form-control-label">Customer</label>
                                            <select id="customerId" name="customerId" class="form-control select2bs4" style="width: 100%;" disabled="">
                                            </select>
                                            <!-- <input type="text" placeholder="customer" id="projectConnection" name="projectConnection" class="form-control" /> -->
                                        </div>
                                    </div>
                                    <div class="row form-group invisible-section">

                                        <div class="col-sm-3">
                                            <label class="form-control-label">Email</label>
                                            <input type="text" placeholder="Email" id="emailId" name="emailId" required class="form-control" />
                                        </div>
                                        <div class="col-sm-3">
                                            <label class="form-control-label">Password</label>
                                            <input type="text" placeholder="Password" id="password" name="password" required class="form-control" />
                                        </div>
                                    </div>
                                    <span style="color:red"><?php echo $this->session->flashdata('info') ?></span>
                                    <span style="color:red"><?php echo $this->session->flashdata('error') ?></span>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn bg-info">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

            <script>
                $(document).ready(function(){
                    // loadTableData()
            var customerData = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/employee ", "GET", "", document.getElementById("session_token").value)
            var cust_result=customerData.responsedata.responseJSON
            console.log(cust_result)
             $('#customerList').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": false,
            data: cust_result,
            order: [
                [1, 'desc']
                ]   ,
            columns: [{
                data: "id",
                defaultContent:"<i class='fas fa-plus' />",
                orderable: false
            },
            {
                data: "name"
            },
            {
                data:["No. of Employees"]
            },
            {
                data:"Visit Address"
            },
            {
                data: null,
                defaultContent: '<i class="fas fa-edit "/>'+"   "+"  "+'<i class="fa fa-trash delete "/>',
                orderable: false
            },
            
        
            ],
           
            });
        })
          
  
            </script>
</section>

<!-- DataTables -->
<link rel="stylesheet" href="assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

<!-- DataTables  & Plugins -->
<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="assets/plugins/jszip/jszip.min.js"></script>
<script src="assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="assets/plugins/select2/js/select2.full.min.js"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/plugins/intl-tel-input/js/utils.js"></script>
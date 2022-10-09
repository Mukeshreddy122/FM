<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <input type="hidden" id="session_token" value="<?php echo $_SESSION['USER_API_TOKEN'] ?>" />
                        <?php if ($_SESSION['permission'] == "ADMIN") {; ?>
                            <a rel="nofollow" id="NewCustomer" href="#NewCustomerModel" data-toggle="modal" class="btn btn-block bg-info" onclick="resetCustomerFormData()">Add <?php echo $title; ?> <i class="fa fa-plus"></i></a>
                        <?php } ?>
                    </h4>
                </div>
                <div class="card-body">
                    <table id="customerList" class="table table-hover table-sm">
                        <thead class="bg-info">
                            <tr>
                                <th>#</th>
                                <th>Customer Name</th>
                                <!-- <th>Type of company</th> -->
                                <!-- <th>Industry</th> -->
                                <th>No. of Employees</th>
                                <!-- <th>VAT Number</th> -->
                                <th>Visit Address</th>

                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="tableData">

                        </tbody>
                    </table>
                </div>
            </div>
            <!-- New Customer Model -->
            <!--<div aria-hidden="true" aria-labelledby="NewCustomerLabel" role="dialog" tabindex="-1" id="NewCustomerModel" class="modal fade modal-fullscreen"> -->
            <div class="modal fade" tabindex="-1" id="NewCustomerModel">
                <div class="modal-dialog modal-lg">
                    <!-- <form class="form" role="form" id="newCustomerForm" name="newCustomerForm" method="post" action="<?php echo base_url() ?>Customer/manageCustomer"> -->
                    <form class="form" role="form" id="newCustomerForm" name="newCustomerForm" onsubmit="return ManageCustomer(document.getElementById('customerId').value);">
                        <div class="modal-content">
                            <div class="modal-header bg-info">
                                <h4 class="modal-title" id="form-title">New Customer</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row form-group">
                                    <div class="hidden-fields">
                                        <input type="hidden" id="customerId" name="customerId" />
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="form-control-label">Customer Name</label>
                                        <input type="text" placeholder="Customer Name" id="customerName" name="customerName" required class="form-control" />
                                    </div>
                                    <!--                   
                                    <div class="col-sm-3">
                                        <label class="form-control-label">Customer Type</label>
                                        <div class="form-select">
                                            <select id="projectType" name="projectType" class="custom-select">
                                                <option value='User'>Standard User</option>
                                                <option value='Manager'>Manager</option>
                                                <option value='ReadOnly'>Read Only</option>
                                            </select>
                                        </div>
                                    </div>
                                    -->
                                    <?php if ($_SESSION['customerTypeOfCompany']) { ?>

                                        <div class="col-sm-3">
                                            <label class="form-control-label">Type of company</label>
                                            <input type="text" placeholder="Type of company" id="typeOfCompany" name="typeOfCompany" required class="form-control" />
                                        </div>
                                    <?php } ?>

                                    <?php if ($_SESSION['customerIndustry']) { ?>
                                        <div class="col-sm-3">
                                            <label class="form-control-label">Industry</label>
                                            <input type="text" placeholder="Industry" id="industry" name="industry" required class="form-control" />
                                        </div>
                                    <?php } ?>

                                    <?php if ($_SESSION['customerNumOfEmployees']) { ?>
                                        <div class="col-sm-3">
                                            <label class="form-control-label">No. of Employees</label>
                                            <input type="number" placeholder="No. of Employees" id="numberOfEmployees" name="numberOfEmployees" required class="form-control" />
                                        </div>
                                    <?php } ?>

                                </div>
                                <div class="row form-group">
                                    <?php if ($_SESSION['customerVATNumber']) { ?>

                                        <div class="col-sm-3">
                                            <label class="form-control-label">VAT Numbers</label>
                                            <input type="text" placeholder="VAT Numbers" id="vatNumber" name="vatNumber" required class="form-control" />
                                        </div>
                                    <?php } ?>

                                    <?php if ($_SESSION['customerVisitAddress']) { ?>
                                        <div class="col-sm-3">
                                            <label class="form-control-label">Visit Address</label>
                                            <input type="text" placeholder="Visit Address" id="visitAddress" name="visitAddress" required class="form-control" />
                                        </div>
                                    <?php } ?>

                                    <?php if ($_SESSION['customerPostAddress']) { ?>
                                        <div class="col-sm-3">
                                            <label class="form-control-label">Post Address</label>
                                            <input type="text" placeholder="Post address" id="postAddress" name="postAddress" required class="form-control" />
                                        </div>
                                    <?php } ?>

                                    <?php if ($_SESSION['customerSisterCompanies']) { ?>
                                        <div class="col-sm-3">
                                            <label class="form-control-label">Sister Companies</label>
                                            <div class="form-select">
                                                <select id="sisterCompanies" name="sisterCompanies" class="custom-select">
                                                    echo "<option value='' selected></option>";
                                                    <?php foreach ($sisterCompanies as $key => $company) {
                                                        echo "<option value='{$company}'>{$company}</option>";
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-9 invisible-section">
                                        <label class="form-control-label">
                                            <font color='red'>*</font>Create a manager user account
                                        </label>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-3 invisible-section">
                                        <label class="form-control-label">Employee Name</label>
                                        <input type="text" placeholder="employee Name" id="employeeName" name="employeeName" required class="form-control" />
                                    </div>

                                    <?php if ($_SESSION['employeeMailAddress']) { ?>

                                        <div class="col-sm-3 invisible-section">
                                            <label class="form-control-label">Mail Address</label>
                                            <input type="text" placeholder="Mail Address" id="mailAddress" name="mailAddress" required class="form-control" />
                                        </div>
                                    <?php } ?>
                                    <?php if ($_SESSION['employeeCompanyRole']) { ?>
                                        <div class="col-sm-3 invisible-section">
                                            <label class="form-control-label">Company Role</label>
                                            <input type="text" placeholder="Company Role" id="companyRole" name="companyRole" required class="form-control" />
                                        </div>
                                    <?php } ?>
                                    <?php if ($_SESSION['employeeExternalCompany']) { ?>
                                        <div class="col-sm-3 invisible-section">
                                            <label class="form-control-label">External Company</label>

                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="externalCompany">
                                                <label class="custom-control-label" for="externalCompany"></label>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="row form-group">

                                    <div class="col-sm-3 invisible-section">
                                        <label class="form-control-label">Email</label>
                                        <input type="email" placeholder="Email" id="emailId" name="emailId" required class="form-control" />
                                    </div>
                                    <div class="col-sm-3 invisible-section">
                                        <label class="form-control-label">Password</label>
                                        <input type="password" placeholder="Password" id="password" name="password" required class="form-control" />
                                    </div>
                                    <!--    <div class="col-sm-3 invisible-section">
                                        <label class="form-control-label">Customer Logo</label>
                                        <input type="file" id="projectLogo" name="projectLogo" class="form-control">
                                    </div>
                                  
                                    <div>
                                        <button type="submit" class="btn bg-info">Save changes</button>
                                    </div> -->
                                </div>
                                <span style="color:red"><?php echo $this->session->flashdata('info') ?></span>
                                <span style="color:red"><?php echo $this->session->flashdata('error') ?></span>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                                <!-- <button type="button" id="saveCustomer" name="saveCustomer" class="btn bg-info">Save changes</button> -->
                                <button type="submit" class="btn bg-info">Save changes</button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <script>
                    $(document).ready(function(){
                    // loadTableData()
            var customerData = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/customer ", "GET", "", document.getElementById("session_token").value)
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
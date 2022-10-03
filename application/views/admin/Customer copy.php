<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
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
                        <tbody>
                            <?php $index = 0;

                            foreach ($customerInfo as $key => $customer) {
                                // echo "<pre>";
                                // print_r($customer);
                                $index++;
                                echo "<tr id='{$customer['id']}'>";
                                //echo "<td> <i class='fa fa-plus'></i> {$index}</td>";
                                echo "<td> <i id='rowid.{$customer['id']}' class='fa fa-plus exp'></i>&nbsp; {$customer['id']}</td>";
                                if (array_key_exists('name', $customer)) {
                                    echo "<td class='custName'>{$customer['name']}</td>";
                                } else {
                                    echo "<td class='custName'>NA</td>";
                                }
                                // if (array_key_exists('Customer Type', $customer)) {
                                //     echo "<td class='custType'>{$customer['Customer Type']}</td>";
                                // } else {
                                //     echo "<td class='custType'>NA</td>";
                                // }
                                // if ($_SESSION['customerIndustry'] == 1) {
                                //     if (array_key_exists('CustomerIndustry', $customer)) {
                                //         echo "<td class='custIndustry'>{$customer['CustomerIndustry']}</td>";
                                //     } else {
                                //         echo "<td class='custIndustry'>NA</td>";
                                //     }
                                // }
                                if (array_key_exists('No. of Employees', $customer)) {
                                    echo "<td class='custEmployees'>{$customer['No. of Employees']}</td>";
                                } else {
                                    echo "<td class='custEmployees'>NA</td>";
                                }

                                // if (array_key_exists('VAT Number', $customer)) {
                                //     echo "<td class='custVatNumber' style='display:none;'>{$customer['VAT Number']}</td>";
                                // } else {
                                //     echo "<td class='custVatNumber' style='display:none;'>NA</td>";
                                // }

                                if (array_key_exists('Visit Address', $customer)) {
                                    echo "<td class='custVisitAddress'>{$customer['Visit Address']}</td>";
                                } else {
                                    echo "<td class='custVisitAddress'>NA</td>";
                                }

                                // if (array_key_exists('Post Address', $customer)) {
                                //     echo "<td class='custPostAddress' style='display:none;'>{$customer['Post Address']}</td>";
                                // } else {
                                //     echo "<td class='custPostAddress' style='display:none;'>NA</td>";
                                // }


                                // if (array_key_exists('Sister Companies', $customer)) {
                                //     echo "<td class='custSisterCompanies' style='display:none;'>{$customer['Sister Companies']}</td>";
                                // } else {
                                //     echo "<td class='custSisterCompanies' style='display:none;'>NA</td>";
                                // }

                                // if (array_key_exists('Customer Type', $customer)) {
                                //     echo "<td class='custType'>{$customer['Customer Type']}</td>";
                                // } else {
                                //     echo "<td class='custType'>NA</td>";
                                // }
                                $deleteUrl = base_url() . 'Customer/delete?id=' . $customer['id'];
                                $editUrl = base_url() . 'Customer/edit?id=' . $customer['id'];
                    
                                // echo "<td><a href='{$editUrl}' ><i class='fas fa-edit bg-info' id='editCustomer' name='editCustomer' aria-hidden='true'></i></a>&nbsp;&nbsp;";
                                if ($_SESSION['permission'] == "ADMIN" || $_SESSION['permission'] == "MANAGER") {
                                    $c_id = $customer['id'];
                                    echo "<td><a href='{$editUrl}' ><p class='fas fa-edit bg-info editCustomer' aria-hidden='true'></p></a>&nbsp;&nbsp;&nbsp;";
                                    echo "<a href='javascript:noReload()'><p class='fa fa-trash bg-info' id={$c_id} onclick='deleteCustomer($c_id)' aria-hidden='true'  ></p></a></td></tr>";
                                   
                                    
                                } else {
                                    echo "<td>&nbsp;</td></tr>";
                                }

                            } ?>
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
                                        <label class="form-control-label"><font color='red'>*</font>Create a manager user account</label>
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
                
                $("#saveCustomer").click(function(event) {
                    event.preventDefault();
                    $("#newCustomerForm").submit(event);
                });

                function deleteCustomer(c_id) {
                    var cust_result = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/customer/" + c_id, "DELETE", "", "");

                    if (cust_result.status == "200"||cust_result.status == "204") {
                        toastr.success('Successfully deleted Customer');
                       
                    } else {
                        toastr.error('Unable to delete Customer');
                    }
                    $("#customerList").DataTable().ajax.reload();
                }
            </script>
            <script>
                function ManageCustomer(customerId) {
                    let cust_map = new Map();

                    cust_map.set("name", document.getElementById("customerName").value)
                        .set("Customer Type", document.getElementById("industry").value)
                        .set("CustomerIndustry", document.getElementById("industry").value)
                        .set("No. of Employees", document.getElementById("numberOfEmployees").value)
                        .set("VAT Number", document.getElementById("vatNumber").value)
                        .set("Visit Address", document.getElementById("visitAddress").value)
                        .set("Post Address", document.getElementById("postAddress").value)
                        .set("customerStatus", 0)
                        .set("sisterCompanies", [])
                        .set("employeesList", [])
                        .set("devicesList", [])
                        .set("projectList", [])
                        .set("createdDate", "");

                    console.log("CustomerId: " + customerId);
                    if (customerId == "-1") {
                        // Create Customer
                        var temp = [];

                        cust_map.set("id", -1);
                        var cust_json = Object.fromEntries(cust_map);

                        var cust_result = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/customer", "POST", JSON.stringify(cust_json), "");
                        var cust_id = JSON.parse(cust_result)["id"].toString();

                        if (parseInt(cust_id) > 0) {
                            let emp_map = new Map();
                            emp_map.set("id", -1)
                                .set("name", document.getElementById("employeeName").value)
                                .set("Mail Address", document.getElementById("mailAddress").value)
                                .set("Company Role", document.getElementById("companyRole").value)
                                .set("employeeStatus", 0)
                                .set("email", document.getElementById("emailId").value)
                                .set("password", md5(document.getElementById("password").value))
                                .set("permission", "MANAGER")
                                .set("countrycode", "")
                                .set("phone", "")
                                .set("Projects List", [])
                                .set("devices list", [])
                                .set("customerId", parseInt(cust_id));
                            if (document.getElementById("externalCompany").checked == true) {
                                emp_map.set("External Company", true);
                            } else {
                                emp_map.set("External Company", false);
                            }
                            var emp_json = Object.fromEntries(emp_map);
                            var emp_result = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/employee", "POST", JSON.stringify(emp_json), "");

                            if (emp_result.includes("Email already exists")) {
                                toastr.error('Email already in use. Please use another email address');
                            } else {
                                try {
                                    var emp_id = JSON.parse(emp_result)["id"].toString();
                                    console.log("Employee ID: " + emp_id);

                                    if (parseInt(emp_id) > 0) {
                                        toastr.success('Successfully created Customer');
                                        $("#NewCustomerModel").modal("hide");
                                        setTimeout(() => {
                                            document.location.reload();
                                        }, 1500);
                                    } else {
                                        toastr.error('Unable to create Customer');
                                    }
                                } catch (e) {
                                    toastr.error('Unable to create Customer');
                                }
                            }
                        } // END IF
                    } else {
                        // Update customer

                        cust_map.set("id", customerId);
                        var cust_json = Object.fromEntries(cust_map);

                        var cust_result = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/customer/" + customerId, "PUT", JSON.stringify(cust_json), "");
                        try {
                            if (JSON.parse(cust_result)["id"].toString() != "-1") {
                                toastr.success('Successfully updated Customer');
                                $("#NewCustomerModel").modal("hide");
                            } else {
                                toastr.error('Unable to update Customer');
                            }
                        } catch (ex) {
                            toastr.error('Unable to update customer');
                        }
                    }
                }
            </script>
            <script>
                $(function() {
                    $('#customerList').DataTable({
                        "paging": true,
                        "lengthChange": false,
                        "searching": true,
                        "ordering": true,
                        "info": true,
                        "autoWidth": false,
                        "responsive": false,
                        order: [
                            [1, 'desc']
                        ]
                    });
                    var table = $('#customerList').DataTable();
                    $('#customerList tbody tr td').on('click', 'i', function() {
                        var tr = $(this).closest('tr');
                        var row = table.row(tr);

                        if (row.child.isShown()) {
                            // This row is already open - close it
                            row.child.hide();
                            tr.removeClass('shown');
                            $('#' + row.id() + ' td i').removeClass('fa-minus');
                            $('#' + row.id() + ' td i').addClass('fa-plus');
                        } else {
                            // Open this row
                            // row.child(showCustomerProjects(row.data())).show();
                            row.child(showCustomerProjects(row)).show();

                            tr.addClass('shown');
                            $('#' + row.id() + ' td i').removeClass('fa-plus');
                            $('#' + row.id() + ' td i').addClass('fa-minus');
                        }
                    });
                    // $('#customerProjectList').DataTable({
                    //     "paging": true,
                    //     "lengthChange": false,
                    //     "searching": true,
                    //     "ordering": true,
                    //     "info": true,
                    //     "autoWidth": false,
                    //     "responsive": false,
                    // });
                });

                function showCustomerProjects(row_data) {
                    console.log(row_data.id());

                    var row_details = "<table id='customerProjectList' class='table' width='80%' cellpadding='2' cellspacing='2'>";
                    row_details += "<thead class='bg-info'>";
                    row_details += "<td>Project ID</td>";
                    row_details += "<td>Project Name</td>";
                    row_details += "<td>Project Cost</td>";
                    row_details += "<td>Fleet</td>";
                    row_details += "<td>Manpower</td>";
                    row_details += "<td>Project Time</td>";
                    row_details += "<td>Income</td>";
                    row_details += "<td>Cost</td>" + "</thead>";

                    var project_data = GetProjectsForCustomer(row_data.id());
                    console.log(project_data);
                    if (!(project_data == null) && project_data.length > 0) {
                        for (let pi = 0; pi < project_data.length; pi++) {
                            var project_json = JSON.parse(project_data[pi]);

                            var row_data = "<tr>";
                            row_data += "<td>" + project_json["id"] + "</td>";
                            row_data += "<td>" + project_json["name"] + "</td>";
                            row_data += "<td>" + project_json["projectCost"] + "</td>";
                            row_data += "<td>" + project_json["deviceCount"] + "</td>";
                            row_data += "<td>" + project_json["manpower"] + "</td>";
                            row_data += "<td>" + project_json["projectStartDate"] + " - " + project_json["projectEndDate"] + "</td>";
                            row_data += "<td>" + project_json["projectIncome"] + "</td>";
                            row_data += "<td>" + project_json["projectProfit"] + "</td>";
                            row_data += "</tr>";

                            row_details += row_data;
                        }
                    } else {
                        row_details += "<tr><td colspan='8' align='center'>No Open Projects</td></tr>";
                    }
                    row_details += "</tr>";
                    return row_details;
                }
            </script>
        </div>
    </div>

    <!-- On click of Customer, show all open projects -->
    <div class="modal fade" tabindex="-1" id="projectProjects">
        <div class="modal-dialog modal-lg" id="projectProjectsDiv">
            <div class="col-12" id="projectProjectsCol">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h4 class="modal-title">Customer Projects</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered table-hover" id="projectProjectsTable">
                            <thead class="bg-info">
                                <tr>
                                    <td>Project ID</td>
                                    <td>Project Name</td>
                                    <td>Project Cost</td>
                                    <td>Fleet</td>
                                    <td>Manpower</td>
                                    <td>Project Time</td>
                                    <td>Income</td>
                                    <td>Cost</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Nordic Constructions</td>
                                    <td>$ 100, 000</td>
                                    <td>6</td>
                                    <td>3</td>
                                    <td>01/01/2022 - 31/05/2022</td>
                                    <td>$ 12,000</td>
                                    <td>$ 88,000</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                        <!-- <button type="submit" class="btn bg-info">Save changes</button> -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- When Project is clicked, show list of all fleet objects linked to it -->
    <div class="card" id="fleetDataForProject">

    </div>
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
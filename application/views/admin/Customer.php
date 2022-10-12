<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <input type="hidden" id="session_token" value="<?php echo $_SESSION['USER_API_TOKEN'] ?>" />
                        <input type="hidden" id="cname" value="<?php echo $_SESSION['myCustomerName'] ?>" />

                        <?php if ($_SESSION['permission'] == "MANAGER" || $_SESSION['permission'] == "ADMIN") {; ?>
                            <button id="NewCustomer" data-toggle="modal" class="btn btn-block bg-info" onclick="editCustomer(-1)">Add <?php echo $title; ?> <i class="fa fa-plus"></i></button>
                        <?php } ?>
                    </h4>
                </div>
                <div class="card-body p-0">
                    <table id="customerRecords" class="table table-striped table-sm">
                        <thead class="bg-info" style="font-family: 'Source Sans Pro', sans-serif;">
                            <tr>
                                <th style="width: 1%">
                                    #
                                </th>
                                <?php if ($_SESSION['permission'] == "MANAGER" || $_SESSION['permission'] == "ADMIN") { ?>
                                    <th style="width: 15%">
                                        Customer Name
                                    </th>
                                    <th style="width: 15%">
                                        Cutomer Type
                                    </th>
                                <?php }  ?>
                                <th style="width:10%">
                                    No. of Employees
                                </th>

                                <th style="width: 15%">
                                    VAT Number
                                </th>
                                <!--  <td>customer Manager</td> -->
                                <th style="width: 15%">
                                    Visit Address
                                </th>
                                <!-- <th style="width: 15%">
                                    customer Time
                                </th> -->
                                <th style="width: 10%">
                                    Post Address
                                </th>
                                <!-- <th style="width: 10%">
                                    Income
                                </th> -->
                                <!-- <th style="width: 5%">
                                    Report
                                </th> -->
                                <th style="width: 13%">
                                    &nbsp;
                                </th>
                            </tr>
                        </thead>
                        <tbody id="customerTableData">
                            <?php
                            $index = 0;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <script>
                $(document).ready(function() {

                    // loadTableData()
                    var customerData = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/customer ", "GET", "", document.getElementById("session_token").value)
                    var cust_result = customerData.responsedata.responseJSON
                    console.log(cust_result)
                    $('#customerRecords').DataTable({
                        "paging": true,
                        "lengthChange": false,
                        "searching": true,
                        "ordering": true,
                        "info": true,
                        "autoWidth": false,
                        "responsive": false,
                        // data: cust_result,
                        order: [
                            [1, 'desc']
                        ],
                        columnDefs: [{
                            "defaultContent": "-",
                            "targets": "_all"
                        }]
                    })
                    $(document).ready(
                        loadTableData()
                    );

                    function loadTableData() {
                        $(".dataTables_empty").empty();
                        var customer_json = " ";
                        <?php
                        if (sizeof($customerInfo) > 0) {
                            echo "toastr.success('Data Loaded!');";
                            $customer_row_data = "";
                            foreach ($customerInfo as $key => $customer) {
                                $index++;
                                // $customer_row_data = "";
                                $customer_row_data = $customer_row_data . "<tr id='{$customer['id']}'>";
                                $customer_row_data = $customer_row_data . "<td class='customerId'>{$customer['id']}</td>";
                                $customer_row_data = $customer_row_data . "<td class='customerName'>{$customer['name']}";
                                $customer_row_data = $customer_row_data . "<td class='customerName'>{$customer['Customer Type']}</td>";
                                $customer_row_data = $customer_row_data . "<td class='customerName'>{$customer['No. of Employees']}</td>";
                                $customer_row_data = $customer_row_data . "<td class='customerVAT'>$ {$customer['VAT Number']}</td>";
                                $customer_row_data = $customer_row_data . "<td class='customerVisit'>$ {$customer['Visit Address']}</td>";
                                $customer_row_data = $customer_row_data . "<td class='customerVisit'>$ {$customer['Post Address']}</td>";

                                if ($_SESSION['permission'] == "MANAGER" || $_SESSION['permission'] == "ADMIN") {
                                    $customer_row_data = $customer_row_data . "<td class='customer-actions text-right'>";

                                    $customer_row_data = $customer_row_data . "<i class='fas fa-eye text-info' onclick='showcustomerDetails({$customer['id']})'></i>&nbsp;&nbsp;&nbsp;";
                                    $customer_row_data = $customer_row_data . "<i class='fas fa-pencil-alt text-orange' onclick='editcustomer({$customer['id']})'></i>&nbsp;&nbsp;&nbsp;";
                                    $customer_row_data = $customer_row_data . "<i class='fas fa-trash text-danger outline'></i></td>";
                                } else {
                                    $customer_row_data = $customer_row_data . "<td><a href='#showcustomerDetails'><i class='fas fa-folder text-info'></i></a>";
                                    $customer_row_data = $customer_row_data . "<i class='fas fa-eye text-info'></i>&nbsp;&nbsp;&nbsp;";
                                    $customer_row_data = $customer_row_data . "&nbsp;&nbsp;&nbsp;</td>";
                                }
                                $customer_row_data = $customer_row_data . "</tr>";
                            }
                            echo "$('#customerRecords').DataTable().destroy();";
                            echo "$('#customerRecords').find('tbody').append(\"$customer_row_data\");";
                            echo "$('#customerRecords').DataTable().draw();";
                        } else {
                            echo "toastr.error('Unable to get data!')";
                        }
                        ?>
                    }
                })
            </script>
            <div class="modal fade" id="addEditCustomerModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-info">
                            <h4 class="modal-title">Customer Details</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card card-light">
                                        <div class="card-header">
                                            <h3 class="card-title">General</h3>

                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="hidden-fields">
                                                    <input type="hidden" id="customerId" name="customerId" />
                                                </div>
                                                <div class="col-sm-12">
                                                    <!-- <label class="form-control-label">Customer Name</label>
                                                <input type="text" placeholder="Customer Name" id="customerName" name="customerName" required class="form-control" /> -->
                                                    <div class="form-group"><label class="form-control-label">Customer Name</label>
                                                        <input type="text" placeholder="Customer Name" id="customerName" name="customerName" required class="form-control" />
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label class="form-control-label">Type of company</label>
                                                    <input type="text" placeholder="Type of company" id="Type of company" name="Type of company" required class="form-control" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label class="form-control-label">Industry</label>
                                                    <input type="text" placeholder="Industry" id="industry" name="industry" required class="form-control" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="form-control-label">No. of Employees</label>
                                                    <input type="text" placeholder="No. of Employees" id="numberOfEmployees" name="numberOfEmployees" required class="form-control" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="form-control-label">VAT Numbers</label>
                                                    <input type="text" placeholder="Visit Address" id="visitAddress" name="visitAddress" required class="form-control" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="form-control-label">Post Address</label>
                                                    <input type="text" placeholder="Post address" id="postAddress" name="postAddress" required class="form-control" />
                                                </div>

                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                    <!-- /.card -->
                                </div>
                                <div class="col-md-6">
                                    <div class="card card-light ">
                                        <div class="card-header">
                                            <h3 class="card-title">Manager user account</h3>

                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label class="form-control-label">Employee Name</label>
                                                    <input type="text" placeholder="employee Name" id="employeeName" name="employeeName" required class="form-control" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="form-control-label">Mail Address</label>
                                                    <input type="text" placeholder="Mail Address" id="mailAddress" name="mailAddress" required class="form-control" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label class="form-control-label">Company Role</label>
                                                    <input type="text" placeholder="Company Role" id="companyRole" name="companyRole" required class="form-control" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="form-control-label">External Company</label>
                                                    <input type="text" placeholder="External Company" id="externalCompany" required class="form-control" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="form-control-label">Email</label>
                                                    <input type="text" placeholder="Email" id="Email" name="Email" required class="form-control" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="form-control-label">Password</label>
                                                    <input type="text" placeholder="Password" id="Password" name="Password" required class="form-control" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="form-control-label">Sister Companies</label>
                                                    <select id="sisterCompanies" name="sisterCompanies" class="custom-select"></select>
                                                </div>
                                            </div>
                                            <!-- <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group select2-info">
                                                    <label>Employees</label>
                                                    <select id="selEmpList" class="select2" multiple="multiple" data-placeholder="Select a Employee" data-dropdown-css-class="select2-info" style="width: 100%;">


                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <label class="form-control-label ">Fleet</label>
                                                <div class="form-select select2-info">
                                                    <select id="selFleetList" class="select2" data-placeholder="Select a E" data-dropdown-css-class="select2-info" multiple name="devices" data-dropdown-css-class="select2-info" class="custom-select">

                                                    </select>
                                                </div>
                                            </div>
                                        </div> -->
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                    <!-- /.card -->
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    <input type="submit" value="Save" id="btnSavecustomer" onclick="savecustomer()" class="btn bg-olive float-right">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" tabindex="-1" id="showcustomerDetails">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-info">
                            <h4 class="modal-title">>New Customer </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12 order-2 order-md-1">
                                    <div class="row">
                                        <div class="col-12 col-sm-3">
                                            <div class="info-box bg-light">
                                                <div class="info-box-content">
                                                    <span class="info-box-text text-center text-muted">Cost</span>
                                                    <span class="info-box-number text-center text-muted mb-0" id="rocustomerCost"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-3">
                                            <div class="info-box bg-light">
                                                <div class="info-box-content">
                                                    <span class="info-box-text text-center text-muted">Income</span>
                                                    <span class="info-box-number text-center text-muted mb-0" id="rocustomerIncome"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-3">
                                            <div class="info-box bg-light">
                                                <div class="info-box-content">
                                                    <span class="info-box-text text-center text-muted">Fleet</span>
                                                    <span class="info-box-number text-center text-muted mb-0" id="rocustomerFleet"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-3">
                                            <div class="info-box bg-light">
                                                <div class="info-box-content">
                                                    <span class="info-box-text text-center text-muted">Manpower</span>
                                                    <span class="info-box-number text-center text-muted mb-0" id="rocustomerManpower"></span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- <div class="row">
                            <div class="col-12 col-md-8 col-lg-8 order-1 order-md-1">
                                <div class="text-muted">
                                    <p class="text-sm">Customer Name
                                        <b class="d-block" id="roCustomerName"></b>
                                    </p>
                                    <p class="text-sm">customer Name
                                        <b class="d-block" id="rocustomerName"></b>
                                    </p>
                                    <p class="text-sm">Start Date
                                        <b class="d-block" id="roStartDate"></b>
                                    </p>
                                    <p class="text-sm">End Date
                                        <b class="d-block" id="roEndDate"></b>
                                    </p>
                                </div>

                            </div> -->
                            <div class="col-12 col-md-4 col-lg-4 order-2 order-md-2">
                                <!-- <div class="col-12 col-sm-2">
                                    <h3 class="text-orange center"><i class="fas fa-wrench"></i> Fleet</h3>
                                </div> -->

                                <div id="roFleetList">

                                </div>

                            </div>

                        </div>
                        <div class="row " data-spy="scroll" id="roEmployeeList">

                        </div>
                    </div>
                </div>
            </div>
            <script>
                function editCustomer(custId) {
                    var permission = <?php echo "'" . $_SESSION['permission'] . "'" ?>;
                    console.log(permission)
                    var customerName = <?php echo $_SESSION['customerName'] ?>;
                    if (customerName != 1) {
                        $("#customerName").hide();
                    }




                    var emp_data = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/employee", "GET", "", document.getElementById("session_token").value).responsedata.responseJSON;
                    var fleet_data = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/fleet", "GET", "", document.getElementById("session_token").value).responsedata.responseJSON;



                    if (custid == -1) {
                        if (permission == "ADMIN") {
                            // change customername textbox to search & select
                            var customer_data = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/customer", "GET", "", document.getElementById("session_token").value).responsedata.responseJSON;
                            div_data = "";
                            $('#customerName').select2().prop('disabled', false);
                            for (let i = 0; i < customer_data.length; i++) {
                                div_data += `<option value=${customer_data[i]['id']}> ${customer_data[i]['name']} </option>`;
                            }
                            $('#customerName').html(div_data);
                        } else {
                            // pre-populate customer details from session information
                            $('#customerName').html("<option value='" + <?php echo $_SESSION['customerId'] ?> + "' selected='selected'>" + document.getElementById('cname').value + "</option>");
                            $('#customerName').select2().prop('disabled', true);
                            document.getElementById('customerName').classList.add('disabled');
                        }

                        // all fields blank
                        document.getElementById('startDate').value = ""
                        document.getElementById('endDate').value = ""
                        document.getElementById('customerName').value = ""
                        document.getElementById('projectCost').value = ""
                        document.getElementById('projectIncome').value = ""
                        document.getElementById('projectManpower').value = ""
                        document.getElementById('projectFleet').value = ""
                        document.getElementById('projectName').value = ""

                    } else {
                        var project_response = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/project/" + projectid, "GET", "", document.getElementById("session_token").value).responsedata.responseText;
                        var project_json = JSON.parse(project_response);

                        /** EMPLOYEE drop down section */
                        var emp_data = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/employee", "GET", "", document.getElementById("session_token").value).responsedata.responseJSON;
                        var proj_emp_list = project_json['employeesList'];

                        var proj_emp_set = new Set(proj_emp_list);

                        var div_data = "";
                        emp_data.forEach(emp => {
                            employee_json = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/employee/" + emp['id'], "GET", "", document.getElementById("session_token").value).responsedata.responseJSON;
                            if (proj_emp_set.has(emp['id'])) {
                                div_data += `<option selected='selected' value='${employee_json['id']}'>${employee_json['name']}</option>`;
                            } else {
                                div_data += `<option value='${employee_json['id']}'>${employee_json['name']}</option>`;
                            }
                        });
                        $('#selEmpList').html(div_data);
                        /** END EMPLOYEE drop down section */

                        /** FLEET drop down section */
                        var fleet_data = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/fleet", "GET", "", document.getElementById("session_token").value).responsedata.responseJSON;
                        var proj_fleet_list = project_json['devicesList'];

                        var proj_fleet_set = new Set(proj_fleet_list);

                        div_data = "";
                        fleet_data.forEach(fleet => {
                            var fleet_json = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/fleet/" + fleet['id'], "GET", "", document.getElementById("session_token").value).responsedata.responseJSON;
                            if (proj_fleet_set.has(fleet['id'])) {
                                div_data += `<option selected='selected' value='${fleet_json['id']}'>${fleet_json['name']}</option>`;
                            } else {
                                div_data += `<option value='${fleet_json['id']}'>${fleet_json['name']}</option>`;
                            }
                        });

                        $("#selFleetList").html(div_data);
                        /** END FLEET drop down section */

                        /** CUSTOMER drop down section */

                        customer = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/customer/" + project_json['customerId'], "GET", "", document.getElementById("session_token").value).responsedata.responseJSON;

                        $('#customerName').html("<option value='" + customer['id'] + "' selected='selected'>" + customer['name'] + "</option>");
                        $('#customerName').select2().prop('disabled', true);
                        document.getElementById('customerName').classList.add('disabled');
                        // console.log(customer)
                        // pull field names from #addEditProjectModal MODAL section 
                        // and populate data for each field from project_json 
                        // document.getElementById('projectName').value = project_json['name'];
                        document.getElementById('startDate').value = project_json['projectStartDate'];
                        document.getElementById('endDate').value = project_json['projectEndDate'];
                        document.getElementById('customerName').value = customer['name'];
                        document.getElementById('projectCost').value = project_json['projectCost'];
                        document.getElementById('projectIncome').value = project_json['projectIncome'];
                        document.getElementById('projectManpower').value = project_json['manpower'];
                        document.getElementById('projectFleet').value = project_json['id'];
                        document.getElementById('projectName').value = project_json['name'];

                        /** END CUSTOMER drop down section */



                    }
                    $('#addEditProjectModal').modal('show');

                    // // fleet details

                    // End of fleet list selection in edit page
                    $('#addEditCustomerModal').modal('show');
                }

                function savecustomer() {

                }

                function showCustomerDetails() {

                }
            </script>

            <!-- DataTables -->
            <link rel="stylesheet" href="assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
            <link rel="stylesheet" href="assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
            <link rel="stylesheet" href="assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
            <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
            <link rel="stylesheet" href="assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
            <link rel="stylesheet" href="assets/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">

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
            <script src="assets/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
            <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
            <script src="assets/plugins/intl-tel-input/js/utils.js"></script>
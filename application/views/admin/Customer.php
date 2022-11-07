<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <input type="hidden" id="session_token" value="<?php echo $_SESSION['USER_API_TOKEN'] ?>" />
                        <input type="hidden" id="cname" value="<?php echo $_SESSION['myCustomerName'] ?>" />

                        <?php if ($_SESSION['permission'] == "MANAGER" || $_SESSION['permission'] == "ADMIN") {; ?>
                            <button id="NewCustomer" data-toggle="modal" class="btn btn-block bg-info" onclick="editCustomer(-1)">  <?php echo $this->lang->line('Add'); ?> <i class="fa fa-plus"></i></button>
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
                                        <?php echo $this->lang->line('Customer Name'); ?>
                                    </th>
                                    <th style="width: 15%">
                                        <?php echo $this->lang->line('Type Of Company'); ?>
                                    </th>
                                <?php }  ?>
                                <th style="width:10%">
                                    <?php echo $this->lang->line('No. Of Employees'); ?>
                                </th>

                                <th style="width: 15%">
                                    <?php echo $this->lang->line('VAT Number'); ?>
                                </th>
                                <!--  <td>customer Manager</td> -->
                                <th style="width: 15%">
                                    <?php echo $this->lang->line('Visit Address'); ?>
                                </th>
                                <!-- <th style="width: 15%">
                                    customer Time
                                </th> -->
                                <th style="width: 10%">
                                    <?php echo $this->lang->line('Post Address'); ?>
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



                    loadTableData()



                });

                function loadTableData() {


                    $('#customerRecords').DataTable().destroy();
                    // document.getElementById('managerUser').classList.add('disabled');
                    // document.getElementById('managerUser').style.opacity = 0.4
                    // document.getElementById('managerUser').style.pointerEvents = "none";
                    var permission = <?php echo "'" . $_SESSION['permission'] . "'" ?>;
                    var customer_json = " ";
                    var customerInfo = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/customer", "GET", "", document.getElementById("session_token").value).responsedata.responseJSON;
                    // console.log(customerInfo)
                    if (customerInfo.length > 0) {
                        toastr.success('Data Loaded!')
                        var customer_row_data = "";
                        customerInfo.forEach(customer => {

                            // $customer_row_data = "";
                            customer_row_data = customer_row_data + `<tr id=${customer['id']}>`
                            customer_row_data = customer_row_data + `<td class='customerId'>${customer['id']}</td>`
                            customer_row_data = customer_row_data + `<td class='customerName'>${customer['name']}`
                            customer_row_data = customer_row_data + `<td class='customerName'>${customer['Customer Type']}</td>`
                            customer_row_data = customer_row_data + `<td class='customerName'>${customer['No. of Employees']}</td>`
                            customer_row_data = customer_row_data + `<td class='customerVAT'> ${customer['VAT Number']}</td>`
                            customer_row_data = customer_row_data + `<td class='customerVisit'>${customer['Visit Address']}</td>`
                            customer_row_data = customer_row_data + `<td class='postAddress'> ${customer['Post Address']}</td>`

                            if (permission == "MANAGER" || permission == "ADMIN") {
                                customer_row_data = customer_row_data + "<td class='customer-actions text-right'>";

                                customer_row_data = customer_row_data + `<i class='fas fa-eye text-info' onclick='editCustomer(${customer['id']})'></i>&nbsp;&nbsp;&nbsp;`;
                                customer_row_data = customer_row_data + `<i class='fas fa-pencil-alt text-orange' onclick='editCustomer(${customer['id']})'></i>&nbsp;&nbsp;&nbsp;`;
                                customer_row_data = customer_row_data + `<i class='fas fa-trash text-danger outline' onclick='deleteCustomer(${customer['id']})'></i></td>`;
                            } else {
                                customer_row_data = customer_row_data + "<td><a href='#showcustomerDetails'><i class='fas fa-eye text-info'></i></a>";
                                // $customer_row_data = $customer_row_data . "<i class='fas fa-eye text-info'></i>&nbsp;&nbsp;&nbsp;";
                                customer_row_data = customer_row_data + "&nbsp;&nbsp;&nbsp;</td>&nbsp;&nbsp;&nbsp;";
                            }
                            customer_row_data = customer_row_data + "</tr>";
                        })
                        $('#customerRecords').DataTable().destroy();
                        $('#customerRecords').find('tbody').append(customer_row_data)
                        $('#customerRecords').DataTable().draw();

                    } else {
                        toastr.error('Unable to get data!')
                    }


                }
            </script>
            <div class="modal fade" id="addEditCustomerModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-info">
                            <h4 class="modal-title">  <?php echo $this->lang->line('Customer Details'); ?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card card-light">
                                        <div class="card-header">
                                            <h3 class="card-title"> <?php echo $this->lang->line('general'); ?></h3>

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
                                                    <div class="form-group"><label class="form-control-label"><?php echo $this->lang->line('Customer Name'); ?></label>
                                                        <input type="text" placeholder="Customer Name" id="customerName" name="customerName" required class="form-control" />
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label class="form-control-label"><?php echo $this->lang->line('Type Of Company'); ?></label>
                                                    <input type="text" placeholder="Type of company" id="typeOfCompany" name="Type of company" required class="form-control" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="form-control-label"><?php echo $this->lang->line('Industry'); ?></label>
                                                    <input type="text" placeholder="Industry" id="industry" name="industry" required class="form-control" />
                                                </div>
                                            </div>

                                            <div class="row">

                                                <div class="col-sm-6">
                                                    <label class="form-control-label"><?php echo $this->lang->line('VAT Number'); ?></label>
                                                    <input type="text" placeholder="VAT Number" id="vatNumber" name="vatNumber" required class="form-control" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="form-control-label"><?php echo $this->lang->line('No. Of Employees'); ?></label>
                                                    <input type="text" placeholder="No. of Employees" id="numberOfEmployees" name="numberOfEmployees" required class="form-control" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="form-control-label"><?php echo $this->lang->line('Visit Address'); ?></label>
                                                    <input type="text" placeholder="Visit Address" id="visitAddress" name="visitAddress" required class="form-control" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="form-control-label"><?php echo $this->lang->line('Post Address'); ?></label>
                                                    <input type="text" placeholder="Post address" id="postAddress" name="postAddress" required class="form-control" />
                                                </div>

                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                    <!-- /.card -->
                                </div>
                                <div class="col-md-6" id="managerUser">
                                    <div class="card card-light ">
                                        <div class="card-header">
                                            <h3 class="card-title"><?php  echo $this->lang->line('Create Admin User Account')  ?></h3>

                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label class="form-control-label"><?php echo $this->lang->line('Employee Name'); ?></label>

                                                    <input id="employeeName" type="text" placeholder="Employee Name" id="employeeName" name="employeeName" required class="form-control" />



                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="form-control-label"><?php  echo $this->lang->line('Mailing Address'); ?></label>
                                                    <input type="text" placeholder="Mail Address" id="mailAddress" name="mailAddress" required class="form-control" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label class="form-control-label"><?php echo $this->lang->line('Company Role'); ?></label>
                                                    <input type="text" placeholder="Company Role" id="companyRole" name="companyRole" required class="form-control" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="form-control-label"><?php  echo $this->lang->line('External Company'); ?></label>
                                                    <input type="text" placeholder="External Company" id="externalCompany" required class="form-control" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="form-control-label"><?php echo $this->lang->line('Email'); ?></label>
                                                    <input type="text" placeholder="Email" id="Email" name="Email" required class="form-control" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="form-control-label"><?php echo $this->lang->line('Password'); ?></label>
                                                    <input type="text" placeholder="Password" id="Password" name="Password" required class="form-control" />
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                    <!-- /.card -->
                                    <div id="projectsList">
                                        <div class="form-group"><label class="form-control-label"><?php echo $this->lang->line('projekt'); ?>:</label></div>
                                        <div id="projects">

                                        </div>


                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <input type="submit" class="btn btn-danger" data-dismiss="modal" value="<?php echo $this->lang->line('Cancel'); ?>">
                                    <input type="submit" value="<?php echo $this->lang->line('Save'); ?>" id="btnSavecustomer" onclick="savecustomer()" class="btn bg-olive float-right">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function editCustomer(custid) {

                document.getElementById('customerId').value = custid;
                if (custid > 0) {

                    document.getElementById('managerUser').classList.add('disabled');
                    document.getElementById('managerUser').style.opacity = 0.4;
                    document.getElementById('managerUser').style.pointerEvents = "none";
                    // $('#managerUser').prop( "disabled", true );
                }
                var permission = <?php echo "'" . $_SESSION['permission'] . "'" ?>;
                var customerName = <?php echo $_SESSION['customerName'] ?>;
                // display modal conditions 

                $("#mydiv").addClass("disabledbutton");
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

                        for (let i = 0; i < customer_data.length; i++) {
                            div_data += `<option value=${customer_data[i]['id']} > ${customer_data[i]['name']}  </option>`;
                        }
                        $('#customerName').html(div_data);
                    } else {
                        // pre-populate customer details from session information
                        $('#customerName').html("<option value='" + <?php echo $_SESSION['customerId'] ?> + "' selected='selected'>" + document.getElementById('cname').value + "</option>");
                        $('#customerName').prop('disabled', true);
                    }

                    // all fields blank
                    document.getElementById('industry').value = ""
                    document.getElementById('typeOfCompany').value = ""
                    document.getElementById('numberOfEmployees').value = ""
                    document.getElementById('postAddress').value = ""
                    document.getElementById('customerName').value = ""
                    document.getElementById('visitAddress').value = ""
                    document.getElementById('vatNumber').value = ""
                    // document.getElementById('postAddress').value = ""
                    // document.getElementById('projectFleet').value = ""
                    // document.getElementById('projectName').value = ""
                    document.getElementById('employeeName').value = ""
                    document.getElementById('mailAddress').value = ""
                    document.getElementById('companyRole').value = ""
                    // document.getElementById('externalCompany').value = emp_data['Visit Address']; external company toggle
                    document.getElementById('Email').value = ""
                    // document.getElementById('password').value = 
                    // document.getElementById('sisterCompanies').value = 
                    document.getElementById('Email').value = ""

                    $("#projectsList").hide()




                } else {

                    var customer = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/customer/" + custid, "GET", "", document.getElementById("session_token").value).responsedata.responseJSON;
                    $('#customerName').html("<option value='" + customer['id'] + "' selected='selected'>" + customer['name'] + "</option>");

                    // feild values 
                    if (permission == "ADMIN") {
                        $('#customerName').prop('disabled', false);
                        document.getElementById("customerName").value = customer['name']
                    } else {

                        document.getElementById("customerName").value = customer['name']
                        $('#customerName').select2().prop('disabled', true);


                    }
                    // document.getElementById('customerName').value = customer['name'];
                    // document.getElementById('projectName').value = customer['projectName'];
                    document.getElementById('industry').value = customer['CustomerIndustry'];
                    document.getElementById('typeOfCompany').value = customer['Customer Type'];
                    document.getElementById('numberOfEmployees').value = customer['No. of Employees'];
                    document.getElementById('postAddress').value = customer['Post Address'];
                    document.getElementById('customerName').value = customer['name'];
                    document.getElementById('vatNumber').value = customer['VAT Number'];
                    document.getElementById('visitAddress').value = customer['Visit Address'];

                    // display projects
                    var projectsList = document.getElementById("projects")

                    if (customer['Projects List'] === undefined) {

                        projectsList.innerHTML = "No open projects found"
                        projectsList.style.color = "red"
                    } else {
                        projectsList.append(customer['Projects List'])
                    }

                }
                // End of fleet list selection in edit page
                $('#addEditCustomerModal').modal('show');
            }

            function savecustomer() {
                var custid = document.getElementById('customerId').value;

                // 1. Create MAP from all fields of addeditcustomermodal pop-up
                // 2. convert that map to JSON 
                // 3. Call POST / PUT to save data
                // 4. If data saved successfully, show green toast and close modal
                // 5. If data does not save, show red toast and DO NOT close modal

                const today = new Date();

                var customerObject = {
                    "id": custid,
                    "name": document.getElementById('customerName').value,
                    "Customer Type": document.getElementById('typeOfCompany').value,
                    "CustomerIndustry": document.getElementById('industry').value,
                    "No. of Employees": document.getElementById('numberOfEmployees').value,
                    "VAT Number": document.getElementById('vatNumber').value,
                    "Visit Address": document.getElementById('visitAddress').value,
                    "Post Address": document.getElementById('postAddress').value,
                    "customerStatus": 0,
                    "sisterCompanies": [],
                    "employeesList": [],
                    "devicesList": [],
                    "projectList": [],
                    "createdDate": today.getUTCDay()
                };
                var vatNumber = document.getElementById('vatNumber').value
                var noOfEmployees = document.getElementById('numberOfEmployees').value
                if (custid > 0) {
                    if (isNaN(vatNumber) || isNaN(noOfEmployees)) {
                        toastr.error("Fields Invalid")
                    }

                }
                var resp;

                if (document.getElementById('customerId').value === "-1") {
                    // new customer. perform POST

                    resp = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/customer", "POST", JSON.stringify(customerObject), document.getElementById("session_token").value).responsedata;
                    console.log(resp)
                } else {
                    // existing customer. perform PUT

                    resp = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/customer/" + custid, "PUT", JSON.stringify(customerObject), document.getElementById("session_token").value).responsedata;
                }
                if (resp.status == 200) {
                    toastr.success("Customer data updated!")
                    $('#addEditCustomerModal').modal('hide')
                    // $('#customerRecords').clear().draw()
                    $('#customerRecords').DataTable().draw();
                } else {
                    // failed
                    // show resp.responseText in red toast
                    toastr.error("Customer not Updated!")
                }
            }

            function deleteCustomer() {
                var custid = document.getElementById('customerId').value;
                resp = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/customer/" + custid, "DELETE", "", document.getElementById("session_token").value).responsedata;
                if (resp.status == 200 || resp.status == 204) {
                    toastr.success("Deleted!")
                } else {
                    toastr.error("Error occurred!")
                }

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
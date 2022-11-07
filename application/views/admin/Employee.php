<link rel="stylesheet" href="assets/plugins/intl-tel-input/css/intlTelInput.css">
<script src="assets/plugins/intl-tel-input/js/intlTelInput.js"></script>

<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <input type="hidden" id="session_token" value="<?php echo $_SESSION['USER_API_TOKEN'] ?>" />
                        <input type="hidden" id="cname" value="<?php echo $_SESSION['myCustomerName'] ?>" />
                        <?php if ($_SESSION['permission'] == "MANAGER" || $_SESSION['permission'] == "ADMIN") {; ?>
                            <button id="NewEmployee" data-toggle="modal" class="btn btn-block bg-info" onclick="editEmployee(-1)"><?php echo $this->lang->line('Add');    ?> <i class="fa fa-plus"></i></button>

                        <?php } ?>
                    </h4>
                </div>
                <div class="card-body">
                    <table id="employeeRecords" class="table table-striped table-sm wrap">
                        <thead class="bg-info" style="font-family: 'Source Sans Pro', sans-serif;">
                            <tr>
                                <th style="width: 2%">
                                    #
                                </th>
                                <th style="width: 13%">
                                    <?php echo $this->lang->line('Employee Name'); ?>
                                </th>
                                <th style="width:15%">
                                    <?php echo $this->lang->line('Mail Address'); ?>
                                </th>
                                <th style="width: 22%">
                                    <?php echo $this->lang->line('Email'); ?>
                                </th>

                                <th style="width: 10%">
                                    <?php echo $this->lang->line('Phone'); ?>
                                </th>
                                <th style="width: 15%">
                                    <?php echo $this->lang->line('Company Role'); ?>
                                </th>
                                <!-- <th style="width: 15%">
                                    Company
                                </th> -->
                                <th style="width: 12%">
                                    <?php echo $this->lang->line('Access'); ?>
                                </th>
                                <th style="width: 25%">

                                </th>
                                <!-- <th style="width: 2%">
                                    &nbsp;
                                </th> -->
                            </tr>
                        </thead>
                        <tbody id="employeeTableData">
                            <?php
                            $index = 0;

                            ?>
                        </tbody>
                    </table>
                </div>
                <script>
                    $(document).ready(function() {
                        $('#employeeRecords').DataTable({
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


                    })

                    function loadTableData() {
                        $('#employeeRecords').DataTable().clear().draw();
                        // var employee_json = " ";
                        <?php
                        if (sizeof($employeeInfo) > 0) {
                            echo "toastr.success('Data Loaded!');";
                            $employee_row_data = "";
                            foreach ($employeeInfo as $key => $employee) {
                                // $c_data = implode(',', $employee);
                                // echo "console.log({$c_data})";
                                // $e_count = count($employee['employeesList']);
                                // $f_count = count($employee['devicesList']);
                                // $p_count = count($employee['projectList']);
                                $employee_row_data = $employee_row_data . "<tr id='{$employee['id']}'>";
                                $employee_row_data = $employee_row_data . "<td class='employeeId'>{$employee['id']}</td>";
                                $employee_row_data = $employee_row_data . "<td class='employeeName'>{$employee['name']}";
                                $employee_row_data = $employee_row_data . "<td class='mailAddress'>{$employee['Mail Address']}";

                                // $employee_row_data = $employee_row_data . "<br/><small><b>Type </b>{$employee['Mail Address']}</small></td>";

                                // $employee_row_data = $employee_row_data . "<td><small><b>Manpower&nbsp;&nbsp;&nbsp;</b>{$employee['phone']}</small>";
                                // $employee_row_data = $employee_row_data . "<br/><small><b>Type </b>{$employee['Company Role']}</small></td>";

                                // $employee_row_data = $employee_row_data . "<br/><small><b>Emp. Count&nbsp;</b>{$e_count}</small></td>";
                                // $employee_row_data = $employee_row_data . "<td><small><b>Fleet Count&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>{$f_count}</small>";
                                // $employee_row_data = $employee_row_data . "<br/><small><b>Projects Count </b>{$p_count}</small></td>";
                                // $employee_row_data = $employee_row_data . "<td>$ {$employee['VAT Number']}</td>";
                                $employee_row_data = $employee_row_data . "<td class='email'>{$employee['email']}</td>";

                                $employee_row_data = $employee_row_data . "<td class='phone'>{$employee['phone']}</td>";
                                $employee_row_data = $employee_row_data . "<td class='companyRole'>{$employee['Company Role']}</td>";
                                $employee_row_data = $employee_row_data . "<td class='permission'>{$employee['permission']}</td>";

                                if ($_SESSION['permission'] == "MANAGER" || $_SESSION['permission'] == "ADMIN") {
                                    $employee_row_data = $employee_row_data . "<td class='employee-actions text-right'>";

                                    $employee_row_data = $employee_row_data . "<i class='fas fa-eye text-info' onclick='editEmployee({$employee['id']})'></i>&nbsp;&nbsp;&nbsp;";
                                    $employee_row_data = $employee_row_data . "<i class='fas fa-pencil-alt text-orange' onclick='editEmployee({$employee['id']})'></i>&nbsp;&nbsp;&nbsp;";
                                    $employee_row_data = $employee_row_data . "<i class='fas fa-trash text-danger outline' onclick='deleteEmployee({$employee['id']})'></i></td>";
                                } else {
                                    $employee_row_data = $employee_row_data . "<td><i class='fas fa-folder text-info'></i>";
                                    $employee_row_data = $employee_row_data . "<i class='fas fa-eye text-info'></i>&nbsp;&nbsp;&nbsp;";
                                    $employee_row_data = $employee_row_data . "</td>";
                                }
                                $employee_row_data = $employee_row_data . "</tr>";
                                $index++;
                            }
                            echo "$('#employeeRecords').DataTable().destroy();";
                            echo "$('#employeeRecords').find('tbody').append(\"$employee_row_data\");";
                            echo "$('#employeeRecords').DataTable().draw();";
                            // echo "console.log(\"{$employee_row_data}\");";
                        } else {
                            echo "toastr.error('Unable to get data!')";
                        }
                        ?>
                    }
                </script>
                <div class="modal fade" id="addEditEmployeeModal">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-info">
                                <h4 class="modal-title"> <?php $this->lang->line('Employee Details'); ?></h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card card-light">
                                            <div class="card-header">
                                                <h3 class="card-title"> <?php echo $this->lang->line('General'); ?></h3>

                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="hidden-fields">
                                                        <input type="hidden" id="empId" name="customerId" />
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group"><label class="form-control-label"> <?php echo $this->lang->line('Customer Name'); ?></label>
                                                            <select class="form-control select2 " id="customerName" style="width: 100%;" required>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group"><label class="form-control-label"> <?php echo $this->lang->line('Employee Name'); ?></label>
                                                            <input type="text" placeholder="Employee Name" id="employeeName" name="employeeName" required class="form-control" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <label class="form-control-label"> <?php  echo $this->lang->line('Mail Address'); ?></label>
                                                        <input type="text" placeholder="Mail Address" id="mailAddress" name="mailAddress" required class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <label class="form-control-label"> <?php echo $this->lang->line('Phone'); ?></label>
                                                        <input type="text" placeholder="Phone Number" id="phoneNumber" name="phoneNumber" required class="form-control" />
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="form-control-label"> <?php echo $this->lang->line('Company Role'); ?></label>
                                                        <input type="text" placeholder="Company Role" id="companyRole" name="companyRole" required class="form-control" />
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
                                                <h3 class="card-title">  <?php echo $this->lang->line('Account'); ?></h3>

                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <label class="form-control-label"><?php echo $this->lang->line('Email'); ?></label>
                                                        <input type="text" placeholder="Email" id="email" name="Email" required class="form-control" />
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="form-control-label"><?php echo $this->lang->line('Password'); ?></label>
                                                        <input type="text" placeholder="Password" id="password" name="Password" required class="form-control" />
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="form-control-label"><?php echo $this->lang->line('Access'); ?></label>
                                                        <select name="Access" class="custom-select" id="permission">
                                                            <option value="USER" selected>USER</option>
                                                            <option value="MANAGER">MANAGER</option>
                                                            <?php if ($_SESSION['permission'] == "ADMIN") {

                                                                echo "<option value='ADMIN'>ADMIN</option> ";
                                                            } ?>

                                                        </select>
                                                    </div>

                                                </div>
                                            </div>
                                            <!-- /.card-body -->
                                        </div>
                                        <div id="projectsList">
                                            <div class="form-group"><label class="form-control-label"><?php echo $this->lang->line('Projects'); ?>:</label></div>
                                            <div id="projects">

                                            </div>


                                        </div>
                                        <!-- /.card -->
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                                        <input type="submit" value="<?php echo $this->lang->line('Save'); ?>" id="btnSavecustomer" onclick="saveDevice()" class="btn bg-olive float-right">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

</section>
<script>
    var permission = <?php echo "'" . $_SESSION['permission'] . "'" ?>;

    function editEmployee(employeeId) {
        document.getElementById('empId').value = employeeId;

        if (permission == "ADMIN") {
            // change customername textbox to search & select
            var div_data = "";
        } else {
            $('#customerName').html("<option value='" + <?php echo $_SESSION['customerId'] ?> + "' selected='selected'>" + document.getElementById('cname').value + "</option>");
            $('#customerName').select2().prop('disabled', true);
            document.getElementById('customerName').classList.add('disabled');
        }

        if (employeeId == -1) {
            var customer_data = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/customer", "GET", "", document.getElementById("session_token").value).responsedata.responseJSON;
            $('#customerName').select2().prop('disabled', false);
            for (let i = 0; i < customer_data.length; i++) {
                div_data += `<option value=${customer_data[i]['id']}> ${customer_data[i]['name']} </option>`;
            }

            $('#customerName').html(div_data);
        } else {
            // $('#customerName').select2().prop('disabled', true);
            var emp_data = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/employee/" + employeeId, "GET", "", document.getElementById("session_token").value).responsedata.responseJSON;

            // pre-populate customer details from session information
            // document.getElementById("customerName").value =emp_data['']
            document.getElementById('mailAddress').value = emp_data['Mail Address']
            document.getElementById('companyRole').value = emp_data['Company Role']
            document.getElementById('employeeName').value = emp_data['name']
            document.getElementById('email').value = emp_data['email']

            document.getElementById('phoneNumber').value = emp_data['phone']

            document.getElementById('password').value = '';
            $('#password').prop('disabled', true);
            $('#customerName').html(`<option value='${emp_data['customerId']}' selected='selected'>${emp_data['customerName']}</option>`);

            var perm_list = ['ADMIN', 'MANAGER', 'USER'];

            var perm_div = "";
            perm_list.forEach(element => {
                if (emp_data['permission'] == element) {
                    perm_div += "<option value='" + element + "' selected='selected'>" + element + "</option>";
                } else {
                    perm_div += "<option value='" + element + "'>" + element + "</option>";
                }
            });
            // displaying projects list 
            var projectsList = document.getElementById("projects")
            var emp_data = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/employee/" + employeeId, "GET", "", document.getElementById("session_token").value).responsedata.responseJSON;
            console.log(emp_data['Projects List'])

            if (emp_data['Projects List'] != 0) {
                projectsList.innerHTML = `<li>${emp_data['Projects List']}</li>`
                console.log(projectsList)


            } else {
                projectsList.innerHTML = "No open projects found"
                projectsList.style.color = "red"

            }






            for (var i = 1; i <= emp_data; i++) {
                var li = document.createElement("li");
                li.className = "file";

                var a = document.createElement("a");
                a.innerHTML = "Subfile " + i;

                li.appendChild(a);
                ul.appendChild(li);
            }
            $("#permission").html(perm_div);
        }


        $("#addEditEmployeeModal").modal("show")

    }


    // save employee function
    function saveDevice() {
        var empid = document.getElementById('empId').value;

        // 1. Create MAP from all fields of addeditcustomermodal pop-up
        // 2. convert that map to JSON 
        // 3. Call POST / PUT to save data
        // 4. If data saved successfully, show green toast and close modal
        // 5. If data does not save, show red toast and DO NOT close modal

        const today = new Date();

        var employeeObject = {
            "id": empid,
            "employeeStatus": 0,
            "customerId": document.getElementById("customerName").value,
            "Mail Address": document.getElementById('mailAddress').value,
            "Company Role": document.getElementById('companyRole').value,
            "External Company": false,
            "Projects List": [],
            "devices list": [],
            "name": document.getElementById('employeeName').value,
            "email": document.getElementById('email').value,
            "countrycode": "",
            "phone": document.getElementById('phoneNumber').value,
            "createdDate": today.getUTCDay(),
            "password": document.getElementById('password').value,
            "permission": $("#permission").val(),
            "customerName": $("#customerName").val()
        }

        var empObject = {
            "id": -1,
            "name": document.getElementById('employeeName').value,
        };
        var resp;
        if (document.getElementById('empId').value === "-1") {
            // new customer. perform POST
            resp = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/employee", "POST", JSON.stringify(employeeObject), document.getElementById("session_token").value).responsedata;

        } else {
            // existing customer. perform PUT
            resp = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/employee/" + empid, "PUT", JSON.stringify(employeeObject), document.getElementById("session_token").value).responsedata;
        }
        if (resp.status == 200) {
            toastr.success("Employee added successfully!")
            $('#addEditEmployeeModal').modal('hide')
            loadTableData();
        } else {
            // failed
            // show resp.responseText in red toast
            toastr.error("Employee not Updated!")
        }
    }

    function deleteEmployee(empid) {
        // var empid = document.getElementById('empId').value;
        console.log(empid)
        resp = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/employee/" + empid, "DELETE", "", document.getElementById("session_token").value).responsedata;
        if (resp.status == 204 || resp.status == 200) {
            toastr.success("Employee deleted successfully!")
            $('#addEditEmployeeModal').modal('hide')
            loadTableData();
        } else {
            // failed
            // show resp.responseText in red toast
            toastr.error("Employee not Updated!")
            loadTableData();
        }



    }
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
<link rel="stylesheet" href="assets/plugins/intl-tel-input/css/intlTelInput.css">
<script src="assets/plugins/intl-tel-input/js/intlTelInput.js"></script>

<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
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
                            <?php $index = 0;
                            foreach ($employees as $key => $employee) {
                                if ($employee['name'] != "admin") {
                                    $userAccess = "";
                                    if ($employee['permission'] == "ADMIN") {
                                        $userAccess = "Administrator";
                                    } else if ($employee['permission'] == "MANAGER") {
                                        $userAccess = "Manager";
                                    } else if ($employee['permission'] == "USER") {
                                        $userAccess = "User";
                                    } else {
                                        $userAccess = "ReadOnly";
                                    }
                                    $index++;
                                    echo "<tr id='{$employee['id']}'>";
                                    // echo "<td>{$index}</td>";
                                    echo "<td> <i id='rowid.{$employee['id']}' class='fa fa-plus'></i></td>";

                                    if (array_key_exists('name', $employee)) {
                                        echo "<td class='empName'>{$employee['name']}</td>";
                                    } else {
                                        echo "<td class='empName'>NA</td>";
                                    }
                                    if (array_key_exists('Mail Address', $employee)) {
                                        echo "<td class='mailAddress'>{$employee['Mail Address']}</td>";
                                    } else {
                                        echo "<td class='mailAddress'>NA</td>";
                                    }
                                    if (array_key_exists('Phone Number', $employee)) {
                                        echo "<td class='phoneNo'>{$employee['Phone Number']}</td>";
                                    } else {
                                        echo "<td class='phoneNo'>NA</td>";
                                    }
                                    if (array_key_exists('Company Role', $employee)) {
                                        echo "<td class='companyRole'>{$employee['Company Role']}</td>";
                                    } else {
                                        echo "<td class='companyRole'>NA</td>";
                                    }
                                    if (array_key_exists('Externally company', $employee)) {
                                        echo "<td class='extCompany'>{$employee['Externally company']}</td>";
                                    } else {
                                        echo "<td class='extCompany'>NA</td>";
                                    }
                                    /*  if (array_key_exists('Visit Address', $employee)) {
                                        echo "<td class='custVisitAddress'>{$employee['Visit Address']}</td>";
                                    } else {
                                        echo "<td class='custVisitAddress'>NA</td>";
                                    }
                                    */
                                    /*  if (array_key_exists('Post Address', $employee)) {
                                        echo "<td class='custPostAddress' style='display:none;'>{$employee['Post Address']}</td>";
                                    } else {
                                        echo "<td class='custPostAddress' style='display:none;'>NA</td>";
                                    }
                                    */
                                    echo "<td class='access'>{$userAccess}</td>";
                                    $deleteUrl = base_url() . 'employee/delete?id=' . $employee['id'];
                                    $editUrl = base_url() . 'employee/edit?id=' . $employee['id'];
                                    // echo "<td><a href='{$viewUrl}' class='btn btn-sm btn-info p-1 m-0 Editemployee'>View</a> &#160; <a href='{$deleteUrl}' class='color-Red'><i class='fa fa-trash' aria-hidden='true'></i></a></td>";
                                    if ($email == "admin") {
                                        if ($employee['name'] == "admin") {
                                            echo "<td>&nbsp;</td></tr>";
                                        } else {
                                            echo "<td><a href='#' ><p class='fas fa-edit bg-info editEmployee' aria-hidden='true'></p></a>&nbsp;&nbsp;&nbsp;";
                                            echo "<a href='{$deleteUrl}' ><p class='fa fa-trash bg-info' aria-hidden='true'></p></a></td></tr>";
                                            // echo "<td><a href='{$deleteUrl}' class='color-Red'><i class='fa fa-trash' aria-hidden='true'></i></a></td>";
                                        }
                                    } else {
                                        echo "<td>&nbsp;</td></tr>";
                                    }
                                }
                            } ?>
                        </tbody>
                    </table>
                </div>

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
                        var input = document.querySelector("#phoneNumber");
                        window.intlTelInput(input, {
                            preferredCountries: ["NO", "SE", "DK", "NL"],
                            utilsScript: "assets/plugins/intl-tel-input/js/utils.js?1638200991544" // just for formatting/placeholders etc
                        });
                        $(function() {
                            $('#customerId').select2({
                                theme: 'bootstrap4',
                                dropdownParent: $('#newEmployeeModel'),
                                placeholder: 'Select a Customer',
                            });
                            $('#projectId').select2({
                                theme: 'bootstrap4',
                                dropdownParent: $('#newEmployeeModel'),
                                placeholder: 'Select a Project',
                                tags: true,
                                multiple: true,
                                tokenSeparators: [',', ' '],
                            });

                            $('#employeeRecords').DataTable({
                                "paging": true,
                                "lengthChange": false,
                                "searching": true,
                                "ordering": true,
                                "info": true,
                                "autoWidth": false,
                                "responsive": false,
                            });

                            var table = $('#employeeRecords').DataTable();
                            $('#employeeRecords tbody tr td').on('click', 'i', function() {
                                var tr = $(this).closest('tr');
                                var row = table.row(tr);

                                // console.log(row.id());

                                if (row.child.isShown()) {
                                    // This row is already open - close it
                                    row.child.hide();
                                    tr.removeClass('shown');
                                    $('#' + row.id() + ' td i').removeClass('fa-minus');
                                    $('#' + row.id() + ' td i').addClass('fa-plus');
                                } else {
                                    // Open this row
                                    row.child(showCustomerProjects(row.data())).show();
                                    tr.addClass('shown');
                                    $('#' + row.id() + ' td i').removeClass('fa-plus');
                                    $('#' + row.id() + ' td i').addClass('fa-minus');
                                }
                            });
                        });

                        function showCustomerProjects(row_data) {
                            var row_details = "<table width='80%' cellpadding='2' cellspacing='2'>";
                            row_details += "<thead class='bg-info'>";
                            row_details += "<td>Project ID</td>";
                            row_details += "<td>Project Name</td>";
                            row_details += "<td>Project Cost</td>";
                            row_details += "<td>Fleet</td>";
                            row_details += "<td>Manpower</td>";
                            row_details += "<td>Project Time</td>";
                            row_details += "<td>Income</td>";
                            row_details += "<td>Cost</td>" + "</thead>";
                            row_details += "<tr>";
                            row_details += "<td>117</td>";
                            row_details += "<td>Oslo Market</td>";
                            row_details += "<td>$ 100,000</td>";
                            row_details += "<td>5</td>";
                            row_details += "<td>2</td>";
                            row_details += "<td>1 Jan, 2022 - 31 May, 2022</td>";
                            row_details += "<td>$ 12,000</td>";
                            row_details += "<td>$ 88,000</td>";
                            row_details += "</tr>";

                            return row_details;
                        }
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
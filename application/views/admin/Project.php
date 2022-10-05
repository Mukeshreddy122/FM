<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <input type="hidden" id="session_token" value="<?php echo $_SESSION['USER_API_TOKEN'] ?>" />

                        <?php if ($_SESSION['permission'] == "MANAGER" || $_SESSION['permission'] == "ADMIN") {; ?>
                            <a rel="nofollow" id="NewProject" href="#showProjectDetails" data-toggle="modal" class="btn btn-block bg-info" onclick="resetFormData()">Add <?php echo $title; ?> <i class="fa fa-plus"></i></a>
                        <?php } ?>
                    </h4>
                </div>
                <div class="card-body p-0">
                    <table id="projectRecords" class="table table-striped table-sm">
                        <thead class="bg-info" style="font-family: 'Source Sans Pro', sans-serif;">
                            <tr>
                                <th style="width: 1%">
                                    #
                                </th>
                                <?php if ($_SESSION['permission'] == "MANAGER" || $_SESSION['permission'] == "ADMIN") { ?>
                                    <th style="width: 15%">
                                        Customer Name
                                    </th>
                                    <th style="width: 20%">
                                        Project Name
                                    </th>
                                <?php } else { ?>
                                    <th style="width: 35%">
                                        Project Name
                                    </th>
                                <?php } ?>
                                <th style="width: 5%">
                                    Fleet
                                </th>
                                <!--  <td>Project Manager</td> -->
                                <th style="width: 5%">
                                    Manpower
                                </th>
                                <!-- <th style="width: 15%">
                                    Project Time
                                </th> -->
                                <th style="width: 10%">
                                    Cost
                                </th>
                                <th style="width: 10%">
                                    Income
                                </th>
                                <!-- <th style="width: 5%">
                                    Report
                                </th> -->
                                <th style="width: 13%">
                                    &nbsp;
                                </th>
                            </tr>
                        </thead>
                        <tbody id="projectTableData">
                            <?php
                            $index = 0;

                            ?>
                        </tbody>
                    </table>
                </div>
                <script>
                    function deleteProject(project_id) {

                        varfleet = performAPIAJAXCall(`http://vghar.ddns.net:6060/ZFMS/project/${project_id}`, "DELETE", "", document.getElementById("session_token").value);
                        console.log(project_id)
                        $('#projectRecords').DataTable().clear();
                    }
                </script>
                <script>
                    $(function() {
                        $('#projectRecords').DataTable({
                            "paging": true,
                            "lengthChange": false,
                            "searching": true,
                            "ordering": true,
                            "info": true,
                            "autoWidth": false,
                            "responsive": false,
                            "order": [
                                [1, 'desc']
                            ]
                        });

                        // var table = $('#projectRecords').DataTable();
                        $('#projectRecords tbody tr td').on('click', 'i', function() {
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
                        // dropdown
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
                        $(document).ready(
                            loadTableData()
                        );

                        function loadTableData() {
                            $(".dataTables_empty").empty();
                            var project_json = "";
                            <?php
                            if (sizeof($projectInfo) > 0) {
                                // echo "toastr.success('Data Loaded!');";
                                $project_row_data = "";
                                foreach ($projectInfo as $key => $project) {
                                    $index++;

                                    // $project_row_data = "";
                                    $project_row_data = $project_row_data . "<tr id='{$project['id']}'>";
                                    $project_row_data = $project_row_data . "<td class='projectId'>{$project['id']}</td>";
                                    $project_row_data = $project_row_data . "<td class='customerName'>{$this->CustomerModel->getCustomer($project['customerId'])['name']}</td>";
                                    // echo "<td class='customerName'>{$project['customerId']}</td>";
                                    $project_row_data = $project_row_data . "<td class='projectName'>{$project['name']}";
                                    $project_row_data = $project_row_data . "<br/><small><b>Date: </b>{$project['projectStartDate']} - {$project['projectEndDate']}</small></td>";
                                    $project_row_data = $project_row_data . "<td class='projectName'>{$project['deviceCount']}</td>";
                                    $project_row_data = $project_row_data . "<td class='projectName'>{$project['manpower']}</td>";
                                    // echo "<td class='projectTime'>{$project['projectStartDate']} - {$project['projectEndDate']}</td>";
                                    $project_row_data = $project_row_data . "<td class='projectCost'>$ {$project['projectCost']}</td>";
                                    $project_row_data = $project_row_data . "<td class='projectIncome'>$ {$project['projectIncome']}</td>";
                                    // echo "<td class='projectReport'><a href='#'>Report</a></td>";
                                    if ($_SESSION['permission'] == "MANAGER" || $_SESSION['permission'] == "ADMIN") {
                                        $project_row_data = $project_row_data . "<td class='project-actions text-right'>";
                                        if ($project['projectIsCompleted']) {
                                            $project_row_data = $project_row_data . "<i class='fas fa-eye text-info' onclick='showProjectDetails({$project['id']})'></i>&nbsp;&nbsp;&nbsp;";
                                            $project_row_data = $project_row_data . "<i class='fas fa-pencil-alt text-gray disabled'></i>&nbsp;&nbsp;&nbsp;";
                                            $project_row_data = $project_row_data . "<i class='fas fa-check text-green'></i></td>";
                                        } else {
                                            $project_row_data = $project_row_data . "<i class='fas fa-eye text-info' onclick='showProjectDetails({$project['id']})'></i>&nbsp;&nbsp;&nbsp;";
                                            $project_row_data = $project_row_data . "<i class='fas fa-pencil-alt text-orange' onclick='editProject({$project['id']})'></i>&nbsp;&nbsp;&nbsp;";
                                            $project_row_data = $project_row_data . "<i class='fas fa-trash text-danger outline'></i></td>";
                                        }
                                    } else {
                                        $project_row_data = $project_row_data . "<td><a href='#showProjectDetails'><i class='fas fa-folder text-info'></i></a>";
                                        $project_row_data = $project_row_data . "<i class='fas fa-eye text-info'></i>&nbsp;&nbsp;&nbsp;";
                                        $project_row_data = $project_row_data . "&nbsp;&nbsp;&nbsp;</td>";
                                    }
                                    $project_row_data = $project_row_data . "</tr>";
                                }
                                echo "$('#projectRecords').DataTable().destroy();";
                                echo "$('#projectRecords').find('tbody').append(\"$project_row_data\");";
                                echo "$('#projectRecords').DataTable().draw();";
                            } else {
                                echo "toastr.error('Unable to get data!')";
                            }
                            ?>
                        }
                    });
                </script>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" id="addEditProjectModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h4 class="modal-title">Project Details</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card card-primary">
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
                                                <input type="hidden" id="projectId" name="projectId" />
                                            </div>
                                            <div class="col-sm-12">
                                                <label class="form-control-label">Customer Name</label>
                                                <input type="text" placeholder="Customer Name" id="customerName" name="customerName" required class="form-control" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label class="form-control-label">Project Name</label>
                                                <input type="text" placeholder="Project Name" id="projectName" name="projectName" required class="form-control" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label class="form-control-label">Start Date</label>
                                                <input type="date" id="startDate" name="startDate" required class="form-control" />
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="form-control-label">End Date</label>
                                                <input type="date" id="endDate" name="endDate" required class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>
                            <div class="col-md-6">
                                <div class="card ">
                                    <div class="card-header">
                                        <h3 class="card-title">Budget</h3>

                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label class="form-control-label">Project Cost</label>
                                                <input type="text" placeholder="Project Cost" id="projectCost" name="projectCost" required class="form-control" />
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="form-control-label">Project Income</label>
                                                <input type="text" placeholder="Project Income" id="projectIncome" name="projectIncome" required class="form-control" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label class="form-control-label">Manpower</label>
                                                <input type="text" placeholder="Manpower" id="projectManpower" name="projectManpower" required class="form-control" />
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="form-control-label">Fleet</label>
                                                <input type="text" placeholder="Manpower" id="projectFleet" name="projectFleet" required class="form-control" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label class="form-control-label">People on Project</label>
                                                <div class="form-select">
                                                    <select id="peopleonProject" multiple name="peopleonProject" class="custom-select">
                                                        <?php
                                                        echo "<option value=''></option>";
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <label class="form-control-label">Fleet</label>
                                                <div class="form-select">
                                                    <select id="devices" multiple name="devices" class="custom-select">
                                                        <?php
                                                        echo "<option value=''></option>";
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                                <input type="submit" value="Save" id="btnSaveProject" class="btn btn-success float-right">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" id="showProjectDetails">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h4 class="modal-title">Project Details</h4>
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
                                                <span class="info-box-number text-center text-muted mb-0" id="roProjectCost"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="info-box bg-light">
                                            <div class="info-box-content">
                                                <span class="info-box-text text-center text-muted">Income</span>
                                                <span class="info-box-number text-center text-muted mb-0" id="roProjectIncome"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="info-box bg-light">
                                            <div class="info-box-content">
                                                <span class="info-box-text text-center text-muted">Fleet</span>
                                                <span class="info-box-number text-center text-muted mb-0" id="roProjectFleet"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="info-box bg-light">
                                            <div class="info-box-content">
                                                <span class="info-box-text text-center text-muted">Manpower</span>
                                                <span class="info-box-number text-center text-muted mb-0" id="roProjectManpower"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <h3 class="text-orange center"><i class="fas fa-wrench"></i> Fleet</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-8 col-lg-8 order-1 order-md-1">
                                <div class="text-muted">
                                    <p class="text-sm">Customer Name
                                        <b class="d-block" id="roCustomerName">Deveint Inc</b>
                                    </p>
                                    <p class="text-sm">Project Name
                                        <b class="d-block" id="roProjectName">Tony Chicken</b>
                                    </p>
                                    <p class="text-sm">Start Date
                                        <b class="d-block" id="roStartDate">Tony Chicken</b>
                                    </p>
                                    <p class="text-sm">End Date
                                        <b class="d-block" id="roEndDate">Tony Chicken</b>
                                    </p>
                                </div>

                            </div>
                            <div class="col-12 col-md-4 col-lg-4 order-2 order-md-2">
                                <div id="roFleetList">

                                </div>
                            </div>
                            <div class="row" id="roEmployeeList">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
</section>

<script type="text/javascript">
    function editProject(projectid) {
        permission = <?php echo "'" . $_SESSION['permission'] . "'" ?>;
        customer = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/customer/" + <?php echo $_SESSION['customerId'] ?>, "GET", "", document.getElementById("session_token").value).responsedata.responseJSON;

        // alert(customer['name']);

        if (permission == "ADMIN") {
            // change customername textbox to search & select
        } else {
            // pre-populate customer details from session information
            document.getElementById('customerName').value = customer['name'];
            document.getElementById('customerName').classList.add('disabled');
            document.getElementById('customerName').setAttribute('readonly', 'readonly');
        }
        if (projectid == -1) {
            // all fields blank

        } else {
            var project_json = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/project/" + projectid, "GET", "", document.getElementById("session_token").value).responsedata.responseJSON;
            // Mukesh Work
            // pull field names from #addEditProjectModal MODAL section 
            // and populate data for each field from project_json 
            document.getElementById('projectName').value = project_json['name'];
        }
        $('#addEditProjectModal').modal('show');
    }

    function showProjectDetails(projectid) {
        // this is read only view of the project details section
        // shown only to user. admin & manager wil see the editProject / addEditProjectModal section
        var project_response = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/project/" + projectid, "GET", "", document.getElementById("session_token").value).responsedata.responseText;
        var project_json = JSON.parse(project_response);
        // alert(device_list['projectCost']);
        // Mukesh to add all other values
        $('#roProjectCost').html(project_json['projectCost']);
        $('#roProjectIncome').html(project_json['projectIncome']);

        var device_array = [];

        device_array = project_json['devicesList'];
        var device_div = "";
        device_array.forEach(element => {
            var device_json = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/fleet/" + element, "GET", "", document.getElementById("session_token").value).responsedata.responseJSON;
            var device_img = performAPIAJAXCallGeneric("http://vghar.ddns.net:6060/ZFMS/fleet/" + element + "/image", "GET", "", document.getElementById("session_token").value).responsedata.responseText;
            device_div += "<div class='post'>";
            device_div += "<div class='user-block'>";
            device_div += "<img class='img-circle img-bordered-sm' src='data:image/png;base64, " + device_img + "' alt=''>";
            device_div += "<span class='username'><p>" + device_json['name'] + "</p></span>";
            if (device_json['deviceOnline']) {
                device_div += "<span class='description'><i class='fa fa-map-marker text-green'></i>&nbsp;Online";
            } else {
                device_div += "<span class='description'><i class='fa fa-map-marker text-red'></i>&nbsp;Offline";
            }
            device_div += "<p>Last Online Time: " + device_json['lastOnlineTime'] + "</p></span>";
            device_div += "<p>Notes: " + device_json['notes'] + "</p>";
            if (device_json['underMaintenance']) {
                device_div += "<p>Maintenance: <i class='fa fa-wrench text-red'></i>" + "</p>";
            } else {
                device_div += "<p>Maintenance: <i class='fa fa-check text-green'></i>" + "</p>";
            }
            device_div += "</div>";
        });
        $('#roFleetList').html(device_div);
        $('#showProjectDetails').modal('show');
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
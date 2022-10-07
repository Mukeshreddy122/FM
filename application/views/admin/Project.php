<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <input type="hidden" id="session_token" value="<?php echo $_SESSION['USER_API_TOKEN'] ?>" />
                        <input type="hidden" id="cname" value="<?php echo $_SESSION['myCustomerName'] ?>" />

                        <?php if ($_SESSION['permission'] == "MANAGER" || $_SESSION['permission'] == "ADMIN") {; ?>
                            <button id="NewProject" data-toggle="modal" class="btn btn-block bg-info" onclick="editProject(-1)">Add <?php echo $title; ?> <i class="fa fa-plus"></i></button>
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
                    // 
                    function deleteProject(project_id) {
                        varfleet = performAPIAJAXCall(`http://vghar.ddns.net:6060/ZFMS/project/${project_id}`, "DELETE", "", document.getElementById("session_token").value);
                        // console.log(project_id)
                        $('#projectRecords').DataTable().clear();
                    }
                </script>
                <script>
                    $(function() {
                        $('#customerName').select2();
                        $('#selEmpList').select2();
                        $('#selFleetList').select2();

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

                        $('#customerName').on('select2:select', function(e) {
                            var data = e.params.data;
                            var custId = parseInt(data.id)
                            var div_data = "";
                            // EMP Data
                            var emp_data = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/employee", "GET", "", document.getElementById("session_token").value).responsedata.responseJSON;
                            for (let i = 0; i < emp_data.length; i++) {
                                if (emp_data[i].customerId === custId) {
                                    div_data += `<option value='${custId}'>${emp_data[i].name}</option>`;
                                }
                            }


                            $('#selEmpList').html(div_data);
                            // EMP End
                            // FLEET Data
                            var fleet_div
                            var fleet_data = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/fleet", "GET", "", document.getElementById("session_token").value).responsedata.responseJSON;
                            for (let i = 0; i < fleet_data.length; i++) {
                                if (fleet_data[i].customerId === custId) {
                                    fleet_div += `<option value='${custId}'>${fleet_data[i].name}</option>`;
                                }
                            }
                            // console.log(div_data)
                            $('#selFleetList').html(fleet_div);
                            // END FLEET
                            // PROJECT DATA
                            // var project_div
                            // var project_data = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/project", "GET", "", document.getElementById("session_token").value).responsedata.responseJSON;
                            // for (let i = 0; i < project_data.length; i++) {
                            //     if (project_data[i].customerId === custId) {
                            //         project_div += `<option value='${custId}'>${project_data[i].name}</option>`;
                            //     }
                            // }

                            // $('#projectName').html(project_div);


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
                            // console.log(row_data.id());

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
                            // console.log(project_data);
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
        <div class="modal fade" id="addEditProjectModal">
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
                                                <input type="hidden" id="projectId" name="projectId" />
                                            </div>
                                            <div class="col-sm-12">
                                                <!-- <label class="form-control-label">Customer Name</label>
                                                <input type="text" placeholder="Customer Name" id="customerName" name="customerName" required class="form-control" /> -->
                                                <div class="form-group"><label class="form-control-label">Customer Name</label>
                                                    <select class="form-control select2 " id="customerName" style="width: 100%;" required>
                                                    </select>
                                                </div>
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
                                <div class="card card-light ">
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
                                                <input type="text" placeholder="Fleet" id="projectFleet" name="projectFleet" required class="form-control" />
                                            </div>
                                        </div>
                                        <div class="row">

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
                                                    <select id="selFleetList" class="select2" data-dropdown-css-class="select2-info" multiple name="devices" data-dropdown-css-class="select2-info" class="custom-select">

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
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <input type="submit" value="Save" id="btnSaveProject" onclick="saveProject()" class="btn bg-olive float-right">
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

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-8 col-lg-8 order-1 order-md-1">
                                <div class="text-muted">
                                    <p class="text-sm">Customer Name
                                        <b class="d-block" id="roCustomerName"></b>
                                    </p>
                                    <p class="text-sm">Project Name
                                        <b class="d-block" id="roProjectName"></b>
                                    </p>
                                    <p class="text-sm">Start Date
                                        <b class="d-block" id="roStartDate"></b>
                                    </p>
                                    <p class="text-sm">End Date
                                        <b class="d-block" id="roEndDate"></b>
                                    </p>
                                </div>

                            </div>
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
</section>

<script type="text/javascript">
    function saveProject() {
        var selEmpList = document.getElementById('selEmpList').value
        var selFleetList = document.getElementById('selFleetList').value

        var startDate = document.getElementById('startDate').value
        var endDate = document.getElementById('endDate').value
        var custId = document.getElementById('customerName').value
        var projectCost = document.getElementById('projectCost').value
        var projectIcome = document.getElementById('projectIncome').value
        var projectManpower = document.getElementById('projectManpower').value
        var projectFleet = document.getElementById('projectFleet').value
        var projectName = document.getElementById('projectName').value
        var projectName = document.getElementById('projectName').value
        var projectName = document.getElementById('projectName').value
        var projectProfit = projectCost - projectIcome




        // perform validation for each field display toaster alert 
        if (projectName === "" || custId === "" || startDate === "" || endDate === "" || projectManpower === "" || projectFleet === "" || projectCost === "" || projectIncome === "" || projectFleet === "" || selEmpList === "" || selFleetList === "") {
            toastr.error("Please fill all the fields!")
        } else {
            // call POST for create new project 

            var newProject = {
                "name": projectName,
                "customerId": custId,
                "projectStartDate": startDate,
                "projectEndDate": endDate,
                "manpower": projectManpower,
                "deviceCount": projectFleet,
                "projectCost": projectCost,
                "projectIncome": projectIcome,
                "projectProfit": projectProfit,
                "employeesList": [selEmpList],
                "devicesList": [
                    selFleetList
                ]
            }
            var project_data = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/project", "POST", JSON.stringify(newProject), document.getElementById("session_token").value);
            console.log(project_data)

        }

        // PUT 
        // perform validation for each field display toaster alert 
        //  if (projectName === "" || custId === "" || startDate === "" || endDate === "" || projectManpower === "" || projectFleet === "" || projectCost === "" || projectIncome === "" || projectFleet === "" || selEmpList === "" || selFleetList === "") {
        //     toastr.error("Please fill all the fields!")
        // } else {
        //     // call PUT for create new project 

        //     var newProject = {
        //         "name": projectName,
        //         "customerId": custId,
        //         "projectStartDate": startDate,
        //         "projectEndDate": endDate,
        //         "manpower": projectManpower,
        //         "deviceCount": projectFleet,
        //         "projectCost": projectCost,
        //         "projectIncome": projectIcome,
        //         "projectProfit": projectProfit,
        //         "employeesList": [selEmpList],
        //         "devicesList": [
        //             selFleetList
        //         ]
        //     }
        //     var project_data = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/project", "PUT", JSON.stringify(newProject), document.getElementById("session_token").value);
        //     console.log(project_data)

        // }


        var empOptions = $('#selEmpList').select2('val')
        var fleetOptions = $('#selFleetList').select2('val')


        if (empOptions.length > document.getElementById("projectManpower").value) {
            toastr.error("Man power exceeded!")
        }
        if (fleetOptions.length > document.getElementById("projectFleet").value) {
            toastr.error("Fleet Count exceeded!")
        }

    }

    function editProject(projectid) {

        var permission = <?php echo "'" . $_SESSION['permission'] . "'" ?>;
        var customerName = <?php echo $_SESSION['customerName'] ?>;
        if(customerName==1)
        {
            $("#customerName").prop('disabled', false);
        }
        else{
            $("#customerName").prop('disabled', true);
        }
        var customerIndustry = <?php echo $_SESSION[' customerIndustry'] ?>;
        var customerTypeOfCompany = <?php echo $_SESSION['customerTypeOfCompany '] ?>;
        var customerNumOfEmployees = <?php echo $_SESSION['customerNumOfEmployees'] ?>;
        var customerVATNumber = <?php echo $_SESSION['customerVATNumbe'] ?>;
        var customerVisitAddress = <?php echo $_SESSION['customerVisitAddress'] ?>;
        var customerPostAddress = <?php echo $_SESSION['customerPostAddress'] ?>;
        var customerSisterCompanies = <?php echo $_SESSION['customerSisterCompanies'] ?>;
        // EMP_NAME
        var employeeName = <?php echo $_SESSION['employeeName'] ?>;
        var employeeMailAddress = <?php echo $_SESSION['employeeMailAddress '] ?>;
        var employeePhoneNumber = <?php echo $_SESSION['employeePhoneNumber'] ?>;
        var employeeCompanyRole = <?php echo $_SESSION['employeeCompanyRole '] ?>;
        var employeeExternalCompany = <?php echo $_SESSION['employeeExternalCompany'] ?>;
        var employeeProjectConnection = <?php echo $_SESSION['employeeProjectConnection'] ?>;
        var deviceName = <?php echo $_SESSION['deviceName'] ?>;
        var deviceWebsite = <?php echo $_SESSION['deviceWebsite'] ?>;
        var deviceSerialNumber = <?php echo $_SESSION[' deviceSerialNumber'] ?>;
        var deviceSenderNumber = <?php echo $_SESSION['deviceSenderNumber'] ?>;
        var deviceSenderType = <?php echo $_SESSION['deviceSenderType'] ?>;
        var deviceCategory = <?php echo $_SESSION['deviceCategory'] ?>;
        var deviceFabrication = <?php echo $_SESSION['deviceFabrication'] ?>;
        var deviceServiceInterval = <?php echo $_SESSION['deviceServiceInterval'] ?>;
        var deviceContainerName = <?php echo $_SESSION['deviceContainerName'] ?>;
        var deviceServiceLog = <?php echo $_SESSION[' deviceServiceLog'] ?>;
        var deviceNotes = <?php echo $_SESSION['deviceNotes '] ?>;
        var devicePicture = <?php echo $_SESSION['devicePicture'] ?>;
        var projectName = <?php echo $_SESSION['projectName'] ?>;
        var projectCustomerName = <?php echo $_SESSION['projectCustomerName'] ?>;
        var projectCost = <?php echo $_SESSION['projectCost'] ?>;
        if(projectCost!=1)
        {
            $("#projectCost").hide();
        }
        var projectIncome = <?php echo $_SESSION['projectIncome'] ?>;
        if(projectIncome!=1)
        {
            $("#projectIncome").hide();
        }
      
        var projectStartTime = <?php echo $_SESSION['projectStartTime'] ?>;
        if(projectStartTime!=1)
        {
            $("#startDate").hide();
        }
       
        var projectEndTime = <?php echo $_SESSION['projectEndTime'] ?>;
        if(projectEndTime!=1)
        {
            $("#endDate").hide();
        }
        var projectFleet = <?php echo $_SESSION['projectFleet'] ?>;
        if(projectFleet!=1)
        {
            $("#projectFleet").hide();
        }
        var projectManpower = <?php echo $_SESSION['projectManpower'] ?>;
        if(projectManpower!=1)
        {
            $("#projectManpower").hide();
        }
        var projectProfit = <?php echo $_SESSION['projectProfit '] ?>;
        if(projectProfit!=1)
        {
            $("#projectProfit").hide();
        }
       


        var emp_data = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/employee", "GET", "", document.getElementById("session_token").value).responsedata.responseJSON;
        var fleet_data = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/fleet", "GET", "", document.getElementById("session_token").value).responsedata.responseJSON;



        if (projectid == -1) {
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
    }

    function showProjectDetails(projectid) {
        // this is read only view of the project details section
        // shown only to user. admin & manager wil see the editProject / addEditProjectModal section
        var project_response = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/project/" + projectid, "GET", "", document.getElementById("session_token").value).responsedata.responseText;
        var project_json = JSON.parse(project_response);
        // console.log(project_json)
        customer = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/customer/" + project_json['customerId'], "GET", "", document.getElementById("session_token").value).responsedata.responseJSON;
        // console.log(customer)
        // alert(device_list['projectCost']);
        // Mukesh to add all other values
        $('#roProjectCost').html(project_json['projectCost']);
        $('#roProjectIncome').html(project_json['projectIncome']);
        $('#roProjectFleet').html(project_json['deviceCount']);
        $('#roProjectManpower').html(project_json['manpower']);
        $('#roCustomerName').html(document.getElementById('cname').value);
        $('#roProjectManpower').html(project_json['manpower']);
        $('#roStartDate').html(project_json['projectStartDate']);
        $('#roEndDate').html(project_json['projectEndDate']);
        $('#roProjectName').html(project_json['name']);

        // employee details 
        var employees_array = [];
        employees_array = project_json['employeesList'];
        var employee_div = "";
        employees_array.forEach(emp => {
            var employee_json = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/employee/" + emp, "GET", "", document.getElementById("session_token").value).responsedata.responseJSON;
            // console.log("Employee json" + JSON.stringify(employee_json))
            employee_div += `<option selected='selected'>${employee_json['name']}</option>`


        });
        $("#selEmpList").html(employee_div)
        // End of emp list selection in edit page

        // fleet details
        var fleets_array = [];
        fleets_array = project_json['devicesList'];
        var fleet_div = "";
        fleets_array.forEach(fleet => {
            var fleet_json = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/fleet/" + fleet, "GET", "", document.getElementById("session_token").value).responsedata.responseJSON;
            // console.log("Employee json" + JSON.stringify(employee_json))
            fleet_div += `<option selected='selected'>${fleet_json['name']}</option>`


        });
        $("#selFleetList").html(fleet_div)
        // End of fleet list selection in edit page

        $('#showProjectDetails').modal('show');


        var device_array = [];

        device_array = project_json['devicesList'];
        var device_div = "";
        device_array.forEach(element => {
            var device_json = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/fleet/" + element, "GET", "", document.getElementById("session_token").value).responsedata.responseJSON;
            var device_img = performAPIAJAXCallGeneric("http://vghar.ddns.net:6060/ZFMS/fleet/" + element + "/image", "GET", "", document.getElementById("session_token").value).responsedata.responseText;
            device_div += "<div class='post'>";
            device_div += "<div class='user-block'>";
            device_div += "<img class='img-circle img-bordered-sm' src='data:image/png;base64, " + device_img + "' alt=''>";
            if (device_json['underMaintenance']) {
                device_div += "<span class='username'><p>" + device_json['name'];
                device_div += " <i class='fa fa-solid fa-toolbox text-red'></i>" + "</p></span>";
            } else {
                device_div += "<span class='username'><p>" + device_json['name'];

                device_div += " <i class='fa fa-solid fa-toolbox text-green'></i>" + "</p></span>";
            }
            if (device_json['deviceOnline']) {
                device_div += "<span class='description'><i class='fa fa-map-marker text-green'></i>&nbsp;Online";
            } else {
                device_div += "<span class='description'><i class='fa fa-map-marker text-red'></i>&nbsp;Offline";
            }
            device_div += "<p>Last Online Time: " + device_json['lastOnlineTime'] + "</p></span>";
            // device_div += "<p>Notes: " + device_json['notes'] + "</p>";

            device_div += "</div>";
        });
        $('#roFleetList').html(device_div);

        // adding the employee details
        var employees_array = [];
        employees_array = project_json['employeesList'];
        var employee_div = "";
        employees_array.forEach(emp => {
            var employee_json = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/employee/" + emp, "GET", "", document.getElementById("session_token").value).responsedata.responseJSON;
            // var employee_img = performAPIAJAXCallGeneric("http://vghar.ddns.net:6060/ZFMS/employee/" + emp + "/image", "GET", "", document.getElementById("session_token").value).responsedata.responseJSON;
            // console.log("Employee json" + JSON.stringify(employee_json))
            employee_div += "<div class='class='col-3 col-md-3 col-sm'>"
            employee_div += "<ul class='users-list clearfix'>"
            employee_div += "<li>"
            employee_div += "<i class='fas fa-user' alt='User Image'></i>"
            employee_div += employee_json['name']
            employee_div += "<span class='users-list-date'>Employee</span>"
            employee_div += "</li>"
            employee_div += "</ul>"
            employee_div += "</option>"

        });
        $("#roEmployeeList").html(employee_div)

        $('#showProjectDetails').modal('show');
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
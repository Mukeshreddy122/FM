<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <input type="hidden" id="session_token" value="<?php echo $_SESSION['USER_API_TOKEN'] ?>" />
                        <input type="hidden" id="cname" value="<?php echo $_SESSION['myCustomerName'] ?>" />
                        <?php if ($_SESSION['permission'] == "MANAGER" || $_SESSION['permission'] == "ADMIN") {; ?>
                            <button id="NewProject" data-toggle="modal" class="btn btn-block bg-info" onclick="editProject(-1)"><?php echo $this->lang->line('Add');
                                                                                                                                echo $this->lang->line('title'); ?> <i class="fa fa-plus"></i></button>
                        <?php } ?>
                        <?php
                        $currencyForCost;
                        switch ($_SESSION['currencyForCost']) {
                            case "dollar":
                                echo "<input type='hidden' id='currencyForCost' value='$'/>";
                                $currencyForCost = "$";
                                break;
                            case "Pound":
                                echo "<input type='hidden' id='currencyForCost' value='£'/>";
                                $currencyForCost = "£";
                                break;
                            case "euro":
                                echo "<input type='hidden' id='currencyForCost' value='€'/>";
                                $currencyForCost = "€";
                                break;
                        }
                        ?>
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
                                        <?php echo $this->lang->line('Customer Name'); ?>
                                    </th>
                                    <th style="width: 20%">
                                        <?php echo $this->lang->line('Project Name'); ?>
                                    </th>
                                <?php } else { ?>
                                    <th style="width: 35%">
                                        <?php echo $this->lang->line('Project Name'); ?>
                                    </th>
                                <?php } ?>
                                <th style="width: 5%">
                                    <?php echo $this->lang->line('Fleet Name'); ?>
                                </th>
                                <th style="width: 5%">
                                    <?php echo $this->lang->line('Manpower'); ?>
                                </th>
                                <th style="width: 10%">
                                    <?php echo $this->lang->line('Cost'); ?>
                                </th>
                                <th style="width: 10%">
                                    <?php echo $this->lang->line('Income'); ?>
                                </th>
                                <th style="width: 8%">
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
                        $('#projectRecords').DataTable().clear();
                    }
                </script>
                <script>
                    $(document).ready(function() {
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
                            $('#selFleetList').html(fleet_div);
                            // END FLEET
                            // PROJECT DATA
                        });
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

                        loadTableData()


                    });

                    function loadTableData() {
                        var projectInfo = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/project", "GET", "", document.getElementById("session_token").value).responsedata.responseJSON;
                        console.log(projectInfo)
                        $(".dataTables_empty").empty();
                        var project_json = " ";
                        <?php
                        $currency_symbol = '';
                        // print_r("currency for cost " .$_SESSION['currencyForCost']);
                        // die;
                        switch ($_SESSION['currencyForCost']) {
                            case 'Dollar':
                                $currency_symbol = '$';
                                break;
                            case 'Pound':
                                $currency_symbol = '£';
                                break;
                            case 'Euro':
                                $currency_symbol = '€';
                                break;
                            default:
                                # code...
                                $currency_symbol = '$';
                                break;
                        }
                        if (sizeof($projectInfo) > 0) {
                            echo "toastr.success('Data Loaded!');";
                            $project_row_data = "";
                            foreach ($projectInfo as $key => $project) {
                                $index++;
                                $project_row_data = $project_row_data . "<tr id='{$project['id']}'>";
                                $project_row_data = $project_row_data . "<td class='projectId'>{$project['id']}</td>";
                                $project_row_data = $project_row_data . "<td class='customerName'>{$this->CustomerModel->getCustomer($project['customerId'])['name']}</td>";
                                // echo "<td class='customerName'>{$project['customerId']}</td>";
                                $project_row_data = $project_row_data . "<td id='projectName'>{$project['name']}";
                                $project_row_data = $project_row_data . "<br/><small><b>Date: </b></small><small id='projectStartDate'>{$project['projectStartDate']}</small> - <small id='projectEndDate'>{$project['projectEndDate']}</small></td>";
                                $project_row_data = $project_row_data . "<td id='deviceCount'>{$project['deviceCount']}</td>";
                                $project_row_data = $project_row_data . "<td id='manpower'>{$project['manpower']}</td>";
                                // echo "<td class='projectTime'>{$project['projectStartDate']} - {$project['projectEndDate']}</td>";
                                $project_row_data = $project_row_data . "<td id='projectCost'>{$currency_symbol} {$project['projectCost']}</td>";
                                $project_row_data = $project_row_data . "<td id='projectIncome'>{$currency_symbol} {$project['projectIncome']}</td>";
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
                </script>
            </div>
        </div>
        <div class="modal fade" id="addEditProjectModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h4 class="modal-title" id="addEditTitle">Add / Edit Project</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card card-light">
                                    <div class="card-header">
                                        <h3 class="card-title"><?php echo $this->lang->line('General'); ?></h3>
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
                                                <div class="form-group"><label class="form-control-label"><?php echo $this->lang->line('Customer Name'); ?></label>
                                                    <select class="form-control select2 " id="customerName" style="width: 100%;" required>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label class="form-control-label"><?php echo $this->lang->line('Project Name'); ?></label>
                                                <input type="text" placeholder="Project Name" id="projectName" name="projectName" required class="form-control" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label class="form-control-label"><?php echo $this->lang->line('StartDate'); ?></label>
                                                <input type="date" id="startDate" name="startDate" required class="form-control" />
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="form-control-label"><?php echo $this->lang->line('EndDate'); ?></label>
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
                                        <h3 class="card-title"><?php echo $this->lang->line('Budget'); ?></h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label class="form-control-label"></label>
                                                <input type="text" placeholder="Project Cost" id="projectCost" name="projectCost" required class="form-control" />
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="form-control-label"><?php echo $this->lang->line('Income'); ?></label>
                                                <input type="text" placeholder="Project Income" id="projectIncome" name="projectIncome" required class="form-control" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label class="form-control-label"><?php echo $this->lang->line('ManPower'); ?></label>
                                                <input type="text" placeholder="Manpower" id="projectManpower" name="projectManpower" required class="form-control" />
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="form-control-label"><?php echo $this->lang->line('Fleet Name'); ?></label>
                                                <input type="text" placeholder="Fleet" id="projectFleet" name="projectFleet" required class="form-control" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group select2-info">
                                                    <label><?php echo $this->lang->line('Employees'); ?></label>
                                                    <select id="selEmpList" class="select2" multiple="multiple" data-placeholder="Select a Employee" data-dropdown-css-class="select2-info" style="width: 100%;">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="form-control-label "><?php echo $this->lang->line('Fleet'); ?></label>
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
                                <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo $this->lang->line('Cancel'); ?></button>
                                <input type="submit" value="<?php echo $this->lang->line('Save'); ?>" id="btnSaveProject" onclick="saveProject()" class="btn bg-olive float-right">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</section>
<script>
    function editProject(projectid) {
        document.getElementById('projectId').value = projectid;
        var permission = <?php echo "'" . $_SESSION['permission'] . "'" ?>;
        console.log(permission)
        var customerName = <?php echo $_SESSION['customerName'] ?>;
        if (customerName != 1) {
            $("#customerName").hide();
        }
        var emp_data = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/employee", "GET", "", document.getElementById("session_token").value).responsedata.responseJSON;
        var fleet_data = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/fleet", "GET", "", document.getElementById("session_token").value).responsedata.responseJSON;
        if (projectid == -1) {
            document.getElementById('addEditTitle').value = "Add New Project";
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
            document.getElementById('addEditTitle').value = "Edit Project - " + project_json['name'];
            /** EMPLOYEE drop down section */
            var emp_data = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/employee", "GET", "", document.getElementById("session_token").value).responsedata.responseJSON;
            var proj_emp_list = project_json['employeesList'];
            var proj_emp_set = new Set(proj_emp_list);
            var div_data = "";
            emp_data.forEach(emp => {
                employee_json = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/employee/" + emp['id'], "GET", "", document.getElementById("session_token").value).responsedata.responseJSON;
                console.log(employee_json)
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
        customer = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/customer/" + project_json['customerId'], "GET", "", document.getElementById("session_token").value).responsedata.responseJSON;
        var currency_val = document.getElementById('currencyForCost').value;
        // Mukesh to add all other values
        $('#roProjectCost').html(currency_val + " " + project_json['projectCost']);
        $('#roProjectIncome').html(currency_val + " " + project_json['projectIncome']);
        $('#roProjectFleet').html(currency_val + " " + project_json['deviceCount']);
        $('#roProjectManpower').html(currency_val + " " + project_json['manpower']);
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
            device_div += "</div>";
        });
        $('#roFleetList').html(device_div);
        // adding the employee details
        var employees_array = [];
        employees_array = project_json['employeesList'];
        var employee_div = "";
        employees_array.forEach(emp => {
            var employee_json = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/employee/" + emp, "GET", "", document.getElementById("session_token").value).responsedata.responseJSON;
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

    function deleteProject() {}

    function saveProject() {
        var projId = document.getElementById('projectId').value
        var selEmpList = document.getElementById('selEmpList').value
        var selFleetList = document.getElementById('selFleetList').value
        // var projId = document.getElementById('project')
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
        // 1. Create MAP from all fields of addeditcustomermodal pop-up
        // 2. convert that map to JSON 
        // 3. Call POST / PUT to save data
        // 4. If data saved successfully, show green toast and close modal
        // 5. If data does not save, show red toast and DO NOT close modal
        const today = new Date();

        var projectObject = {
            "id": projId,
            "name": projectName,
            "customerId": custId,
            "projectStartDate": startDate,
            "projectEndDate": endDate,
            "manpower": projectManpower,
            "deviceCount": projectFleet,
            "projectCost": projectCost,
            "projectIncome": projectIcome,
            "projectProfit": projectProfit,
            "projectStatus": 0,
            "projectIsCompleted": false,
            "createdDate": today.getUTCDay(),
            "employeesList": [],
            "devicesList": []
        }
        // var empObject = {
        //     "id": -1,
        //     "name": document.getElementById('employeeName').value,
        // };
        var resp;
        if (document.getElementById('projectId').value == "-1") {
            // new customer. perform POST
            resp = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/project", "POST", JSON.stringify(projectObject), document.getElementById("session_token").value).responsedata;
        } else {
            // existing customer. perform PUT
            resp = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/project/" + projId, "PUT", JSON.stringify(projectObject), document.getElementById("session_token").value).responsedata;
        }
        if (resp.status == 200) {
            toastr.success("Project data updated!")
            $('#addEditCustomerModal').modal('hide')
            loadTableData();
        } else {
            // failed
            // show resp.responseText in red toast
            toastr.error("Customer not Updated!")
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
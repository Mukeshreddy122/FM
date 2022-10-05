<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                    <input type="hidden" id="session_token" value="<?php echo $_SESSION['USER_API_TOKEN'] ?>" />

                        <?php if ($_SESSION['permission'] == "MANAGER" || $_SESSION['permission'] == "ADMIN") {; ?>
                            <a rel="nofollow" id="NewProject" href="#NewProjectModel" data-toggle="modal" class="btn btn-block bg-info" onclick="resetFormData()">Add <?php echo $title; ?> <i class="fa fa-plus"></i></a>
                        <?php } ?>
                    </h4>
                </div>
                <div class="card-body">
                    <table id="projectRecords" class="table  table-hover table-sm">
                        <thead class="bg-info font-weight-bold" >
                            <tr>
                                <td>Project ID</td>
                                <!-- <td>Customer Name</td> -->
                                <!-- <td>Project Name</td> -->
                                <td>Fleet</td>
                                <td>Project Cost</td>
                                
                                 <!-- <td>Project Manager</td> -->
                                <td>Manpower</td>
                                <td>Project Time</td>
                                <td>Income</td>
                                <td>Project start-date</td>
                                <td>Project end-date</td>
                                <!-- <td>Report</td> -->
                                <td id="action-header">Actions</td>
                                
                            </tr>
                        </thead>
                        <tbody>
                           
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
                    

                    var table = $('#projectRecords').DataTable();
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
                       
                        var project_result = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/project", "GET", " ", document.getElementById("session_token").value);
                        console.log(project_result.responsedata.responseJSON)
                        var status =project_result.status
                        console.log(status)
                        var project_res =project_result.responsedata.responseJSON
                        var permission = "<?php echo $_SESSION['permission'] ?>"
                        console.log(permission)
                        $(".dataTables_empty").empty();


                        if (project_res.length > 0) {
                            toastr.success(`Data Loaded!`);

                            for (let i = 0; i < project_res.length; i++) {

                                var linedata = '';
                                linedata = `<tr id=${project_res[i].id}>`;
                                linedata += `<td><i id=${project_res[i].id} class="fa fa-plus" exp></i>&nbsp;${project_res[i].id}</td>`;
                                linedata += `<td>${project_res[i].name}</td>`;
                                linedata += `<td> ${project_res[i].projectCost}</td>`;
                                linedata += `<td> ${project_res[i].manpower}</td>`;
                                linedata += `<td> ${project_res[i].projectIncome}</td>`;
                                linedata += `<td> ${project_res[i].projectProfit}</td>`;
                                linedata += `<td>${project_res[i].projectStartDate}</td>`;
                                linedata += `<td>${project_res[i].projectEndDate}</td>`;

                                if (permission === "ADMIN" || permission === "MANAGER") {
                                    linedata += `<td><a href='{$editUrl}' ><p class='fas fa-edit bg-info editCustomer' aria-hidden='true'></p></a>&nbsp;&nbsp;&nbsp;`;
                                    linedata += `<a href='#'><p class='fa fa-trash '  onclick='deleteProject(${project_res[i].id})' aria-hidden='true'  ></p></a></td></tr>`;
                                } 
                               

                                linedata += `</tr>`;

                                $('#projectRecords').append(linedata);
                            }
                        } else {
                            
                            toastr.error('Sorry Try Later!')
                        }
                       
                        



                    }
                });
            </script>
            </div>

            <!-- When Project is clicked, show list of all fleet objects linked to it -->
            <div class="card" id="fleetDataForProject">

            </div>

            <!-- New Project Modal -->
            <div class="modal fade" tabindex="-1" id="NewProjectModel">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-info" id="addProject">
                            <h4 class="modal-title">New Project</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="form" role="form" method="post" action="<?php echo base_url() ?>Project/manageProject">
                                <div class="row form-group">
                                    <div class="hidden-fields">
                                        <input type="hidden" id="projectId" name="projectId" />
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="form-control-label">Customer Name</label>
                                        <input type="text" placeholder="Customer Name" id="customerName" name="customerName" required class="form-control" />
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="form-control-label">Project Name</label>
                                        <input type="text" placeholder="Project Name" id="projectName" name="projectName" required class="form-control" />
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="form-control-label">Project Cost</label>
                                        <input type="text" placeholder="Project Cost" id="projectCost" name="projectCost" required class="form-control" />
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="form-control-label">Manpower</label>
                                        <input type="text" placeholder="Manpower" id="projectManpower" name="projectManpower" required class="form-control" />
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="form-control-label">Project Income</label>
                                        <input type="text" placeholder="Project Income" id="projectIncome" name="projectIncome" required class="form-control" />
                                    </div>
                                    <!--    <div class="col-sm-3">
                                        <label class="form-control-label">Project Manager</label>
                                        <div class="form-select">
                                            <select id="projectManager" name="projectManager" class="custom-select">
                                                <?php
                                                echo "<option value=''></option>";
                                                ?>
                                            </select>
                                        </div>
                                    </div> -->
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-3">
                                        <label class="form-control-label">People on Project</label>
                                        <div class="form-select">
                                            <select id="peopleonProject" multiple name="peopleonProject" class="custom-select">
                                                <?php
                                                echo "<option value=''></option>";
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="form-control-label">Start Date</label>
                                        <input type="date" id="startDate" name="startDate" required class="form-control" />
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="form-control-label">End Date</label>
                                        <input type="date" id="endDate" name="endDate" required class="form-control" />
                                    </div>
                                    <div class="col-sm-3">
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
                                <span style="color:red"><?php echo $this->session->flashdata('info') ?></span>
                                <span style="color:red"><?php echo $this->session->flashdata('error') ?></span>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn bg-info">Save changes</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
             // access
             var addBtn=document.getElementById("addProject")
            var actionHeader=document.getElementById("action-header")
             var permission = "<?php echo $_SESSION['permission'] ?>"
             if (permission === "ADMIN" || permission === "MANAGER") {
                        addBtn.style.visibility = 'visible'; 
                        actionHeader.style.visibility = 'visible'; 
                                   
                    } else {
                            addBtn.remove()
                            actionHeader.remove()
                            toastr.success('User')
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
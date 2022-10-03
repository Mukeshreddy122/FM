<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
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
                                <td>Customer Name</td>
                                <td>Project Name</td>
                                <td>Project Cost</td>
                                <td>Fleet</td>
                                <!--  <td>Project Manager</td> -->
                                <td>Manpower</td>
                                <td>Project Time</td>
                                <td>Income</td>
                                <td>Report</td>
                                <td>Actions</td>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php $index = 0;
                            foreach ($projectInfo as $key => $project) {
                                $index++;
                                echo "<tr id='{$project['id']}'>";
                                echo "<td class='projectId'>{$project['id']}</td>";
                                echo "<td class='projectId'>{$project['customerId']}</td>";
                                echo "<td class='projectName'>{$project['name']}</td>";
                                echo "<td class='projectCost'>{$project['projectCost']}</td>";
                                echo "<td class='projectName'>{$project['deviceCount']}</td>";
                                echo "<td class='projectName'>{$project['manpower']}</td>";
                                echo "<td class='projectTime'>{$project['projectStartDate']} - {$project['projectEndDate']}</td>";
                                echo "<td class='projectIncome'>{$project['projectIncome']}</td>";
                                echo "<td class='projectReport'><a href='#'>Report</a></td>";
                                $deleteUrl = base_url() . 'Customer/delete?id=' . $project['id'];
                                $editUrl = base_url() . 'Customer/edit?id=' . $project['id'];
                                // echo "<td><a href='{$editUrl}' ><i class='fas fa-edit bg-info' id='editCustomer' name='editCustomer' aria-hidden='true'></i></a>&nbsp;&nbsp;";
                                if ($_SESSION['permission'] == "ADMIN" || $_SESSION['permission'] == "MANAGER") {
                                    $c_id = $project['id'];
                                    echo "<td><a href='#' ><p class='fas fa-edit bg-info editCustomer' aria-hidden='true'></p></a>&nbsp;&nbsp;&nbsp;";
                                    echo "<a href='{$deleteUrl}' ><p class='fa fa-trash bg-info' aria-hidden='true'></p></a></td></tr>";
                                    // echo "<a href='#' ><p class='fa fa-trash bg-info' aria-hidden='true' onclick='deleteCustomer($c_id)'></p></a></td></tr>";
                                } else {
                                    echo "<td>&nbsp;</td></tr>";
                                }
                               
                                
                            }

                            ?>
                        </tbody>
                    </table>
                </div>
                <script>
                    $(function() {
                        $('#projectRecords').DataTable({
                            "paging": true,
                            "lengthChange": false,
                            "searching": true,
                            "ordering": true,
                            "info": true,
                            "autoWidth": false,
                            "responsive": true,
                        });
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
                        <div class="modal-header bg-info">
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
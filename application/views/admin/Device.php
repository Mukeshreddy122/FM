<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <a rel="nofollow" id="NewDevice" href="#newDeviceModal" data-toggle="modal" class="btn btn-block bg-info" onclick="resetFormData()">Add Fleet <i class="fa fa-plus"></i></a>
                    </h4>
                </div>
                <div class="card-body">
                    <table id="deviceRecords" class="table table-sm table-hover ">
                        <thead class="bg-info font-weight-bold">
                            <tr>
                                <td>#</td>
                                <td>Fleet Name</td>
                                <td>Fleet Website</td>
                                <td>Serial Number</td>
                                <td>Sender Number</td>
                                <td>Sender Type</td>
                                <td>Category</td>
                                <td>Fabrication</td>
                                <td>Service interval</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $index = 0;
                            foreach ($devices as $deviceKey => $Device) {
                                $index++;
                                echo "<tr id='{$Device['id']}'>";
                                echo "<td>{$index}</td>";
                                echo (array_key_exists('name', $Device)) ? "<td class='name'>{$Device['name']}</td>" : "<td class='name'>NA</td>";
                                echo (array_key_exists('Device Website', $Device)) ? "<td class='website'>{$Device['Device Website']}</td>" : "<td class='website'>NA</td>";
                                echo (array_key_exists('Serial Number', $Device)) ? "<td class='serialNo'>{$Device['Serial Number']}</td>" : "<td class='serialNo'>NA</td>";
                                echo (array_key_exists('Sender Number', $Device)) ? "<td class='senderNo'>{$Device['Sender Number']}</td>" : "<td class='senderNo'>NA</td>";
                                echo (array_key_exists('Sender Type', $Device)) ? "<td class='senderType'>{$Device['Sender Type']}</td>" : "<td class='senderType'>NA</td>";
                                echo (array_key_exists('Object Category', $Device)) ? "<td class='objectCategory'>{$Device['Object Category']}</td>" : "<td class='objectCategory'>NA</td>";
                                echo (array_key_exists('Fabrication', $Device)) ? "<td class='fabrication'>{$Device['Fabrication']}</td>" : "<td class='fabrication'>NA</td>";
                                echo (array_key_exists('Service Interval', $Device)) ? "<td class='serviceInterval'>{$Device['Service Interval']}</td>" : "<td class='serviceInterval'>NA</td>";
                                $deleteUrl = base_url() . 'Device/delete?id=' . $Device['id'];
                                $editUrl = base_url() . 'Device/edit?id=' . $Device['id'];
                                echo "<td><a href='#' ><p class='fas fa-edit bg-info editDevice' aria-hidden='true'></p></a>&nbsp;&nbsp;&nbsp;";
                                echo "<a href='{$deleteUrl}' ><p class='fa fa-trash bg-info' aria-hidden='true'></p></a></td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal fade" tabindex="-1" id="newDeviceModal">
                <div class="modal-dialog modal-lg">
                    <form class="form" role="form" method="post" action="<?php echo base_url() ?>Device/manageDevice">
                        <div class="modal-content">
                            <div class="modal-header bg-info">
                                <h4 class="modal-title">New Fleet</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row form-group">
                                    <div class="hidden-fields">
                                        <input type="hidden" id="deviceId" name="deviceId" />
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="form-control-label">Device Name</label>
                                        <input type="text" placeholder="Device Name" id="deviceName" name="deviceName" required class="form-control" />
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="form-control-label">Device Website</label>
                                        <input type="url" placeholder="" id="deviceWebsite" name="deviceWebsite" required class="form-control" />
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="form-control-label">Serial Number</label>
                                        <input type="text" placeholder="Serial number object" id="serialNumber" name="serialNumber" required class="form-control" />
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="form-control-label">Sender Number</label>
                                        <input type="tel" placeholder="Sender number" id="senderNumber" name="senderNumber" required class="form-control" />
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-3">
                                        <label class="form-control-label"> Sender type</label>
                                        <div class="form-select">
                                            <select id="senderType" name="senderType" class="custom-select">
                                                <?php
                                                foreach ($senderTypes as $key => $senderType) {
                                                    echo "<option value='{$senderType}'>{$senderType}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <label class="form-control-label">Object Category</label>
                                        <div class="form-select">
                                            <select id="objectCategory" name="objectCategory" class="custom-select">
                                                <?php
                                                foreach ($objectCategories as $key => $objectCategory) {
                                                    echo "<option value='{$objectCategory}'>{$objectCategory}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="form-control-label">Fabrication</label>
                                        <input type="text" placeholder="Fabrication" id="fabrication" name="fabrication" require class="form-control" />
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="form-control-label">Service Interval</label>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <input type="number" placeholder="" id="intervalPrefix" name="intervalPrefix" require class="form-control" />
                                            </div>
                                            <div class="col-sm-6 form-select">
                                                <select id="intervalSuffix" name="intervalSuffix" class="custom-select">
                                                    <option value="days">days</option>
                                                    <option value="months">months</option>
                                                    <option value="years">years</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-3 invisible-section">
                                        <label class="form-control-label">Name of tool / container</label>
                                        <input type="text" placeholder="Name of tool or container" id="deviceTool" name="deviceTool" required class="form-control" />
                                    </div>
                                    <div class="col-sm-3 invisible-section">
                                        <label class="form-control-label">Service Log</label>
                                        <input type="text" placeholder="Service Log" id="serviceLog" name="serviceLog" require class="form-control" />
                                    </div>
                                    <div class="col-sm-3 invisible-section">
                                        <label class="form-control-label">Notes</label>
                                        <input type="text" placeholder="Notes" id="Notes" name="Notes" require class="form-control" />
                                    </div>
                                    <div class="col-sm-3 invisible-section">
                                        <label class="form-control-label">Picture of Product</label>
                                        <input type="file" name="pictureOfProduct" class="form-control-file" require />
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
            </div>


        </div>
    </div>
    <script>
        $(function() {
            $('#deviceRecords').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": false,
            });
            var table = $('#deviceRecords').DataTable();
            $('#deviceRecords tbody tr td').on('click', 'i', function() {
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
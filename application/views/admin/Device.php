<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <input type="hidden" id="session_token" value="<?php echo $_SESSION['USER_API_TOKEN'] ?>" />
                        <input type="hidden" id="cname" value="<?php echo $_SESSION['myCustomerName'] ?>" />
                        <?php if ($_SESSION['permission'] == "MANAGER" || $_SESSION['permission'] == "ADMIN") {; ?>
                            <button id="NewDevice" data-toggle="modal" class="btn btn-block bg-info" onclick="editDevice(-1)">Add <?php echo $title; ?> <i class="fa fa-plus"></i></button>

                        <?php } ?>
                    </h4>
                </div>
                <div class="card-body">
                    <table id="deviceRecords" class="table table-striped table-sm">
                        <thead class="bg-info" style="font-family: 'Source Sans Pro', sans-serif;">
                            <tr>
                                <th style="width: 5%">
                                    #
                                </th>
                                <th style="width: 20%">
                                    Fleet
                                </th>

                                <th style="width: 20%">
                                    Fleet ID'S
                                </th>

                                <th style="width: 20%">

                                    Object Details
                                </th>
                                <th style="width: 20%">
                                    Service Interval
                                </th>

                                <th style="width: 15%">

                                </th>
                                <!-- <th style="width: 8%">
                                    &nbsp;
                                </th> -->
                            </tr>
                        </thead>
                        <tbody id="deviceTableData">
                            <?php
                            $index = 0;

                            ?>
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
    </div>

    <script>
        $(document).ready(function() {
            // loadTableData()
            var customerData = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/fleet ", "GET", "", document.getElementById("session_token").value)
            var cust_result = customerData.responsedata.responseJSON

            $('#deviceRecords').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": false,

                order: [
                    [1, 'desc']
                ]

            });

            $(document).ready(
                loadTableData()
            );

            function loadTableData() {
                $(".dataTables_empty").empty();
                var device_json = " ";
                <?php
                if (sizeof($devices) > 0) {
                    echo "toastr.success('Data Loaded!');";
                    $device_row_data = "";
                    $index = 1;
                    foreach ($devices as $key => $device) {


                        // $device_row_data = "";
                        $device_row_data = $device_row_data . "<tr '>";
                        $device_row_data = $device_row_data . "<td class='deviceId'>{$device['id']}</td>";
                        // $device_row_data = $device_row_data . "<td class='deviceName'>{$this->deviceModel->getdevice($device['deviceId'])['name']}</td>";
                        // echo "<td class='deviceName'>{$device['deviceId']}</td>";
                        // Device details column
                        $device_row_data = $device_row_data . "<td class='deviceName'>{$device['name']}";
                        $device_row_data = $device_row_data . "<br/><small><b>Website: &nbsp;</b>{$device['Device Website']}</small>";
                        if ($device['deviceOnline']) {
                            $device_row_data = $device_row_data . "<br/><small><b>Online : &nbsp; </b><i class='fa fa-map-marker text-green' aria-hidden='true'></i> {$device['lastOnlineTime']}</small></td> ";
                        } else {
                            $device_row_data = $device_row_data . "<br/><small><b>Online : &nbsp; </b><i class='fa fa-map-marker text-red' aria-hidden='true'></i> {$device['lastOnlineTime']}</small></td>";
                        }
                        // Device details column END 
                        // Device ID details 
                        $device_row_data = $device_row_data . "<td class='deviceName'><small><b>Device-uniqueId: &nbsp;</b>{$device['deviceUniqueId']}</small>";
                        $device_row_data = $device_row_data . "<br/><small><b>Serial Number: &nbsp;</b>{$device['Serial Number']}</small></td>";


                        // Fleet object and fabrication
                        $device_row_data = $device_row_data . "<td class='deviceName'></i><small><b>Category: &nbsp;</b>{$device['Object Category']}</small>";
                        $device_row_data = $device_row_data . "<br/><small><b>Fabrication: &nbsp;</b>{$device['Fabrication']}</small></td>";

                        // Service type and interval

                        $device_row_data = $device_row_data . "<td class='servicInterval'><small><i class='fa fa-calendar  text-primary' aria-hidden='true'></i></small> {$device['Service Interval']}-{$device['serviceIntervalType']} ";
                        if($device['underMaintenance']){
                        $device_row_data=$device_row_data."<br> <small><i class='fa fa-suitcase text-red' aria-hidden='true'></i></small> &nbsp; Maintanence</td>";

                        }
                        else{
                        $device_row_data=$device_row_data."<br> <small><i class='fa fa-suitcase text-green' aria-hidden='true'></i> </small> &nbsp; Maintanence</td>";

                        }
                        



                        // echo "<td class='deviceReport'><a href='#'>Report</a></td>";
                        if ($_SESSION['permission'] == "MANAGER" || $_SESSION['permission'] == "ADMIN") {
                            $device_row_data = $device_row_data . "<td class='device-actions text-right'>";
                            if ($device['underMaintenance']) {
                                $device_row_data = $device_row_data . "<i class='fas fa-eye text-info' onclick='showdeviceDetails({$device['id']})'></i>&nbsp;&nbsp;&nbsp;";
                                $device_row_data = $device_row_data . "<i class='fas fa-pencil-alt text-gray disabled'></i>&nbsp;&nbsp;&nbsp;";
                                $device_row_data = $device_row_data . "<i class='fas fa-check text-green'></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
                            } else {
                                $device_row_data = $device_row_data . "<i class='fas fa-eye text-info' onclick='showdeviceDetails({$device['id']})'></i>&nbsp;&nbsp;&nbsp;";
                                $device_row_data = $device_row_data . "<i class='fas fa-pencil-alt text-orange' onclick='editDevice({$device['id']})' ></i>&nbsp;&nbsp;&nbsp;";
                                $device_row_data = $device_row_data . "<i class='fas fa-trash text-danger outline'></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
                            }
                        } else {
                            $device_row_data = $device_row_data . "<td><a href='#showdeviceDetails'><i class='fas fa-folder text-info'></i></a>";
                            $device_row_data = $device_row_data . "<i class='fas fa-eye text-info'></i>&nbsp;&nbsp;&nbsp;";
                            $device_row_data = $device_row_data . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
                        }
                        $device_row_data = $device_row_data . "</tr>";
                        $index++;
                    }
                    echo "$('#deviceRecords').DataTable().destroy();";
                    echo "$('#deviceRecords').find('tbody').append(\"$device_row_data\");";
                    echo "$('#deviceRecords').DataTable().draw();";
                } else {
                    echo "toastr.error('Unable to get data!')";
                }
                ?>



            }
        })
    </script>
    <div class="modal fade" id="addEditDeviceModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title">Fleet Details</h4>
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
                                            <div class="form-group"><label class="form-control-label">Customer Name</label>
                                                <select class="form-control select2 " id="customerName" style="width: 100%;" required>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label class="form-control-label">Fleet Name </label>
                                            <input type="text" placeholder="Fleet Name" id="fleetName" name="fleetName" required class="form-control" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label class="form-control-label">Fleet Unique ID</label>
                                            <input type="text" placeholder="Unique ID" id="uniqueID" name="uniqueID" required class="form-control" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label class="form-control-label">Fleet Website</label>
                                            <input type="text" placeholder="Fleet Website" id="fleetWebsite" name="fleetWebsite" required class="form-control" />
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-control-label">Serial Number</label>
                                            <input type="text" placeholder="Serial Number" id="serialNumber" name="serialNumber" required class="form-control" />
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-control-label">Object Category</label>
                                            <input type="text" placeholder="Object Category" id="objectCategory" name="objectCategory" required class="form-control" />
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-control-label">Fabrication</label>
                                            <input type="text" placeholder="Fabrication" id="fabrication" name="Fabrication" required class="form-control" />
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
                                    <h3 class="card-title">Additional Data </h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label class="form-control-label">Sender Number </label>
                                            <input type="text" placeholder="Sender Number" id="senderNumber" name="senderNumber" required class="form-control" />
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-control-label">Sender Type</label>
                                            <input type="text" placeholder="Sender Type" id="senderType" name="senderType" required class="form-control" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label class="form-control-label">Service Interval</label>
                                            <input type="text" placeholder="Service Interval" id="serviceInterval" name="Service Interval" required class="form-control" />
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-control-label">Service Interval Type</label>
                                            <input type="text" placeholder="Interval Type" id="serviceIntervalType" name="serviceIntervalType" required class="form-control" />
                                        </div>
                                        <div class="col-sm-12">
                                            <label class="form-control-label">Name of Tool/Container</label>
                                            <input type="text" placeholder="Name of Tool/Container" id="nameOfContainer" name="nameOfContainer" required class="form-control" />
                                        </div>
                                        <div class="col-sm-12">
                                            <label class="form-control-label">Device Model</label>
                                            <input type="text" placeholder="Device Model" id="deviceModel" name="deviceModel" required class="form-control" />
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
    <div class="modal fade" tabindex="-1" id="showdeviceDetails">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title">New Device </h4>
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
        function editDevice(deviceId) {
            var permission = <?php echo "'" . $_SESSION['permission'] . "'" ?>;


            if(deviceId<=0){
                if (permission == "ADMIN") {
                // change customername textbox to search & select
                var customer_data = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/customer", "GET", "", document.getElementById("session_token").value).responsedata.responseJSON;
                var div_data = "";
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
            }
            // all feilds blank
            document.getElementById("customerName").value = ""
            document.getElementById("fleetName").value = ""
            document.getElementById("uniqueID").value = ""
            document.getElementById("fleetWebsite").value = ""
            document.getElementById("serialNumber").value = ""
            document.getElementById("objectCategory").value = ""
            document.getElementById("fabrication").value = ""
            document.getElementById("senderNumber").value = ""
            document.getElementById("senderType").value = ""
            document.getElementById("serviceInterval").value = ""
            document.getElementById("serviceIntervalType").value = ""
            document.getElementById("nameOfContainer").value = ""
            document.getElementById("deviceModel").value = ""


            $("#addEditDeviceModal").modal("show")
        }


        function showdeviceDetails(deviceId) {
            $("#showdeviceDetails").modal("show")
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
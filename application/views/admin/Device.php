<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <input type="hidden" id="session_token" value="<?php echo $_SESSION['USER_API_TOKEN'] ?>" />
                        <input type="hidden" id="cname" value="<?php echo $_SESSION['myCustomerName'] ?>" />
                        <a rel="nofollow" id="NewDevice" href="#newDeviceModal" data-toggle="modal" class="btn btn-block bg-info" onclick="editDevice(-1)">Add Fleet <i class="fa fa-plus"></i></a>
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
            console.log(cust_result)
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
                        if($device['deviceOnline']){
                            $device_row_data=$device_row_data."<br/><small><b>Online : &nbsp; </b><i class='fa fa-map-marker text-green' aria-hidden='true'></i> {$device['lastOnlineTime']}</small></td> ";
                        }else{
                            $device_row_data=$device_row_data."<br/><small><b>Online : &nbsp; </b><i class='fa fa-map-marker text-red' aria-hidden='true'></i> {$device['lastOnlineTime']}</small></td>";
                        }
                         // Device details column END 
                        // Device ID details 
                        $device_row_data = $device_row_data . "<td class='deviceName'><small><b>Device-uniqueId: &nbsp;</b>{$device['deviceUniqueId']}</small>";
                        $device_row_data = $device_row_data . "<br/><small><b>Serial Number: &nbsp;</b>{$device['Serial Number']}</small></td>";
                      
                       
                        // Fleet object and fabrication
                        $device_row_data = $device_row_data . "<td class='deviceName'></i><small><b>Category: &nbsp;</b>{$device['Object Category']}</small>";
                        $device_row_data = $device_row_data . "<br/><small><b>Fabrication: &nbsp;</b>{$device['Fabrication']}</small></td>";
                        
                        // Service type and interval
                        
                        $device_row_data = $device_row_data . "<td class='servicInterval'><small><i class='fa fa-calendar  text-primary' aria-hidden='true'></i></small> {$device['Service Interval']}-{$device['serviceIntervalType']}</td> ";
                       
                       


                        // echo "<td class='deviceReport'><a href='#'>Report</a></td>";
                        if ($_SESSION['permission'] == "MANAGER" || $_SESSION['permission'] == "ADMIN") {
                            $device_row_data = $device_row_data . "<td class='device-actions text-right'>";
                            if ($device['underMaintenance']) {
                                $device_row_data = $device_row_data . "<i class='fas fa-eye text-info' onclick='showdeviceDetails({$device['id']})'></i>&nbsp;&nbsp;&nbsp;";
                                $device_row_data = $device_row_data . "<i class='fas fa-pencil-alt text-gray disabled'></i>&nbsp;&nbsp;&nbsp;";
                                // $device_row_data = $device_row_data . "<i class='fas fa-check text-green'></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
                            } else {
                            $device_row_data = $device_row_data . "<i class='fas fa-eye text-info' onclick='showdeviceDetails({$device['id']})'></i>&nbsp;&nbsp;&nbsp;";
                            $device_row_data = $device_row_data . "<i class='fas fa-pencil-alt text-orange' onclick='editdevice({$device['id']})'></i>&nbsp;&nbsp;&nbsp;";
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
    <div class="modal fade" id="addEditCustomerModal">
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
                                                    <!-- <label class="form-control-label">Customer Name</label>
                                                <input type="text" placeholder="Customer Name" id="customerName" name="customerName" required class="form-control" /> -->
                                                    <div class="form-group"><label class="form-control-label">Device Name</label>
                                                        <input type="text" placeholder="Device Name" id="Device Name" name="Device Name" required class="form-control" />
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label class="form-control-label">Type of company</label>
                                                    <input type="text" placeholder="Type of company" id="Type of company" name="Type of company" required class="form-control" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label class="form-control-label">Industry</label>
                                                    <input type="text" placeholder="Industry" id="industry" name="industry" required class="form-control" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="form-control-label">No. of Employees</label>
                                                    <input type="text" placeholder="No. of Employees" id="numberOfEmployees" name="numberOfEmployees" required class="form-control" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="form-control-label">VAT Numbers</label>
                                                    <input type="text" placeholder="Visit Address" id="visitAddress" name="visitAddress" required class="form-control" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="form-control-label">Post Address</label>
                                                    <input type="text" placeholder="Post address" id="postAddress" name="postAddress" required class="form-control" />
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
                                            <h3 class="card-title">Manager user account</h3>

                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label class="form-control-label">Employee Name</label>
                                                    <input type="text" placeholder="employee Name" id="employeeName" name="employeeName" required class="form-control" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="form-control-label">Mail Address</label>
                                                    <input type="text" placeholder="Mail Address" id="mailAddress" name="mailAddress" required class="form-control" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label class="form-control-label">Company Role</label>
                                                    <input type="text" placeholder="Company Role" id="companyRole" name="companyRole" required class="form-control" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="form-control-label">External Company</label>
                                                    <input type="text" placeholder="External Company" id="externalCompany" required class="form-control" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="form-control-label">Email</label>
                                                    <input type="text" placeholder="Email" id="Email" name="Email" required class="form-control" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="form-control-label">Password</label>
                                                    <input type="text" placeholder="Password" id="Password" name="Password" required class="form-control" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="form-control-label">Sister Companies</label>
                                                    <select id="sisterCompanies" name="sisterCompanies" class="custom-select"></select>
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
            <div class="modal fade" tabindex="-1" id="showcustomerDetails">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-info">
                            <h4 class="modal-title">>New Customer </h4>
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
                function editDevice(deviceId){
                    $("#addEditCustomerModal").modal("show")
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
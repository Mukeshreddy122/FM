<section class="content">
    <div class="row" id="fleetListParentDiv">
        <div class="col-12" id="fleetListColumnDiv">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <input type="hidden" id="session_token" value="<?php echo $_SESSION['USER_API_TOKEN'] ?>" />
                        <input type="hidden" id="cname" value="<?php echo $_SESSION['myCustomerName'] ?>" />
                        <?php if ($_SESSION['permission'] == "MANAGER" || $_SESSION['permission'] == "ADMIN") {; ?>
                            <button id="NewDevice" data-toggle="modal" class="btn btn-block bg-info" onclick="editAddDevice(-1)"><?php echo  $this->lang->line('Add');
                                                                                                                                    $this->lang->line('title'); ?> <i class="fa fa-plus"></i></button>

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
                                    <?php echo $this->lang->line('Fleet'); ?>
                                </th>

                                <th style="width: 20%">
                                    <?php echo $this->lang->line('Fleet ID'); ?>

                                </th>

                                <th style="width: 20%">

                                    <?php echo $this->lang->line('Object Details'); ?>
                                </th>
                                <th style="width: 20%">
                                    <?php echo $this->lang->line('ServiceInterval'); ?>
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
        <div id="fleetDetailsDiv">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                       
                    </h4>
                    <button type="button" onclick="closeDetailSection()" class="close btn-close-red" aria-label="Close" style="display: block;float:right;position:relative;  top:-10px; right: -10px; height: 20px;">


                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body">
                    <div id="detailBody"></div>
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
            loadTableData()
        });

        function loadTableData() {
            $('#deviceRecords').DataTable().clear().draw();
            var permission = <?php echo "'" . $_SESSION['permission'] . "'" ?>;
            var device_row_data = "";
            var deviceInfo = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/fleet", "GET", "", document.getElementById("session_token").value).responsedata.responseJSON;

            // console.log(deviceInfo)
            if (deviceInfo.length > 0) {
                toastr.success('Data Loaded!')

                deviceInfo.forEach(device => {
                    device_row_data = device_row_data + `<tr>`;
                    device_row_data = device_row_data + `<td class='deviceId'>${device['id']}</td>`;
                    device_row_data = device_row_data + `<td class='deviceName'>${device['name']}`;
                    device_row_data = device_row_data + `<br/><small><b>Website: &nbsp;</b>${device['Device Website']}</small>`;
                    if (device['deviceOnline']) {
                        device_row_data = device_row_data + `<br/><small><b>Online : &nbsp; </b><i class='fa fa-map-marker text-green' aria-hidden='true'></i> ${device['lastOnlineTime']}</small></td> `;
                    } else {
                        device_row_data = device_row_data + `<br/><small><b>Online : &nbsp; </b><i class='fa fa-map-marker text-red' aria-hidden='true'></i> ${device['lastOnlineTime']}</small></td>`;
                    }
                    // Device details column END 
                    device_row_data = device_row_data + `<td class='deviceName'><small><b>Device-uniqueId: &nbsp;</b>${device['deviceUniqueId']}</small>`;
                    device_row_data = device_row_data + `<br/><small><b>Serial Number: &nbsp;</b>${device['Serial Number']}</small></td>`;
                    // Fleet object and fabrication
                    device_row_data = device_row_data + `<td class='deviceName'></i><small><b>Category: &nbsp;</b>${device['Object Category']}</small>`;
                    device_row_data = device_row_data + `<br/><small><b>Fabrication: &nbsp;</b>${device['Fabrication']}</small></td>`;

                    // Service type and interval
                    device_row_data = device_row_data + `<td class='servicInterval'><small><i class='fa fa-calendar  text-primary' aria-hidden='true'></i></small> ${device['Service Interval']}-${device['serviceIntervalType']} `;
                    if (device['underMaintenance']) {
                        device_row_data = device_row_data + `<br> <small><i class='fa fa-suitcase text-red' onclick='showMaintenanceDetails(${device['id']})' aria-hidden='true'></i></small> &nbsp; Maintenance &nbsp; <small><i class='fa fa-times text-red' aria-hidden='true'></i></small></td>`;
                    } else {
                        device_row_data = device_row_data + `<br> <small><i class='fa fa-suitcase text-green' onclick='showMaintenanceDetails(${device['id']})' aria-hidden='true'></i> </small> &nbsp; Maintenance &nbsp; <small><i class='fa fa-plus text-green' aria-hidden='true' onclick='showMaintenance(${device['id']})'></i></small></td>`;
                    }
                    if (permission == "MANAGER" || permission == "ADMIN") {
                        device_row_data = device_row_data + "<td class='device-actions text-right'>";
                        if (device['underMaintenance']) {
                            device_row_data = device_row_data + `<i class='fas fa-eye text-info' onclick='editAddDevice(${device['id']})'></i>&nbsp;&nbsp;&nbsp;`;
                            device_row_data = device_row_data + `<i class='fas fa-pencil-alt text-gray disabled'></i>&nbsp;&nbsp;&nbsp;`;
                            device_row_data = device_row_data + `<i class='fas fa-check text-green'></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>`;
                        } else {
                            device_row_data = device_row_data + `<i class='fas fa-eye text-info' onclick='editAddDevice(${device['id']})'></i>&nbsp;&nbsp;&nbsp;`;
                            device_row_data = device_row_data + `<i class='fas fa-pencil-alt text-orange' onclick='editAddDevice(${device['id']})' ></i>&nbsp;&nbsp;&nbsp;`;
                            device_row_data = device_row_data + `<i class='fas fa-trash text-danger outline' onclick='deleteDevice(${device['id']})'></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>`;
                        }
                    } else {
                        device_row_data = device_row_data + `<td><a href='#showdeviceDetails'><i class='fas fa-folder text-info'></i></a>`;
                        device_row_data = device_row_data + `<i class='fas fa-eye text-info'></i>&nbsp;&nbsp;&nbsp;`;
                        device_row_data = device_row_data + `&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>`;
                    }
                    device_row_data = device_row_data + `</tr>`;


                })
                $('#deviceRecords').DataTable().destroy()
                // console.log(device_row_data)
                $('#deviceRecords').find('tbody').append(device_row_data)
                $('#deviceRecords').DataTable().draw()

            } else {
                toastr.error('Unable to get data!')
            }


        }
    </script>
    <div class="modal fade" id="addEditDeviceModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title"><small class="text-muted"></small> <?php echo $this->lang->line('Details'); ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-light">
                                <div class="card-header">
                                    <h3 class="card-title"><?php echo $this->lang->line('genral'); ?></h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="hidden-fields">
                                            <input type="hidden" id="deviceId" name="deviceId" />
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
                                            <label class="form-control-label"><?php echo $this->lang->line('Fleet Name'); ?></label>
                                            <input type="text" placeholder="Fleet Name" id="fleetName" name="fleetName" required class="form-control" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label class="form-control-label"><?php echo $this->lang->line('Fleet Unique Id'); ?></label>
                                            <input type="text" placeholder="Unique ID" id="uniqueID" name="uniqueID" required class="form-control" />
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-control-label"><?php echo $this->lang->line('Fleet Website'); ?></label>
                                            <input type="text" placeholder="Fleet Website" id="fleetWebsite" name="fleetWebsite" required class="form-control" />
                                        </div>

                                    </div>
                                    <div class="row">

                                        <div class="col-sm-6">
                                            <label class="form-control-label"><?php echo $this->lang->line('Object Category'); ?>y</label>
                                            <input type="text" placeholder="Object Category" id="objectCategory" name="objectCategory" required class="form-control" />
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-control-label"><?php echo $this->lang->line('Fabrication'); ?></label>
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
                                    <h3 class="card-title"><?php echo $this->lang->line('Additional Data'); ?></h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label class="form-control-label"><?php echo $this->lang->line('Sender Number'); ?></label>
                                            <input type="text" placeholder="Sender Number" id="senderNumber" name="senderNumber" required class="form-control" />
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-control-label"><?php echo $this->lang->line('Sender Type'); ?></label>
                                            <input type="text" placeholder="Sender Type" id="senderType" name="senderType" required class="form-control" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label class="form-control-label"><?php echo  $this->lang->line('Service Interval'); ?></label>
                                            <input type="text" placeholder="Service Interval" id="serviceInterval" name="Service Interval" required class="form-control" />
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-control-label"><?php echo $this->lang->line('Service Interval Type'); ?></label>
                                            <input type="text" placeholder="Interval Type" id="serviceIntervalType" name="serviceIntervalType" required class="form-control" />
                                        </div>
                                        <div class="col-sm-12">
                                            <label class="form-control-label"><?php echo $this->lang->line('Name of Tool/Container'); ?></label>
                                            <input type="text" placeholder="Name of Tool/Container" id="nameOfContainer" name="nameOfContainer" required class="form-control" />
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-control-label"><?php echo $this->lang->line('Device Model'); ?></label>
                                            <input type="text" placeholder="Device Model" id="deviceModel" name="deviceModel" required class="form-control" />
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-control-label"><?php echo $this->lang->line('Serial Number'); ?></label>
                                            <input type="text" placeholder="Serial Number" id="serialNumber" name="serialNumber" required class="form-control" />
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
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo $this->lang->line('Cancel'); ?></button>
                            <input type="submit" value="<?php echo $this->lang->line('Save'); ?>" id="btnSavecustomer" onclick="saveDevice()" class="btn bg-olive float-right">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    <!-- maintanence modal  -->
    <div class="modal fade" id="maintanenceModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title"><?php echo $this->lang->line('Maintenance Details'); ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-light">
                                <div class="card-header">
                                    <h3 class="card-title"><?php echo $this->lang->line('general'); ?></h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="hidden-fields">
                                            <input type="hidden" id="deviceId" name="deviceId" />
                                        </div>
                                        <!-- <div class="col-sm-12">
                                            <div class="form-group"><label class="form-control-label">Customer Name</label>
                                                <select class="form-control select2 " id="customerName" style="width: 100%;" required>
                                                </select>
                                            </div>
                                        </div> -->
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label class="form-control-label"><?php echo $this->lang->line('Fleet Name'); ?> </label>
                                            <input type="text" placeholder="Fleet Name" id="fleetName" name="fleetName" required class="form-control" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label class="form-control-label"><?php echo $this->lang->line('Fleet Unique Id'); ?></label>
                                            <input type="text" placeholder="Unique ID" id="uniqueID" name="uniqueID" required class="form-control" />
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label class="form-control-label"><?php echo $this->lang->line('Maintenance Cost'); ?></label>
                                            <input type="text" placeholder="Maintenance Cost" id="maintenanceCost" name="maintenanceCost" required class="form-control" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label class="form-control-label"><?php echo $this->lang->line('Maintenance Pictures'); ?></label>
                                            <input type="file" multiple id="gallery-photo-add">
                                            <div class="gallery" data-spy="scroll" data-offset="0"></div>
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
                                    <h3 class="card-title"><?php echo $this->lang->line('Maintenance Pictures'); ?> </h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label class="form-control-label"><?php echo $this->lang->line('Maintenance Details'); ?></label>
                                            <textarea type="text" placeholder="maintenanceNotes" id="maintenanceNotes" name="maintenanceNotes" required class="form-control"></textarea>
                                        </div>

                                    </div>
                                    <div class="row">

                                        <div class="col-sm-12">
                                            <label class="form-control-label"><?php echo $this->lang->line('StartDate'); ?></label>
                                            <input type="date" id="maintenanceStartDate" name="maintenanceStartDate" required class="form-control" />
                                        </div>



                                    </div>
                                    <div class="row">

                                        <div class="col-sm-12">
                                            <label class="form-control-label"><?php echo $this->lang->line(' EndDate'); ?></label>
                                            <input type="date" id="maintanenceEndDate" name="maintenanceEndDate" required class="form-control" />
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
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo $this->lang->line(' Close'); ?></button>
                            <input type="submit" value="<?php echo $this->lang->line(' Save'); ?>" id="btnSavecustomer" onclick="saveDevice()" class="btn bg-olive float-right">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    <script>
        // show maintenace details 9side bar )
        function showMaintenanceDetails(devId) {
            $('#fleetListColumnDiv').removeClass('col-md-12');
            $('#fleetListColumnDiv').addClass('col-md-9');
            // side view 
            $('#fleetDetailsDiv').addClass('col-md-3')
            var maintenance_data = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/fleet/" + devId + "/maintenance", "GET", "", document.getElementById("session_token").value).responsedata;
            var maintenances = maintenance_data.responseJSON
            // console.log(maintenance_data.status)
            if (maintenance_data.status == 200) {
                // toastr.success("Device Maintenance!")
                maintenances.forEach(maintenance => {
                    $(".card-header").addClass('bg-info')
                    $('#detailBody').text(maintenance.name);
                    

                })
            } else {
                if (maintenances == null) {
                    toastr.error("No Maintenance!")
                    $('#fleetListColumnDiv').addClass('col-md-12');

                }
            }
           
            $('fleetDetailsDiv').addClass('col-md-9');
            $('#detailTitle').text(maintenances.deviceName[0]);
            
        }

        function closeDetailSection() {
            $('#fleetListColumnDiv').removeClass('col-md-9');
            $('#fleetListColumnDiv').addClass('col-md-12');

            $('fleetDetailsDiv').removeClass('col-md-3');
            $(".close").click(function() {
                $(this).parent().hide();
            });

        }
        // redirecting to maintanence page on plus icon click 
        function showMaintenance(devId) {
            // document.getElementById("gallery").style.height=400
            // document.getElementById("gallery").style.width=400
            // document.getElementById("gallery").style.maxheight=400
            // document.getElementById("gallery").style.overflowY = "scroll";
            var device_data = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/fleet/" + devId, "GET", "", document.getElementById("session_token").value).responsedata.responseJSON;
            console.log(device_data['name'])
            document.getElementById('fleetName').value = device_data['name']
            $(function() {
                // Multiple images preview in browser
                var imagesPreview = function(input, placeToInsertImagePreview) {

                    if (input.files) {
                        var filesAmount = input.files.length;

                        for (i = 0; i < filesAmount; i++) {
                            var reader = new FileReader();

                            reader.onload = function(event) {
                                $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                                $('img').width(100);
                                $('img').height(100);
                            }

                            reader.readAsDataURL(input.files[i]);
                        }
                    }

                };






                $('#gallery-photo-add').on('change', function() {
                    imagesPreview(this, 'div.gallery');
                });
            });


            $("#maintanenceModal").modal("show")
        }

        function editAddDevice(deviceId) {
            var permission = <?php echo "'" . $_SESSION['permission'] . "'" ?>;
            document.getElementById('deviceId').value = deviceId;


            if (deviceId <= 0) {
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
            var custName = document.getElementById("customerName")
            if (deviceId == -1) {

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
            } else {
                var deviceData = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/fleet/" + deviceId, "GET", "", document.getElementById("session_token").value).responsedata.responseJSON;
                // console.log(deviceData)
                var customerData = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/customer/" + deviceData['customerId'], "GET", "", document.getElementById("session_token").value).responsedata.responseJSON;
                // console.log(customerData)

                var opt = document.createElement('option');
                opt.value = deviceData['id'];
                opt.innerHTML = customerData['name'];
                custName.appendChild(opt)
                document.getElementById("fleetName").value = deviceData['name']
                document.getElementById("uniqueID").value = deviceData['deviceUniqueId']
                document.getElementById("fleetWebsite").value = deviceData['Device Website']
                document.getElementById("serialNumber").value = deviceData['Serial Number']
                document.getElementById("objectCategory").value = deviceData['Object Category']
                document.getElementById("fabrication").value = deviceData['Fabrication']
                document.getElementById("senderNumber").value = deviceData['Sender Number']
                document.getElementById("senderType").value = deviceData['Sender Type']
                document.getElementById("serviceInterval").value = deviceData['Service Interval']
                document.getElementById("serviceIntervalType").value = deviceData['serviceIntervalType']
                document.getElementById("nameOfContainer").value = deviceData['nameOfToolOrContainer']
                document.getElementById("deviceModel").value = deviceData['devicemodel']
            }
            // all fields blank



            $("#addEditDeviceModal").modal("show")
        }

        function saveDevice() {
            var devId = document.getElementById('deviceId').value;

            // 1. Create MAP from all fields of addeditcustomermodal pop-up
            // 2. convert that map to JSON 
            // 3. Call POST / PUT to save data
            // 4. If data saved successfully, show green toast and close modal
            // 5. If data does not save, show red toast and DO NOT close modal
            const today = new Date();
            var deviceObject = {
                "id": devId,
                "name": document.getElementById("fleetName").value,
                "deviceUniqueId": document.getElementById("uniqueID").value,
                "Device Website": document.getElementById("fleetWebsite").value,
                "Serial Number": document.getElementById("serialNumber").value,
                "countryCode": "",
                "Sender Number": document.getElementById("senderNumber").value,
                "Sender Type": document.getElementById("senderType").value,
                "Object Category": document.getElementById("objectCategory").value,
                "Fabrication": document.getElementById("fabrication").value,
                "Service Interval": document.getElementById("serviceInterval").value,
                "serviceIntervalType": document.getElementById("serviceIntervalType").value,
                "nameOfToolOrContainer": document.getElementById("nameOfContainer").value,
                "notes": "",
                "fleetImage": "",
                "deviceStatus": 0,
                "deviceOnline": false,
                "createdDate": today.getUTCDay(),
                "lastOnlineTime": "",
                "devicemodel": document.getElementById("deviceModel").value,
                "underMaintenance": false,
                "customerId": document.getElementById("customerName").value
            }
            var resp;
            if (document.getElementById('deviceId').value === "-1") {
                // new customer. perform POST
                resp = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/fleet", "POST", JSON.stringify(deviceObject), document.getElementById("session_token").value).responsedata;
                // console.log(resp)
            } else {
                // existing customer. perform PUT
                resp = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/fleet/" + devId, "PUT", JSON.stringify(deviceObject), document.getElementById("session_token").value).responsedata;
                // console.log(resp)
            }
            if (resp.status == 200) {
                toastr.success("Success!")
                $('#addEditDeviceModal').modal('hide')
                loadTableData()
            } else {
                // failed
                // show resp.responseText in red toast
                toastr.error("Error!")
            }
            // MAINTENANCE PUT AND POST
            var maintanenceObject = {
                "createdDate": today.getUTCDay(),
                "id": '',
                "deviceId": devId,
                "name": name,
                "deviceName": document.getElementById('fleetName').value,
                "maintenanceStartDate": document.getElementById('maintenanceStartDate').value,
                "maintenanceEndDate": document.getElementById('maintenanceEndDate').value,
                "maintenanceCompleted": '',
                "maintenanceTextStatus": '',
                "maintenanceStatus": '',
                "maintenanceCost": document.getElementById('maintenanceCost').value,
                "maintenanceNotes": document.getElementById('maintenanceNotes').value,
                "maintenancePictures": []
            }
            var resp = '';
            if (document.getElementById('deviceId').value === "-1") {
                // new customer. perform POST
                resp = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/maintenance", "POST", JSON.stringify(maintanenceObject), document.getElementById("session_token").value).responsedata;
                // console.log(resp)
            } else {
                // existing customer. perform PUT
                resp = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/maintenance/" + devId, "PUT", JSON.stringify(maintanenceObject), document.getElementById("session_token").value).responsedata;
                // console.log(resp)
            }
            if (resp.status == 200) {
                toastr.success("Success!")
                $('#maintanenceModal').modal('hide')
                loadTableData()
            } else {
                // failed
                // show resp.responseText in red toast
                toastr.error("Error!")
            }



        }

        function deleteDevice(devId) {
            resp = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/fleet/" + devId, "DELETE", "", document.getElementById("session_token").value).responsedata;
            // console.log(resp)
            if (resp.status == 200 || resp.status == 204) {
                toastr.success("Deleted!")
                $('#addEditDeviceModal').modal('hide')
                // $('#customerRecords').clear().draw()
                // $('#deviceRecords').DataTable().draw();
                loadTableData()
            } else {
                // failed
                // show resp.responseText in red toast
                toastr.error("Error!")
                loadTableData()
            }

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
<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <input type="hidden" id="session_token" value="<?php echo $_SESSION['USER_API_TOKEN'] ?>" />
                        <input type="hidden" id="cname" value="<?php echo $_SESSION['myCustomerName'] ?>" />
                        <?php if ($_SESSION['permission'] == "MANAGER" || $_SESSION['permission'] == "ADMIN") {; ?>
                            <button id="NewDevice" data-toggle="modal" class="btn btn-block bg-info" onclick="editAddMaintenance(-1)">Add <?php echo $title; ?> <i class="fa fa-plus"></i></button>

                        <?php } ?>
                    </h4>
                </div>
                <div class="card-body">
                    <table id="maintenanceRecords" class="table table-striped table-sm">
                        <thead class="bg-info" style="font-family: 'Source Sans Pro', sans-serif;">
                            <tr>
                                <th style="width: 3%">
                                    #
                                </th>
                                <th style="width: 15%">
                                    Name
                                </th>

                                <th style="width: 15%">
                                    Fleet Name
                                </th>

                                <th style="width: 20%">

                                    Fleet ID
                                </th>


                                <th style="width: 20%">
                                    Created Date
                                </th>

                                <th style="width: 10%">

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
            $('#maintenanceRecords').DataTable({
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
            $('#maintenanceRecords').DataTable().clear().draw();
            var permission = <?php echo "'" . $_SESSION['permission'] . "'" ?>;
            var maintenance_row_data = "";
            var maintenanceInfo = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/maintenance", "GET", "", document.getElementById("session_token").value).responsedata.responseJSON;

            if (maintenanceInfo.length > 0) {
                toastr.success('Data Loaded!')

                maintenanceInfo.forEach(maintenance => {
                    maintenance_row_data = maintenance_row_data + `<tr id='${maintenance['id']}'>`;
                    maintenance_row_data = maintenance_row_data + `<td class='mainId'>${maintenance['id']}</td>`;
                    maintenance_row_data = maintenance_row_data + `<td class='mainName'>${maintenance['name']}`;
                    // maintenanceInfo details column END 
                    maintenance_row_data = maintenance_row_data + `<td class='deviceUniqueId'><small><b>Fleet-uniqueId: &nbsp;</b>${maintenance['deviceId']}</small>`;
                    maintenance_row_data = maintenance_row_data + `<br/><small><b>FleetName: &nbsp;</b>${maintenance['deviceName']}</small></td>`;
                    // Fleet object and fabrication
                    maintenance_row_data = maintenance_row_data + `<td class='deviceName'></i><small>${maintenance['maintenanceCost']}</small>`;


                    // Service type and interval
                    maintenance_row_data = maintenance_row_data + `<td class='servicInterval'><small><b>Start:</b><i class='fa fa-calendar  text-primary' aria-hidden='true'></i></small> ${maintenance['maintenanceStartDate']}</br> `;
                    maintenance_row_data = maintenance_row_data + `<small><b>End:</b><i class='fa fa-calendar  text-primary' aria-hidden='true'></i></small> ${maintenance['maintenanceEndDate']}</td>`

                    if (permission == "MANAGER" || permission == "ADMIN") {
                        maintenance_row_data = maintenance_row_data + "<td class='maintenanceInfo-actions text-right'>";
                        if (maintenanceInfo['maintenanceCompleted']) {
                            maintenance_row_data = maintenance_row_data + `<i class='fas fa-eye text-info' onclick='editAddMaintenance(${maintenance['id']})'></i>&nbsp;&nbsp;&nbsp;`;
                            maintenance_row_data = maintenance_row_data + `<i class='fas fa-pencil-alt text-gray disabled'></i>&nbsp;&nbsp;&nbsp;`;
                            maintenance_row_data = maintenance_row_data + `<i class='fas fa-check text-green'></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>`;
                        } else {
                            maintenance_row_data = maintenance_row_data + `<i class='fas fa-eye text-info' onclick='editAddMaintenance(${maintenance['id']})'></i>&nbsp;&nbsp;&nbsp;`;
                            maintenance_row_data = maintenance_row_data + `<i class='fas fa-pencil-alt text-orange' onclick='editAddMaintenance(${maintenance['id']})' ></i>&nbsp;&nbsp;&nbsp;`;
                            maintenance_row_data = maintenance_row_data + `<i class='fas fa-trash text-danger outline' onclick='deletemaintenance(${maintenance['id']})'></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>`;
                        }
                    } else {
                        maintenance_row_data = maintenance_row_data + `<td><a href='#showdeviceDetails'><i class='fas fa-folder text-info'></i></a>`;
                        maintenance_row_data = maintenance_row_data + `<i class='fas fa-eye text-info'></i>&nbsp;&nbsp;&nbsp;`;
                        maintenance_row_data = maintenance_row_data + `&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>`;
                    }
                    maintenance_row_data = maintenance_row_data + `</tr>`;
                    $('#maintenanceRecords').DataTable().destroy()
                    // console.log( maintenance_row_data)
                    $('#maintenanceRecords').find('tbody').append(maintenance_row_data)
                    
                    $('#maintenanceRecords').DataTable().draw()

                })

            } else {
                toastr.error('Unable to get data!')
            }


        }
    </script>
    <div class="modal fade" id="maintanenceModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title">Maintanence Details</h4>
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
                                            <input type="hidden" id="mainId" name="mainId" />
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
                                            <label class="form-control-label">Maintenance Name </label>
                                            <input type="text" placeholder=" Name" id="mainName" name="fleetName" required class="form-control" />
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
                                        <div class="col-sm-12">
                                            <label class="form-control-label">Maintenance Cost</label>
                                            <input type="text" placeholder="Maintenance Cost" id="maintenanceCost" name="maintenanceCost" required class="form-control" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label class="form-control-label">Maintenance Pictures</label>
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
                                    <h3 class="card-title">Additional Data </h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label class="form-control-label">Maintenance Notes</label>
                                            <textarea type="text" placeholder="maintenanceNotes" id="maintenanceNotes" name="maintenanceNotes" required class="form-control"></textarea>
                                        </div>

                                    </div>
                                    <div class="row">

                                        <div class="col-sm-12">
                                            <label class="form-control-label">Maintenance StartDate</label>
                                            <input type="date" id="maintenanceStartDate" name="maintenanceStartDate" required class="form-control" />
                                        </div>



                                    </div>
                                    <div class="row">

                                        <div class="col-sm-12">
                                            <label class="form-control-label">Maintanence EndDate</label>
                                            <input type="date" id="maintenanceEndDate" name="maintenanceEndDate" required class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-control-label">Status</label>
                                        <select name="Access" class="custom-select" id="status">
                                            <option value="2" selected>In progress</option>
                                            <option value="0">Pending</option>
                                            <option value="1">Completed</option>
                                        </select>
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
                            <input type="submit" value="Save" id="btnSavecustomer" onclick="saveMaintenance()" class="btn bg-olive float-right">
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
        // redirecting to maintanence page on plus icon click 

        function editAddMaintenance(mainId) {
            var permission = <?php echo "'" . $_SESSION['permission'] . "'" ?>;

             // document.getElementById("gallery").style.height=400
            // document.getElementById("gallery").style.width=400
            // document.getElementById("gallery").style.maxheight=400
            // document.getElementById("gallery").style.overflowY = "scroll";
            var main_data = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/maintenance/" + mainId, "GET", "", document.getElementById("session_token").value).responsedata.responseJSON;
            
           
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
            document.getElementById('mainId').value = mainId;
            if (mainId == -1) {
                document.getElementById("mainName").value = ""
                document.getElementById("fleetName").value = ""
                document.getElementById("uniqueID").value = ""
                document.getElementById("maintenanceCost").value = ""
                document.getElementById("maintenanceNotes").value = ""
                document.getElementById("maintenanceStartDate").value = ""
                document.getElementById("maintenanceEndDate").value = ""

            } else {
                var mainData = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/maintenance/" + mainId, "GET", "", document.getElementById("session_token").value).responsedata.responseJSON;
                document.getElementById("mainName").value = mainData['name']
                document.getElementById("fleetName").value = mainData['deviceName']
                document.getElementById("uniqueID").value = mainData['deviceId']
                document.getElementById("maintenanceCost").value = mainData['maintenanceCost']
                document.getElementById("maintenanceNotes").value = mainData['maintenanceNotes']
                document.getElementById("maintenanceStartDate").value = mainData['maintenanceStartDate']
                document.getElementById("maintenanceEndDate").value = mainData['maintenanceEndDate']
                document.getElementById("maintenanceEndDate").value = mainData['maintenanceEndDate']
                
                
            }
            // all fields blank



            $("#maintanenceModal").modal("show")
        }

        function saveMaintenance() {
            var mainId = document.getElementById('mainId').value;

            // 1. Create MAP from all fields of addeditcustomermodal pop-up
            // 2. convert that map to JSON 
            // 3. Call POST / PUT to save data
            // 4. If data saved successfully, show green toast and close modal
            // 5. If data does not save, show red toast and DO NOT close modal
            const today = new Date();
            var mainData = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/maintenance/" + mainId, "GET", "", document.getElementById("session_token").value).responsedata.responseJSON;

            // MAINTENANCE PUT AND POST
            var maintanenceObject = {
                "createdDate": today.getUTCDay(),
                "id":mainId,
                "deviceId": document.getElementById('uniqueID').value,
                "name": document.getElementById('mainName').value,
                "deviceName": document.getElementById('fleetName').value,
                "maintenanceStartDate": document.getElementById('maintenanceStartDate').value,
                "maintenanceEndDate": document.getElementById('maintenanceEndDate').value,
                "maintenanceCompleted": '',
                "maintenanceTextStatus": '',
                "maintenanceStatus": document.getElementById('status').value,
                "maintenanceCost": document.getElementById('maintenanceCost').value,
                "maintenanceNotes": document.getElementById('maintenanceNotes').value,
                "maintenancePictures": []
            }
            var resp = '';
            if (document.getElementById('mainId').value === "-1") {
                // new customer. perform POST
                resp = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/maintenance", "POST", JSON.stringify(maintanenceObject), document.getElementById("session_token").value).responsedata;
                // console.log(resp)
            } else {
                // existing customer. perform PUT
                resp = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/maintenance/" + mainId, "PUT", JSON.stringify(maintanenceObject), document.getElementById("session_token").value).responsedata;
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

        function deletemaintenance(mainId) {
            resp = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/maintenance/" + mainId, "DELETE", "", document.getElementById("session_token").value).responsedata;
            
            if (resp.status === 200 || resp.status === 204) {
                toastr.success("Deleted!")
                $('#maintanenceModal').modal('hide')
              
                loadTableData()
            } else {
                
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
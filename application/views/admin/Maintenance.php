<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <input type="hidden" id="session_token" value="<?php echo $_SESSION['USER_API_TOKEN'] ?>" />
                        <input type="hidden" id="cname" value="<?php echo $_SESSION['myCustomerName'] ?>" />
                        <?php if ($_SESSION['permission'] == "MANAGER" || $_SESSION['permission'] == "ADMIN") {; ?>
                            <button id="newMaintenance" data-toggle="modal" class="btn btn-block bg-info" onclick="editAddMaintenance(-1)"><?php echo $this->lang->line('Add'); ?> <i class="fa fa-plus"></i></button>

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
                                <?php echo $this->lang->line('DeviceName'); ?>
                                </th>

                                <th style="width: 15%">
                                <?php echo $this->lang->line('Fleet Details'); ?>
                                </th>

                                <th style="width: 20%">

                                <?php echo  $this->lang->line('Maintenance Cost'); ?>
                                    
                                </th>


                                <th style="width: 20%">
                                <?php echo $this->lang->line('Created Date'); ?>
                                </th>

                                <th style="width: 10%">

                                </th>
                                <!-- <th style="width: 8%">
                                    &nbsp;
                                </th> -->
                            </tr>
                        </thead>
                        <tbody id="maintenanceTableData">
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
            console.log(maintenanceInfo)
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
                    maintenance_row_data = maintenance_row_data + `<td class='servicInterval'><small><b>Start  &nbsp;:&nbsp;</b><i class='fa fa-calendar  text-primary' aria-hidden='true'></i></small> ${maintenance['maintenanceStartDate']}</br> `;
                    maintenance_row_data = maintenance_row_data + `<small><b>End  &nbsp;&nbsp;&nbsp; :&nbsp;</b><i class='fa fa-calendar  text-primary' aria-hidden='true'></i></small> ${maintenance['maintenanceEndDate']}</td>`

                    if (permission == "MANAGER" || permission == "ADMIN") {
                        maintenance_row_data = maintenance_row_data + "<td class='maintenanceInfo-actions text-right'>";
                        if (maintenanceInfo['maintenanceCompleted']) {
                            maintenance_row_data = maintenance_row_data + `<i class='fas fa-eye text-info' onclick='showMaintenanceDetails(${maintenance['id']})'></i>&nbsp;&nbsp;&nbsp;`;
                            maintenance_row_data = maintenance_row_data + `<i class='fas fa-pencil-alt text-gray disabled'></i>&nbsp;&nbsp;&nbsp;`;
                            maintenance_row_data = maintenance_row_data + `<i class='fas fa-check text-green'></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>`;
                        } else {
                            maintenance_row_data = maintenance_row_data + `<i class='fas fa-eye text-info' onclick='showMaintenanceDetails(${maintenance['id']})'></i>&nbsp;&nbsp;&nbsp;`;
                            maintenance_row_data = maintenance_row_data + `<i class='fas fa-pencil-alt text-orange' onclick='editAddMaintenance(${maintenance['id']})' ></i>&nbsp;&nbsp;&nbsp;`;
                            maintenance_row_data = maintenance_row_data + `<i class='fas fa-trash text-danger outline' onclick='deletemaintenance(${maintenance['id']})'></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>`;
                        }
                    } else {
                        maintenance_row_data = maintenance_row_data + `<td><a href='#showMaintenanceDetails'><i class='fas fa-folder text-info'></i></a>`;
                        maintenance_row_data = maintenance_row_data + `<i class='fas fa-eye text-info'></i>&nbsp;&nbsp;&nbsp;`;
                        maintenance_row_data = maintenance_row_data + `&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>`;
                    }
                    maintenance_row_data = maintenance_row_data + `</tr>`;
                })
                $('#maintenanceRecords').DataTable().destroy()
                // console.log( maintenance_row_data)
                $('#maintenanceRecords').find('tbody').append(maintenance_row_data)

                $('#maintenanceRecords').DataTable().draw()
            } else {
                toastr.error('Unable to get data!')
            }


        }
    </script>

    <!-- show details  -->
    <div class="modal fade" id="maintanenceModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title"> <?php echo $this->lang->line('Maintenance Details'); ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-light">
                                <div class="card-header">
                                    <h3 class="card-title"> <?php echo $this->lang->line('general'); ?></h3>

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
                                            <label class="form-control-label"><?php echo $this->lang->line('name'); ?> </label>
                                            <input type="text" placeholder=" Name" id="mainName" name="fleetName" required class="form-control" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label class="form-control-label"><?php echo $this->lang->line('Fleet Name'); ?> </label>
                                            <input type="text" disabled placeholder="Fleet Name" id="fleetName" name="fleetName" required class="form-control" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label class="form-control-label"><?php echo $this->lang->line('Fleet Unique Id'); ?></label>
                                            <input type="text" disabled placeholder="Unique ID" id="uniqueID" name="uniqueID" required class="form-control" />
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label class="form-control-label"> <?php echo $this->lang->line('Maintenance Cost'); ?></label>
                                            <input type="text" placeholder=" Cost" id="maintenanceCost" name="maintenanceCost" required class="form-control" />
                                        </div>
                                    </div>





                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <div class="col-md-6">
                            <div class="card card-light " id="showDetails">
                                <div class="card-header">
                                    <h3 class="card-title"> <?php echo $this->lang->line('Additional Data'); ?></h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label class="form-control-label"><?php echo $this->lang->line('Maintenance Notes'); ?> </label>
                                            <textarea type="text" placeholder="Notes" id="maintenanceNotes" name="maintenanceNotes" required class="form-control"></textarea>
                                        </div>

                                    </div>
                                    <div class="row">

                                        <div class="col-sm-6">




                                        </div>



                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label class="form-control-label"> <?php echo $this->lang->line('StartDate'); ?></label>
                                            <input type="date" id="maintenanceStartDate" name="maintenanceStartDate" required class="form-control" />
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="form-control-label"> <?php echo $this->lang->line('EndDate'); ?></label>
                                            <input type="date" id="maintenanceEndDate" name="maintenanceEndDate" required class="form-control" />
                                        </div>

                                    </div>

                                    <div class="col-sm-12">
                                        <label class="form-control-label"><?php echo $this->lang->line('Status'); ?></label>
                                        <select name="Access" class="custom-select" id="status">
                                            <option value="2" selected>In progress</option>
                                            <option value="0">Pending</option>
                                            <option value="1">Completed</option>
                                        </select>
                                    </div>
                                    <div class="row" id="maintImgGallery">
                                        <label class="form-control-label"><?php echo $this->lang->line('pictures'); ?> </label>
                                        <input type="file" multiple id="gallery-photo-add" class="form-control">
                                        <!-- <div class="gallery" id="maintImgGallery" data-spy="scroll" data-offset="0"></div> -->
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
                            <input type="submit" value="<?php echo $this->lang->line('Save'); ?>" id="btnSavecustomer" onclick="saveMaintenance()" class="btn bg-olive float-right">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // redirecting to maintanence page on plus icon click 
        function showMaintenanceDetails(mainId) {
            var mainData = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/maintenance/" + mainId, "GET", "", document.getElementById("session_token").value).responsedata.responseJSON;
            document.getElementById("mainName").value = mainData['name']
            document.getElementById("fleetName").value = mainData['deviceName']
            document.getElementById("uniqueID").value = mainData['deviceId']
            document.getElementById("maintenanceCost").value = mainData['maintenanceCost']
            document.getElementById("maintenanceNotes").value = mainData['maintenanceNotes']
            document.getElementById("maintenanceStartDate").value = mainData['maintenanceStartDate']
            document.getElementById("maintenanceEndDate").value = mainData['maintenanceEndDate']
            document.getElementById("maintenanceEndDate").value = mainData['maintenanceEndDate']
            // disable
            document.getElementById("mainName").disabled = true;
            document.getElementById("fleetName").disabled = true;
            document.getElementById("uniqueID").disabled = true;
            document.getElementById("maintenanceCost").disabled = true;
            document.getElementById("maintenanceNotes").disabled = true;
            document.getElementById("maintenanceStartDate").disabled = true;
            document.getElementById("maintenanceEndDate").disabled = true;
            document.getElementById("maintenanceEndDate").disabled = true;
            $("#maintanenceModal").modal("show")
        }

        function editAddMaintenance(mainId) {
            document.getElementById("mainName").disabled = false;
            document.getElementById("fleetName").disabled = false;
            document.getElementById("uniqueID").disabled = false;
            document.getElementById("maintenanceCost").disabled = false;
            document.getElementById("maintenanceNotes").disabled = false;
            document.getElementById("maintenanceStartDate").disabled = false;
            document.getElementById("maintenanceEndDate").disabled = false;
            document.getElementById("maintenanceEndDate").disabled = false;
            var permission = <?php echo "'" . $_SESSION['permission'] . "'" ?>;

            // document.getElementsByClassName("gallery").style.height=400
            // document.getElementsByClassName("gallery").style.width=400
            // document.getElementsByClassName("gallery").setAttribute("style","overflow:auto;")
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
                                $($.parseHTML('<img>')).attr('src', event.target.result).attr('id', i).appendTo(placeToInsertImagePreview);
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


            if (document.getElementById('status').value == 0) {
                document.getElementById("mainName").disabled = true;
                document.getElementById("fleetName").disabled = true;
                document.getElementById("uniqueID").disabled = true;
                document.getElementById("maintenanceCost").disabled = true;
                document.getElementById("maintenanceNotes").disabled = true;
                document.getElementById("maintenanceStartDate").disabled = true;
                document.getElementById("maintenanceEndDate").disabled = true;
                document.getElementById("maintenanceEndDate").disabled = true;
            }
            // $("#maintanenceModal").modal("show")
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
                var images = mainData['maintenancePictures']
                var gallery = document.getElementById("maintImgGallery")
                // gallery.style.position = 'relative'
                for (var i = 0; i < images.length; i++) {

                    var innerDiv = document.createElement('div')
                    var span = document.createElement('span')
                  
                    
                    span.innerHTML = "<i class='badge bg-info fa fa-minus' aria-hidden='true'></i>"
                    // innerDiv.appendChild(icon)
                    innerDiv.className = "btn btn-app"
                    innerDiv.className = "col-sm-2 btn btn-app"
                    innerDiv.attr("data-toggle",'modal')
                    var img = document.createElement('img')
                    img.src = "data:image/png;base64," + performAPIAJAXCallGeneric("http://vghar.ddns.net:6060/ZFMS/" + images[i], "GET", "", document.getElementById("session_token").value).responsedata.responseText

                    img.style.height = '40px'
                    img.style.width = '50px'
                    img.style.paddingTop = '3px'

                    innerDiv.appendChild(img)
                    innerDiv.appendChild(span)


                    gallery.appendChild(innerDiv)
                }
                console.log(gallery)
                // PICTURES POPUP
                $(function() {
                    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
                        event.preventDefault();
                        $(this).ekkoLightbox({
                            alwaysShowClose: true
                        });
                    });

                    $('.filter-container').filterizr({
                        gutterPixels: 3
                    });
                    $('.btn[data-filter]').on('click', function() {
                        $('.btn[data-filter]').removeClass('active');
                        $(this).addClass('active');
                    });
                })






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
                "id": mainId,
                "deviceId": document.getElementById('uniqueID').value,
                "name": document.getElementById('mainName').value,
                "deviceName": document.getElementById('fleetName').value,
                "maintenanceStartDate": document.getElementById('maintenanceStartDate').value,
                "maintenanceEndDate": document.getElementById('maintenanceEndDate').value,
                "maintenanceCompleted": 0,
                "maintenanceTextStatus": document.getElementById('status').value,
                "maintenanceStatus": 0,
                "maintenanceCost": document.getElementById('maintenanceCost').value,
                "maintenanceNotes": document.getElementById('maintenanceNotes').value,
                "maintenancePictures": imagesPreview
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
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Ekko Lightbox -->
<script src="../plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- Filterizr-->
<script src="../plugins/filterizr/jquery.filterizr.min.js"></script>
<!-- AdminLTE for demo purposes -->
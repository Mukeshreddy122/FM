<section class="content">
    <!-- Main row -->
    <div class="row">
        <!-- Left col -->

        <section class="col-lg-10 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="nav-tabs-custom">
                <!-- Map box -->
                <div class="box box-solid bg-light-blue-gradient">
                    <input type="hidden" id="gpsLat">
                    <input type="hidden" id="gpsLon">
                    <div class="box-body">
                        <div id="map" style="height: 560px; width: 100%;"></div>
                    </div>
                </div>
                <!-- /.box -->

        </section>
        <section class="col-med-2 connectedSortable">
            <div class="small-box bg-info">
                <div class="inner">
                    <h4><?php echo $customerCount ?></h4>

                    <p>Customers</p>
                </div>
                <div class="icon">
                    <i class="fas fa-building"></i>
                </div>
                <a href="<?php echo base_url('Customer'); ?>" class="small-box-footer">Customer Details <i class="fa fa-arrow-circle-right"></i></a>
            </div>
            <div class="small-box bg-green">
                <div class="inner">
                    <h4><?php echo $projectCount ?></h4>

                    <p>Open Projects</p>
                </div>
                <div class="icon ">
                    <i class="fas fa-project-diagram"></i>
                </div>
                <a href="Project" class="small-box-footer">Project Details <i class="fa fa-arrow-circle-right"></i></a>
            </div>
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h4><?php echo $fleetCount ?></h4>

                    <p>Fleet items on the road</p>
                </div>
                <div class="icon">
                    <i class="fa fa-screwdriver"></i>
                </div>
                <a href="Device" class="small-box-footer">Fleet Details <i class="fa fa-arrow-circle-right"></i></a>
            </div>
            <div class="small-box bg-red collapsed-box">
                <div class="inner">
                    <h4><?php echo $employeeCount ?></h4>

                    <p>Users</p>
                </div>
                <div class="icon">
                    <i class="fa fa-user"></i>
                </div>
                <a href="Employee" class="small-box-footer">Employee Details <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </section>
        <!-- right col -->
    </div>
    <!-- /.row (main row) -->
    <div class="row">
        <!-- Left col -->
    </div>
</section>


<script src="assets/js/uiajax.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.1/dist/leaflet.css" integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.1/dist/leaflet.js" integrity="sha256-NDI0K41gVbWqfkkaHj15IzU7PtMoelkzyKp8TOaFQ3s=" crossorigin=""></script>

<script>
    var zoom = 16;
    setInterval(mapCaller, 1000)
    var map = L.map('map').setView([20.5937, 78.9629], 5);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);
    mapCaller()
    var result, data

    function mapCaller() {
        // var arr = {"USER_API_TOKEN":"9e90b62c-b640-420c-a5c9-b79c831705b0"};
        result = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/location", "GET", "", "9e90b62c-b640-420c-a5c9-b79c831705b0");
        data = (result.responsedata.responseJSON)
    }
    for (let i = 0; i < data.length; i++) {
        var marker = L.marker([data[i].latitude, data[i].longitude]).addTo(map);
        marker.bindPopup(`<b>${data[i].deviceName}</b><br>at ${data[i].locationTime}`).openPopup();
        marker.bindTooltip(data[i].deviceName).openTooltip();
        map.on('click', onMapClick);
    }
    result=""
</script>
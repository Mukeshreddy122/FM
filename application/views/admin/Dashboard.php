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
                    <input type='hidden' id='USER_API_TOKEN' value="<?php echo $_SESSION['USER_API_TOKEN'] ?>">

                    <div class="box-body">
                        <div id="map" style="height: 550px; width: 100%;"></div>
                    </div>
                </div>
                <!-- /.box -->

        </section>
        <section class="col-lg-2 connectedSortable">
            <div class="small-box bg-info ">
                <div class="inner col-lg-6">
                    <h4><?php echo $customerCount ?></h4>

                    <p><?php echo $this->lang->line('Customers'); ?> </p>
                </div>
                <div class="icon">
                    <i class="fas fa-building"></i>
                </div>
                <a href="<?php echo base_url('Customer'); ?>" class="small-box-footer"> <i class="fa fa-arrow-circle-right"></i> <?php echo $this->lang->line('Details'); ?></a>
            </div>
            <div class="small-box bg-green">
                <div class="inner">
                    <h4><?php echo $projectCount ?></h4>

                    <p><?php echo $this->lang->line('Open Projects'); ?> </p>
                </div>
                <div class="icon ">
                    <i class="fas fa-project-diagram"></i>
                </div>
                <a href="Project" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i> <?php echo $this->lang->line('Details'); ?></a>
            </div>
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h4><?php echo $fleetCount ?></h4>

                    <p><?php echo $this->lang->line('Fleet items on the road');?></p>
                </div>
                <div class="icon">
                    <i class="fa fa-screwdriver"></i>
                </div>
                <a href="Device" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i> <?php echo $this->lang->line('Details'); ?></a>
            </div>
            <div class="small-box bg-red collapsed-box">
                <div class="inner">
                    <h4><?php echo $employeeCount ?></h4>

                    <p><?php echo $this->lang->line('Users');?></p>
                </div>
                <div class="icon">
                    <i class="fa fa-user"></i>
                </div>
                <a href="Employee" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i> <?php echo $this->lang->line('Details'); ?></a>
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
    var zoom = 18;
    var map = L.map('map').setView([20.5937, 78.9629], 5);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        // maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);
    var markerLayerGroup;
    mapCaller()
    var result, data;
    var marker;
    function mapCaller() {
        
        // var arr = {"USER_API_TOKEN":"9e90b62c-b640-420c-a5c9-b79c831705b0"};
        result = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/location", "GET", "", document.getElementById('USER_API_TOKEN').value);
        data = (result.responsedata.responseJSON)
        
        for(let i=0;i<data.length;i++){
             marker = L.marker([data[i].latitude, data[i].longitude]).addTo(map);
            marker.bindPopup(`<strong>Name:</strong>${data[i].deviceName} <br><strong>Updated Time:</strong>${data[i].locationTime}`)
            
        }
        marker=[]
        marker.remove()
        setInterval(mapCaller,3000)
    }
    
    
</script>
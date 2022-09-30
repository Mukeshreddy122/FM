<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>150</h3>

                    <p>Total Customers</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="<?php echo base_url('Customer'); ?>" class="small-box-footer">Customer Details <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>53<sup style="font-size: 20px">%</sup></h3>

                    <p>Projects Completed</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="Project" class="small-box-footer">Project Details <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>44</h3>

                    <p>Fleet items on the road</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="Device" class="small-box-footer">Track your Fleet <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>65</h3>

                    <p>Users</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="Employee" class="small-box-footer">Users Details <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>
    <!-- /.row -->
    <!-- Main row -->
    <div class="row">
        <!-- Left col -->
        
        <section class="col-lg-9 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="nav-tabs-custom">
                <!-- Map box -->
                <div class="box box-solid bg-light-blue-gradient">
                    <input type="hidden" id="gpsLat">
                    <input type="hidden" id="gpsLon">
                    <div class="box-body">
                        <div id="mymap" style="height: 400px; width: 100%;"></div>
                    </div>
                </div>
                <!-- /.box -->

        </section>
        <section class="col-lg-3 connectedSortable">

        </section>
        <!-- right col -->
    </div>
    <!-- /.row (main row) -->

</section>

<script src="http://www.openlayers.org/api/OpenLayers.js"></script>
<script>
    $(document).ready(function() {
        init();
    });
</script>
<script>
    var lat, lon;
    var map, vectorLayer, selectMarkerControl, selectedFeature;
    //    var lat = 21.7679;
    //    var lon = 78.8718;

    var zoom = 16;
    var curpos = new Array();
    var position;
    var fromProjection = new OpenLayers.Projection("EPSG:4326"); // Transform from WGS 1984
    var toProjection = new OpenLayers.Projection("EPSG:900913"); // to Spherical Mercator Projection

    var cntrposition;
    var markers;

    function init() {
        if (window.navigator.geolocation) {
            window.navigator.geolocation.getCurrentPosition(
                getCurLocation, errHandler);
        }
    }

    function getCurLocation(position) {
        lat = position.coords.latitude;
        lon = position.coords.longitude;
        //    alert("Latitude : " + lat + " Longitude: " + lon);
        loadMap();
    }

    function errHandler(err) {
        lat = 44.439663;
        lon = 26.096306;

        if (err.code == 1) {
            // Error: Access is denied
        } else if (err.code == 2) {
            // Error: Position is unavailable
        }
        loadMap();
    }

    function loadMap() {
        cntrposition = new OpenLayers.LonLat(lon, lat).transform(fromProjection, toProjection);

        map = new OpenLayers.Map("mymap", {
            controls: [
                new OpenLayers.Control.PanZoomBar(),
                new OpenLayers.Control.LayerSwitcher({}),
                new OpenLayers.Control.Permalink(),
                new OpenLayers.Control.MousePosition({}),
                new OpenLayers.Control.ScaleLine(),
                new OpenLayers.Control.OverviewMap(),
            ]
        });
        var mapnik = new OpenLayers.Layer.OSM("MAP");
        markers = new OpenLayers.Layer.Markers("Markers");
        map.addLayers([mapnik, markers]);
        map.addLayer(mapnik);
        map.setCenter(cntrposition, zoom);
        markers.addMarker(new OpenLayers.Marker(cntrposition));
        var click = new OpenLayers.Control.Click();
        map.addControl(click);
        click.activate();
    };
    OpenLayers.Control.Click = OpenLayers.Class(OpenLayers.Control, {
        defaultHandlerOptions: {
            'single': true,
            'double': false,
            'pixelTolerance': 0,
            'stopSingle': false,
            'stopDouble': false
        },
        initialize: function(options) {
            this.handlerOptions = OpenLayers.Util.extend({}, this.defaultHandlerOptions);
            OpenLayers.Control.prototype.initialize.apply(
                this, arguments
            );
            this.handler = new OpenLayers.Handler.Click(
                this, {
                    'click': this.trigger
                }, this.handlerOptions
            );
        },
        trigger: function(e) {
            var lonlat = map.getLonLatFromPixel(e.xy);
            lonlat1 = new OpenLayers.LonLat(lonlat.lon, lonlat.lat).transform(toProjection, fromProjection);
            document.getElementById("gpsLat").value = lonlat1.lat;
            document.getElementById("gpsLon").value = lonlat1.lon;
            //alert("Hello..." + lonlat1.lon + "  " + lonlat1.lat);
            document.getElementById("saveLoc").style.display = "block";
            GetReverseGeoAddress();
            var newpos = new OpenLayers.LonLat(lonlat1.lon, lonlat1.lat).transform(fromProjection, toProjection);
            markers.addMarker(new OpenLayers.Marker(newpos));

        }
    });
</script>
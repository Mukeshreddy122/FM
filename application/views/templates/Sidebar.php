<!-- <aside class="main-sidebar elevation-4"> -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Brand Logo -->
    <a href="PM" class="brand-link">
        <img src="assets/img/logo.png" alt="ZofTECH Logo" class="brand-image " style="opacity: .8">
        <!-- <span class="brand-text font-weight-light">ZofTECH</span> -->
    </a>

    <!-- sidebar: style can be found in sidebar.less -->
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a href="Profile" class="d-block">Welcome <?php echo $name; ?></a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="header">&nbsp;</li>
                <li class="nav-item">
                    <a href="<?php echo base_url('PM'); ?>" <?php if ($this->uri->segment(1) == "PM") {
                                                                echo 'class="nav-link active-aqua"';
                                                            } else {
                                                                echo 'class="nav-link "';
                                                            } ?>>
                        <i class="nav-icon fa fa-home"></i>
                        <p>Home</p>
                    </a>
                </li>
                <?php if ($_SESSION['permission'] == "MANAGER" || $_SESSION['permission'] == "ADMIN") {; ?>
                    <li class="nav-item">
                        <a href="<?php echo base_url('Customer'); ?>" <?php if ($this->uri->segment(1) == "Customer") {
                                                                            echo 'class="nav-link active-aqua"';
                                                                        } else {
                                                                            echo 'class="nav-link "';
                                                                        } ?>>
                            <i class="nav-icon fas fa-city"></i>
                            <p>Customers</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo base_url('Employee'); ?>" <?php if ($this->uri->segment(1) == "Employee") {
                                                                            echo 'class="nav-link active-aqua"';
                                                                        } else {
                                                                            echo 'class="nav-link "';
                                                                        } ?>>
                            <i class="nav-icon fa fa-user"></i>
                            <p>Employees</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo base_url('Device'); ?>" <?php if ($this->uri->segment(1) == "Device") {
                                                                        echo 'class="nav-link active-aqua"';
                                                                    } else {
                                                                        echo 'class="nav-link "';
                                                                    } ?>>
                            <i class="nav-icon fas fa-truck-pickup"></i>
                            <p>Fleet</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo base_url('Maintenance'); ?>" <?php if ($this->uri->segment(1) == "Maintenance") {
                                                                        echo 'class="nav-link active-aqua"';
                                                                    } else {
                                                                        echo 'class="nav-link "';
                                                                    } ?>>
                            <i class="nav-icon fas fa-tools"></i>
                            <p>Maintenance</p>
                        </a>
                    </li>
                <?php } ?>
                <li class="nav-item">
                    <a href="<?php echo base_url('Project'); ?>" <?php if ($this->uri->segment(1) == "Project") {
                                                                        echo 'class="nav-link active-aqua"';
                                                                    } else {
                                                                        echo 'class="nav-link "';
                                                                    } ?>>
                        <i class="nav-icon fa fa-project-diagram"></i>
                        <p>Projects</p>
                    </a>
                </li>
                <?php if ($_SESSION['permission'] == "MANAGER" || $_SESSION['permission'] == "ADMIN") {; ?>
                    <li class="nav-item">
                        <a href="<?php echo base_url('Report'); ?>" <?php if ($this->uri->segment(1) == "Report") {
                                                                        echo 'class="nav-link active-aqua"';
                                                                    } else {
                                                                        echo 'class="nav-link "';
                                                                    } ?>>
                            <i class="nav-icon fas fa-chart-pie"></i>
                            <p>Reports</p>
                        </a>
                    </li>
                <?php } ?>

                <?php if ($_SESSION['permission'] == "ADMIN") {; ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>
                                Settings
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?php echo base_url('Settings') . "#generalSettings"; ?>" class="nav-link">
                                    <i class="fa fa-language"></i>
                                    <p>Language Settings</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo base_url('Settings') . "#customerSettings"; ?>" class="nav-link">
                                    <i class="fa fa-building"></i>
                                    <p>Customer Settings</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo base_url('Settings') . "#userSettings"; ?>" class="nav-link">
                                    <i class="fa fa-user"></i>
                                    <p>Employee Settings</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo base_url('Settings') . "#fleetSettings"; ?>" class="nav-link">
                                    <i class="fa fa-screwdriver"></i>
                                    <p>Fleet Settings</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fa fa-tools"></i>
                                    <p>Options & Settings</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fa fa-sim-card nav-icon"></i>
                                    <p>Fleet Sender Type</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fa fa-layer-plus nav-icon"></i>
                                    <p>
                                        Fleet Object Category
                                        <!-- <i class="right fas fa-angle-left"></i> -->
                                    </p>
                                </a>
                        </ul>
                    <?php } ?>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo base_url('logout'); ?>" class="nav-link ">
                            <i class="nav-icon fa fa-lock"></i>
                            <p>Logout</p>
                        </a>
                    </li>
            </ul>
        </nav>
    </div>
    <!-- /.sidebar -->
</aside>
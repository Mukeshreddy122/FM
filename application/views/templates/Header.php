<!-- <body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed"> -->

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">

    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__wobble" src="assets/img/logo.png" alt="ZofTECH Logo" height="70" width="200">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark">
            <!-- TOP  navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="<?php echo base_url('PM'); ?>" <?php if ($this->uri->segment(1) == "PM") {
                                                                echo 'class="nav-link active-aqua"';
                                                            } else {
                                                                echo 'class="nav-link "';
                                                            } ?>>
                        <!-- Home -->
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
                            <!-- Customers -->
                            <p>Customers</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo base_url('Employee'); ?>" <?php if ($this->uri->segment(1) == "Employee") {
                                                                            echo 'class="nav-link active-aqua"';
                                                                        } else {
                                                                            echo 'class="nav-link "';
                                                                        } ?>>
                            <!-- <i class="nav-icon fa fa-user">&nbsp;Employees</i> -->
                            <p>Employees</p>
                        </a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="<?php echo base_url('Device'); ?>" <?php if ($this->uri->segment(1) == "Device") {
                                                                        echo 'class="nav-link active-aqua"';
                                                                    } else {
                                                                        echo 'class="nav-link "';
                                                                    } ?>>
                            <!-- <i class="nav-icon fa fa-screwdriver">&nbsp;Fleet</i> -->
                            <p>Fleet</p>
                        </a>
                    </li>
                <?php } ?>
                <li class="nav-item">
                    <a href="<?php echo base_url('Project'); ?>" <?php if ($this->uri->segment(1) == "Project") {
                                                                        echo 'class="nav-link active-aqua"';
                                                                    } else {
                                                                        echo 'class="nav-link "';
                                                                    } ?>>
                        <!-- <i class="nav-icon fa fa-project-diagram">&nbsp;Projects</i> -->
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
                            <!-- <i class="nav-icon fas fa-chart-pie">&nbsp;Reports</i> -->
                            <p>Reports</p>
                        </a>
                    </li>
                <?php } ?>

                <?php if ($_SESSION['permission'] == "ADMIN") {; ?>
                    <li class="nav-item navbar-dark dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="nav-icon fas fa-cog">&nbsp;</i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="<?php echo base_url('Settings') . "#generalSettings"; ?>">
                                <i class="fa fa-language"></i>
                                &nbsp;&nbsp;Language Settings
                            </a>
                            <a class="dropdown-item" href="<?php echo base_url('Settings') . "#customerSettings"; ?>">
                                <i class="fa fa-building"></i>
                                &nbsp;&nbsp;Customer Settings

                            </a>
                            <a class="dropdown-item" href="<?php echo base_url('Settings') . "#userSettings"; ?>">
                                <i class="fa fa-user"></i>
                                &nbsp;&nbsp;Employee Settings
                            </a>
                            <a class="dropdown-item" href="<?php echo base_url('Settings') . "#fleetSettings"; ?>">
                                <i class="fa fa-screwdriver"></i>
                                &nbsp;&nbsp;Fleet Settings
                            </a>
                        </div>
                    </li>
                <?php } ?>
                </li>
                <!-- <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li> -->

            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <!-- <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="Type your keywords here" aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li> -->

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownUser" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <!-- <i class="fas fa-th-large"></i> -->
                        <?php echo $email; ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="<?php echo base_url('Profile'); ?>">
                            <i class="fas fa-user text-info"></i>
                            &nbsp;&nbsp;Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php echo base_url('Logout'); ?>">
                            <i class="fas fa-lock text-orange"></i>
                            &nbsp;&nbsp;Logout</a>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->
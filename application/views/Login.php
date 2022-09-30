<!DOCTYPE html>
<html lang="en">

<head>
    <title>ZofTECH Fleet Management System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.1/dist/leaflet.css"
    integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14="
    crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.1/dist/leaflet.js"
    integrity="sha256-NDI0K41gVbWqfkkaHj15IzU7PtMoelkzyKp8TOaFQ3s="
    crossorigin=""></script>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="assets/css/adminlte.min.css">

    <!-- jQuery -->
    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- jquery-validation -->
    <script src="assets/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="assets/plugins/jquery-validation/additional-methods.min.js"></script>
    <script src="assets/js/adminlte.js"></script>
    <script type="text/javascript" src="assets/js/script.js"></script>
    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,500;1,400&display=swap" rel="stylesheet">

</head>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed ">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="navbar navbar-expand navbar-dark ">
            <a class="navbar-brand" href="#"><img class="pr-5 pl-5" style="height:2em ;width:100%; " src="<?php echo base_url('assets/img/logo.png'); ?>" alt="Theme-Logo" /></a>
            <div class="collapse navbar-collapse right" id="collapsibleNavbar">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        &nbsp;&nbsp;&nbsp;&nbsp;
                    </li>
                    <li class="nav-item ">
                        <h3  style="padding-left:50px ;letter-spacing:0.1em; word-spacing:0.1em;">Welcome to your asset tracking portal</h3>
                    </li>
                </ul>
            </div>
            
            <!-- Left navbar links -->
     </nav>
        <!-- login form -->
        <div class="login-box pt-5 mr-5 float-right pl-15">
  <!-- /.login-logo -->
  <div class="card "  >
    <div class="card-body login-card-body">
      <p class="login-box-msg"><h5  style="color: #17a2b8;">Sign in to start your session</h5></p>

      <form class="form" role="form" method="post" id="zofLoginForm" name="zofLoginForm" action="<?php echo base_url() ?>Login/validateLogin">
        <div class="input-group mb-3">
          <input type="text" class="form-control bg-white" id="userName" name="userName" placeholder="Username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control bg-white" id="password" name="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" name="button" id="login" class="btn btn-block btn-secondary login_btn bg-info">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <!-- /.social-auth-links -->

      <p class="mb-1">
        <a href="forgot-password.html" style="color: #6495ed;">I forgot my password</a>
      </p>
      <div class="alert alert-dark text-left m-0 p-0" style="border: none;" role="alert">
            <span style="color:#CD5C5C"><?php echo $this->session->flashdata('info') ?></span>
            <span style="color:#CD5C5C"><?php echo $this->session->flashdata('error') ?></span>
        </div>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
       
    </div>
    <!--   <div class="row">
        <h3>Welcome to your asset tracking portal</h3>
    </div>
-->
<script src="assets/js/md5.js"></script>
    <script>
    var email=document.getElementById("userName").value
    var password=document.getElementById("password").value
    var logIn={
        "email":email,
        "password":md5(password)
    }
        $('#zofLoginForm').validate({
            rules: {
                userName: {
                    required: true,
                    // email: true,
                },
                password: {
                    required: true,
                    minlength: 5
                }
            },
            messages: {
                userName: {
                    required: "Please enter email address",
                    email: "Please enter a valid email address"
                },
                password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 5 characters long"
                }
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    </script>
</body>

</html>
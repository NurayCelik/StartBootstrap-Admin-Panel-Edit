
<?php
include '../../classes/Adminlogin.php'; 
$al   = new Adminlogin(); // create object 
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['loginbtn'])) {
        $adminUser = $_POST['username'];
        $adminPass = $_POST['password'];
       
        $loginChk  = $al->adminLogin($adminUser, $adminPass);
        
    } 
   
?>


<html lang="tr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin - Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>


<body class="bg-gradient-primary changeBack">
    <style>
        .changeBack{
            background-color: #656872;
            background-image: linear-gradient(
            180deg
            ,#4e73df 10%,#fdfdfd 100%);
            background-size: cover;
        }
        .changeImage{
        background: url(img/blue.png) !important;
        background-position: center;
        background-size: cover !important;
        background-repeat: no-repeat !important;
        text-align: center;
        }
        .changeMargin{
        margin-top: 6rem!important;
        }
    </style>

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-8 col-lg-10 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5 changeMargin">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image changeImage"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <form action ="" class="user" method="POST">
                                        <!-- <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address...">
                                        </div> -->
                                        <div class="form-group">
                                            <input type="text" name="username" 
                                            value="<?php if(isset($_COOKIE['username']) && $_COOKIE['username'] != ''){echo $_COOKIE['username'];}else {echo '';} ?>"
                                            class="form-control form-control-user"
                                                id="exampleInputEmTet" aria-describedby="textHelp"
                                                placeholder="Enter Username...">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" 
                                            value="<?php if(isset($_COOKIE['password']) && $_COOKIE['password'] != ""){echo $_COOKIE['password'];}else {echo "";} ?>" 
                                            class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" 
                                                <?php if(isset($_COOKIE['remember_me']) && $_COOKIE['remember_me']=="1"){echo "checked='checked'";} ?> 
                                                name="remember_me" value="1" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <!--<a href="index.php" class="btn btn-primary btn-user btn-block"> -->
                                        <button type="submit" name="loginbtn" class="btn btn-primary btn-user btn-block">Login</button>
                                        <!--  </a> -->

                                        <!-- <hr>
                                        <a href="index.html" class="btn btn-google btn-user btn-block">
                                            <i class="fab fa-google fa-fw"></i> Login with Google
                                        </a>
                                        <a href="index.html" class="btn btn-facebook btn-user btn-block">
                                            <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                                        </a> -->
                                    </form>
                                    <!-- <hr>
                                    <div class="text-center">
                                        <a class="small" href="forgot-password.html">Forgot Password?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="register.html">Create an Account!</a>
                                    </div> -->
                                </div>
                        </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
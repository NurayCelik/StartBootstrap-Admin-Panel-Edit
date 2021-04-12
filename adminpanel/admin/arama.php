<?php 
  include '../../datalib/Session.php'; // include our Session.php page 
 Session::checkSession(); // Added checkSession Method

 header("Cache-Control: no-cache, must-revalidate");
 header("Pragma:no-cache");
 header("Expires:Sat, 26 Jul 1997 05:00:00 GMT");
 header("Cache-Control:max-age=2592000");
 date_default_timezone_set('Europe/Istanbul'); 
 
?> 



<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin Panel</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body style="">

    <!-- Page Wrapper -->
    <div id="wrapper">
                  <!-- Begin Page Content -->
   <div class="container-fluid">
                    <!-- DataTales Example -->
   <!-- Page Heading -->
   <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Merhaba <span class="succes" style="color:darkblue;"><?php echo Session::get('adminUser');?></span>,</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
   </div>
   <div class="card-body">
    <?php 
           if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['araBtn'])){
            $query = $_POST['aranan'];
            $cleanQuery = urlencode($query);
            $url = 'http://www.google.com/search?q='.$cleanQuery;
            $scrape = file_get_contents($url);

          
            
           ?>
          <script>window.location.href = '<?php echo $scrape; ?>';  </script>
         
           <?php
      
            }
                else {
                    echo "No Record Found";
                } 
        ?>
   


                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
  
<?php
include("includes/footer.php");
?>
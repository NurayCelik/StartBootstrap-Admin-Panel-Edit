<?php
include("includes/header.php");
include '../../classes/User.php'; 
include_once '../../helpers/Format.php';
?>
<?php 
  $us =  new User();
  $fm =  new Format();
  
 
  if (!($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editBtn'])) ) { 
    echo "<script>window.location = 'register.php';  </script>"; 
    }else {
        $id = $_POST['editId']; 
       
  }
 if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updatebtn'])){ 
      $idn = $_POST['formId'];
      $updatedAdmin = $us->adminUpdate($_POST, $idn);
  }

 ?>
<div class="container-fluid">

    <?php 
            if(isset($updatedAdmin)) {
                echo  '<p class="mb-4">'.$updatedAdmin.'</p>';
            }
            
    ?>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"> EDIT USER PROFILE </h6>
        </div>
        <div class="card-body">

        <?php
          
           $adminData = $us->getAdminId(@$id); // Create this method in our User.php Class
           if($adminData) {
            while ($value = $adminData->fetch_assoc()) { 
       ?> 

        <form action="" method="POST" id="">

        <div class="modal-body">

            <div class="form-group">
                <label> Username </label>
                <input type="text" required="required" name="username" class="form-control" value="<?php  echo $fm->validation($value['username']); ?>" placeholder="Enter Username">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="useremail" required="required" name="useremail" class="form-control checking_email" value="<?php echo $fm->validation($value['useremail']); ?>" placeholder="Enter Email">
                <small class="error_email" style="color: red;"></small>
            </div>
            <div class="form-group">
                <label>Password</label>
                <!-- readonly="readonly" sadece okunur yapar veya disabled="disabled" de sadece okunur yapar -->
                <input type="text" required="required" name="password" value="<?php echo $fm->validation($value['password']); ?>" class="form-control" value="<?php echo $fm->validation($value['password']); ?>" placeholder="Enter Password">
            </div>
            <div class="form-group">
                <label>User Type</label>
                <input type="text" required="required" name="usertype" class="form-control" value="<?php echo $fm->validation($value['usertype']); ?>" placeholder="Confirm Usertype">
            </div>
            <div class="form-group">
               <input type="hidden" name="formId" value="<?php echo $fm->validation($value['id']); ?>">
            </div>
         </div>
        <div class="modal-footer">
            <a href="<?php echo $_SERVER['PHP_SELF'];?>"><button type="button" class="btn btn-info" data-dismiss="modal"><i class="fas fa-undo"></i>  Cancel </button></a>
            <button type="submit" name="updatebtn" class="btn btn-primary">Update</button>
        </div>
        </form>

        <?php
                 
            }
        }
        ?>
        
        </div>
    </div>
</div>


            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->       
    </div>
    <!-- End of Content Wrapper -->

 </div>
    <!-- End of Page Wrapper -->  
 

<?php
include("includes/footer.php");
?>